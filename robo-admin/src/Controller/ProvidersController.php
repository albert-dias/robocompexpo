<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\ORM\TableRegistry;
/**
 * Providers Controller
 *
 *
 * @method \App\Model\Entity\Provider[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProvidersController extends AppController
{
    
    public function initialize() {
        $this->loadComponent('Rating');
        $this->loadComponent('S3Tools');
        $this->loadComponent('Emails');
        $this->loadModel('ProvidersImages');
        $this->loadModel('Users');
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
    
        $conditions['Providers.companies_id'] = $this->request->session()->read('Auth.User.company_id');
    
        if ($email) {
            $conditions['People.email'] = $email;
        }

        if ($name) {
            $conditions['People.name LIKE '] = "%$name%";
        }
        
        $this->paginate = [
            'contain'       => ['Companies', 'People', 'Categories', 'Subcategories'],
            'conditions' => $conditions,
            'sortWhitelist' => [
                'People.email'     => 'email',
                'People.id'        => 'name'
            ]
        ];
        
        $providers = $this->paginate($this->Providers, ['limit' => 10, 'order' => array( 
            'id' => 'DESC'
         )]);
        
        foreach ($providers as $value) {
            $value->rating = $this->Rating->ratingProvider($value->id);
        }
        
        $this->set(compact('providers'));
    }

    /**
     * View method
     *
     * @param string|null $id Provider id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $provider = $this->Providers->get($id, [
            'contain' => ['People', 'Categories', 'Subcategories']
        ]);
        
        $images = $this->ProvidersImages->find()->where([
            'providers_id' => $id
        ]);

        foreach ($images as $value) {
            $value->url = $this->S3Tools->getUrlTemp($value->image, 120);
        }

        $this->set('provider', $provider);
        $this->set('images', $images);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {   
        if ($this->request->is('post')) {
            $cpf = $this->request->getData('cpf');
            $cpf = str_replace('.', '', str_replace('-','', $cpf));
            return $this->redirect(['action' => 'addStepOne', $cpf]);
        }     
    }

    public function addStepOne($cpf)
    {

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
                
                $provider = $this->searchProviders($person_new->id);                           
                $provider->category_id = $this->request->getData('category_id');
                $provider->subcategory_id = $this->request->getData('subcategory_id');
                $provider->active = $this->request->getData('active');

                if($this->Providers->save($provider)){
                    $this->Flash->success(__('Prestador salvo com sucesso.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
            
            $this->Flash->error(__('Prestador não pode ser salvo. Por favor, tente novamente.'));
        }     
        $categories = $this->Providers->Categories->find('list', ['limit' => 200])->where(['active' => true]);
        $subcategories = $this->Providers->Subcategories->find('list', ['limit' => 200])->where(['active' => true]);
        
        $pr = $this->searchProviders($person->id);

        if($pr){
            $person->category_id = $pr->category_id;
            $person->subcategory_id = $pr->subcategory_id;
            $person->active= $pr->active;
        }
        
        $this->set(compact('person', 'categories', 'subcategories'));   
    }
    
    private function searchProviders($person_id)
    {

        $provider = $this->Providers->find()->where([
            'person_id' => $person_id
        ])
        ->first();
        
        if(!$provider){
            $provider                   = $this->Providers->newEntity();
            $provider->person_id        = $person_id;
            $provider->companies_id     = $this->request->session()->read('Auth.User.company_id');
            $provider->acting_region    = 'RN';
            $provider->active           = false;
        }
        return $provider;
    }

    private function searchPerson($cpf)
    {
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
     * @param string|null $id Provider id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $provider = $this->Providers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $provider = $this->Providers->patchEntity($provider, $this->request->getData());
            if ($this->Providers->save($provider)) {
                $this->Flash->success(__('The provider has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The provider could not be saved. Please, try again.'));
        }
        $this->set(compact('provider'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Provider id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $provider = $this->Providers->get($id);
        if ($this->Providers->delete($provider)) {
            $this->Flash->success(__('The provider has been deleted.'));
        } else {
            $this->Flash->error(__('The provider could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

        /**
     * Organiza o upload.
     * @access public
     * @param Array $imagem
     * @param String $data
     */
    public function upload($id,  $type)
    {
        $provider = $this->Providers->get($id,
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
            'id'            => $provider->person_id
        ]);
   
        }else if ($type == 'attachment'){
            $this->request->session()->write('Upload',
            [
            'table'         => 'ProvidersImages',
            'column'        => 'image',
            'dir'           => 'providers',
            'max_files'     => 10,
            'max_file_size' => 1000000,
            'download'      => true,
            'types_file'    => ['jpe?g', 'png', 'pdf'],
            'id'            => $provider->id
        ]);

        
        }
        $this->set('provider', $provider);
    }

    public function active($id){
        $provider = $this->Providers->get($id, [
            'contain' => ['People']
        ]);
        $pas = $this->gerarSenha(8, true, true, true, false); 
        $user = $this->Users->newEntity();
        $user->company_id = $this->request->session()->read('Auth.User.company_id');
        $user->users_types_id = 4;
        $user->person_id = $provider->person_id;
        $user->name = $provider->person->name;
        $user->email = $provider->person->email;
        $user->password = $pas;       
        $user->active = true;

        $http = new Client(Configure::read('API'));
        
        $response = $http->post('/Transactions/createSellers', ['provider_id' => $provider->id]);
        
        $obj = json_decode($response->body);
        
        if (isset($obj->status) && $obj->status == true && $obj->result->id) {
            $provider->seller_id = $obj->result->id;
        }else{
            $this->Flash->error(__('Usuário não pode ser ativado. '.$response->body));
            return $this->redirect(['action' => 'view', $provider->id]);
        }

        
        if($this->Users->save($user) && $provider->seller_id && $this->Providers->save($provider)){
            
            $this->Emails->sendEmailPassword([
                'email' => $user->email,
                'name' => $user->name,
                'password' => $pas
            ]);
            
            $provider->active = true;
            $this->Providers->save($provider);

            $this->Flash->success(__('Usuário ativado com sucesso.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('Usuário não pode ser ativado. Por favor, tente novamente.'));
        return $this->redirect(['action' => 'view', $provider->id]);
       
    }
    
    public function inactive($id){
        $provider = $this->Providers->get($id, [
            'contain' => ['People']
        ]);
        
        $user = $this->Users->find()->where([
            'person_id' => $provider->person_id,
            'users_types_id' => 4
        ])
        ->first();
        
        if($user){
            $user->active = false;
            if(!$this->Users->save($user)){
                $this->Flash->error(__('Usuário não pode ser inativado. Por favor, tente novamente.'));
                return $this->redirect(['action' => 'view', $provider->id]);
            }
        }

        $provider->active = false;

        if($this->Providers->save($provider)){
            $this->Flash->success(__('Usuário inativado com sucesso.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error(__('Usuário não pode ser inativado. Por favor, tente novamente.'));
        return $this->redirect(['action' => 'view']);
       
    }

    
    private function gerarSenha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos)
    {
        $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
        $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
        $nu = "0123456789"; // $nu contem os números
        $si = "!@#$%¨&*()_+="; // $si contem os símbolos
        $senha = '';
       
        if ($maiusculas){
              // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
              $senha .= str_shuffle($ma);
        }
       
          if ($minusculas){
              // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
              $senha .= str_shuffle($mi);
          }
       
          if ($numeros){
              // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
              $senha .= str_shuffle($nu);
          }
       
          if ($simbolos){
              // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
              $senha .= str_shuffle($si);
          }
       
          // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
          return substr(str_shuffle($senha),0,$tamanho);
      }
}
