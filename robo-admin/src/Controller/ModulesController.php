<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Modules Controller
 *
 * @property \App\Model\Table\ModulesTable $Modules
 *
 * @method \App\Model\Entity\Module[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ModulesController extends AppController
{

    public function initialize() {
        parent::initialize();
        $this->loadModel('Plans');
        $this->loadModel('ModulesHasCompanies');

    }

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
            $conditions['Modules.id'] = $id;
        }

        if ($name) {
            $conditions['Modules.name LIKE '] = "%$name%";
        }
        
        if (isset($active) && $active != '') {
            $conditions['Modules.active'] = $active;
        }
        
        $this->paginate = [
            'conditions' => $conditions,
        ];
        
        $modules = $this->paginate($this->Modules);

        $this->set(compact('modules'));
    }

    /**
     * View method
     *
     * @param string|null $id Module id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $module = $this->Modules->get($id, [
            'contain' => ['Companies']
        ]);

        $this->set('module', $module);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $module = $this->Modules->newEntity();
        if ($this->request->is('post')) {
            // $this->d($this->request->getData());
            $module = $this->Modules->patchEntity($module, $this->request->getData());
            $module = $this->Modules->save($module);
            if ($module) {
                
                $data =  $this->request->getData();
                $data_modules = [];
                $save_module = null;
                if(!empty($data['ModulesHasCompany']['plans_id'])){
                    foreach ($data['ModulesHasCompany']['plans_id'] as $key => $value) {
                        if($value == ''){
                            $value = null;
                        }
                        $modules_has_company = $this->ModulesHasCompanies->newEntity();
                        $data_modules = array(
                            'modules_id'=>$module->id,
                            'plans_id'=>$value,
                            'company_id'=>1
                        );
                    $modules_has_company = $this->ModulesHasCompanies->patchEntity($modules_has_company, $data_modules);
                    $this->ModulesHasCompanies->save($modules_has_company);
                    }
                }else{
                    $modules_has_company = $this->ModulesHasCompanies->newEntity();
                        $data_modules = array(
                            'modules_id'=>$module->id,
                            'plans_id'=>null,
                            'company_id'=>1
                        );
                    $modules_has_company = $this->ModulesHasCompanies->patchEntity($modules_has_company, $data_modules);
                    $this->ModulesHasCompanies->save($modules_has_company);
                }
                $this->Flash->success(__('Módulo salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
                
                
            }
            
            $this->Flash->error(__('Módulo não pode ser salvo. Por favor, tente novamente.'));
        }
        $module_plans = $this->Plans->find('list');
        $this->set(compact('module','module_plans'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Module id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $module = $this->Modules->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $date = $this->request->getData();
            $module = $this->Modules->patchEntity($module, $date);
            // $this->d($date);
            if ($this->Modules->save($module)) {
                $ModulesHasCompanies_delete = $this->ModulesHasCompanies->find('all')->where(['modules_id'=>$module->id])->toArray();
                foreach ( $ModulesHasCompanies_delete as $value) {
                    $this->ModulesHasCompanies->delete($value);
                }
                if(isset($date['ModulesHasCompany']['plans_id'])){
                    foreach ($date['ModulesHasCompany']['plans_id'] as $key => $value) {
                        $modules_has_company = $this->ModulesHasCompanies->newEntity();
                        $data_modules = array(
                            'modules_id'=>$module->id,
                            'plans_id'=>$value,
                            'company_id'=>1
                        );
                    $modules_has_company = $this->ModulesHasCompanies->patchEntity($modules_has_company, $data_modules);
                    $this->ModulesHasCompanies->save($modules_has_company);
                    }
                }
                $this->Flash->success(__('Módulo salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Módulo não pode ser salvo. Por favor, tente novamente.'));
        }
        $module_plans = $this->Plans->find('all')->toArray();
        $module_plans_query=  $this->ModulesHasCompanies->find('all')->where(['modules_id'=>$module->id])->toArray();
        $module_plans_select = [];
        foreach ($module_plans_query as $key => $value) {
            $module_plans_select[$key] = $value->plans_id;
        }
        // $this->d($module_plans);
        // $this->d($module_plans_select);
        
        $this->set(compact('module','module_plans','module_plans_select'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Module id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $module = $this->Modules->get($id);
        if ($this->Modules->delete($module)) {
            $this->Flash->success(__('Módulo removido com sucesso.'));
        } else {
            $this->Flash->error(__('Módulo não pode ser deletado. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
