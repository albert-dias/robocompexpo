<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Ratings Controller
 *
 * @property \App\Model\Table\RatingsTable $Ratings
 *
 * @method \App\Model\Entity\Rating[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RatingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {

        $types = [
            'provider' => 'Prestador',
            'client' => 'Cliente'
        ];

        $stars      = isset($this->request->data['stars']) ? $this->request->data['stars'] : NULL;
        $id         = isset($this->request->data['id']) ? $this->request->data['id'] : NULL;
        $type       = isset($this->request->data['type']) ? $this->request->data['type'] : NULL;
        $conditions = [];

        if ($id) {
            $conditions['Ratings.id'] = $id;
        }

        if (isset($stars) && $stars) {
            $conditions['Ratings.stars'] = $stars;
        }
        
        if (isset($type) && $type) {
            $conditions['Ratings.type'] = $type;
        }
        
        $this->paginate = [
            'conditions' => $conditions,
            'contain' => ['Companies', 'ServiceOrders', 'Clients'=>['People'], 'Providers'=>['People']]
        ];
        

        $ratings = $this->paginate($this->Ratings);

        $this->set(compact('ratings', 'types'));

    }

    /**
     * View method
     *
     * @param string|null $id Rating id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rating = $this->Ratings->get($id, [
            'contain' => ['Companies', 'ServiceOrders'=>['Categories', 'Subcategories'], 'Clients'=>['People'], 'Providers'=>['People']]
        ]);

        $type = [
            'provider' => 'Prestador',
            'client' => 'Cliente'
        ];

        $this->set(compact('rating', 'type'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rating = $this->Ratings->newEntity();
        if ($this->request->is('post')) {
            $rating = $this->Ratings->patchEntity($rating, $this->request->getData());
            if ($this->Ratings->save($rating)) {
                $this->Flash->success(__('The rating has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rating could not be saved. Please, try again.'));
        }
        $companies = $this->Ratings->Companies->find('list', ['limit' => 200]);
        $serviceOrders = $this->Ratings->ServiceOrders->find('list', ['limit' => 200]);
        $clients = $this->Ratings->Clients->find('list', ['limit' => 200]);
        $providers = $this->Ratings->Providers->find('list', ['limit' => 200]);
        $this->set(compact('rating', 'companies', 'serviceOrders', 'clients', 'providers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Rating id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rating = $this->Ratings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rating = $this->Ratings->patchEntity($rating, $this->request->getData());
            if ($this->Ratings->save($rating)) {
                $this->Flash->success(__('The rating has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rating could not be saved. Please, try again.'));
        }
        $companies = $this->Ratings->Companies->find('list', ['limit' => 200]);
        $serviceOrders = $this->Ratings->ServiceOrders->find('list', ['limit' => 200]);
        $clients = $this->Ratings->Clients->find('list', ['limit' => 200]);
        $providers = $this->Ratings->Providers->find('list', ['limit' => 200]);
        $this->set(compact('rating', 'companies', 'serviceOrders', 'clients', 'providers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Rating id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rating = $this->Ratings->get($id);
        if ($this->Ratings->delete($rating)) {
            $this->Flash->success(__('The rating has been deleted.'));
        } else {
            $this->Flash->error(__('The rating could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
