<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 *
 * @method \App\Model\Entity\Payment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PaymentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ServiceOrders']
        ];
        $payments = $this->paginate($this->Payments);

        $this->set(compact('payments'));
    }

    /**
     * View method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payment = $this->Payments->get($id, [
            'contain' => ['ServiceOrders' => [
                'Categories',
                'Subcategories',
                'Providers' => [
                    'People'
                ],
                'Clients' => [
                    'People'
                ]
            ]]
        ]);

        $this->set('payment', $payment);
    }
    
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payment = $this->Payments->newEntity();
        if ($this->request->is('post')) {
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('The payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment could not be saved. Please, try again.'));
        }
        $serviceOrders = $this->Payments->ServiceOrders->find('list', ['limit' => 200]);
        $this->set(compact('payment', 'serviceOrders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payment = $this->Payments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('The payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment could not be saved. Please, try again.'));
        }
        $serviceOrders = $this->Payments->ServiceOrders->find('list', ['limit' => 200]);
        $this->set(compact('payment', 'serviceOrders'));
    }
    
    public function transfer($id = null)
    {

        $payment = $this->Payments->get($id, [
            'contain' => []
        ]);
        
        if($payment->providers_transfer){
            $this->Flash->error(__('Valor do prestador já repassado.')); 
            return $this->redirect(['action' => 'index']);
        }
      
        if($payment->image == null){
            $this->Flash->error(__('Comprovante não foi anexado.')); 
            return $this->redirect(['action' => 'upload', $payment->id]);
        }
       $payment->providers_transfer = true;
         
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('Valor do prestador repassado com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Valor do prestador não repassado. Por favor, tente novamente.'));
        
        return $this->redirect(['action' => 'index']);
    }

      /**
     * Organiza o upload.
     * @access public
     * @param Array $imagem
     * @param String $data
     */
    public function upload($id)
    {

        $this->request->session()->write('Upload',
            [
            'table'         => 'Payments',
            'column'        => 'image',
            'dir'           => 'payments',
            'max_files'     => 1,
            'max_file_size' => 1000000,
            'download'      => true,
            'types_file'    => ['jpe?g', 'png', 'pdf'],
            'id'            => $id
        ]);

    }
  


    /**
     * Delete method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payment = $this->Payments->get($id);
        if ($this->Payments->delete($payment)) {
            $this->Flash->success(__('The payment has been deleted.'));
        } else {
            $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
