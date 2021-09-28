<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use RestApi\Controller\ApiController;

/**
 * ServiceOrders Controller
 *
 * @property \App\Model\Table\ServiceOrdersTable $ServiceOrders
 *
 * @method \App\Model\Entity\ServiceOrder[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ServiceOrdersController extends ApiController
{

    public function initialize()
    {
        $this->loadModel('Providers');
        $this->loadModel('Clients');
        $this->loadModel('Margin');
        $this->loadComponent('S3Tools');
        $this->loadComponent('ErrorList');
        return parent::initialize();
    }

    /*
    * Retorna todas as OS daquele prestador
    */
    public function getServiceOrdersProvider()
    {

        $d = $this->jwtPayload;

        $provider = $this->Providers->get($d->id);

        $orders = $this->ServiceOrders->find()
            ->select([
                'ServiceOrders.id',
                'ServiceOrders.date_service_ordes',
                'ServiceOrders.description',
                'ServiceOrders.value_initial',
                'ServiceOrders.status',
                'client' => 'name'
            ])
            ->where([
                'providers_id' => $provider->id
            ])
            ->contain([
                'Clients' => [
                    'People'
                ]
            ])
            ->order([
                'date_service_ordes' => 'DESC'
            ]);

        $this->apiResponse = $orders;
    }

    /*
    * Retorna todas as OS que estão sendo cotadas 
    * dentro da sua categoria e subcategoria 
    */
    public function getServiceOrdersProviderRequests()
    {
        $d = $this->jwtPayload;

        $provider = $this->Providers->get($d->id);
        $orders = $this->ServiceOrders->find()
            ->select([
                'ServiceOrders.id',
                'ServiceOrders.date_service_ordes',
                'ServiceOrders.description',
                'ServiceOrders.value_initial',
                'ServiceOrders.status',
                'address'  => 'address',
                'number'   => 'number',
                'district' => 'district',
                'city'     => 'city',
                'state'    => 'state',
                'cep'      => 'cep',
                'client'   => 'name',
            ])
            ->contain([
                'Clients' => [
                    'People'
                ]
            ])
            ->where([
                'categories_id' => $provider->category_id,
                'subcategories_id' => $provider->subcategory_id,
                'status' => 'solicitando_orcamento',
                'providers_id IS NULL'
            ])
            ->order([
                'date_service_ordes' => 'DESC'
            ]);

        $this->apiResponse = $orders;
    }

    /*
    * Retorna todas as OS que já estão agendadas para 
    * o prestador
    */
    public function getServiceOrdersProviderScheduled()
    {
        $d = $this->jwtPayload;

        $provider = $this->Providers->get($d->id);

        $orders = $this->ServiceOrders->find()
            ->select([
                'ServiceOrders.id',
                'ServiceOrders.date_service_ordes',
                'ServiceOrders.description',
                'ServiceOrders.value_initial',
                'ServiceOrders.value_final',
                'ServiceOrders.status',
                'client' => 'name'
            ])
            ->contain([
                'Clients' => [
                    'People'
                ]
            ])
            ->where([
                'providers_id' => $provider->id,
                'status IN' => ['agendada', 'reagendada']
            ])->order([
                'date_service_ordes' => 'DESC'
            ]);

        foreach ($orders as $value) {
            if($value->value_final){              
                $value->value_initial = $value->value_final;
            }
        }    
       
        
        $this->apiResponse = $orders;
    }

    /*
    * Retorna todas as OS que já estão em execução para 
    * o prestador
    */
    public function getServiceOrdersRunning()
    {
        $d = $this->jwtPayload;

        $provider = $this->Providers->get($d->id);

        $orders = $this->ServiceOrders->find()
            ->select([
                'ServiceOrders.id',
                'ServiceOrders.date_service_ordes',
                'ServiceOrders.description',
                'ServiceOrders.value_initial',
                'ServiceOrders.status',
                'client' => 'name'
            ])
            ->contain([
                'Clients' => [
                    'People'
                ]
            ])
            ->where([
                'providers_id' => $provider->id,
                'status' => 'em_execucao'
            ])->order([
                'date_service_ordes' => 'DESC'
            ]);

        $this->apiResponse = $orders;
    }

    /*
    * Retorna OS que tiveram lance aceito pelo cliente 
    * e que agora aguarda a confirmação do prestador
    */
    public function getServiceOrdersApprovedBudget()
    {
        $d = $this->jwtPayload;

        $provider = $this->Providers->get($d->id);

        $orders = $this->ServiceOrders->find()
            ->select([
                'ServiceOrders.id',
                'ServiceOrders.date_service_ordes',
                'ServiceOrders.description',
                'ServiceOrders.value_initial',
                'ServiceOrders.margin',
                'ServiceOrders.value_provider',
                'ServiceOrders.value_admin',
                'ServiceOrders.status',
                'client'          => 'name',
                'client_andress'  => 'address',
                'client_number'   => 'number',
                'client_district' => 'district',
                'client_city'     => 'city',
                'client_state'    => 'state'
            ])
            ->contain([
                'Clients' => [
                    'People'
                ]
            ])
            ->where([
                'providers_id' => $provider->id,
                'status' => 'agendamento_prestador'
            ])->order([
                'date_service_ordes' => 'DESC'
            ]);
        foreach ($orders as $value) {
            $winner = $this->getBudgetWinner($value->id);
            
            if($winner){
                $value->date_service_ordes = $winner->date_suggestion;
            }

        }
        $this->apiResponse = $orders;
    }

    /**
     * busque o lance ganhador da OS
     */
    private function getBudgetWinner($os_id){
        $t = $table = TableRegistry::getTableLocator()->get('Budgets');
        
        $winner = $t->find()->where([
            'service_orders_id' => $os_id,
            'status' => 'APROVADO'
        ])
        ->first();

        return $winner;
    }
    
    /*
    * Retorna todas as OS que foram realizadas pelo prestador
    * e que estão finalizadas
    */
    public function getServiceOrdersProviderFinalized()
    {
        $d = $this->jwtPayload;

        $provider = $this->Providers->get($d->id);

        $orders = $this->ServiceOrders->find()
            ->select([
                'ServiceOrders.id',
                'ServiceOrders.date_service_ordes',
                'ServiceOrders.description',
                'ServiceOrders.value_initial',
                'ServiceOrders.status',
                'client' => 'name'
            ])
            ->contain([
                'Clients' => [
                    'People'
                ]
            ])
            ->where([
                'providers_id' => $provider->id,
                'status' => 'finalizada'
            ])->order([
                'date_service_ordes' => 'DESC'
            ]);
        $this->apiResponse = $orders;
    }

    /*
    * Retorna detalhes da OS pelo seu ID
    */
    public function getDetailOs()
    {
        $os_id = $this->request->data('os_id');
        $os = $this->ServiceOrders->get($os_id, [
            'contain' => [
                'Clients' => [
                    'People',
                ],
                'ProvidersLeft'
            ]
        ]);

        $os->images = $this->listImagesOS($os->id);

        if($os->value_final){
            $os->value_initial = $os->value_final;
        }

        if($os->client->image){
            $os->client->image = $this->getImageProfile($os->client->image);
        }

        if($os->providers_left && $os->providers_left->image){
            $os->providers_left->image = $this->getImageProfile($os->providers_left->image);
        }

        $this->apiResponse = $os;
    }

    /**
     * Buscar imagens de envolvidos no processo.
     */
    private function getImageProfile($key){
        $url = $this->S3Tools->getUrlTemp($key, 60);
        return $url;
    }

    /*
    * Altera status da OS para em execução
    * Quando o prestador inicia o serviço junto ao cliente
    */
    public function startOs()
    {
        $d = $this->jwtPayload;

        $provider = $this->Providers->get($d->id);

        $os_id = $this->request->data('os_id');
        $os = $this->ServiceOrders->get($os_id);

        if ($os->providers_id != $provider->id) {
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'A OS não pode ser iniciada por esse prestador.';
            return;
        }

        if ($os->status == 'em_execucao') {
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'OS já foi iniciada';
            return;
        } else if ($os->status != 'agendada' && $os->status != 'reagendada') {
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'OS não pode ser iniciada. Ela se encontra fora de agendamento.';
            return;
        }

        $os->status = 'em_execucao';
        $os->time_start = date('Y-m-d h:i:s');

        if ($this->ServiceOrders->save($os)) {
            $this->apiResponse['message'] = 'OS iniciada com sucesso';
            return;
        }

        $this->responseStatus = false;
        $this->apiResponse['message'] = 'Falha ao iniciar OS.';
    }

    /*
    * Altera status da OS para finalizada
    * Quando o prestador conclui o serviço acordado com o cliente
    */
    public function finishOs()
    {
        $d = $this->jwtPayload;

        $provider = $this->Providers->get($d->id);

        $os_id = $this->request->data('os_id');
        $os = $this->ServiceOrders->get($os_id);

        if ($os->providers_id != $provider->id) {
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'A OS não pode ser finalizada por esse prestador.';
            return;
        }

        if ($os->status != 'em_execucao') {
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'OS não se encontra em execução, por isso não pode ser finalizada';
            return;
        }

        $os->status = 'finalizada';
        $os->time_end = date('Y-m-d h:i:s');

        if ($os->value_final == null) {
            $os->value_final = $os->value_initial;
        }

        if ($this->ServiceOrders->save($os)) {
            $this->apiResponse['message'] = 'OS finalizada com sucesso';
            return;
        }

        $this->responseStatus = false;
        $this->apiResponse['message'] = 'Falha ao finalizar OS.';
    }

    /*
    * Lista de pagamentos a receber pela administradora
    */
    public function getOpenPayments()
    {

        $this->loadModel('Margin');

        $d = $this->jwtPayload;

        $initial_date  = $this->request->data('initial_date');
        $final_date    = $this->request->data('final_date');

        if (!$initial_date || !$final_date) {
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Data informada não é valida.';
            return;
        }

        $provider = $this->Providers->get($d->id);
        $service_orders = $this->ServiceOrders->find()
            ->select([
                'description' => 'description',
                'value_initial' => 'value_initial',
                'margin' => 'margin',
                'margin' => 'margin',
                'date_service_ordes' => 'date_service_ordes'
            ])
            ->where([
                'providers_id' => $provider->id,
                'date_service_ordes >=' => $initial_date . " 00:00:00",
                'date_service_ordes <=' => $final_date . " 23:59:59",
                'status' => 'finalizada',
                'pay' => false
            ])
            ->order([
                'date_service_ordes' => 'DESC'
            ]);

        foreach ($service_orders as $value) {
            $net = ($value->margin / 100) * $value->value_final;
            $value->net_value = $value->value_final - $net;
            $value->date_service_ordes = $value->date_service_ordes->format('Y-m-d');
        }

        $this->apiResponse = $service_orders;
    }

    /*
    * Lista de todas as OS finalizadas com detalhes de valores
    */
    public function getAllPayments()
    {

        $this->loadModel('Margin');

        $d = $this->jwtPayload;

        $initial_date  = $this->request->data('initial_date');
        $final_date    = $this->request->data('final_date');

        if (!$initial_date || !$final_date) {
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Data informada não é valida.';
            return;
        }

        $provider = $this->Providers->get($d->id);

        $service_orders = $this->ServiceOrders->find()
            ->select([
                'description' => 'description',
                'value_initial' => 'value_initial',
                'margin' => 'margin',
                'value_final' => 'value_final',
                'date_service_ordes' => 'date_service_ordes',
                'pay' => 'pay'
            ])
            ->where([
                'providers_id' => $provider->id,
                'date_service_ordes >=' => $initial_date . " 00:00:00",
                'date_service_ordes <=' => $final_date . " 23:59:59",
                'status' => 'finalizada'
            ])
            ->order([
                'date_service_ordes' => 'DESC'
            ]);

        foreach ($service_orders as $value) {
            $net = ($value->margin / 100) * $value->value_final;
            $value->net_value = $value->value_final - $net;
            $value->date_service_ordes = $value->date_service_ordes->format('Y-m-d');
        }

        $this->apiResponse = $service_orders;
    }

    /**
     * Prestador confirma agendamento de OS após o usuário ter 
     * aceitado o seu orçamento
     */
    public function scheduleOS()
    {
        $d = $this->jwtPayload;
        $provider = $this->Providers->get($d->id);

        $os_id = $this->request->data('os_id');
        $os = $this->ServiceOrders->get($os_id);

        if ($os->providers_id != $provider->id) {
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Prestador não pode negociar está ordem de serviço';
            return;
        }

        if ($os->status != 'agendamento_prestador') {
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'OS não pode ser agendada por está fora do status de pré agendamento';
            return;
        }

        $os->status = 'agendada';

        if ($this->ServiceOrders->save($os)) {
            $this->apiResponse = [
                'save' => true
            ];

            return;
        }

        $this->responseStatus = false;
        $this->apiResponse = [
            'save' => false,
            'msg_erro' => $this->ErrorList->errorInString($os->errors())
        ];

        return;
    }

    /**
     * Cliente abre OS
     */
    public function newOS()
    {
        $d = $this->jwtPayload;
        $client = $this->Clients->get($d->id);

        if (!$client) {
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => 'Cliente não encontrado.'
            ];
            return;
        }

        $os = $this->ServiceOrders->newEntity();
        $os->companies_id = '1';
        $os->clients_id = '1';
        $os->categories_id = $this->request->data('category_id');
        $os->subcategories_id = $this->request->data('subcategory_id');
        $os->date_service_ordes = date('Y-m-d H:i:s');
        $os->description = $this->request->data('description');
        $os->status = 'solicitando_orcamento';

        if (!$this->ServiceOrders->save($os)) {
            $this->responseStatus = false;
            $this->apiResponse = [
                'save' => false,
                'msg_erro' => $this->ErrorList->errorInString($os->errors())
            ];
            return;
        }

        foreach ($_FILES['file']['name'] as $key => $value) {
            $name = $_FILES['file']['name'][$key];
            $tmp_name = $_FILES['file']['tmp_name'][$key];
            $key = bin2hex(openssl_random_pseudo_bytes(10));
            $a = $this->upImagem($name, $tmp_name, $os->id, $key);
            if (!$a['save']) {
                $this->responseStatus = false;
                $this->apiResponse = [
                    'save' => false,
                    'msg_erro' => $a['msg_erro']
                ];
                return;
            }
        }

        $this->apiResponse = [
            'save' => true
        ];

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

        $path = 'os' . "/" . $os_id . "/" . $key . "." . $data['ext'];

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
        $table = TableRegistry::getTableLocator()->get('ServiceOrdersImages');
        $r = $table->newEntity();
        $r->service_orders_id = $os_id;
        $r->path = $path;

        return $table->save($r);
    }

    /**
     * Lista OS que estão em etapa de leilão para o cliente 
     */
    public function listOsSearchBudgets()
    {
        $d = $this->jwtPayload;
        $client = $this->Clients->get($d->id);

        $list = $this->ServiceOrders->find()
            ->contain([
                'Categories',
                'Subcategories'
            ])
            ->where([
                'status' => 'solicitando_orcamento',
                'clients_id' => $client->id
            ])
            ->order(['ServiceOrders.created' => 'DESC']);

        $return = [];

        foreach ($list as $value) {
            $return[] = [
                'os_id' => $value->id,
                'category_id' => $value->categories_id,
                'category' => $value->category->name,
                'subcategory_id' => $value->subcategories_id,
                'subcategory' => $value->subcategory->name,
                'created' => $value->created->format('d/m/Y H:i:s'),
                'description' => $value->description,
            ];
        }

        $this->apiResponse = $return;
    }

    /**
     * Lista OS que estão agendadas para o cliente 
     */
    public function listOsScheduledClient()
    {
        $d = $this->jwtPayload;
        $client = $this->Clients->get($d->id);

        $list = $this->ServiceOrders->find()
            ->contain([
                'Categories',
                'Subcategories'
            ])
            ->where([
                'status IN' => ['agendada', 'reagendada'],
                'clients_id' => $client->id
            ])
            ->order('ServiceOrders.created');

        $return = [];

        foreach ($list as $value) {
            $return[] = [
                'os_id'          => $value->id,
                'category_id'    => $value->categories_id,
                'category'       => $value->category->name,
                'subcategory_id' => $value->subcategories_id,
                'subcategory'    => $value->subcategory->name,
                'date_service'   => $value->date_service_ordes->format('d/m/Y H:i:s'),
                'created'        => $value->created->format('d/m/Y H:i:s'),
                'description'    => $value->description,
            ];
        }

        $this->apiResponse = $return;
    }

    /**
     * Lista as images cadastradas para OS
     */
    private function listImagesOS($os_id)
    {
        $t = TableRegistry::get('ServiceOrdersImages');
        $images = $t->find()->where([
            'service_orders_id' => $os_id
        ])
            ->order('created')
            ->all();
        $urls_aws = [];

        foreach ($images as  $value) {
            $urls_aws[] = [
                'image_id' => $value->id,
                'url' => $this->S3Tools->getUrlTemp($value->path, '1000')
            ];
        }

        return $urls_aws;
    }

    /**
     * Lista OS que estão concluídas para o cliente 
     */
    public function listOsCompletedClient()
    {
        $d = $this->jwtPayload;
        $client = $this->Clients->get($d->id);

        $list = $this->ServiceOrders->find()
            ->contain([
                'Categories',
                'Subcategories'
            ])
            ->where([
                'status IN' => ['finalizada'],
                'clients_id' => $client->id
            ])
            ->order('ServiceOrders.created');

        $return = [];

        foreach ($list as $value) {
            $return[] = [
                'os_id' => $value->id,
                'category_id' => $value->categories_id,
                'category' => $value->category->name,
                'subcategory_id' => $value->subcategories_id,
                'subcategory' => $value->subcategory->name,
                'date_service'   => $value->date_service_ordes->format('d/m/Y H:i:s'),
                'created' => $value->created->format('d/m/Y H:i:s'),
                'description' => $value->description,
            ];
        }

        $this->apiResponse = $return;
    }

    /**
     * Cancelamento de OS por parte de cliente
     */
    public function cancelOs()
    {
        $d = $this->jwtPayload;

        $client = $this->Clients->get($d->id);

        $os_id = $this->request->data('os_id');

        $os = $this->ServiceOrders->get($os_id);

        if ($os->status == 'finalizada') {
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Os não pode ser cancelada. Status: ' . $os->status;
            return;
        }

        if ($os->clients_id != $client->id) {
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Você não pode cancelar está OS ' . $client->id;
            return;
        }

        $os->status = 'cancelada';

        if (!$this->ServiceOrders->save($os)) {
            $msg_erro = $this->ErrorList->errorInString($os->errors());
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Falha ao aceitar novo valor. ' . $msg_erro;
            return;
        }

        $this->apiResponse = 'OS cancelada com sucesso';
    }

    /**
     * Lista OS que estão e aberto para pagamento
     */
    public function listMyOsPayOpen()
    {
        $d = $this->jwtPayload;
        $client = $this->Clients->get($d->id);

        $list = $this->ServiceOrders->find()
            ->contain([
                'Categories',
                'Subcategories'
            ])
            ->where([
                'status' => 'finalizada',
                'paid_by_customer' => false,
                'clients_id' => $client->id
            ])
            ->order('ServiceOrders.created');

        $return = [];

        foreach ($list as $value) {
            $return[] = [
                'os_id' => $value->id,
                'category_id' => $value->categories_id,
                'category' => $value->category->name,
                'subcategory_id' => $value->subcategories_id,
                'subcategory' => $value->subcategory->name,
                'created' => $value->created->format('d/m/Y H:i:s'),
                'description' => $value->description,
            ];
        }

        $this->apiResponse = $return;
    }

    /**
     * Cliente aceita finalização da OS
     * Cliente 
     */
    public function payOs()
    {
        $d = $this->jwtPayload;

        $client = $this->Clients->get($d->id);

        $os_id = $this->request->data('os_id');

        $os = $this->ServiceOrders->get($os_id);

        if ($os->status != 'finalizada') {
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Os não pode ser paga. Status: ' . $os->status;
            return;
        }

        if ($os->paid_by_customer) {
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Os já está paga.';
            return;
        }

        if ($os->clients_id != $client->id) {
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Você não pode pagar está OS.';
            return;
        }

        $os->paid_by_customer = true;

        // aqui vc tem que chamar a api de pagamento 

        if (!$this->ServiceOrders->save($os)) {
            $msg_erro = $this->ErrorList->errorInString($os->errors());
            $this->responseStatus = false;
            $this->apiResponse['message'] = 'Falha ao aceitar novo valor. ' . $msg_erro;
            return;
        }

        $this->apiResponse = 'OS finalizada com sucesso';
    }

    /**
     * Liste OS que estão em estado de negociação.
     * para determinado cliente.  
     */
    public function getOsInNegociation()
    {
        $d = $this->jwtPayload;
        $client = $this->Clients->get($d->id);
        $list = $this->ServiceOrders->find()
            ->contain([
                'Categories',
                'Subcategories'
            ])
            ->where([
                'status' => 'em_negociacao',
                'clients_id' => $client->id
            ])
            ->order('ServiceOrders.created');

        $return = [];

        foreach ($list as $value) {
            $return[] = [
                'os_id' => $value->id,
                'category_id' => $value->categories_id,
                'category' => $value->category->name,
                'subcategory_id' => $value->subcategories_id,
                'subcategory' => $value->subcategory->name,
                'created' => $value->created->format('d/m/Y H:i:s'),
                'description' => $value->description,
                'value_final' => $value->value_final,
            ];
        }
        $this->apiResponse = $return;
    }
}
