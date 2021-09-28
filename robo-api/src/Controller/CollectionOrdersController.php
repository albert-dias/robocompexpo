<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use RestApi\Controller\ApiController;
use Cake\Datasource\ConnectionManager;

/**
 * ServiceOrders Controller
 *
 * @property \App\Model\Table\ServiceOrdersTable $ServiceOrders
 *
 * @method \App\Model\Entity\ServiceOrder[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CollectionOrdersController extends ApiController
{

    public function initialize()
    {
        $this->loadModel('CollectionOrders');
        $this->loadModel('Users');
        $this->loadModel('Clients');
        $this->loadModel('People');
        $this->loadModel('CollectionOrdersCategories');
        $this->loadComponent('S3Tools');
        $this->loadComponent('ErrorList');
        return parent::initialize();
    }

    private function getUserLogged() {
      $d = $this->jwtPayload;
      $client = $this->Clients->get($d->id);
      $person = $this->People->get($client->person_id);
      $query = $this->Users->find('all')->where(['person_id =' => $person->id]);
      return $query->first();
    }

    private function getPersonLogged() {
      $d = $this->jwtPayload;
      $client = $this->Clients->get($d->id);
      $person = $this->People->get($client->person_id);
      return $person;
    }

    public function insert() {
      $d = $this->jwtPayload;
      $client = $this->Clients->get($d->id);
      $person = $this->People->get($client->person_id);
      $query = $this->Users->find('all')->where(['person_id =' => $person->id]);
      $user = $query->first();

      $collection_order = $this->CollectionOrders->newEntity();
      $collection_order->users_id = $user->id;
      $collection_order->quantity_garbage_bags = $this->request->data('quantity_garbage_bags');
      $collection_order->date_service_ordes = $this->request->data('datetime_collection_ordes');

      if($this->request->data('use_person_address')) {
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
        $collection_order->latitude = $this->request->data('latitude');
        $collection_order->longitude = $this->request->data('longitude');
      }
      $collection_order->comments = $this->request->data('comments');
      $collection_order->status = 'pendente';
      $collection_order->period = $this->request->data('period');
      $collection_order->type = $this->request->data('type');
      $this->CollectionOrders->save($collection_order);

      /*
      $msg_erro = $this->ErrorList->errorInString($collection_order->errors());
      $this->apiResponse['message'] = $msg_erro.' - 1001';
      return;
      */

      $categorie_ids = $this->request->data('categorie_ids');
      if(!is_null($categorie_ids)) {
        $categorie_ids = json_decode($categorie_ids);
        foreach($categorie_ids as $categorie_id) {
          $collection_order_categories = $this->CollectionOrdersCategories->newEntity();
          $collection_order_categories->collection_orders_id = $collection_order->id;
          $collection_order_categories->categorie_id = $categorie_id;
          $this->CollectionOrdersCategories->save($collection_order_categories);
        }
      }

      foreach ($_FILES['file']['name'] as $key => $value) {
        $name = $_FILES['file']['name'][$key];
        $tmp_name = $_FILES['file']['tmp_name'][$key];
        $key = bin2hex(openssl_random_pseudo_bytes(10));
        $a = $this->upImagem($name, $tmp_name, $collection_order->id, $key);
        if (!$a['save']) {
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => $a['msg_erro']
            ];
            return;
        }
      }

      $this->apiResponse['message'] = 'salvo com sucesso';
      return;
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
        return [
          'save' => false,
          'path' => null,
          'msg_erro' => 'Extensão da imagem deve ser PNG ou JPG'
        ];
      }

      $result = $this->S3Tools->upImage($path, $data['file']);

      if ($result['@metadata']['statusCode'] == 200) {
        if ($this->saveBaseImg($os_id, $path)) {
          return [
            'save' => true,
            'path' => $path,
            'msg_erro' => ''
          ];
        }
        return [
          'save' => false,
          'path' => null,
          'msg_erro' => 'Erro ao salvar a imagem no banco'
        ];
      }

      return [
        'save' => false,
        'path' => null,
        'msg_erro' => 'Falha ao fazer upload de ' . $path
      ];
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

    public function getAll() {
      $d = $this->jwtPayload;
      //$person = $this->getPersonLogged();

      $latitude = $this->request->data('latitude');
      $longitude = $this->request->data('longitude');

      $sql = 'SELECT collection_orders.* FROM collection_orders INNER JOIN plans ON (collection_orders.latitude - ' . $latitude . ') * (collection_orders.latitude - ' . $latitude . ') + (collection_orders.longitude - ' . $longitude . ') * (collection_orders.longitude - ' . $longitude . ') <= plans.radius * plans.radius INNER JOIN users ON users.plan_id = plans.id INNER JOIN clients ON clients.person_id = users.person_id WHERE clients.id = ' . $d->id;
      $collection_orders = $this->query($sql);

      /*
      $collection_orders = $this->CollectionOrders->find("all")->where([
        'status' => 'pendente', 
        'latitude >=' => $person->latitude - $this->radius, 
        'latitude <=' => $person->latitude + $this->radius, 
        'longitude >=' => $person->longitude - $this->radius,
        'longitude <=' => $person->longitude + $this->radius
        ])->toArray();*/
      foreach ($collection_orders as $collection_order) {
        $collection_order->image = $this->getFirstImageOC($collection_order->id);
        $collection_order->images = $this->listImagesOC($collection_order->id);

        $collection_order->collection_order_response = $this->getResponse($collection_order->id);
      }

      $this->apiResponse["collection_orders"] = $collection_orders;
    }

    /**
     * Lista OS que estão agendadas para o cliente 
     */
    public function listOsScheduledClient($status)
    {
        $user = $this->getUserLogged();

        $page = $this->request->data('page') ?: 1;
        $limit = $this->request->data('limit') ?: 10;

        $list = $this->CollectionOrders->find()
            ->where([
                'status' => $status,
                'users_id' => $user->id
            ])
            ->order('CollectionOrders.created')->limit($limit)->offset(($page - 1) * $limit);

        $return = [];

        foreach ($list as $value) {
            $return[] = [
                'id'          => $value->id,
                'quantity_garbage_bags'    => $value->quantity_garbage_bags,
                'date_service_ordes'       => $value->date_service_ordes->format('d/m/Y H:i:s'),
                'address' => $value->address,
                'number'    => $value->number,
                'complement'   => $value->complement,
                'comments' => $value->comments,
                'status' => $value->status,
                'district' => $value->district,
                'city' => $value->city,
                'state' => $value->state,
                'created'        => $value->created->format('d/m/Y H:i:s'),
                'period' => $value->period
            ];
        }

        $this->apiResponse = $return;
    }

    public function cancelCollectionOrder($collection_order_id) {
      $user = $this->getUserLogged();

      $collection_order = $this->CollectionOrders->get($collection_order_id);
      if($collection_order->users_id != $user->id) {
        $this->apiResponse['message'] = 'Você não tem permissão cancelar esta solicitação de coleta';
        return;
      }
      
      if($collection_order->status == 'finalizada') {
        $this->apiResponse['message'] = 'Esta solicitação de coleta já se encontra finalizada';
        return;
      }

      $collection_order->status = 'cancelada';
      $this->CollectionOrders->save($collection_order);
      $this->apiResponse['message'] = 'Solicitação de coleta cancelada com sucesso';
      return;
    }

    /*
    * Retorna detalhes da OS pelo seu ID
    */
    public function getDetailOc()
    {
        $oc_id = $this->request->data('oc_id');
        $oc = $this->CollectionOrders->get($oc_id);

        $oc->images = $this->listImagesOC($oc->id);

        $this->apiResponse = $oc;
        //$this->apiResponse["images"] = $images;
    }

    /**
     * Lista as images cadastradas para OS
     */
    private function listImagesOC($oc_id)
    {
        $t = TableRegistry::get('CollectionOrdersImages');
        $images = $t->find()->where([
            'collection_orders_id' => $oc_id
        ])->order('created')->all();
        $urls_aws = [];

        foreach ($images as  $value) {
            $urls_aws[] = [
                'image_id' => $value->id,
                'url' => $this->S3Tools->getUrlTemp($value->path, '1000')
            ];
        }

        return $urls_aws;
    }

    private function getFirstImageOC($oc_id) {
      $t = TableRegistry::get('CollectionOrdersImages');
      $image = $t->find()->where([
        'collection_orders_id' => $oc_id
      ])->order('created')->first();

      if ($image) {
        return $this->S3Tools->getUrlTemp($image->path, '1000');
      }

      return null;
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

    private function getResponse($id) {
      $d = $this->jwtPayload;
      $sql = "select collection_orders_responses.* from collection_orders_responses inner join users on users.id = collection_orders_responses.users_id inner join clients on clients.person_id = users.person_id where clients.id = " . $d->id;
      $esponses = $this->query($sql);
      return count($responses) > 0 ? $responses[0] : null;
    }
}
