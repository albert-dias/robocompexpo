<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Gatways Controller
 *
 * @property \App\Model\Table\GatwaysTable $Gatways
 *
 * @method \App\Model\Entity\Gatway[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GatwaysController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $name       = isset($this->request->data['name']) ? $this->request->data['name'] : NULL;
        $id         = isset($this->request->data['id']) ? $this->request->data['id'] : NULL;
        $active     = isset($this->request->data['active']) ? $this->request->data['active'] : NULL;
        $conditions = [];

        if ($id) {
            $conditions['Gatways.id'] = $id;
        }

        if ($name) {
            $conditions['Gatways.name LIKE '] = "%$name%";
        }
        
        if (isset($active) && $active != '') {
            $conditions['Modules.active'] = $active;
        }
        
        $this->paginate = [
            'conditions' => $conditions,
        ];
        
        $gatways = $this->paginate($this->Gatways);

        $this->set(compact('gatways'));
    }

    /**
     * View method
     *
     * @param string|null $id Gatway id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $gatway = $this->Gatways->get($id, [
            'contain' => []
        ]);

        $this->set('gatway', $gatway);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $gatway = $this->Gatways->newEntity();
        if ($this->request->is('post')) {
            $gatway = $this->Gatways->patchEntity($gatway, $this->request->getData());
            if ($this->Gatways->save($gatway)) {
                $this->Flash->success(__('Registro salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Registro não pode ser salvo. Por favor tente novamente'));
        }

        $this->set(compact('gatway'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Gatway id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $gatway = $this->Gatways->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $gatway = $this->Gatways->patchEntity($gatway, $this->request->getData());
            if ($this->Gatways->save($gatway)) {
                $this->Flash->success(__('Registro salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao editar registro. Por favor, tente novamente.'));
        }
        $this->set(compact('gatway'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Gatway id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $gatway = $this->Gatways->get($id);
        if ($this->Gatways->delete($gatway)) {
            $this->Flash->success(__('Gatway removido com sucesso.'));
        } else {
            $this->Flash->error(__('The gatway could not be deleted. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
