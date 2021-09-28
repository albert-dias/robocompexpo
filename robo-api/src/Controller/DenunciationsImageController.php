<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DenunciationsImage Controller
 *
 * @property \App\Model\Table\DenunciationsImageTable $DenunciationsImage
 *
 * @method \App\Model\Entity\DenunciationsImage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DenunciationsImageController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $denunciationsImage = $this->paginate($this->DenunciationsImage);

        $this->set(compact('denunciationsImage'));
    }

    /**
     * View method
     *
     * @param string|null $id Denunciations Image id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $denunciationsImage = $this->DenunciationsImage->get($id, [
            'contain' => []
        ]);

        $this->set('denunciationsImage', $denunciationsImage);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $denunciationsImage = $this->DenunciationsImage->newEntity();
        if ($this->request->is('post')) {
            $denunciationsImage = $this->DenunciationsImage->patchEntity($denunciationsImage, $this->request->getData());
            if ($this->DenunciationsImage->save($denunciationsImage)) {
                $this->Flash->success(__('The denunciations image has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The denunciations image could not be saved. Please, try again.'));
        }
        $this->set(compact('denunciationsImage'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Denunciations Image id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $denunciationsImage = $this->DenunciationsImage->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $denunciationsImage = $this->DenunciationsImage->patchEntity($denunciationsImage, $this->request->getData());
            if ($this->DenunciationsImage->save($denunciationsImage)) {
                $this->Flash->success(__('The denunciations image has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The denunciations image could not be saved. Please, try again.'));
        }
        $this->set(compact('denunciationsImage'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Denunciations Image id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $denunciationsImage = $this->DenunciationsImage->get($id);
        if ($this->DenunciationsImage->delete($denunciationsImage)) {
            $this->Flash->success(__('The denunciations image has been deleted.'));
        } else {
            $this->Flash->error(__('The denunciations image could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
