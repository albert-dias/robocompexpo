<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Can component
 */
class CanComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public function check($company_id) {
        $id         = $this->request->session()->read('Auth.User.company_id');
        $controller = $this->_registry->getController();

        if ($company_id == $id) {
            return true;
        }

        $controller->Flash->error(__('Você não tem permissão para realizar essa ação.'));

        return $controller->redirect(['controller' => 'pages', 'action' => 'home']);
    }

    public function checkInstitution($company_id, $institution_id) {
        $_company_id     = $this->request->session()->read('Auth.User.company_id');
        $_institution_id = $this->request->session()->read('Auth.User.person.institution_id');
        $controller      = $this->_registry->getController();

        if ($company_id == $_company_id && $institution_id == $_institution_id) {
            return true;
        }

        $controller->Flash->error(__('Você não tem permissão para realizar essa ação.'));

        return $controller->redirect(['controller' => 'pages', 'action' => 'home']);
    }

}
