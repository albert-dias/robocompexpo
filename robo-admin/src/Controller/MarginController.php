<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Margin Controller
 *
 *
 * @method \App\Model\Entity\Margin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MarginController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        $margin = $this->Margin->find()->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $margin = $this->Margin->patchEntity($margin, $this->request->getData());
            if ($this->Margin->save($margin)) {
                $this->Flash->success(__('Margem atualizada com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar a margem. Por favor, tente novamente.'));
        }

        $this->set(compact('margin'));
    }

    /**
     * View method
     *
     * @param string|null $id Margin id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $margin = $this->Margin->get($id, [
            'contain' => []
        ]);

        $this->set('margin', $margin);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $margin = $this->Margin->newEntity();
        if ($this->request->is('post')) {
            $margin = $this->Margin->patchEntity($margin, $this->request->getData());
            if ($this->Margin->save($margin)) {
                $this->Flash->success(__('The margin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The margin could not be saved. Please, try again.'));
        }
        $this->set(compact('margin'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Margin id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $margin = $this->Margin->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $margin = $this->Margin->patchEntity($margin, $this->request->getData());
            if ($this->Margin->save($margin)) {
                $this->Flash->success(__('The margin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The margin could not be saved. Please, try again.'));
        }
        $this->set(compact('margin'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Margin id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $margin = $this->Margin->get($id);
        if ($this->Margin->delete($margin)) {
            $this->Flash->success(__('The margin has been deleted.'));
        } else {
            $this->Flash->error(__('The margin could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
