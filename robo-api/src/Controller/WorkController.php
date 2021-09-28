<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use RestApi\Controller\ApiController;

/**
 * Work Controller
 * 
 * @property \App\Model\Table\WorkTable $Work
 * @method \App\Model\Entity\Work[]|\Cake|Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

 class WorkController extends ApiController
 {
     /**
      * Inicialização de Componentes Necessários
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

      public function addWork() {
          $token = $this->jwtPayload;
          $client = $this->Clients->get($token->id);
          $people = $this->People->get($client->person_id);

          $id_work = $this->request->data('id_work');
          $code_tec = $this->request->data('code_tec');
          $cod_client = $this->request->data('cod_client');
          $hour = $this->request->data('hour');
          $day = $this->request->data('day');
          $month = $this->request->data('month');
          $year = $this->request->data('year');
          $hour = $this->request->data('hour');
          $time = $this->request->data('time');

          $code_work = $year . $month . $day . $hour . $time;

          if($this->request->is('post')){
              $addWork = $this->Work->newEntity();

              $addWork->id_work = $id_work;
              $addWork->code_tec = $code_tec;
              $addWork->cod_client = $cod_client;
              $addWork->accepted = '1';
              $addWork->day = $day;
              $addWork->month = $month;
              $addWork->year = $year;
              $addWork->hour  = $hour ;
              $addWork->time = $time;
              $addWork->code_work = $code_work;
              
              $result = $this->Work->save($addWork);
              if(!$result){
                  $this->apiResponse['MENSAGEM'] = 'Não foi possível salvar o trabalho.';
                  return;
              }

              $this->apiResponse['MENSAGEM'] = 'Trabalho salvo na agenda. ' . $result;
          }

          $work = $this->apiResponse['USUÁRIO'] = 'CODE: ' . $code_work;
          return;
      }
 }