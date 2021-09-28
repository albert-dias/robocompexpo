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
class MyServiceOrdersController extends ApiController
{

    public function initialize()
    {
        $this->loadModel('MyServiceOrders');
        $this->loadModel('Users');
        $this->loadModel('Clients');
        $this->loadModel('People');
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
      $id = $this->request->data('id');

      $this->apiResponse['ID'] = $id;
      return;
    }

    /**
     * Upload de imagens do serviço
     */
    private function upImagem($file, $tmp_file, $se_id, $key)
    {
      $data['file'] = $tmp_file;
      $data['info'] = pathinfo($file);
      $data['ext']  = $data['info']['extension'];

      $path = 'service' . "/" . $se_id . "/" . $key . "." . $data['ext'];

      if ($data['ext'] != 'jpg' && $data['ext'] != 'jpeg' && $data['ext'] != 'png') {
        return [
          'save' => false,
          'path' => null,
          'msg_erro' => 'Extensão da imagem deve ser PNG ou JPG'
        ];
      }

      $result = $this->S3Tools->upImage($path, $data['file']);

      if ($result['@metadata']['statusCode'] == 200) {
        if ($this->saveBaseImg($se_id, $path)) {
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
    private function saveBaseImg($se_id, $path)
    {
      $table = TableRegistry::getTableLocator()->get('MyServiceOrdersImages');
      $r = $table->newEntity();
      $r->my_service_orders_id = $se_id;
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

        $list = $this->MyServiceOrders->find()
            ->where([
                'status' => $status,
                'users_id' => $user->id
            ])
            ->order('MyServiceOrders.created')->limit($limit)->offset(($page - 1) * $limit);

        $return = [];

        foreach ($list as $value) {
            $return[] = [
                'id'          => $value->id,
                'service_name' => $value->service_name,
                'price'    => $value->price,
                'description' => $value->description,
                'created'        => $value->created->format('d/m/Y H:i:s'),
            ];
        }

        $this->apiResponse = $return;
    }

    public function cancelMyServiceOrder($my_service_order_id) {
      $user = $this->getUserLogged();

      $my_service_order = $this->MyServiceOrders->get($my_service_order_id);
      if($my_service_order->users_id != $user->id) {
        $this->apiResponse['message'] = 'Você não tem permissão de cancelar este serviço';
        return;
      }
      
      if($my_service_order->status == 'finalizada') {
        $this->apiResponse['message'] = 'Este serviço já se encontra finalizado';
        return;
      }

        if($my_service_order->status = 'cancelada') {
        $this->CollectionOrders->save($collection_order);
        $this->apiResponse['message'] = 'Solicitação de coleta cancelada com sucesso';
        return;
        }
    }

    /*
    * Retorna detalhes da OS pelo seu ID
    */
    public function getDetailOc()
    {
        $oc_id = $this->request->data('oc_id');
        $oc = $this->MyServiceOrders->get($oc_id);

        $oc->images = $this->listImagesOC($oc->id);

        $this->apiResponse = $oc;
        //$this->apiResponse["images"] = $images;
    }

    /**
     * Lista as images cadastradas para OS
     */
    private function listImagesOC($oc_id)
    {
        $t = TableRegistry::get('MyServiceOrdersImages');
        $images = $t->find()->where([
            'my_service_orders_id' => $oc_id
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
      $t = TableRegistry::get('MyServiceOrdersImages');
      $image = $t->find()->where([
        'my_service_orders_id' => $oc_id
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
      $sql = "select my_service_orders_responses.* from my_service_orders_responses inner join users on users.id = my_service_orders_responses.users_id inner join clients on clients.person_id = users.person_id where clients.id = " . $d->id;
      $esponses = $this->query($sql);
      return count($responses) > 0 ? $responses[0] : null;
    }
}
