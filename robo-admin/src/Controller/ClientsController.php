<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Controller\AppController;

/**
 * Clients Controller
 *
 *
 * @method \App\Model\Entity\Client[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClientsController extends AppController
{

    public function initialize() {
        $this->loadComponent('Rating');
        parent::initialize();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $name          = isset($this->request->data['name']) ? $this->request->data['name'] : NULL;
        $email         = isset($this->request->data['email']) ? $this->request->data['email'] : NULL;
    
        $conditions['Clients.companies_id'] = $this->request->session()->read('Auth.User.company_id');
    
        if ($email) {
            $conditions['People.email'] = $email;
        }

        if ($name) {
            $conditions['People.name LIKE '] = "%$name%";
        }
        
        $this->paginate = [
            'contain'       => ['Companies', 'People'],
            'conditions' => $conditions,
            'sortWhitelist' => [
                'People.email'     => 'email',
                'People.name'      => 'name',
                'People.id'        => 'id'
            ]
        ];
        
       $clients = $this->paginate($this->Clients, ['limit' => 10, 'order' => array(
            'Clients.name' => 'asc'
       )]);
        
        foreach ($clients as $value) {
            $value->rating = $this->Rating->ratingClients($value->id);
        }

        $this->set(compact('clients'));
    }

    /**
     * View method
     *
     * @param string|null $id Client id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $client = $this->Clients->get($id, [
            'contain' => ['People']
        ]);

        $this->set('client', $client);
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $cpf = $this->request->getData('cpf');
            $cpf = str_replace('.', '', str_replace('-','', $cpf));
            return $this->redirect(['action' => 'addStepOne', $cpf]);
        }
    }

    public function addStepOne($cpf){

        $person = $this->searchPerson($cpf);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $p = TableRegistry::get('People');

            $cpf = $this->request->data('cpf');
        
            $person_old = $this->searchPerson($cpf);
            $person_new = $p->patchEntity($person_old, $this->request->getData());
            $phpdate = strtotime($person_new->date_of_birth);

            $person_new->date_of_birth = date('Y-m-d', $phpdate);
            $person_new->company_id = $this->request->session()->read('Auth.User.company_id');
            $person_new->active = true;

            if ($p->save($person_new)) { 
                
                $client = $this->searchClients($person_new->id);                     
                $client->active = $this->request->getData('active');

                if($this->Clients->save($client)){
                    $this->Flash->success(__('Cliente salvo com sucesso.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('Cliente não pode ser salvo. Por favor, tente novamente.'));
        }     
        
        $pr = $this->searchClients($person->id);

        if($pr){
            $person->active= $pr->active;
        }
        
        $this->set(compact('person'));   
    }
    
    private function searchClients($person_id){

        $client = $this->Clients->find()->where([
            'person_id' => $person_id
        ])
        ->first();
        
        if(!$client){
            $client                   = $this->Clients->newEntity();
            $client->person_id        = $person_id;
            $client->companies_id     = $this->request->session()->read('Auth.User.company_id');
            $client->acting_region    = 'RN';
            $client->active           = false;
        }
        return $client;
    }

    private function searchPerson($cpf){
        $p = TableRegistry::get('People');
        
        $person = $p->find()->where([
            'cpf' => $cpf
        ])->first();
        
        if(!$person){
            $person = $p->newEntity();
            $person->cpf = $cpf;
        }
        return $person;
    }


    /**
     * Edit method
     *
     * @param string|null $id Client id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $client = $this->Clients->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $client = $this->Clients->patchEntity($client, $this->request->getData());
            if ($this->Clients->save($client)) {
                $this->Flash->success(__('The client has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client could not be saved. Please, try again.'));
        }
        $this->set(compact('client'));
    }


        /**
     * Organiza o upload.
     * @access public
     * @param Array $imagem
     * @param String $data
     */
    public function upload($id,  $type)
    {
        $client = $this->Clients->get($id,
        [
            'conditions' => [
                'companies_id' => $this->request->session()->read('Auth.User.company_id')
            ]
        ]);

        if($type == 'profile'){
        $this->request->session()->write('Upload',
            [
            'table'         => 'People',
            'column'        => 'image',
            'dir'           => 'people',
            'max_files'     => 1,
            'max_file_size' => 1000000,
            'download'      => true,
            'types_file'    => ['jpe?g', 'png'],
            'id'            => $client->person_id
        ]);
   
        }else if ($type == 'attachment'){
            $this->request->session()->write('Upload',
            [
            'table'         => 'ClientsImages',
            'column'        => 'image',
            'dir'           => 'clients',
            'max_files'     => 10,
            'max_file_size' => 1000000,
            'download'      => true,
            'types_file'    => ['jpe?g', 'png', 'pdf'],
            'id'            => $client->id
        ]);

        
        }
        $this->set('client', $client);
    }

    public function Balance($id){
        
        $client = $this->Clients->get($id, [
            'contain' => ['People']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $client->balance = $this->request->getData('value');
            if ($this->Clients->save($client)) {
                $this->Flash->success(__('Saldo atualiado com sucesso.'));

                return $this->redirect(['action' => 'balance', $id]);
            }
            $this->Flash->error(__('Erro ao atualizar saldo. Por favor, tente novamente.'));
        }
        
        $this->set(compact('client')); 
    }

    /**
     * Delete method
     *
     * @param string|null $id Client id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $client = $this->Clients->get($id);
        if ($this->Clients->delete($client)) {
            $this->Flash->success(__('The client has been deleted.'));
        } else {
            $this->Flash->error(__('The client could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function inprogress(){
        
    }
}
