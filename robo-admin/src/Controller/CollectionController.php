<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CollectionController extends AppController
{   

    public function initialize() {
        parent::initialize();
        $this->loadModel('CollectionOrders');
        $this->loadModel('CollectionOrdersResponses');
        $this->loadModel('People');
        $this->loadModel('Users');
        $this->loadComponent('S3Tools');
        $this->loadComponent('Notification');
        $this->loadModel('CollectionOrdersCategories');
        $this->loadModel('CollectionOrdersImages');
        $this->loadModel('CollectionOrdersDenied');
        
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
   


    public function index(){
        

       $this->set(compact('collections'));
    }

    public function indexJson(){
        $id_user = $this->request->session()->read('Auth.User.id');
        $collections = $this->query('SELECT 
        co.id,
        CONCAT(co.address,", ",co.number," - ",co.district)  as address,
        co.status,
        co.created as `data`
        FROM collection_orders as co 
        WHERE co.users_id = '.$id_user. ' AND co.status <> "cancelada"');
        foreach ($collections as $collection) {
         $collections_categories = $this->query("SELECT cc.id, cc.categorie_id,cc.collection_orders_id, c.name,c.url_icon FROM collection_orders_categories as cc
         INNER JOIN categories as c ON c.id = cc.categorie_id WHERE cc.collection_orders_id = ".$collection->id);
             $categories = [];
            foreach ($collections_categories as $collection_categorie) {
               array_push($categories,"<img style='width: 30px;' src='".$this->request->webroot."/".$collection_categorie->url_icon."' alt='$collection_categorie->name' title='$collection_categorie->name'>&nbsp;");
            }
            $queryresposta = $this->query("SELECT COUNT(*) as `resposta` FROM collection_orders_responses as cr WHERE cr.collection_order_id = ".$collection->id)[0];
            $collection->resposta = $queryresposta->resposta;
            $collection->data = date("d/m/Y h:m",strtotime($collection->data));
            $collection->categories = $categories;
        }

        $data = $this->request->getData();
        $json = $this->datatableQueryjsontojson($collections,$data);

        $this->set('json',$json);
        $this->set('_serialize',array('json'));
        $this->response->statusCode(200);

    }



    public function add(){
        
        $collection = $this->CollectionOrders->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $person = $this->request->session()->read('Auth.User');
            $id_user = $person['id'];
            $person = $this->People->get($person['person_id']);
            $user = $this->Users->get($id_user);
            // $this->d($data);
            $collection_order = $this->CollectionOrders->newEntity();
            $collection_order->users_id = $user->id;
            $collection_order->quantity_garbage_bags = $data['quantity_garbage_bags'];
            $collection_order->date_service_ordes = $data['datetime_collection_ordes'];

            if($this->request->data('cep') == null) {
                $collection_order->address = $person->address;
                $collection_order->number = $person->number;
                $collection_order->complement = $person->complement;
                $collection_order->district = $person->district;
                $collection_order->city = $person->city;
                $collection_order->state = $person->state;
                $collection_order->latitude = $person->latitude;
                $collection_order->longitude = $person->longitude;
            } else {
                $collection_order->address = $this->request->data('address');
                $collection_order->number = $this->request->data('number');
                $collection_order->complement = $this->request->data('complement');
                $collection_order->district = $this->request->data('district');
                $collection_order->city = $this->request->data('city');
                $collection_order->state = $this->request->data('state');
               if($this->request->data('latitude') == null && $this->request->data('longitude') == null){
                $arracoordenadas = $this->Coord(str_replace(" ","+",$data['number'])."+".str_replace(" ","+",$data['address'])
                .",+".str_replace(" ","+",$data['district']).",+".str_replace(" ","+",$data['city']));
                $collection_order->latitude = $arracoordenadas['lat'];
                $collection_order->longitude = $arracoordenadas['lng'];
               }else{
                $collection_order->latitude = $this->request->data('latitude');
                $collection_order->longitude = $this->request->data('longitude');
               }
            }
            
            $collection_order->comments = $this->request->data('comments');
            $collection_order->status = 'pendente';
            $collection_order->period = $this->request->data('period');
            $collection_order->type = $this->request->data('type');
            $collection_order->created = date("Y-m-d H:i:s");
            $collection_order->modified = date("Y-m-d H:i:s");
            if(!$this->CollectionOrders->save($collection_order)) {
                // $this->slackAPI("ERRO ao cadastra a coletar do usuário id = ".$user->id);
                $this->Flash->error(__('Error ao cadastra a coletar'));
                return $this->redirect(['action' => 'index']);
            }

            $categorie_ids =  $data['categories'];
            if(!is_null($categorie_ids)) {
                foreach($categorie_ids as $categorie_id) {
                $collection_order_categories = $this->CollectionOrdersCategories->newEntity();
                $collection_order_categories->collection_orders_id = $collection_order->id;
                $collection_order_categories->categorie_id = $categorie_id;
                    if(!$this->CollectionOrdersCategories->save($collection_order_categories)){
                        // $this->slackAPI("ERRO ao cadastrar as categorias do usuário id = ".$user->id." Coletar: ".$collection_order->id );
                        $this->Flash->error(__('Error ao cadastra a categoria da coleta'));
                        return $this->redirect(['action' => 'index']);
                    }
                }
            }
            foreach ($_FILES['file']['name'] as $key => $value) {
                $name = $_FILES['file']['name'][$key];
                $tmp_name = $_FILES['file']['tmp_name'][$key];
                $key = bin2hex(openssl_random_pseudo_bytes(10));
                $a = $this->upImagem($name, $tmp_name, $collection_order->id, $key);
                if (!$a) {
                    // $this->slackAPI("ERRO ao cadastrar as fotos do usuário id = ".$user->id." Coletar: ".$collection_order->id );
                    $this->Flash->error(__('Error ao cadastra a as fotos da coleta'));
                    return $this->redirect(['action' => 'index']);
                }
            }
            if($this->request->is('ajax')){
                // $this->Notification->sendNotification(null,null,"Você pode ir buscar a coleta ".$id,"O gerador aceitou sua resposta","collection-orders/view/".$id);
                $this->set('mensagem', "Salvo com sucesso!");
                $this->set('_serialize', array('mensagem'));
                $this->response->statusCode(200);
                return null;
            }
            $this->Flash->success(__('Coleta cadastrada com sucesso'));
            return $this->redirect(['action' => 'index']);
        }
        

        $option_mult_query = $this->query("SELECT id, `name` FROM `categories`");
        $option_mult = [];
     
        foreach ($option_mult_query as  $value) {
            $option_mult[$value->id] = $value->name;
        }
            

        $this->set(compact('option_mult','collection'));
    }

    public function delete($id){
        $person = $this->request->session()->read('Auth.User');
        $id_user = $person['id'];
        $CollectionOrdersTable = TableRegistry::get('CollectionOrders');
        $CollectionOrders = $this->CollectionOrders
        ->find('all')
        ->where(['id'=>$id,'users_id'=> $id_user])->first();
        $CollectionOrders = $this->CollectionOrders->patchEntity($CollectionOrders,['status'=>'cancelada']);
        if($this->CollectionOrders->save($CollectionOrders)){
            $this->Flash->success(__('Coleta cancelada com sucesso.'));
            return $this->redirect(['action' => 'index']);
        }else{
            $this->Flash->error(__('Error ao cancelar a coleta.'));
            return $this->redirect(['action' => 'index']);
        }
		
    }


    public function dellanexo($id_imagem,$id_collection){
		$CollectionOrdersImagesTable = TableRegistry::get('collection_orders_images');
        $CollectionOrdersImages = $this->CollectionOrdersImages
        ->find('all')
        ->where(['id'=>$id_imagem,'collection_orders_id'=> $id_collection])->toArray();
		$CollectionOrdersImagesTable->delete($CollectionOrdersImages);
    }

    /**
     * Upload de imagens da OS
     */
    private function upImagem($file, $tmp_file, $os_id, $key)
    {
      $data['file'] = $tmp_file;
      $data['info'] = pathinfo($file);
      $data['ext']  = $data['info']['extension'];

      $path = 'coleta' . "/" . $os_id . "/" . $key . "." . $data['ext'];

      if ($data['ext'] != 'jpg' && $data['ext'] != 'jpeg' && $data['ext'] != 'png') {
        if($this->request->is('ajax')){
            $this->set('mensagem', "Externção de imagem dever ser JPG ou PNG ou JPEG");
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(500);
            return false;
        }
        $this->Flash->error(__('Externção de imagem dever ser JPG ou PNG ou JPEG'));
        return $this->redirect(['action' => 'index']);
      }
      
      $result = $this->S3Tools->upImage($path, $data['file']);

      if ($result['@metadata']['statusCode'] == 200) {
        if (!$this->saveBaseImg($os_id, $path)) {
            if($this->request->is('ajax')){
                $this->set('mensagem', "Error ao cadastra a as fotos da coleta por favor tente mais tarde!");
                $this->set('_serialize', array('mensagem'));
                $this->response->statusCode(500);
                return false;
            }
            $this->Flash->error(__('Error ao cadastra a as fotos da coleta'));
            return false;
        }
        return true;
      }

     
    }

    /**
     * Salva no banco de dados as imagens que foram enviadas
     */
    private function saveBaseImg($os_id, $path)
    {
      $table = TableRegistry::getTableLocator()->get('CollectionOrdersImages');
      $r = $table->newEntity();
      $r->collection_orders_id = $os_id;
      $r->path = $path;

      return $table->save($r);
    }

    
    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id){
        $collection_orders = $this->query("SELECT *,(CASE WHEN c.name LIKE '%/%' THEN REPLACE(c.name, '/', '<br>') ELSE c.name END) AS name,co.id,GROUP_CONCAT(c.name SEPARATOR ', ') as `materiais`,GROUP_CONCAT(c.id SEPARATOR ', ') as `categorias`, cc.categorie_id as categories 
        FROM `collection_orders` as co 
        INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id 
        LEFT JOIN  categories as c ON c.id = cc.categorie_id
        WHERE co.id = $id GROUP BY co.id")[0];
        $person = $this->request->session()->read('Auth.User');
        $id_user = $person['id'];
        if($collection_orders->users_id != $id_user && $this->request->session()->read('Auth.User.users_types_id') != 1){
            $this->Flash->error(__('você não tem acesso a essa coleta'));
            return $this->redirect(['action' => 'index']);
        }
            
        if($this->request->is('get')){
            $gerador = $this->query("SELECT p.id as id,
            p.name as nome, 
            p.number_contact as contato
            FROM people as p
            INNER JOIN users as u ON u.person_id = p.id 
            WHERE u.id = $collection_orders->users_id")[0];
            $queryresposta = $this->query("SELECT u.id as `user_id`,u.name,p.number_contact, cr.created,cr.status,cr.id FROM collection_orders_responses as cr 
            INNER JOIN users as u ON u.id = cr.company_id INNER JOIN people as p ON u.person_id = p.id 
            WHERE cr.collection_order_id = ".$collection_orders->id." ORDER BY cr.status DESC");
            foreach ($queryresposta as $resposta) {
                if($resposta->status == "pendente"){
                    $resposta->badge = "badge-warning";
                }
                if($resposta->status == "negada"){
                    $resposta->badge = "badge-danger";
                }
                if($resposta->status == "aceita" || $resposta->status == "recebido"){
                    $resposta->badge = "badge-success";
                }
                if($collection_orders->type == 1){
                    $categories = explode(",",$collection_orders->categorias);

                    $resposta->precos = $this->query("SELECT (CASE WHEN c.name LIKE '%/%' THEN REPLACE(c.name, '/', '<br>') ELSE c.name END) AS name,c.url_icon,uc.Price FROM users_categories as uc 
                    INNER JOIN categories as c ON c.id = uc.categorie_id WHERE uc.user_id = ".$resposta->user_id." AND uc.categorie_id IN (".implode(",",$categories).")");
                }
            }
            $collection_orders->resposta = $queryresposta;
                $collection_orders_images = $this->CollectionOrdersImages
                ->find()
                ->where(['CollectionOrdersImages.collection_orders_id'=>$collection_orders->collection_orders_id]);
                foreach ($collection_orders_images as $collection_orders_image) {
                    
                    if($collection_orders_image->path){
                        $img = $this->S3Tools->getUrlTemp($collection_orders_image->path, 120);
                        $xml = null;
                        if(!$xml){
                        $collection_orders_image->url = $img;
                        }else{
                            $collection_orders_image->url = $this->request->getAttribute("webroot")."webroot/assets/images/sem-fotos.png"; ;
                        }
                        
                    }   
                }
            
                 
             $user = $this->Users
                 ->find()
                 ->select(['name'])
                 ->where(['Users.id'=>$collection_orders->users_id])
                 ->first();
                 $infoCategories = TableRegistry::get('categories');
                 $infoCategories = $infoCategories
                                      ->find()
                                      ->where(['categories.id'=>$collection_orders->categories])->toArray();
            $collection_orders->images =  $collection_orders_images;
            $collection_orders->user = $user;
            $collection_orders->categories_info = $infoCategories[0];
        }
        
            if($this->request->is('ajax')){
                $data = $this->request->getData();
                $queryresposta = $this->query("SELECT u.id as `user_id`,u.name,p.number_contact, cr.created,cr.status,cr.id FROM collection_orders_responses as cr 
                INNER JOIN users as u ON u.id = cr.company_id INNER JOIN people as p ON u.person_id = p.id 
                WHERE cr.collection_order_id = ".$collection_orders->id." ORDER BY cr.created ASC");
                if($collection_orders->type == 1){
                    foreach ($queryresposta as $key => $resposta) {
                        $categories = explode(",",$collection_orders->categorias);

                        $resposta->precos = $this->query("SELECT c.name,c.url_icon,uc.Price FROM users_categories as uc 
                        INNER JOIN categories as c ON c.id = uc.categorie_id WHERE uc.user_id = ".$resposta->user_id." AND uc.categorie_id IN (".implode(",",$categories).")");
                    }
                }
                $this->set(compact('collection_orders','gerador'));
                $this->set('queryresposta', $queryresposta);
                $this->set('_serialize', array('queryresposta'));
                $this->response->statusCode(200);
                return null;
            }
            $this->set(compact('collection_orders','gerador'));
    }

    
    public function aceito($id){
        $collection_orders = $this->query("SELECT *,co.id, cc.categorie_id as categories FROM `collection_orders` as co 
        INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id 
        WHERE co.id = $id GROUP BY co.id")[0];
        $person = $this->request->session()->read('Auth.User');
        $data = $this->request->getData();
        $id_user = $person['id'];
        if($collection_orders->users_id != $id_user){
            $this->set('mensagem', "Você não tem acesso!");
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(500);
            return null;
        }

        $check_status = $this->query('SELECT co.status as `status` 
        FROM collection_orders as co WHERE co.id = '.$id)[0];
        if($check_status->status != "pendente"){
            $this->set('mensagem', "Essa coletar já foi ".$check_status->status);
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(500);
            return null;
        }

        $collection_orders = $this->CollectionOrders->get($id);
        $collection_orders->status = "agendada";
        $respostas = $this->CollectionOrdersResponses->find('all')->where(['collection_order_id'=>$id]);
        $denied = [];
        $id_user_resposta = null;
        $id_resposta = null;
        if($this->CollectionOrders->save($collection_orders)){
            foreach ($respostas as $resposta) {
                if($resposta->id == $data['resposta']){
                    $resposta->status = "aceita";
                    $id_user_resposta = $resposta->company_id;
                    $id_resposta =  $resposta->id;
                }else{
                    $resposta->status = "negada";
                    $denied = TableRegistry::get('collection_orders_denied');
                    $denied = $denied->newEntity();
                    $denied->user_id = $resposta->company_id;
                    $denied->collection_order_id = $id;
                    if(!$this->CollectionOrdersDenied->save($denied)){
                        $this->set('mensagem', "Falhar ao registra ao cadastra negados");
                        $this->set('_serialize', array('mensagem'));
                        $this->response->statusCode(500);
                        return null;
                    }
                }
                if(!$this->CollectionOrdersResponses->save($resposta)){
                    $this->set('mensagem', "Falhar ao registra ao resposta!");
                    $this->set('_serialize', array('mensagem'));
                    $this->response->statusCode(500);
                    return null;
                }
            }
        }else{
            $this->set('mensagem', "Falhar ao registra ao cadastra aceito");
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(500);
            return null;
        }
        $this->loadComponent('Emails');
        $coletor = $this->query("SELECT p.name,p.email FROM collection_orders_responses as cr INNER JOIN users as u ON u.id = cr.users_id INNER JOIN people as p ON p.id = u.person_id WHERE cr.id = ".$id_resposta)[0];
        $this->Emails->sendEmailNotificationColetor(array("name"=>$coletor->name,"email"=>$coletor->email,"id_coleta"=>$id,"nome_gerador"=>$person['name'],"telefone"=>$this->TophoneBR($person['person']['number_contact']),"endereco"=> $collection_orders->address.", ".$collection_orders->number." - ".$collection_orders->district.". ".$collection_orders->city."/".$collection_orders->state));
        $this->Notification->sendNotification($id_user,$id_user_resposta,"Você pode ir buscar a coleta ".$id,"O gerador aceitou sua resposta","collection-orders/view/".$id);
        $this->set('mensagem', "Cadastrado com sucesso!");
        $this->set('_serialize', array('mensagem'));
        $this->response->statusCode(200);
        return null;
    }

    public function negado($id){
        $collection_orders = $this->query("SELECT *,co.id, cc.categorie_id as categories FROM `collection_orders` as co 
        INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id 
        WHERE co.id = $id GROUP BY co.id")[0];
        $person = $this->request->session()->read('Auth.User');
        $data = $this->request->getData();
        $id_user = $person['id'];
        if($collection_orders->users_id != $id_user){
            $this->Flash->error(__('você não tem acesso a essa coleta'));
            return $this->redirect(['action' => 'index']);
        }

        $check_status = $this->query('SELECT co.status as `status` 
        FROM collection_orders as co WHERE co.id = '.$id)[0];
        if($check_status->status != "pendente"){
            $this->set('mensagem', "Essa coletar já foi ".$check_status->status);
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(500);
        }

        
        $resposta = $this->CollectionOrdersResponses->get($data['resposta']);
        $denied = [];

                
        $resposta->status = "negada";
        $denied = TableRegistry::get('collection_orders_denied');
        $denied = $denied->newEntity();
        $denied->user_id = $resposta->company_id;
        $denied->collection_order_id = $id;
        if(!($this->CollectionOrdersDenied->save($denied) && $this->CollectionOrdersResponses->save($resposta))){
            $this->set('mensagem', "Falhar ao registra ao cadastra negados");
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(500);
            return null;
        }

            

        $this->set('mensagem', "Coletor recusado com sucesso!");
        $this->set('_serialize', array('mensagem'));
        $this->response->statusCode(200);
        return null;
    }

    public function cancelar($id){
        $collection_orders = $this->query("SELECT *,co.id, cc.categorie_id as categories FROM `collection_orders` as co 
        INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id 
        WHERE co.id = $id GROUP BY co.id")[0];
        $person = $this->request->session()->read('Auth.User');
        $data = $this->request->getData();
        $id_user = $person['id'];
        if($collection_orders->users_id != $id_user){
            $this->Flash->error(__('você não tem acesso a essa coleta'));
            return $this->redirect(['action' => 'index']);
        }

        $check_status = $this->query('SELECT co.status as `status` 
        FROM collection_orders as co WHERE co.id = '.$id)[0];
        if($check_status->status != "pendente"){
            $this->set('mensagem', "Essa coletar já foi ".$check_status->status);
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(500);
        }

        $collection_orders = $this->CollectionOrders->get($id);
        $collection_orders->status = "pendente";
        $respostas = $this->CollectionOrdersResponses->find('all')->where(['collection_order_id'=>$id])->toArray();
        $denieds = TableRegistry::get('collection_orders_denied');
        $denieds = $denieds->find('all')->where(['collection_order_id'=>$id]);
        foreach ($denieds as $denied) {
           if(!$this->CollectionOrdersDenied->delete($denied)){
                $this->set('mensagem', "Falhar ao registra ao resposta!");
                $this->set('_serialize', array('mensagem'));
                $this->response->statusCode(500);
                return null;
           }
        }
        if($this->CollectionOrders->save($collection_orders)){
            foreach ($respostas as $resposta) {
                
                if($resposta->status == "aceita"){
                    $resposta->status = "negada";
                    $denied = TableRegistry::get('collection_orders_denied');
                    $denied = $denied->newEntity();
                    $denied->user_id = $resposta->company_id;
                    $denied->collection_order_id = $id;
                    if(!($this->CollectionOrdersDenied->save($denied))){
                        $this->set('mensagem', "Falhar ao registra ao cadastra negados");
                        $this->set('_serialize', array('mensagem'));
                        $this->response->statusCode(500);
                        return null;
                    }

                }else{
                    $resposta->status = "pendente";
                }
                if(!$this->CollectionOrdersResponses->save($resposta)){
                    $this->set('mensagem', "Falhar ao registra ao resposta!");
                    $this->set('_serialize', array('mensagem'));
                    $this->response->statusCode(500);
                    return null;
                }
            }
        }else{
            $this->set('mensagem', "Falhar ao registra cancelamento da coleta!");
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(500);
            return null;
        }

        $this->set('mensagem', "Cancelado com sucesso!");
        $this->set('_serialize', array('mensagem'));
        $this->response->statusCode(200);
        return null;




    }

    public function finalizar($id){
        $collection_orders = $this->query("SELECT *,co.id, cc.categorie_id as categories FROM `collection_orders` as co 
        INNER JOIN collection_orders_categories as cc ON cc.collection_orders_id = co.id 
        WHERE co.id = $id GROUP BY co.id")[0];
        $person = $this->request->session()->read('Auth.User');
        $data = $this->request->getData();
        $id_user = $person['id'];
        if($collection_orders->users_id != $id_user){
            $this->set('mensagem', "Você não tem acesso!");
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(500);
            return null;
        }

        $collection_orders = $this->CollectionOrders->get($id);
        $collection_orders->status = "coletada";
        if($this->CollectionOrders->save($collection_orders)){
            $this->set('mensagem', "Cadastrado com sucesso!");
            $this->set('_serialize', array('mensagem'));
            $this->response->statusCode(200);
            return $this->redirect(['action' => 'index']);
        }
    }

    

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    private function edit($id = null)
    {
        $collection = $this->CollectionOrders->get($id);
        $person = $this->request->session()->read('Auth.User');
        $id_user = $person['id'];


        if ($this->request->is(['patch', 'post', 'put'])) {

        }


        if($collection->users_id !== $person['id']){
            $this->Flash->error(__('Você não tem acesso a essa coleta'));
            return $this->redirect(['action' => 'index']);
        }
            $collection_orders_images = $this->CollectionOrdersImages
             ->find()
             ->where(['CollectionOrdersImages.collection_orders_id'=>$collection->id])->toArray();
            foreach ($collection_orders_images as $collection_orders_image) {
                if($collection_orders_image->path){
                     $collection_orders_image->url = $this->S3Tools->getUrlTemp($collection_orders_image->path, 120);
 
                 }   
            }
        $collection->images = $collection_orders_images;
        // $this->d($collection->images);
        $option_select_query = $this->query("SELECT * FROM collection_orders_categories as cc INNER JOIN categories as ca ON ca.id = cc.categorie_id WHERE cc.collection_orders_id =".$id);
        $option_mult_query = $this->query("SELECT id, `name` FROM `categories`");
        $option_mult = [];
        $option_select = [];
        foreach ($option_select_query as $key => $value) {
            $option_select[$key] = $value->id;
        }
        foreach ($option_mult_query as  $value) {
            $option_mult[$value->id] = $value->name;
        }
            

        $this->set(compact('option_mult','option_select','collection'));
        
    }

    

    private function Coord($endereco){
        // ini_set('allow_url_fopen', true);
        // ini_set('allow_url_include', true);
        // # https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyB0ijoL_gfvaD5WC1Qr27Ppf_ScpP_P62Y
        // $json_file = file_get_contents($this->myUrlEncode("https://maps.googleapis.com/maps/api/geocode/json?address=".$endereco."&key=AIzaSyB0ijoL_gfvaD5WC1Qr27Ppf_ScpP_P62Y"));
        // var_dump(ini_get('allow_url_fopen'));
        // var_dump(ini_get('allow_url_include'));
        // var_dump($this->myUrlEncode("https://maps.googleapis.com/maps/api/geocode/json?address=".$endereco."&key=AIzaSyB0ijoL_gfvaD5WC1Qr27Ppf_ScpP_P62Y"));
        // var_dump($json_file);
        // exit();
        // $json_str = json_decode($json_file, true);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->myUrlEncode("https://maps.googleapis.com/maps/api/geocode/json?address=".$endereco."&key=AIzaSyB0ijoL_gfvaD5WC1Qr27Ppf_ScpP_P62Y"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $json_str = json_decode( $response, true );
        $itens = $json_str['results'][0]['geometry']['location'];
        return $itens;
    }

    
    private function searchClient($person_id){

        $client = $this->Clients->find()->where([
            'person_id'=> $person_id
        ])->first();

        return $client;
    }


    private function addClient($person)
    {
        $c = $this->searchClient($person->id);


        if($c){
            return null;
        }
        $data = $this->request->getData();
        $client = $this->Clients->newEntity();
        $data_client['companies_id'] = $person->company_id;
        $data_client['person_id'] = $person->id;
        $data_client['acting_region'] = 'RN';
        $data_client['active'] = true;
        $data_client['plan_id'] = isset($data['plan_id']) ? $data['plan_id'] : null;
        $client = $this->Clients->patchEntity($client, $data_client);
        $this->Clients->save($client);
        
    }
    
    /**
     * Organiza o upload.
     * @access public
     * @param Array $imagem
     * @param String $data
     */
    private function upload($id)
    {

        $user = $this->Users->get($id,
            [
            'conditions' => [
                'Users.company_id' => $this->request->session()->read('Auth.User.company_id')
            ]
        ]);

        $this->request->session()->write('Upload',
            [
            'table'         => 'Users',
            'column'        => 'image',
            'dir'           => 'users',
            'max_files'     => 1,
            'max_file_size' => 1000000,
            'download'      => true,
            'types_file'    => ['jpe?g', 'png'],
            'id'            => $id
        ]);

        $this->set('user', $user);
    }
  
    private function uploadProfile($client)
    {
        $client = $this->Clients->get($client->id);

        if (!$client) {
            $this->Flash->error(__('Erro imagem não foi salva!'));
            return $this->redirect(['action' => 'add']);
        }
        if($_FILES['perfil']["tmp_name"] == ''){
            return;
        }
     

        $data['file'] = $_FILES['perfil']["tmp_name"];
        $data['info'] = pathinfo($_FILES['perfil']["name"]);
        $data['ext']  = $data['info']['extension'];
        
        $path =  "clients/" . $client->id . "/perfil." . $data['ext'];

        if ($data['ext'] != 'jpg' && $data['ext'] != 'png' && $data['ext'] != 'jpeg') {
            $this->responseStatus = false;
            $this->apiResponse =  [
                'save' => false,
                'path' => null,
                'msg_erro' => 'Extensão da imagem deve ser PNG ou JPG'
            ];
            return;
        }
       
        $result = $this->S3Tools->upImage($path, $data['file']);

        if ($result['@metadata']['statusCode'] == 200) {
            $client->image = $path;

            if ($this->Clients->save($client)) {
                if($client->person_id == $this->request->session()->read('Auth.User.person.id')){
                    $this->request->session()->write('Auth.User.image',$this->S3Tools->getUrlTemp($client->image,120));
                }
                return;
            }

            $this->responseStatus = false;
            $this->apiResponse =   [
                'save' => false,
                'path' => null,
                'msg_erro' => 'Erro ao salvar a imagem no banco'
            ];
        }

        $this->responseStatus = false;
        $this->apiResponse =   [
            'save' => false,
            'path' => null,
            'msg_erro' => 'Falha ao fazer upload de ' . $path
        ];
    }

    private function uploadlocation($client){
        $data['file'] = $_FILES['perfil']["tmp_name"];
        $arquivo_tmp = $_FILES['perfil']['tmp_name'];
        $data['info'] = pathinfo($_FILES['perfil']["name"]);

        $data['ext']  = $data['info']['extension'];
        $path =  "clients/" . $client->id . "/perfil." . $data['ext'];
        

    }

    


}
