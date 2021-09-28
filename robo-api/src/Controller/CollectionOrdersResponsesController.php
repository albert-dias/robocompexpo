<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validation;
use RestApi\Controller\ApiController;
use RestApi\Utility\JwtToken;

class CollectionOrdersResponsesController extends ApiController {
  public function initialize() {
    $this->loadModel('Users');
    $this->loadModel('CollectionOrders');
    $this->loadModel('Clients');
    return parent::initialize();
  }

  public function create() {
    $collection_order_id = $this->request->data('collection_order_id');

    if(!$collection_order_id) {
      $this->responseStatus = false;
      $this->apiResponse = "Falha ao cadastrar resposta a solicitação de coleta";
      return;
    }

    /*
    $collection_order = checkCollectionOrder($collection_order_id);
    if(!$collection_order || $collection_order->status !== 'pendente') {
      $this->responseStatus = false;
      $this->apiResponse = "Falha ao cadastrar resposta a solicitação de coleta";
      return;
    }
    */

    $d = $this->jwtPayload;
    $client = $this->Clients->get($d->id);
    $user = $this->Users->find()->where([
      'person_id' => $client->person_id
    ])->first();

    $collection_order_response = $this->CollectionOrdersResponses->newEntity();
    $collection_order_response->collection_order_id = $collection_order_id;
    $collection_order_response->users_id = $user->id;
    if ($this->CollectionOrdersResponses->save($collection_order_response)) {
      $this->apiResponse = "Resposta a solicitação de coleta cadastrada com sucesso";
    } else {
      $this->responseStatus = false;
      $this->apiResponse = "Falha ao cadastrar resposta a solicitação de coleta";
    }
  }

  private function checkCollectionOrder($id) {
    try {
      $collection_order = $this->CollectionOrders->get($id);
      return $collection_order;
    } catch(Cake\Datasource\Exception\RecordNotFoundException $e) {
      return false;
    }
  }
}