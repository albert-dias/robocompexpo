<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use RestApi\Controller\ApiController;

/**
 * MyServices Controller
 * 
 * @property \App\Model\Table\MyServicesTable $Services
 * @method \App\Model\Entity\MyServices[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

 class MyServicesController extends ApiController
 {
    /**
     * Inicialização de componentes necessários
     */
    public function initialize()
    {
        $this->loadModel('Providers');
        $this->loadModel('S3Tools');
        $this->loadModel('ErrorList');
        $this->loadModel('Users');
        $this->loadModel('People');
        $this->loadModel('Clients');
        $this->loadModel('Margin');
        return parent::initialize();
    }

    public function query($sql){
        $connection = ConnectionManager::get('default');
        $query = $connection->execute($sql)->fetchall('assoc');
        return $this->arrayToArrayObj($query);
    }
    public function arrayToObj($arr){
        $object = (object) [];
        foreach ($arr as $key => $value)
        {
          if(is_numeric($value) && strpos($value, ".") !== false){$value = (float)$value;}
          if(is_numeric($value) && strpos($value, ".") == false) { $value = (int)$value;}
          $object->$key = $value;
        }
        return $object;
      }
    
      public function arrayToArrayObj($arr){
        $arr2 = [];
        foreach ($arr as $key => $value){
          $value2 = $this->arrayToObj($value);
          array_push($arr2,$value2);
        }
        return $arr2;
      }

    public function addServices() {

        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        $idPerson = $this->Clients->find()->where(['id =' => $client->id]);
        $idUser = $this->Users->find()->where(['person_id =' => $client->person_id])->first();

        $category = $this->request->data('category');
        $subcategory = $this->request->data('subcategory');
        $price = $this->request->data('price');
        $description = $this->request->data('description');
        $foto = $this->request->data('photo');

        $this->apiResponse['client'] = $client->id;
        $this->apiResponse['people'] = $client->person_id;
        $this->apiResponse['id_user'] = $idUser->id;

        $this->apiResponse['category'] = $category;
        $this->apiResponse['subcategory'] = $subcategory;
        $this->apiResponse['price'] = $price;
        $this->apiResponse['description'] = $description;

        $service = $this->MyServices->newEntity();
        $service->client_id = $client->id;
        $service->category = $category;
        $service->subcategory = $subcategory;
        $service->price = $price;
        $service->description = $description;
        $service->created = date('Y-m-d H:i:s');
        $service->modified = date('Y-m-d H:i:s');
        $service->path = $foto;

        if(!$this->MyServices->save($service)) {
            $this->apiResponse['message'] = 'Erro, não foi possível salvar o serviço.';
            return;
        }
        
        $this->apiResponse['IDRESULT'] = $service->id;
    }

    /**
     * Adicionar imagens no serviço
     */

    public function addServicesImage()
    {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        $myServiceID = $this->request->data('my_service_id');
        $path = $this->request->data('path');

        $this->apiResponse['client'] = $client;
        $this->apiResponse['person'] = $person;
        $this->apiResponse['myServiceID'] = $myServiceID;
        $this->apiResponse['path'] = $path;
        return;
    }

    private function upImagemService($file, $tmp_file, $se_id, $key) {
        $data['file'] = $tmp_file;
        $data['info'] = pathinfo($file);
        $data['ext'] = $data['info']['extension'];

        $path = 'services' . "/" . $se_id . "/" . $key . "." . $data['ext'];

        if ($data['ext'] != 'jpg' && $data['ext'] != 'jpeg' && $data['ext'] != 'png') {
            return [
                'save' => false,
                'path' => null,
                'msg_erro' => 'Extensão da imagem deve ser PNG ou JPG/JPEG'
            ];
        }
        
        $result = $this->S3Tools->upImage($path, $data['file']);

        if($result['@metadata']['statusCode'] == 200) {
            if($this->saveBaseImgService($se_id, $path)) {
                return[
                    'save' => true,
                    'path' => null,
                    'msg_erro' => 'Erro ao salvar imagem no banco.'
                ];
            }
        }

        return [
            'save' => false,
            'path' => null,
            'msg_erro' => 'Falha ao fazer upload de ' . $path
        ];
    }

    private function saveBaseImgService($se_id, $path) {
        $table = TableRegistry::getTableLocator()->get('MyServicesImages');
        $r = $table->newEntity();
        
        $r->my_services_id = $se_id;
        $r->path = $path;
        $r->created = date('Y-m-d H:i:s');

        return $table->save($r);
    }

    /**
     * Localizar todos os serviços de quem está logado como EmpresaTI
     * Pesquisar serviços
     */
    public function setServices()
    {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);

        $person = $this->People->get($client->person_id);

        if($this->request->is('get')){
            $services = $this->MyServices->find()->where([
                'client_id' => $client->id
            ])->toArray();
            $this->apiResponse['services'] = $services;
            return;
        }
    }

    /**
     * Localizar todos os serviços independente de qual EmpresaTI seja
     * Pesquisar serviços
     */
    public function setAllServices()
    {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);

        $person = $this->People->get($client->person_id);

        if($this->request->is('get')){
            $services = $this->query('SELECT my_services.*, users.name, users.num_rating, users.tot_rating
                                      FROM my_services INNER JOIN users WHERE users.id = my_services.client_id');
            $this->apiResponse['services'] = $services;
            return;
        }
    }

    /**
     * Localizar todos os serviços para o cliente logado
     * Pesquisar por serviços
     */
    public function setFilterServices()
    {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);

        $text = '\'%' . $this->request->data('service_name') . '%\'';
        $technic = '\'%' . $this->request->data('name_technic') . '%\'';
        $categoria = $this->request->data('category');
        $search = $this->request->data('search');
        $aux = 'Todas as categorias';

        $latitude = $this->request->data('latitude');
        $longitude = $this->request->data('longitude');

        $filtro = $this->request->data('filtro');

        $table = TableRegistry::get('MyServices');

        if($categoria == $aux) {
            if($search === 'serviços'){
                if($this->request->is('post')){

                    $sql = 'SELECT my_services.*, users.name, users.num_rating, users.tot_rating
                            FROM my_services INNER JOIN users INNER JOIN people INNER JOIN clients
                            WHERE clients.id = my_services.client_id AND clients.person_id = people.id 
                            AND people.name = users.name
                            AND subcategory LIKE '.$text;
                    switch($filtro) {
                        case 'price':
                            $sql = $sql . ' ORDER BY my_services.price ASC, (users.tot_rating / users.num_rating) DESC';
                            break;
                        case 'qualification':
                            $sql = $sql . ' ORDER BY (users.tot_rating / users.num_rating) DESC,  my_services.price ASC';
                            break;
                        case 'quantity':
                            $sql = $sql . ' ORDER BY users.tot_rating DESC';
                            break;
                            case 'distance':
                                $sql  = $sql . 'ORDER BY (SQRT(POWER(('.$latitude.'- people.latitude), 2) + POWER(('.$longitude.'-people.longitude),2))) ASC';
                                break;
                    }
                }
            }
            else{
                if($this->request->is('post')){

                    $sql = 'SELECT my_services.*, users.name, users.num_rating, users.tot_rating
                    FROM my_services INNER JOIN users INNER JOIN people INNER JOIN clients
                    WHERE my_services.client_id = clients.id AND clients.person_id = people.id
                    AND users.person_id = people.id
                    AND people.name LIKE '.$technic;

                    switch($filtro) {
                        case 'price':
                            $sql = $sql . ' ORDER BY my_services.price ASC, (users.tot_rating / users.num_rating) DESC';
                            break;
                        case 'qualification':
                            $sql = $sql . ' ORDER BY (users.tot_rating / users.num_rating) DESC,  my_services.price ASC';
                            break;
                        case 'quantity':
                            $sql = $sql . ' ORDER BY users.tot_rating DESC';
                            break;
                        case 'distance':
                            $sql  = $sql . 'ORDER BY (SQRT(POWER(('.$latitude.'- people.latitude), 2) + POWER(('.$longitude.'-people.longitude),2))) ASC';
                            break;
                    }
                }
            }
        }
        else{
            if($search === 'serviços'){

                $sql = 'SELECT my_services.*, users.name, users.num_rating, users.tot_rating
                FROM my_services INNER JOIN users INNER JOIN people INNER JOIN clients
                WHERE my_services.client_id = clients.id AND clients.person_id = people.id AND users.person_id = people.id
                AND users.person_id = people.id
                AND my_services.subcategory LIKE '. $text .' AND my_services.category LIKE \'' . $categoria.'\'';
                
                    switch($filtro) {
                        case 'price':
                            $sql = $sql . ' ORDER BY my_services.price ASC, (users.tot_rating / users.num_rating) DESC';
                            break;
                        case 'qualification':
                            $sql = $sql . ' ORDER BY (users.tot_rating / users.num_rating) DESC,  my_services.price ASC';
                            break;
                        case 'quantity':
                            $sql = $sql . ' ORDER BY users.tot_rating DESC';
                            break;
                        case 'distance':
                            $sql  = $sql . 'ORDER BY (SQRT(POWER(('.$latitude.'- people.latitude), 2) + POWER(('.$longitude.'-people.longitude),2))) ASC';
                            break;
                    }
            }
            else{
                $sql = 'SELECT my_services.*, users.name, users.num_rating, users.tot_rating
                FROM my_services INNER JOIN people INNER JOIN clients INNER JOIN users
                WHERE my_services.client_id = clients.id AND clients.person_id = people.id
                AND people.name = users.name AND people.name LIKE '.$technic.' AND my_services.category LIKE \'' . $categoria . '\'';

                switch($filtro) {
                    case 'price':
                        $sql = $sql . ' ORDER BY my_services.price ASC, (users.tot_rating / users.num_rating) DESC';
                        break;
                    case 'qualification':
                        $sql = $sql . ' ORDER BY (users.tot_rating / users.num_rating) DESC,  my_services.price ASC';
                        break;
                    case 'quantity':
                        $sql = $sql . ' ORDER BY users.tot_rating DESC';
                        break;
                    case 'distance':
                        $sql  = $sql . 'ORDER BY (SQRT(POWER(('.$latitude.'- people.latitude), 2) + POWER(('.$longitude.'-people.longitude),2))) ASC';
                        break;
                }
            }
        }

        $services = $this->query($sql);
        
        $this->apiResponse['services'] = $services;
        $this->apiResponse['TEXTO'] = $text;
        $this->apiResponse['RESPOSTA'] = $filtro;

        return;
    }

    public function filterServiceSelected()
    {
        $serv = $this->request->data('search');
        $sql = 'SELECT my_services.*, people.email, people.number, people.number_contact, people.address, people.name
                FROM my_services LEFT JOIN clients ON clients.id = my_services.client_id
                LEFT JOIN people ON people.id = clients.person_id WHERE my_services.id = ' . $serv;
        
        if($this->request->is('post')){
            $filter = $this->query($sql);
            $this->apiResponse['sql'] = $filter;
            return;
        }
    }

    /**
     * Retirar serviços da base de dados
     * Excluir serviços
     */

    public function deleteServices($idS)
    {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        if($this->request->is('post')){
            $service = $this->MyServices->get($idS);
            $result = $this->MyServices->delete($service);

            if($result){
                $this->apiResponse['message'] = 'Delete realizado com sucesso.';
            }else{ $this->apiResponse['message'] = 'Não foi possível deletar o serviço.'; }
           return;
         }
    }

    /**
     * Modifica serviços na base de dados
     * Editar serviços
     */

    public function updateServices()
    {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        $price = $this->request->data('price');
        $description = $this->request->data('description');
        $foto = $this->request->data('photo');


        if($this->request->is('post')){
            $id = $this->request->data('id');
            
            $myServices_table = TableRegistry::get('MyServices');
            $service = $myServices_table->find()->where(['id =' => $id])->first();
            $service->price = $price;
            $service->description = $description;
            $service->modified = date('Y-m-d H:i:s');

            if(!$this->MyServices->save($service)) {
                $this->apiResponse['alert'] = 'Erro, não foi possível modificar o serviço.';
                return;
            }
            
            

            $this->apiResponse['alert'] = 'Serviço atualizado com sucesso.';
            $this->apiResponse['id'] = $service->id;
            return;
        }
    }
 }