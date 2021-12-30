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
class EmployeeController extends AppController
{   

    public function initialize() {
        parent::initialize();
        $this->loadModel('Users');
        $this->loadModel('People');
        $this->loadModel('UserRelationships');
        $this->loadModel('UsersCategories');
        $this->loadModel('Clients');
        $this->loadComponent('S3Tools');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {    
        $list = null;
        $this->set(compact('list'));
        $person = $this->request->session()->read('Auth.User');
        if($person['plan_id'] == 4){
            $this->render('index_gerador');
        }
        if($person['plan_id'] == 5){

            $this->render('index_plans_basic');
        }
       
    }


    public function lists($list = null){
        
        $this->set(compact('list'));
        $person = $this->request->session()->read('Auth.User');
        if($person['plan_id'] == 4){
            $this->render('index_gerador');
        }
        if($person['plan_id'] == 5){
            $this->render('index_plans_basic');
        }
    }

    public function listJson($list = null){
        $where = null;
        if($list == 'active'){
            $where = "AND u.active = true";
        }elseif($list == 'inactive'){
            $where = "AND u.active = false";
        }
        $person = $this->request->session()->read('Auth.User');
        $data = $this->request->getData();
        $company_id = $this->current_Company();
        $users = $this->query("SELECT 
            u.name,
            u.email,
            ut.type,
            p.id as `id_person`,
            person.number_contact,
            c.image,u.id as `id_user`, 
            p.title,
            c.image
        FROM users as u
        INNER JOIN people as person ON person.id = u.person_id
        INNER JOIN clients as c ON c.person_id = person.id
        INNER JOIN users_types as ut ON u.users_types_id = ut.id
        INNER JOIN plans as p ON p.id = u.plan_id
        INNER JOIN user_relationships as ur ON ur.user_id = u.id
        WHERE  ur.active = true AND ur.company_id = $company_id $where ORDER BY ur.company_id DESC");
        foreach ($users as $user) {
            if($user->id_user == $person['id']){
                $user->islogin = 1;
            }else{
                $user->islogin = 0;
            }
            if($user->image){
                $user->image = $this->S3Tools->getUrlTemp($user->image, 120);
            }else{
                $user->image = $this->request->getAttribute("webroot")."webroot/assets/images/sem-fotos.png";
            }
            $user->option = null;
        }
        
        if($person['plan_id'] == 5){
            foreach ($users as $user) {
                if($user->id_user == $person['id']){
                    $user->islogin = 1;
                }else{
                    $user->islogin = 0;
                }
                $users_categories_query = $this->query("SELECT * FROM users_categories as uc 
                INNER JOIN categories as c ON c.id = uc.categorie_id WHERE uc.user_id = ".$user->id_user);
                $users_categories = array();
                foreach ($users_categories_query as $value) {

                    array_push($users_categories,"<img style='width: 30px;' src='".$this->request->webroot."/".$value->url_icon."' alt='$value->name' title='$value->name'>&nbsp;");
                }
                $user->categories = $users_categories;
            }
        }
        
        $json = $this->datatableQueryjsontojson($users,$data);

        $this->set('json',$json);
        $this->set('_serialize',array('json'));
        $this->response->statusCode(200);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $company_id = $this->current_Company();
        $user_relationships = TableRegistry::get('user_relationships');
        $user_check = $user_relationships
                    ->find('all')
                    ->where(['user_id'=>$id,'company_id'=>$company_id,'active'=>true])
                    ->order(['user_id' => 'DESC'])
                    ->toArray();
        if(!empty($user_check)){
            $user = $this->Users->get($id, [
                'contain' => ['People']
            ]);
        }else{
            return $this->redirect(['controller'=>'pages','action' => 'index']);
        }
        
        
        
        $this->set('user', $user);
    }

    



    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $People = $this->People->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['company_id'] = $this->current_Company();
            $this->request->data['Users.active'] = true;
            $person = $this->request->session()->read('Auth.User');
            $People = null;
            if($person['plan_id'] == 4){
                $this->addGerador();
            }
            if($person['plan_id'] == 5){
                $this->addPlansBasic();
            }
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('People'));
        $person = $this->request->session()->read('Auth.User');
        if($person['plan_id'] == 4){
            $this->render('add_gerador');
        }
        if($person['plan_id'] == 5){
            $option_mult_query = $this->query("SELECT id, `name` FROM `categories`");
            $option_mult = [];
     
            foreach ($option_mult_query as  $value) {
                $option_mult[$value->id] = $value->name;
            }
            

            $this->set(compact('option_mult'));
            $this->render('add_plans_basic');
        }
        
    }

    private function addGerador(){
        $data = $this->request->getData();
        $datainicial = new \DateTime($data['date_of_birth']);
        $datafinal = new \DateTime(date('Y-m-d'));
        $invertal = $datainicial->diff($datafinal);
        if($invertal->format( '%Y' ) < 18){
            $this->Flash->error(__('Colaborado precisa ter maior de 18 anos.'));
            return $this->redirect(['action' => 'index']);
        }
        $data['cpf'] = str_replace(".", "", str_replace("-", "", $data['cpf']));
        $data['rg'] = str_replace(".", "", str_replace("-", "", $data['rg']));
        $data['cep'] = str_replace(".", "", str_replace("-", "", $data['cep']));
        $data['number_contact'] = str_replace("(", "", str_replace(")", "", str_replace(" ", "",  str_replace("-", "", $data['number_contact']))));
        // $this->d($data);
        $People = TableRegistry::get('people');
        $users = TableRegistry::get('users');

        //checar se usuario já existe
        $check = $this->query("SELECT COUNT(*) as `check`, id,plan_id FROM `users` WHERE cpf =".$data['cpf'])[0];
        if($check->check != 0){
            if(!($this->validaCPF($data['cpf']))){
                $this->Flash->error(__('CPF não é valido'));
                return $this->redirect(['action' => 'index']);
            }
            $user_relationships = TableRegistry::get('user_relationships');
            $user = $user_relationships
                    ->find('all')
                    ->where(['user_id'=>$check->id])
                    ->order(['user_id' => 'DESC'])
                    ->toArray();
                    
            if(empty($user)){
                if ($user['active']) {
                    $this->Flash->info(__('CPF cadastrado em outra empresa.'));
                    return $this->redirect(['action' => 'index']);
                }else{
                   if($check->plan_id == 1 || $check->plan_id == 2){
                    $user_id = $check->id;
                    $company_id = $this->current_Company();
                    $this->user_relationships($user_id,$company_id);
                    return $this->redirect(['action' => 'index']);
                   }else{
                    $this->Flash->error(__('esse CPF tem um plano que não pode ser cadastrado na sua empresa.'));
                    return $this->redirect(['action' => 'index']);
                   }
                }
                
            }else{
                $user_id = $check->id;
                $company_id = $this->current_Company();
                $this->user_relationships($user_id,$company_id);
                return $this->redirect(['action' => 'index']);
            }
            
        }
        
        // cadastra dados para tabela people
        $People = $this->People->newEntity();
        $People->name = $data['name'];
        $People->cpf = $data['cpf'];
        $People->rg = $data['rg'];
        $People->city = $data['city'];
        $People->email = $data['email'];
        $People->institution_rg = $data['institution_rg'];
        $People->date_of_birth = $data['date_of_birth'];
        $People->number_contact = $data['number_contact'];
        $People->cep = $data['cep'];
        $People->address = $data['address'];
        $People->complement = $data['complement'];
        $People->number = $data['number'];
        $People->district = $data['district'];
        $People->state = $data['state'];
        $People->gender = $data['gender'];
        $arracoordenadas = $this->Coord(str_replace(" ","+",$data['number'])."+".str_replace(" ","+",$data['address'])
        .",+".str_replace(" ","+",$data['district']).",+".str_replace(" ","+",$data['city']));
        
        $People->latitude = $arracoordenadas['lat'];
        $People->longitude = $arracoordenadas['lng'];


        $people_id = $this->People->save($People);
        if ($people_id) {
            $this->addClient($people_id);
            $users = $this->Users->newEntity();
            $users->company_id = 1;
            $users->person_id = $people_id->id;
            $users->active = true;   
            $users->name = $data['name'];
            $users->email = $data['email'];
            $users->nickname = $data['nickname'];
            $users->users_types_id = 5;
            $users->plan_id = null;
            $users->cpf = $data['cpf'];
            $users->password = $data['password'];
            $user_id = $this->Users->save($users);
            if ($user_id) {
                //salvar foto do perfil
                $client =$this->searchClient($people_id->id);
               
                $this->uploadProfile($client);
                //salvar em user_relationships
                $user_id = $user_id->id;
                $company_id = $this->current_Company();
                $this->user_relationships($user_id,$company_id);
                $this->Flash->success(__('Usuário salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
            } 

        }

    }

    private function addPlansBasic(){
        $data = $this->request->getData();
        $datainicial = new \DateTime($data['date_of_birth']);
        $datafinal = new \DateTime(date('Y-m-d'));
        $invertal = $datainicial->diff($datafinal);
        if($invertal->format( '%Y' ) < 18){
            $this->Flash->error(__('Colaborado precisa ter maior de 18 anos.'));
            return $this->redirect(['action' => 'index']);
        }
        $data['cpf'] = str_replace(".", "", str_replace("-", "", $data['cpf']));
        $data['rg'] = str_replace(".", "", str_replace("-", "", $data['rg']));
        $data['cep'] = str_replace(".", "", str_replace("-", "", $data['cep']));
        $data['number_contact'] = str_replace("(", "", str_replace(")", "", str_replace(" ", "",  str_replace("-", "", $data['number_contact']))));
        $People = TableRegistry::get('people');
        $users = TableRegistry::get('users');
        //checar se usuario já existe
        $check = $this->query("SELECT COUNT(*) as `check`, id,plan_id FROM `users` WHERE cpf =".$data['cpf'])[0];
        if($check->check != 0){
            if(!($this->validaCPF($data['cpf']))){
                $this->Flash->error(__('CPF não é valido'));
                return $this->redirect(['action' => 'index']);
            }
            $user_relationships = TableRegistry::get('user_relationships');
            $user = $user_relationships
                    ->find('all')
                    ->where(['user_id'=>$check->id])
                    ->order(['user_id' => 'DESC'])
                    ->toArray();
                    
            if(empty($user)){
                if ($user['active']) {
                    $this->Flash->info(__('CPF cadastrado em outra empresa.'));
                    return $this->redirect(['action' => 'index']);
                }else{
                    if($check->plan_id == 1 || $check->plan_id == 2){
                        $user_id = $check->id;
                        $company_id = $this->current_Company();
                        $this->user_relationships($user_id,$company_id);
                        return $this->redirect(['action' => 'index']);
                    }else{
                        $this->Flash->error(__('esse CPF tem um plano que não pode ser cadastrado na sua empresa.'));
                        return $this->redirect(['action' => 'index']);
                    }
                }
                
            }else{
                $user_id = $check->id;
                $company_id = $this->current_Company();
                $this->user_relationships($user_id,$company_id);
                return $this->redirect(['action' => 'index']);
            }
            
        }
        // cadastra dados para tabela people
        
        $People = $this->People->newEntity();
        $People->name = $data['name'];
        $People->cpf = $data['cpf'];
        $People->rg = $data['rg'];
        $People->city = $data['city'];
        $People->email = $data['email'];
        $People->institution_rg = $data['institution_rg'];
        $People->date_of_birth = $data['date_of_birth'];
        $People->number_contact = $data['number_contact'];
        $People->cep = $data['cep'];
        $People->address = $data['address'];
        $People->complement = $data['complement'];
        $People->number = $data['number'];
        $People->district = $data['district'];
        $People->state = $data['state'];
        $People->gender = $data['gender'];
        $arracoordenadas = $this->Coord(str_replace(" ","+",$data['number'])."+".str_replace(" ","+",$data['address'])
        .",+".str_replace(" ","+",$data['district']).",+".str_replace(" ","+",$data['city']));
        $People->latitude = $arracoordenadas['lat'];
        $People->longitude = $arracoordenadas['lng'];
        $people_id = $this->People->save($People);
        if ($people_id) {
            $this->addClient($people_id);
            $users = $this->Users->newEntity();
            $users->company_id = 1;
            $users->person_id = $people_id->id;
            $users->active = true;   
            $users->name = $data['name'];
            $users->email = $data['email'];
            $users->nickname = $data['nickname'];
            $users->users_types_id = 4;
            $users->plan_id = 1;
            $users->cpf = $data['cpf'];
            $users->password = $data['password'];
            $user_id = $this->Users->save($users);
            if ($user_id) {
                //salvar foto do perfil
                $client =$this->searchClient($people_id->id);
                $this->uploadProfile($client);
                //salvar em user_relationships
                $user_id = $user_id->id;
                $company_id = $this->current_Company();
                $this->user_relationships($user_id,$company_id);
                $data_categories = [];
                foreach ($data['categories'] as  $value) {
                        $UsersCategories =  $this->UsersCategories->newEntity();
                        $UsersCategories->user_id = $user_id;
                        $UsersCategories->categorie_id = $value;
                        $this->UsersCategories->save($UsersCategories);
                    
                }
                return $this->redirect(['action' => 'index']);
            } 
            $this->Flash->error(__('Error ao salva'));
            return $this->redirect(['action' => 'index']);

        }
        


    }


    private function user_relationships($user_id,$company_id){
        $user_relationships = $this->UserRelationships->newEntity();
        $user_relationships->company_id = $company_id;
        $user_relationships->user_id = $user_id;
        $user_relationships->active = true;
        if ($this->UserRelationships->save($user_relationships)) {
            $person = $this->request->session()->read('Auth.User');
            if($person['plan_id'] == 4){
                $this->Flash->success(__('Colaborador cadastrado com sucesso.'));
            }
            if($person['plan_id'] == 5){
                $this->Flash->success(__('Associado cadastrado com sucesso.'));
            }
           
        }
        
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $company_id = $this->current_Company();
        $user_relationships = TableRegistry::get('user_relationships');
        $user_check = $user_relationships
                    ->find('all')
                    ->where(['user_id'=>$id,'company_id'=>$company_id,'active'=>true])
                    ->order(['user_id' => 'DESC'])
                    ->toArray();
        if(empty($user_check)){
            return $this->redirect(['controller'=>'pages','action' => 'index']);
        }
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        
        $People = $this->People->get($user->person_id, [
            'contain' => ['Users']
        ]);
        $person = $this->request->session()->read('Auth.User');
        $client =$this->searchClient($user->person_id);
        $this->addClient($People);
        

        $UsersCategories = $this->UsersCategories
        ->find('all')
        ->where(['user_id'=>$id])->toArray();
        

        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            if(!($this->validaCPF($data['cpf']))){
                $this->Flash->error(__('CPF não é valido'));
                return $this->redirect(['action' => 'index']);
            }
            $datainicial = new \DateTime($data['date_of_birth']);
            $datafinal = new \DateTime(date('Y-m-d'));
            $invertal = $datainicial->diff($datafinal);
            if($invertal->format( '%Y' ) < 18){
                $this->Flash->error(__('Colaborado precisa ter maior de 18 anos.'));
                return $this->redirect(['action' => 'index']);
            }
            $data['cpf'] = str_replace(".", "", str_replace("-", "", $data['cpf']));
            $data['rg'] = str_replace(".", "", str_replace("-", "", $data['rg']));
            $data['cep'] = str_replace(".", "", str_replace("-", "", $data['cep']));
            $data['number_contact'] = str_replace("(", "", str_replace(")", "", str_replace(" ", "",  str_replace("-", "", $data['number_contact']))));
            $arracoordenadas = $this->Coord(str_replace(" ","+",$data['number'])."+".str_replace(" ","+",$data['address'])
            .",+".str_replace(" ","+",$data['district']).",+".str_replace(" ","+",$data['city']));
            $People = $this->People->patchEntity($People, $data);
            $People->latitude = $arracoordenadas['lat'];
            $People->longitude = $arracoordenadas['lng'];
            $People->active = true;
            $People = $this->People->save($People);
            if ($People) {
                $user = $this->Users->patchEntity($user, $this->request->getData());
                $user_id = $this->Users->save($user);
                if($user_id){
                    if($person['plan_id'] == 5){
                        foreach ($UsersCategories as $value) {
                            $id_categorie = $value->id;
                            $aux = $this->UsersCategories->get($id_categorie, [
                                'contain' => []
                            ]);
                            $this->UsersCategories->delete($aux);
                        }
                        $user_id = $user_id->id;
                        foreach ($data['categories'] as  $value) {
                            $UsersCategories =  $this->UsersCategories->newEntity();
                            $UsersCategories->user_id = $user_id;
                            $UsersCategories->categorie_id = $value;
                            if(!$this->UsersCategories->save($UsersCategories)){
                                $this->Flash->error(__('Usuário não pode ser salvo. Por favor, tente novamente.'));
                            }
                        }
                        
                        //salvar foto do perfil
                        

                        
                    }
                    $this->uploadProfile($client);
                    $this->Flash->success(__('Usuário salvo com sucesso.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('Usuário não pode ser salvo. Por favor, tente novamente.'));
                return $this->redirect(['action' => 'index']);
            }
            
        }
        $this->set(compact('People','avatar'));
        $person = $this->request->session()->read('Auth.User');

        if($person['plan_id'] == 4){
            $this->render('edit_gerador');
        }

        if($person['plan_id'] == 5){
            // UsersCategories
            $option_select_query = $this->query("SELECT * FROM users_categories as uc INNER JOIN categories as c ON c.id = uc.categorie_id WHERE uc.user_id =".$id);
            $option_mult_query = $this->query("SELECT id, `name` FROM `categories`");

            $option_mult = [];
            $option_select = [];
            foreach ($option_select_query as $key => $value) {
                $option_select[$key] = $value->id;
            }
            foreach ($option_mult_query as  $value) {
                $option_mult[$value->id] = $value->name;
            }
            


            $this->set(compact('option_mult','option_select'));
            $this->render('edit_plans_basic');
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $company_id = $this->current_Company();
        $user_relationships = TableRegistry::get('user_relationships');
        $user_check = $user_relationships
                    ->find('all')
                    ->where(['user_id'=>$id,'company_id'=>$company_id,'active'=>true])
                    ->order(['user_id' => 'DESC'])
                    ->toArray();
        if(empty($user_check)){
            return $this->redirect(['controller'=>'pages','action' => 'index']);
        }
        $this->request->allowMethod(['post', 'delete']);
        // $user = $this->Users->get($id);
        
        // $this->Can->check($user->company_id);
        $user_relationships = $this->UserRelationships
                                    ->find('all')
                                    ->where(["user_id"=>$id,"active"=>true])->first();
                               
        $aux = array(
            'id'=>$user_relationships->id,
            'user_id'=>$id,
            'active'=>false
        );
        $user_relationships = $this->UserRelationships->patchEntity($user_relationships, $aux);    
        if ($this->UserRelationships->save($user_relationships)) {
            $this->Flash->success(__('Usuário removido com sucesso.'));
        } else {
            $this->Flash->error(__('Usuário não pode ser removido. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
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
