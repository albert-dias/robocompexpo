<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * ErrorList component
 */
class ErrorListComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function errorInString($errors){
        $r = "";
        
        foreach ($errors as $key => $value) {
            foreach ($value as $value2) {
                $r .= $key.' '.$value2.'|';
            }
        }
        return substr_replace($r, '', -1);;        
    }
}
