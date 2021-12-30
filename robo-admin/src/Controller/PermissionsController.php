<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Permissions Controller
 *
 * @property \App\Model\Table\PermissionsTable $Permissions
 *
 * @method \App\Model\Entity\Permission[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PermissionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $name       = isset($this->request->data['name']) ? $this->request->data['name'] : NULL;
        $controller = isset($this->request->data['controller']) ? $this->request->data['controller'] : NULL;
        $module     = isset($this->request->data['module']) ? $this->request->data['module'] : NULL;

        $conditions = [];
        
        if ($controller) {
            $conditions['Permissions.controller LIKE '] = "%$controller%";;
        }

        if ($name) {
            $conditions['Permissions.name LIKE '] = "%$name%";
        }
        
        if ($module) {
            $conditions['Permissions.modules_id'] = $module;
        }
        
         $this->paginate = [
            'contain'       => ['Modules'],
            'conditions'    => $conditions,
            'sortWhitelist' => [
                'Permissions.name'   => 'name',
                'Modules.name'  => 'Modules.name',
                'Permissions.id' => 'id',
                'Permissions.controller'  => 'controller'
            ]
        ];
        
        $modules = $this->Permissions->Modules->find('list')->all(); 
        $permissions = $this->paginate($this->Permissions);

        $this->set(compact('permissions', 'modules'));
    }

    /**
     * View method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $permission = $this->Permissions->get($id, [
            'contain' => ['Modules']
        ]);

        $this->set('permission', $permission);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $permission = $this->Permissions->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['controller'] = ucfirst($data['controller']);
            $permission = $this->Permissions->patchEntity($permission, $data);
            if ($this->Permissions->save($permission)) {
                $this->Flash->success(__('Página foi salva com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Página não pode ser salva. Por favor, tente novamente.'));
        }
        $modules = $this->Permissions->Modules->find('list', ['limit' => 200]);
        $this->set(compact('permission', 'modules'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $permission = $this->Permissions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $permission = $this->Permissions->patchEntity($permission, $this->request->getData());
            if ($this->Permissions->save($permission)) {
                $this->Flash->success(__('Página foi salva com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Página não pode ser salva. Por favor, tente novamente.'));
        }
        $modules = $this->Permissions->Modules->find('list', ['limit' => 200]);
        $this->set(compact('permission', 'modules'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Permission id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $permission = $this->Permissions->get($id);
        if ($this->Permissions->delete($permission)) {
            $this->Flash->success(__('Página deletada com sucesso.'));
        } else {
            $this->Flash->error(__('Página não pode ser deletada. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
