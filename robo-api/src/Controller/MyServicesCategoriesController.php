<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use RestApi\Controller\ApiController;

/**
 * MyServicesCategories Controller
 *
 * @property \App\Model\Table\MyServicesCategoriesTable $Services
 * @method \App\Model\Entity\MyServicesCategories[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

class MyServicesCategoriesController extends ApiController
{
    /**
      * Inicialização dos components
      */
    public function initialize()
    {
        $this->loadModel('Providers');
        $this->loadModel('ErrorList');
        $this->loadModel('Users');
        $this->loadModel('People');
        $this->loadModel('Clients');
        $this->loadModel('Margin');
        return parent::initialize();
    }

    public function query($sql){
        $connection = ConnectionManager::get('default');
        $query = $connection->execute($sql)->fetchall('assoc');
        return $this->arrayToArrayObj($query);
    }
    public function arrayToObj($arr){
        $object = (object) [];
        foreach ($arr as $key => $value)
        {
            if(is_numeric($value) && strpos($value, ".") !== false){$value = (float)$value;}
            if(is_numeric($value) && strpos($value, ".") == false) { $value = (int)$value;}
            $object->$key = $value;
        }
        return $object;
    }

    public function arrayToArrayObj($arr){
        $arr2 = [];
        foreach ($arr as $key => $value){
            $value2 = $this->arrayToObj($value);
            array_push($arr2,$value2);
        }
        return $arr2;
    }

    public function getAll()
    {
        //EM LOCALHOST MUDAR PARA O SEU IP
        // $url = 'https://grupoecomp.corpstek.com.br/robo-admin/webroot/';     //em produção
        $url = 'http://192.168.88.71/robo-comp/robo-admin/webroot/';            //localhost
        // $url = 'http://192.168.88.170/robo-comp/robo-admin/webroot';

        $categories = $this->MyServicesCategories->find()
        ->select([
            'id',
            'category_name',
            'url_icon',
            'description'
        ])
        ->where([
            'active' => true,
        ])
        ->order(['name']);

        foreach ($categories as $values) {
            if ($value->url_icon) {
                $value->url_icon = $url . $value->url_icon;
            }
        }

        $this->apiResponse = $categories;
    }

    public function listCategories() {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);

        $person = $this->People->get($client->person_id);

        if($this->request->is('get')){
            $categories = $this->MyServicesCategories->find('all')->toArray();
            $this->apiResponse['categories'] = $categories;
            return;
        }
    }

    public function setCategories() {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);

        $person = $this->People->get($client->person_id);

        if($this->request->is('get')){
            $sql = 'SELECT * FROM my_services_categories INNER JOIN users_categories
                    WHERE users_categories.categorie_id = my_services_categories.id
                    AND users_categories.user_id = '.$token->id.'
                    ORDER BY my_services_categories.id ASC';

            $sql2 = 'SELECT * FROM subcategories INNER JOIN my_services_categories INNER JOIN users_categories
                    WHERE users_categories.categorie_id = my_services_categories.id
                    AND subcategories.category_id = my_services_categories.id
                    AND users_categories.user_id = '.$token->id.'
                    ORDER BY my_services_categories.id ASC';

            $categories = $this->query($sql);
            $subcategories = $this->query($sql2);
            $this->apiResponse['categories'] = $categories;
            $this->apiResponse['subcategories'] = $subcategories;
            return;
        }

        if($this->request->is('post')){
            $search = $this->request->data('search');

            $categories = $this->MyServicesCategories->find('all')->where([
                'category_name' => $search,
            ])->toArray();
            $this->apiResponse['categories'] = $categories;
            return;
        }
    }

    public function setSubCategories() {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        $person = $this->People->get($client->person_id);

        $search = $this->request->data('search');
        $support = "Todas as categorias";

        $table = TableRegistry::get('MyServicesCategories');
        $table2 = TableRegistry::get('Subcategories');

        if($this->request->is('post')) {

            $filter = $table->find()->where([
                'category_name' => $search,
            ])->first();

            $filter2 = $table2->find()->where([
                'category_id' => $filter->id,
                'active' => '1',
            ])->toArray();

            $this->apiResponse['subcategories'] = $filter2;
            return;
        }
    }
}
