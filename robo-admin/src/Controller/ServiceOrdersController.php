<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use DateTime;
/**
 * ServiceOrders Controller
 *
 * @property \App\Model\Table\ServiceOrdersTable $ServiceOrders
 *
 * @method \App\Model\Entity\ServiceOrder[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */


class ServiceOrdersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    
    public $_STATUS = [
        'solicitando_orcamento' => 'Solicitando orçamento',
        'aprovacao_orcamento'   => 'Orçamento aprovado',
        'agendamento_prestador' => 'Aguardando agendamento pelo prestador',
        'agendada'              => 'Agendada',
        'em_execucao'           => 'Em execução',
        'em_negociacao'         => 'Em negociação',
        'reagendada'            => 'Reagendada',
        'finalizada'            => 'Finalizada'
    ];

    public function index()
    {
        
        $this->loadModel('Categories');
        $this->loadModel('Subcategories');
        $this->loadModel('Providers');

        
        $id                       = isset($this->request->data['id']) ? $this->request->data['id'] : NULL;
        $date_start_search_orders = isset($this->request->data['date_start_search_orders']) ? $this->request->data['date_start_search_orders'] : NULL;
        $date_end_search_orders   = isset($this->request->data['date_end_search_orders']) ? $this->request->data['date_end_search_orders'] : NULL;
        $status                   = isset($this->request->data['status']) ? $this->request->data['status'] : NULL;
        $pay                      = isset($this->request->data['pay']) ? $this->request->data['pay'] : NULL;
        $categories_id            = isset($this->request->data['categories_id']) ? $this->request->data['categories_id'] : NULL;
        $subcategories_id         = isset($this->request->data['subcategories_id']) ? $this->request->data['subcategories_id'] : NULL;
        $providers_id             = isset($this->request->data['providers_id']) ? $this->request->data['providers_id'] : NULL;

        $conditions['ServiceOrders.companies_id'] = $this->request->session()->read('Auth.User.company_id');

        if ($id) {
            $conditions['ServiceOrders.id'] = $id;
        }

        if($date_start_search_orders && $this->validateDate($date_start_search_orders)){
            $date_start_search_orders = str_replace("/", "-", $date_start_search_orders);
            $date_start = new Time($date_start_search_orders);
            $conditions['ServiceOrders.date_service_ordes >='] = $date_start;
        }

        if($date_end_search_orders && $this->validateDate($date_end_search_orders)){
            $date_end_search_orders = str_replace("/", "-", $date_end_search_orders);
            $date_end = new Time($date_end_search_orders);
            $conditions['ServiceOrders.date_service_ordes <='] = $date_end;
        }

        if($status){
            $conditions['ServiceOrders.status'] = $status;
        }
      
        if($pay){
            $conditions['ServiceOrders.pay'] = $pay;
        }
        
        if($categories_id){
            $conditions['ServiceOrders.categories_id'] = $categories_id;
        }
       
        if($subcategories_id){
            $conditions['ServiceOrders.subcategories_id'] = $subcategories_id;
        }
        
        if($providers_id){
            $conditions['ServiceOrders.providers_id'] = $providers_id;
        }

       /*  if ($name) {
            $conditions['Users.name LIKE '] = "%$name%";
        }
        
        if ($users_types_id) {
            $conditions['Users.users_types_id'] = $users_types_id;
        }
         */

        $this->paginate = [
            'contain'       => ['Companies', 'Clients'=>['People'], 'ProvidersLeft'=>['People'], 'Categories', 'Subcategories'],
            'conditions' => $conditions,
            'sortWhitelist' => [
                'Categories.name'                  => 'Categories.name',
                'Subcategories.name'               => 'Subcategories.name',
                'ServiceOrders.date_service_ordes' => 'ServiceOrders.date_service_ordes',
                'ServiceOrders.value_initial'      => 'ServiceOrders.value_initial',
                'ServiceOrders.status'             => 'ServiceOrders.status',
                'ServiceOrders.pay'                => 'ServiceOrders.pay'
            ]
        ];
        $serviceOrders = $this->paginate($this->ServiceOrders, ['limit' => 10, 'order' => array( // sets a default order to sort by
        'ServiceOrders.date_service_ordes' => 'DESC'
    )]);
        
        $categories    = $this->Categories->find('list')->where(['active' => true])->order('name')->all();
        $subcategories = $this->Subcategories->find('list')->where(['active' => true])->order('name')->all();
        $providers     = $this->Providers->find('list', [
            'keyField' => 'id',
            'valueField' => function ($row) {return $row->person->name;}
        ])->contain('People')->order('name');
        
        $status = $this->_STATUS;

        //$this->set(compact('serviceOrders', 'usersTypes'));
        $this->set(compact('serviceOrders', 'status', 'categories', 'subcategories', 'providers'));
       
    }

    private function validateDate($date, $format = 'd-m-Y')
    {
        $d = DateTime::createFromFormat($format, $date);
        
        return $d && $d->format($format) === $date;
    }

    /**
     * View method
     *
     * @param string|null $id Service Order id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $t = TableRegistry::get('ServiceOrdersImages');
        $this->loadComponent('S3Tools');

        $serviceOrder = $this->ServiceOrders->get($id, [
            'contain' => ['Companies', 'Clients'=>['People'], 'ProvidersLeft'=>['People'], 'Categories', 'Subcategories', 'ServiceOrdersImages']
        ]);

        $status = $this->_STATUS;

        $images = $t->find()->where([
            'service_orders_id' => $id
        ]);

        foreach ($images as $value) {
            $value->url = $this->S3Tools->getUrlTemp($value->path, 120);
        }

        $this->set(compact('status'));
        $this->set(compact('images'));
        $this->set('serviceOrder', $serviceOrder, 'status', $status);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        
        $this->loadModel('Clients');
        $this->loadModel('Providers');

        $serviceOrder = $this->ServiceOrders->newEntity();
        if ($this->request->is('post')) {
            $serviceOrder = $this->ServiceOrders->patchEntity($serviceOrder, $this->request->getData());
            $serviceOrder->companies_id = $this->request->session()->read('Auth.User.company_id');
            $serviceOrder->margin = $this->getMargin();
            $serviceOrder->date_service_ordes = new Time($serviceOrder->date_service_ordes);
            if ($this->ServiceOrders->save($serviceOrder)) {
                $this->Flash->success(__('Ordem de serviço salva com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A ordem de serviço não pode ser salva. Por favor, tente novamente.'));
        }
        $companies = $this->ServiceOrders->Companies->find('list', ['limit' => 200]);
        $providers     = $this->Providers->find('list', [
            'keyField' => 'id',
            'valueField' => function ($row) {return $row->person->name;}
        ])->contain('People');
        
        $categories = $this->ServiceOrders->Categories->find('list', ['limit' => 200]);
        
        $clients     = $this->Clients->find('list', [
            'keyField' => 'id',
            'valueField' => function ($row) {return $row->person->name;}
        ])->contain('People');
        
        $status = $this->_STATUS;

        $categories = $this->ServiceOrders->Categories->find('list', ['limit' => 200]);
        $subcategories = $this->ServiceOrders->Subcategories->find('list', ['limit' => 200]);
        $this->set(compact('serviceOrder', 'companies', 'clients', 'providers', 'categories', 'subcategories', 'status'));
    }

    private function getMargin()
    {
        $t = TableRegistry::get('Margin');
        $margin = $t->get(1);
        return $margin->value;
    }

    /**
     * Edit method
     *
     * @param string|null $id Service Order id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('Clients');
        $this->loadModel('Providers');

        $serviceOrder = $this->ServiceOrders->get($id, [
            'contain' => []
        ]);

        $serviceOrder->date_service_ordes =  $serviceOrder->date_service_ordes->format('d-m-Y');

        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $this->request->data['date_service_ordes'] = new Time($this->request->data['date_service_ordes']);
            
            $serviceOrder = $this->ServiceOrders->patchEntity($serviceOrder, $this->request->getData());

            if ($this->ServiceOrders->save($serviceOrder)) {
                $this->Flash->success(__('Ordem de serviço salva com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A ordem de serviço não pode ser salva. Por favor, tente novamente.'));
        }

        $companies = $this->ServiceOrders->Companies->find('list', ['limit' => 200]);
        $providers     = $this->Providers->find('list', [
            'keyField' => 'id',
            'valueField' => function ($row) {return $row->person->name;}
        ])->contain('People');
        
        $categories = $this->ServiceOrders->Categories->find('list', ['limit' => 200]);
        
        $clients     = $this->Clients->find('list', [
            'keyField' => 'id',
            'valueField' => function ($row) {return $row->person->name;}
        ])->contain('People');
        
        $status = $this->_STATUS;

        $categories = $this->ServiceOrders->Categories->find('list', ['limit' => 200]);
        $subcategories = $this->ServiceOrders->Subcategories->find('list', ['limit' => 200]);
        $this->set(compact('serviceOrder', 'companies', 'clients', 'providers', 'categories', 'subcategories', 'status'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Service Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        return $this->redirect(['action' => 'index']);

        // $this->request->allowMethod(['post', 'delete']);
        // $serviceOrder = $this->ServiceOrders->get($id);
        // if ($this->ServiceOrders->delete($serviceOrder)) {
        //     $this->Flash->success(__('The service order has been deleted.'));
        // } else {
        //     $this->Flash->error(__('The service order could not be deleted. Please, try again.'));
        // }

        // return $this->redirect(['action' => 'index']);
    }
}
