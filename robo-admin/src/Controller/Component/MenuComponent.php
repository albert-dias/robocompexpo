<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
/**
 * Menu component
 */
class MenuComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public function Permissions() {
        
        if (!$this->userActive($this->request->session()->read('Auth.User.id'))){
             return false;
        }

        $p = TableRegistry::get('ModulesHasCompanies');

        $type_user = TableRegistry::get('UsersTypesHasModules')
                ->find('list', [
                    'keyField'   => 'modules_id',
                    'valueField' => 'modules_id'
                ])
                ->where([
                    'users_types_id' => $this->request->session()->read('Auth.User.users_types_id')
                ])
                ->toArray();
        
        if(!$type_user){
            return false;
        }
        
        $modules = $p->find('all')
                ->where([
                    // 'plans_id'  => $this->request->session()->read('Auth.User.plan_id'),
                    'modules_id IN' => $type_user
                ])
                ->contain([
                    'Modules',
                    'Plans',
                ])
                ->order(['Modules.name'])
                ->toList();

        $menu = [];
        $perm = ['Pages', 'Ajax', 'Charts', 'MachineGun'];

        foreach ($modules as $value) {
            $permi       = TableRegistry::get('Permissions');
            $permissions = $permi->find('all')
                        ->where([
                            'modules_id' => $value->modules_id
                        ])
                        ->order(['Permissions.name'])
                        ->toList();



            foreach ($permissions as $value_) {
                $menu[$value->module->name]['pages'][]       = ['page' => $value_->name, 'controller' => $value_->controller];
                $menu[$value->module->name]['details']       = ['class' => $value->module->icon];
                $menu[$value->module->name]['controllers'][] = $value_->controller;
                $perm[]                                      = $value_->controller;
            }
        }
        
        $this->request->session()->write('Config.menu', $menu);
        $this->request->session()->write('Config.permissions', $perm);
        
        return true;
    }
    
    private function userActive($id) {
        $q = TableRegistry::get('Users');
        $u = $q->find()->where([
                    'id'     => $id,
                    'active' => true
                ])->count();

        return $u;
    }

}
