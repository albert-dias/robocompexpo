<?php
namespace App\Controller;

use RestApi\Controller\ApiController;
use Cake\ORM\TableRegistry;

class PlansController extends ApiController {

    public function initialize() {
        $this->loadModel('Plans');
        return parent::initialize();
    }

    public function get($user_types_id) {
        $plans = $this->Plans->find('all')->all();
        $this->apiResponse = $plans->toArray();
    }

    //Função para puxar os planos de usuário na janela de administração

    public function getPlans() {
        if($this->request->is('get')){
            $filter = $this->Plans->find()->toArray();
            $this->apiResponse['plans'] = $filter;
        }
        
        return;
    }

    public function updatePlans(){        

        if($this->request->is('post')){

            $raio = $this->request->data('raio');
            $id = $this->request->data('id');

            $table = TableRegistry::get('Plans');

            $query = $table->find()->where([
                'id' => $id,
            ])->first();

            $query->raio = $raio;

            if(!$table->save($query)){
                $this->apiResponse['ERRO'] = 'ERRO AO SALVAR RAIO DE ATUAÇÃO, TENTE NOVAMENTE.';
                return;
            }

            $this->apiResponse['raio'] =  $raio.' km';
            return;
        }
    }
}