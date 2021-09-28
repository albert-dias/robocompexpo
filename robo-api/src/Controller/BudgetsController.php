<?php

namespace App\Controller;

use RestApi\Controller\ApiController;
use stdClass;

/**
 * Budgets Controller
 *
 * @property \App\Model\Table\BudgetsTable $Budgets
 *
 * @method \App\Model\Entity\Budget[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BudgetsController extends ApiController
{
    public function initialize()
    {
        $this->loadModel('Providers');
        $this->loadModel('Clients');
        $this->loadModel('Margin');
        $this->loadModel('ServiceOrders');
        $this->loadComponent('ErrorList');
        $this->loadComponent('Rating');
        $this->loadComponent('S3Tools');
        return parent::initialize();
    }

    /**
     * inserir lance dado pelo prestador
     */
    public function insertBudget()
    {
        $d = $this->jwtPayload;
        
        $provider = $this->Providers->get($d->id);
        $service_orders_id = $this->request->data('os_id');

        $bg = $this->searchBudget($provider->id, $service_orders_id);

        if($bg){
            $msg_erro = "Você já deu lance para essa ordem de serviço";
            $this->responseStatus = false;
            $this->apiResponse['message'] = $msg_erro;  
            return;
        }

        $value = $this->request->data('value');
        $date_suggestion = $this->request->data('date_suggestion');

        $budget = $this->Budgets->newEntity();

        $budget->service_orders_id = $service_orders_id;
        $budget->providers_id = $provider->id;
        $budget->value = $value;
        $budget->date_suggestion = $date_suggestion;
        $budget->status = 'NOVO';

        if ($this->Budgets->save($budget)) {
            $this->responseStatus = true;
            $this->apiResponse['message'] = 'salvo com sucesso';
        } else {
            $msg_erro = $this->ErrorList->errorInString($budget->errors());
            $this->responseStatus = false;
            $this->apiResponse['message'] = $msg_erro;
        }
    }

    /**
     * verifica se prestador já deu lance para a OS
     */
    private function searchBudget($provider_id, $os_id){
        
        $list = $this->Budgets->find()->where([
            'providers_id' => $provider_id,
            'service_orders_id' => $os_id
        ])->first();
        
        return $list;
    }

    /**
     * Lista todos os lances do prestador 
     */
    public function listBudgetProvider(){
        $d = $this->jwtPayload;
        $provider = $this->Providers->get($d->id);
        $list = $this->Budgets->find()->where([
            'providers_id' => $provider->id
        ]);
        $this->responseStatus = true;
        $this->apiResponse = $list;
    }

    /**
     * Prestador dar novo lance a OS que já estava agendada
     * Em casos de novos detalhes identificados no ato do serviço
     */
    public function startTrading(){
        $this->loadModel('ServiceOrders');

        $d = $this->jwtPayload;
        $provider = $this->Providers->get($d->id); 
        
        $service_orders_id = $this->request->data('os_id');
        $new_value = $this->request->data('new_value');

        if(!$service_orders_id){
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'ID da ordem de serviço não é válido';
            return;  
        }

        $service_order = $this->ServiceOrders->get($service_orders_id);

        if($service_order->status != 'agendada' && $service_order->status != 'reagendada'){
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Ordem de serviço não pode ser negociada. Fora do status de agendamento';
            return;  
        }

        if($service_order->providers_id != $provider->id){
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Prestador não pode negociar está ordem de serviço';
            return;  
        }

        if(!is_numeric($new_value)){
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Valor inválido';
            return;
        }

        if($service_order->value_initial > $new_value){
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Novo valor apresentado é menor que valor acordado';
            return;
        }

        $service_order->status = "em_negociacao";
        $service_order->value_final = $new_value;

        if($this->ServiceOrders->save($service_order)){
            $this->responseStatus = true;
            $this->apiResponse['message'] = 'Salvo com sucesso';
            return;
        }

        $this->responseStatus = false;
        $this->apiResponse['message'] = 'Não foi possível entrar em negociação';
        return;
    }


    /**
     * Cliente aceita o novo valor negociado pelo prestador.
     * Resposta ao metodo startTrading
     */
    public function endTrading(){
        $d = $this->jwtPayload;
        
        $client = $this->Clients->get($d->id); 

        $os_id = $this->request->data('os_id');

        $os = $this->ServiceOrders->get($os_id);
        
        if($os->status != 'em_negociacao'){
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Os não pode ser negociada. Status: '.$os->status;
            return;
        }

        if($os->clients_id != $client->id){
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Você não pode negociar está OS '.$client->id;
            return;
        }

        $os->status = 'agendada';

        if(!$this->ServiceOrders->save($os)){
            $msg_erro = $this->ErrorList->errorInString($os->errors());
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Falha ao aceitar novo valor. '.$msg_erro;
            return;
        }

        $this->apiResponse = 'Novo valor aceito com sucesso';
    }

    /*
     * Cliente aceita o lance ofertado para sua OS
     */
    public function winningBid(){
        $d = $this->jwtPayload;
        
        $client = $this->Clients->get($d->id); 

        $budget_id = $this->request->data('budget_id');
        
        $budget = $this->Budgets->get($budget_id, [
            'contain' => [
                'ServiceOrders',
                'Providers' => 'Subcategories'
            ]
        ]);

        if($client->id != $budget->service_order->clients_id){
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Cliente não pode aceitar esse lance. Ordem de serviço não encontrada para esse cliente.';
            return;
        }

        $os = $this->ServiceOrders->get($budget->service_order->id);
        
        if($os->status != 'solicitando_orcamento' && $os->status != 'aprovacao_orcamento'){
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Os não pode ser agendada.';
            return;
        }

        $os->status = 'agendamento_prestador';
        $os->providers_id = $budget->providers_id;
        
        $margin = $this->Margin->get(1);
        
        $os->margin = $margin->value;

        if($budget->provider->subcategory->margin){
            $os->margin = $budget->provider->subcategory->margin;
        }

        $os->value_admin        = ($os->margin / 100 ) * $budget->value;
        $os->value_provider     = $budget->value - $os->value_admin;
        $os->value_initial      = $budget->value;
        $os->value_final        = $budget->value;
        $os->date_service_ordes = $budget->date_suggestion;

        $budget->status = 'APROVADO';
        
        $this->closeAuction($budget->id, $os->id);

        if(!$this->Budgets->save($budget)){
            $msg_erro = $this->ErrorList->errorInString($budget->errors());
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Falha ao aprovar lance. '.$msg_erro;
            return;
        }

        if(!$this->ServiceOrders->save($os)){
            $msg_erro = $this->ErrorList->errorInString($os->errors());
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Falha ao registrar lance. '.$msg_erro;
            return;
        }

        $this->apiResponse = 'Lance aceito com sucesso';
    }

    /**
     * Muda o status dos lances após cliente ter aceitado seu melhor lance
     */
    private function closeAuction($winner_id, $os_id)
    {
         $a = $this->Budgets->updateAll(['status' => 'RECUSADO'], [
                'service_orders_id' => $os_id,
                'id !=' => $winner_id
        ]);
    }


    /**
     * Lista todos os lances da OS 
     */
    public function listBudgetOs(){
        $d = $this->jwtPayload;
        $client = $this->Clients->get($d->id);
        
        $service_orders_id = $this->request->data('os_id');
        $service_order = $this->ServiceOrders->get($service_orders_id);

        if($client->id != $service_order->clients_id){
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Cliente não pode visualizar ofertas para essa OS.';
            return;
        }

        $list = $this->Budgets
        ->find()
        ->select([
            'Budgets.id', 
            'provider' => 'name',
            'providers_id',
            'Budgets.value',
            'Budgets.date_suggestion',
            'Budgets.service_orders_id'
        ])
        ->contain([
            'Providers' => [
                'People'
            ],
            'ServiceOrders'
        ])
        ->where([
            'Budgets.service_orders_id' => $service_order->id,
            'ServiceOrders.status' => 'solicitando_orcamento'
        ])
        ->order([
            'value' => 'DESC'
        ]);

        foreach ($list as $value) {
            $value->stars = $this->Rating->ratingProvider($value->providers_id);
            $value->date_suggestion = $value->date_suggestion->format('d/m/Y H:i:s');
        }
        
        $this->responseStatus = true;
        $this->apiResponse = $list;
    }

    /**
     * Retorna detalhe do lance
     */
    public function getBudget(){
        $d = $this->jwtPayload;
        
        $client = $this->Clients->get($d->id); 

        $budget_id = $this->request->data('budget_id');
        
        $budget = $this->Budgets->get($budget_id, [
            'contain' => [
                'ServiceOrders' => [
                    'Categories',
                    'Subcategories'
                ],
                'Providers' => ['People']
            ]
        ]);
        //debug($budget);       
        if($client->id != $budget->service_order->clients_id){
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Cliente não pode analisar esse lance. Ordem de serviço não encontrada para esse cliente.';
            return;
        } 

        $obj          = new stdClass();
        $obj->date    = $budget->date_suggestion->format('d/m/Y');
        $obj->hour    = $budget->date_suggestion->format('h:i:s');
        $obj->service = $budget->service_order->description;
        $obj->address = $budget->provider->person->address.', '.
                        $budget->provider->person->number.', '.
                        $budget->provider->person->district.', '.
                        $budget->provider->person->complement.' '.
                        $budget->provider->person->city.', '.
                        $budget->provider->person->state.', '.
                        $budget->provider->person->cep;
        $obj->category        = $budget->service_order->category->name;
        $obj->subcategory     = $budget->service_order->subcategory->name;
        $obj->value           = $budget->value;
        $obj->stars_provider  = $this->Rating->ratingProvider($budget->providers_id);
        $obj->photo_provider  = null;
        if($budget->provider->image){
             $obj->photo_provider  = $this->S3Tools->getUrlTemp($budget->provider->image, '60');
        }
        $this->apiResponse    = $obj;
    }
}
