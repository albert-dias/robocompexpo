<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * UsersTypes Controller
 *
 * @property \App\Model\Table\UsersTypesTable $UsersTypes
 *
 * @method \App\Model\Entity\UsersType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersTypesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $name       = isset($this->request->data['name']) ? $this->request->data['name'] : NULL;
        $id         = isset($this->request->data['id']) ? $this->request->data['id'] : NULL;
        $active     = isset($this->request->data['active']) ? $this->request->data['active'] : NULL;
        $conditions = [];

        if ($id) {
            $conditions['UsersTypes.id'] = $id;
        }

        if ($name) {
            $conditions['UsersTypes.type LIKE '] = "%$name%";
        }
        
        if (isset($active) && $active != '') {
            $conditions['UsersTypes.active'] = $active;
        }
        
        
         $this->paginate = [
            'contain' => ['UsersTypesHasModules'=>'Modules'],
            'conditions' => $conditions,
        ];
         
        $usersTypes = $this->paginate($this->UsersTypes);

        $this->set(compact('usersTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Users Type id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $usersType = $this->UsersTypes->get($id, [
            'contain' => ['Modules', 'Users']
        ]);

        $this->set('usersType', $usersType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usersType = $this->UsersTypes->newEntity();
        if ($this->request->is('post')) {
            $usersType = $this->UsersTypes->patchEntity($usersType, $this->request->getData());
            if ($this->UsersTypes->save($usersType)) {
                $this->Flash->success(__('Tipo de usuário salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            
            $this->Flash->error(__('Tipo de usuário não pode ser salvo. Por favor, tente novamente.'));
        }
        $modules = $this->UsersTypes->Modules->find('list');
        $this->set(compact('usersType', 'modules'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Users Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usersType = $this->UsersTypes->get($id, [
            'contain' => ['Modules']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usersType = $this->UsersTypes->patchEntity($usersType, $this->request->getData());
            if ($this->UsersTypes->save($usersType)) {
                $this->Flash->success(__('Tipo de usuário salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Tipo de usuário não pode ser salvo. Por favor, tente novamente.'));
        }
        $modules = $this->UsersTypes->Modules->find('list');
        $this->set(compact('usersType', 'modules'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Users Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usersType = $this->UsersTypes->get($id);
        if ($this->UsersTypes->delete($usersType)) {
            $this->Flash->success(__('Tipo de usuário deletado com sucesso.'));
        } else {
            $this->Flash->error(__('Tipo de usuário não pode ser deletado. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
