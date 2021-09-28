<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use RestApi\Controller\ApiController;

/**
 * Worktime Controller
 * 
 * @property \App\Model\Table\WorktimeTable $Shopping
 * @method \App\Model\Entity\Worktime[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

class WorktimeController extends ApiController
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

    public function setAllWorkTime() {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        $this->apiResponse['CLIENTE'] = $client->id;
        
        $table = TableRegistry::get('worktime');

        $sql = 'SELECT * FROM worktime WHERE company_id = '. $client->id .' ORDER BY opcao_id, start_time ASC';

        $return = $this->query($sql);
        $this->apiResponse['horarios'] = $return;
    }

    public function addWorkTime() {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        $company_id = $this->request->data('company_id');
        $opcao = $this->request->data('opcao');
        $opcao_id = $this->request->data('opcao_id');
        $ativo = $this->request->data('ativo');
        $start_time = $this->request->data('start_time');
        $finish_time = $this->request->data('finish_time');

        if($this->request->is('post')) {
            $addWork = $this->Worktime->newEntity();

            $addWork->company_id = $company_id;
            $addWork->opcao = $opcao;
            $addWork->opcao_id = $opcao_id;
            $addWork->active = $ativo;
            $addWork->start_time = $start_time;
            $addWork->finish_time = $finish_time;

            $sql = 'INSERT INTO worktime (company_id, opcao, opcao_id, active, start_time, finish_time)
            VALUES ( '.$company_id.',\''. $opcao.'\','.$opcao_id.' ,'.$ativo.',\''.$start_time.'\',\''.$finish_time.'\')';

            // $this->apiResponse['SQL'] = $sql;
            // return;

            $result = $this->query($sql);

            if(!$result) {
                $this->apiResponse['ERRO'] = $sql;
                return;
            }
            $this->responseStatus = true;
            $this->apiResponse['CERTO'] = $sql;

        }
    }

    public function deleteWorkTime($idDel) {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);
        
        if($this->request->is('post')) {
            $work = $this->Worktime->get($idDel);

            $sql = 'DELETE FROM worktime WHERE id = '. $idDel ;

            $result = $this->query($sql);
            
            if(!$result){
                $this->apiResponse['RESULTADO'] = 'Erro ao tentar apagar o horário.';
                return;
            }

            $this->apiResponse['RESULTADO'] = 'Horário apagado com sucesso.';
            return;
        }
    }

    public function updateWorkTime() {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        $id = $this->request->data('id');
        $start = $this->request->data('hora_start');
        $finish = $this->request->data('hora_finish');

        if($this->request->is('post')) {
            
            $sql = 'UPDATE worktime SET start_time = \''. $start . '\', finish_time = \''. $finish . '\' WHERE id = ' .$id ;

            $result = $this->query($sql);

            $this->apiResponse['CHEGUEI AQUI'] = $result; return;
            
            if(!$result){
                $this->apiResponse['ERRO_UPDATE'] = 'Não conseguimos salvar a alteração.';
                return;
            }

            $this->apiResponse['WORK_UPDATE'] = $work;
            return;
        }
    }

    public function selectWorkTime($idSel) {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        if($this->request ->is('post')) {
            $sql = 'SELECT * FROM worktime WHERE id = '. $idSel ;

            $result = $this->query($sql);
            
            if(!$result){
                $this->apiResponse['SELECTED'] = 'Erro ao tentar puxar o horário.';
                return;
            }

            $this->apiResponse['SELECTED'] = $result;
            return;
        }
    }

    public function desativateWorkTime($idDes) {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);
        if($this->request->is('post')) {
            $work = $this->Worktime->get($idDes);

            if($work->active === 1)
            { $sql = 'UPDATE worktime SET active = 0 WHERE id ='. $idDes; }
            else { $sql = 'UPDATE worktime SET active = 1 WHERE id ='. $idDes; }

            $result = $this->query($sql);
            
            if(!$result){
                $this->apiResponse['RESULTADO'] = 'Erro ao tentar mudar o horário.';
                return;
            }

            $this->apiResponse['RESULTADO'] = 'Horário alterado com sucesso.';
            return;
        }
    }

    public function seeSchedules($idA){
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);
        $aceito = 'aceito';

        if($this->request->is('post')) {
        
            $sql = 'SELECT worktime.* FROM worktime 
            INNER JOIN my_services
            WHERE my_services.client_id = worktime.company_id
            AND worktime.active = 1 AND my_services.id = '.$idA.'
            ORDER BY opcao_id,start_time ASC';

            $next = 'SELECT WEEKDAY(shopping_cart.dia) as week, shopping_cart.dia, shopping_cart.horario
            FROM shopping_cart INNER JOIN my_services
            WHERE my_services.id = ' .$idA. ' AND my_services.client_id = shopping_cart.company_id
            AND shopping_cart.status = \'aceito\' ORDER BY WEEKDAY(shopping_cart.dia) ASC';
        }
        
        $schedule = $this->query($sql);
        $works = $this->query($next);

        $this->apiResponse['query'] = $schedule;
        $this->apiResponse['works'] = $works;
    }

    /**
     * Funções auxiliares, não deletar ou modificar
     */
    public function query($sql){
        $connection = ConnectionManager::get('default');
        $query = $connection->execute($sql)->fetchall('assoc');
        return $this->arrayToArrayObj($query);
    }
    public function arrayToObj($arr){
        $object = (object) [];
        foreach ($arr as $key => $value)
        {
            if(is_float($value) && strlen($value) <= 8) { $value = (float)$value;} 
        
            if(is_int($value) && strlen($value) <= 8) { $value = (int)$value;} 
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
}
