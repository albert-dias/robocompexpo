<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Leads Controller
 *
 * @property \App\Model\Table\LeadsTable $Leads
 *
 * @method \App\Model\Entity\Lead[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LeadsController extends AppController
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
        $conditions = ['archived' => false];

        if ($id) {
            $conditions['Leads.id'] = $id;
        }

        if ($name) {
            $conditions['Leads.name LIKE '] = "%$name%";
        }
        
        $this->paginate = [
            'contain' => ['Companies'],
            'conditions' => $conditions,
        ];

        $leads = $this->paginate($this->Leads);

        $this->set(compact('leads'));
    }

    /**
     * View method
     *
     * @param string|null $id Lead id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lead = $this->Leads->get($id, [
            'contain' => ['Companies']
        ]);

        $this->set('lead', $lead);
    }


    /**
     * Delete method
     *
     * @param string|null $id Lead id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $lead = $this->Leads->get($id);
        $lead->archived = true;

        if ($this->Leads->save($lead)) {
            $this->Flash->success(__('Registro arquivado com sucesso.'));
        } else {
            $this->Flash->error(__('Não foi possivel arquivar o arquivo. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
