<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Companies Controller
 *
 * @property \App\Model\Table\CompaniesTable $Companies
 *
 * @method \App\Model\Entity\Company[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompaniesController extends AppController
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
            $conditions['Companies.id'] = $id;
        }

        if ($name) {
            $conditions['Companies.name LIKE '] = "%$name%";
        }
        
        if (isset($active) && $active != '') {
            $conditions['Companies.active'] = $active;
        }
        

        $this->paginate = [
            'contain' => ['Modules', 'Users'],
            'conditions' => $conditions
        ];
        $companies = $this->paginate($this->Companies);
        
        $this->set(compact('companies'));
    }

    /**
     * View method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $company = $this->Companies->get($id, [
            'contain' => ['ResalePlans', 'ErrorLogs', 'Modules', 'Users']
        ]);

        $this->set('company', $company);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $company = $this->Companies->newEntity();
        if ($this->request->is('post')) {
            $company = $this->Companies->patchEntity($company, $this->request->getData());
            if ($this->Companies->save($company)) {
                $this->Flash->success(__('A empresa salva com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A empresa não pode ser salva. Por favor tente novamente.'));
        }
        $modules = $this->Companies->Modules->find('list');
        $resalePlans = $this->Companies->ResalePlans->find('list', ['limit' => 200]);
        $this->set(compact('company', 'resalePlans', 'modules'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $company = $this->Companies->get($id, [
            'contain' => ['Modules']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $company = $this->Companies->patchEntity($company, $this->request->getData());
            if ($this->Companies->save($company)) {
                $this->Flash->success(__('A empresa salva com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A empresa não pode ser salva. Por favor tente novamente.'));
        }
        $modules = $this->Companies->Modules->find('list');
        $resalePlans = $this->Companies->ResalePlans->find('list', ['limit' => 200]);
        $this->set(compact('company', 'resalePlans', 'modules'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $company = $this->Companies->get($id);
        if ($this->Companies->delete($company)) {
            $this->Flash->success(__('Empresa deletada com sucesso.'));
        } else {
            $this->Flash->error(__('A empresa não pode ser deletada. Por favor tente novamente'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
     public function upload($id) {

        $company = $this->Companies->get($id);

        $this->request->session()->write('Upload', [
            'table'         => 'Companies',
            'column'        => 'image',
            'dir'           => 'companies',
            'max_files'     => 1,
            'max_file_size' => 1000000,
            'download'      => true,
            'types_file'    => ['jpe?g', 'png'],
            'id'            => $id
        ]);

        $this->set('company', $company);
    }

}
