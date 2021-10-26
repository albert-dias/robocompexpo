<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use RestApi\Controller\ApiController;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 *
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends ApiController
{

    public function getAll()
    {
        //EM LOCALHOST MUDAR PARA O SEU IP
        // $url = 'https://grupoecomp.corpstek.com.br/robo-admin/webroot/';         //em produção
        $url = 'http://192.168.88.71/robo-comp/robo-admin/webroot/';                //localhost
        // $url = 'http://192.168.88.170/robo-comp/robo-admin/webroot/';

        $categories = $this->Categories->find()
            ->select([
                'id',
                'name',
                'url_icon',
                'description_category'
            ])
            ->where([
                'active' => true,
            ])
            ->order(['name']);

        foreach ($categories as $value) {
            if ($value->url_icon) {
                $value->url_icon = $url . $value->url_icon;
            }
        }
        $this->apiResponse['categorias'] = $categories;
    }
}
