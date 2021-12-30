<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Margin Controller
 *
 *
 * @method \App\Model\Entity\Margin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PlansController extends AppController{
   

    public function index(){
        $title       = isset($this->request->data['title']) ? $this->request->data['title'] : NULL;
        $users_types_id = isset($this->request->data['UsersTypes']) ? $this->request->data['UsersTypes'] : NULL;
 
        $conditions = [];
        

        if ($title) {
            $conditions['Plans.title LIKE '] = "%$title%";
        }
        
        if ($users_types_id) {
            $conditions['Plans.users_types_id'] = $users_types_id;
        }
        
         $this->paginate = [
            'contain'       => ['UsersTypes'],
            'conditions'    => $conditions,
            'sortWhitelist' => [
                'Plans.title'   => 'title',
                'UsersTypes.type'  => 'UsersTypes.type',
                'Plans.id' => 'id',
                'Plans.value'=>'value',
                'Plans.radius'=>'radius',
                'Plans.is_admin'=>'is_admin',
                'Plans.is_mobile'=>'is_mobile',
                'Plans.priority'=>'priority'
            ]
        ];
        
        $UsersType = $this->Plans->UsersTypes->find('list')->all(); 
        $Plans = $this->paginate($this->Plans);
        // $this->d($Plans);
        $this->set(compact('Plans', 'UsersType'));
    }

    public function add(){
        $Plans = $this->Plans->newEntity();
        if ($this->request->is('post')) {
            $Plans = $this->Plans->patchEntity($Plans, $this->request->getData());
            if ($this->Plans->save($Plans)) {
                $this->Flash->success(__('Plano foi salva com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Plano não pode ser salva. Por favor, tente novamente.'));
        }
        $UsersType = $this->Plans->UsersTypes->find('list')->all();
        $this->set(compact('Plans', 'UsersType'));
    }

    public function edit($id = null){
        $Plans = $this->Plans->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $Plans = $this->Plans->patchEntity($Plans, $this->request->getData());
            if ($this->Plans->save($Plans)) {
                $this->Flash->success(__('Plano foi salva com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Plano não pode ser salva. Por favor, tente novamente.'));
        }
        $UsersType = $this->Plans->UsersTypes->find('list')->all();
        $this->set(compact('Plans', 'UsersType'));
    }

    public function view($id = null)
    {
        $Plans = $this->Plans->get($id, [
            'contain' => ['UsersTypes']
        ]);
            // $this->d($Plans->priority_time->format('H:i:s'));
        $this->set('Plans', $Plans);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $Plans = $this->Plans->get($id);
        if ($this->Plans->delete($Plans)) {
            $this->Flash->success(__('Plano deletada com sucesso.'));
        } else {
            $this->Flash->error(__('Plano não pode ser deletada. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
