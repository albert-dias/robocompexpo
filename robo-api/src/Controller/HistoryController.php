<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use RestApi\Controller\ApiController;

/**
 * History Controller
 * 
 * @property \App\Model\Table\HistoryMachineTable $History
 * @method \App\Model\Entity\HistoryMachine[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

class HistoryController extends ApiController
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

    public function query($sql) {
        $connection = ConnectionManager::get('default');
        $query = $connection->execute($sql)->fetchall('assoc');
        return $this->arrayToArrayObj($query);
    }
    public function arrayToObj($arr) {
        $object = (object) [];
        foreach ($arr as $key => $value)
        {
        if(is_numeric($value) && strpos($value, ".") !== false){$value = (float)$value;}
        if(is_numeric($value) && strpos($value, ".") == false) { $value = (int)$value;}
        $object->$key = $value;
        }
        return $object;
    }

    public function arrayToArrayObj($arr) {
        $arr2 = [];
        foreach ($arr as $key => $value){
            $value2 = $this->arrayToObj($value);
            array_push($arr2,$value2);
        }
        return $arr2;
    }

    /**
     * Adicionar um histórico ao banco de dados
     */

    public function addHistory() {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        $shop_id = $this->request->data('shop_id');

        $historyMachineTable = TableRegistry::get('History_machine');
        $shoppingReportTable = TableRegistry::get('ShoppingCart');

        $add = $historyMachineTable->newEntity();
        // $add2 = $this->query('UPDATE shopping_cart SET report = 1 WHERE id = '.$shop_id);

        $add2 = $shoppingReportTable->find()->where([
            'id' => $this->request->data('shop_id'),
        ])->first();

        if($this->request->is('post')) {
            $add->client_id = $this->request->data('client_id');
            $add->company_id = $this->request->data('company_id');
            $add->type_service = $this->request->data('type_service');
            $add->shop_id = $this->request->data('shop_id');
            $add->serial_code = $this->request->data('serial');
            $add->problem = $this->request->data('problem');
            $add->description = $this->request->data('description');
            $add->suggestion = $this->request->data('suggestion');
            $add->created = date('Y-m-d H:i:s');

            $add2->report = '1';

            $add = $historyMachineTable->save($add);
            $add2 = $this->query('UPDATE shopping_cart SET report = true WHERE shopping_cart.id = '.$shop_id);
            if(!$add){
                return [
                    'save' => false,
                    'msg_erro' => 'Não foi possível salvar sua avaliação.'
                ];
            }
            if(!$add2){
                return [
                    'save'=> false,
                    'msg_erro' => 'Não foi possível salvar a avaliação.'
                ];
            }

            $this->apiResponse['SALVO'] = $add->id;
            $this->apiResponse['REPORT'] = $add2;
            return;
        }
    }

    /**
     * Checar se o histórico já foi adicionado
     * para poder finalizar a ordem de serviço
     */

    public function checkHistory() {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        $id = $this->request->data('id');

        // $historyMachineTable = TableRegistry::get('History_machine');

        if($this->request->is('post')) {
            $sql = 'SELECT * FROM history_machine WHERE shop_id = '.$id;
            $this->apiResponse['SQL'] = $sql;

            $service = $this->query($sql);
        
             $this->apiResponse['service'] = $service;
            return;
        }
    }
}

/*  client_id: route.params.id.client_id,
    company_id: authState.value.user.client_id,
    type_service: nameMachine.value,
    serial: serialNumber.value,
    problem: problem.value,
    description: description.value,
    suggestion: suggestion.value, */