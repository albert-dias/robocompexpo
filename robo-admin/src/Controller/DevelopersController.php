<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
/**
 * Developers Controller
 *
 * @property \App\Model\Table\DevelopersTable $Developers
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevelopersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {          
        $name          = isset($this->request->data['name']) ? $this->request->data['name'] : NULL;
        $company_id         = isset($this->request->data['company_id']) ? $this->request->data['company_id'] : NULL;
        $users_types_id = isset($this->request->data['users_types_id']) ? $this->request->data['users_types_id'] : NULL;

        $conditions['Developers.active']       = true;
        
        if ($company_id) {
            $conditions['Developers.company_id'] = $company_id;
        }

        if ($name) {
            $conditions['Developers.name LIKE '] = "%$name%";
        }
        
        if ($users_types_id) {
            $conditions['Developers.users_types_id'] = $users_types_id;
        }
        
        $this->paginate = [
            'contain'       => ['Companies'=>'ModulesHasCompanies', 'UsersTypes' => ['UsersTypesHasModules' => 'Modules']],
            'conditions'    => $conditions,
            'sortWhitelist' => [
                'Companies.name'   => 'Companies.name',
                'UsersTypes.type'  => 'type',
                'Developers.email' => 'email',
                'Developers.name'  => 'name',
                'Developers.id'    => 'id'
            ]
        ];
        $users = $this->paginate($this->Developers, ['limit' => 10]);
        $companies = $this->Developers->Companies->find('list')->all();
        $usersTypes = $this->Developers->UsersTypes->find('list')->all();
        
        $this->set(compact('users', 'usersTypes', 'companies'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Developers->get($id, [
            'contain' => ['Companies', 'UsersTypes']
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Developers->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['active'] = true;
            $user = $this->Developers->patchEntity($user, $this->request->getData());
            if ($this->Developers->save($user)) {
                
                $this->Flash->success(__('Usuário salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            
            $this->Flash->error(__('Usuário não pode ser salvo. Por favor, tente novamente.'));
        }
        $companies = $this->Developers->Companies->find('list', ['limit' => 200]);
        $usersTypes = $this->Developers->UsersTypes->find('list', ['limit' => 200]);
        $this->set(compact('user', 'companies', 'usersTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Developers->get($id, [
            'contain' => []
        ]);
        
       
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Developers->patchEntity($user, $this->request->getData());
            if ($this->Developers->save($user)) {
                 
                $this->Flash->success(__('Usuário salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Usuário não pode ser salvo. Por favor, tente novamente.'));
        }
        $companies = $this->Developers->Companies->find('list', ['limit' => 200]);
        $usersTypes = $this->Developers->UsersTypes->find('list', ['limit' => 200]);
        $this->set(compact('user', 'companies', 'usersTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Developers->get($id);
        
        if ($this->Developers->delete($user)) {
            $this->Flash->success(__('Usuário removido com sucesso.'));
        } else {
            $this->Flash->error(__('Usuário não pode ser removido. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
 
     
    /**
     * Organiza o upload.
     * @access public
     * @param Array $imagem
     * @param String $data
     */
    public function upload($id)
    {

        $user = $this->Developers->get($id);

        $this->request->session()->write('Upload',
            [
            'table'         => 'Developers',
            'column'        => 'image',
            'dir'           => 'users',
            'max_files'     => 1,
            'max_file_size' => 1000000,
            'download'      => true,
            'types_file'    => ['jpe?g', 'png'],
            'id'            => $id
        ]);

        $this->set('user', $user);
    }

}
