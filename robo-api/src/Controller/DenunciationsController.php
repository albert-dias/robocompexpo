<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Denunciations Controller
 *
 * @property \App\Model\Table\DenunciationsTable $Denunciations
 *
 * @method \App\Model\Entity\Denunciation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DenunciationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $denunciations = $this->paginate($this->Denunciations);

        $this->set(compact('denunciations'));
    }

    /**
     * View method
     *
     * @param string|null $id Denunciation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $denunciation = $this->Denunciations->get($id, [
            'contain' => []
        ]);

        $this->set('denunciation', $denunciation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $denunciation = $this->Denunciations->newEntity();
        if ($this->request->is('post')) {
            $denunciation = $this->Denunciations->patchEntity($denunciation, $this->request->getData());
            if ($this->Denunciations->save($denunciation)) {
                $this->Flash->success(__('The denunciation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The denunciation could not be saved. Please, try again.'));
        }
        $this->set(compact('denunciation'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Denunciation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $denunciation = $this->Denunciations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $denunciation = $this->Denunciations->patchEntity($denunciation, $this->request->getData());
            if ($this->Denunciations->save($denunciation)) {
                $this->Flash->success(__('The denunciation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The denunciation could not be saved. Please, try again.'));
        }
        $this->set(compact('denunciation'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Denunciation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $denunciation = $this->Denunciations->get($id);
        if ($this->Denunciations->delete($denunciation)) {
            $this->Flash->success(__('The denunciation has been deleted.'));
        } else {
            $this->Flash->error(__('The denunciation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
