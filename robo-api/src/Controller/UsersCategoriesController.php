<?php

namespace App\Controller;

use RestApi\Controller\ApiController;
use Cake\Datasource\ConnectionManager;
use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersCategoriesController extends ApiController
{

    public function initialize()
    {
        $this->loadModel('Clients');
        return parent::initialize();
    }

    public function getCategoriesUser()
    {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);
        //EM LOCALHOST MUDAR PARA O SEU IP
        // $url = 'https://grupoecomp.corpstek.com.br/robo-admin';      //em produção
        $url = 'http://192.168.88.71/robo-comp/robo-admin';             //localhost
        // $url = 'http://192.168.88.170/robo-comp/robo-admin';

        /* SELECT categories.* FROM categories
        INNER JOIN users_categories ON categories.id = users_categories.categorie_id
        INNER JOIN users ON users.id = users_categories.user_id
        INNER JOIN clients ON clients.person_id = users.person_id WHERE clients.id = 50  */

        $client_id = $client->id;
        $sql = 'SELECT users_categories.*, categories.name, categories.url_icon FROM categories INNER JOIN users_categories ON categories.id = users_categories.categorie_id INNER JOIN users ON users.id = users_categories.user_id INNER JOIN clients ON clients.person_id = users.person_id WHERE clients.id = ' . $client_id;

        $userCategories = $this->query($sql);

        foreach ($userCategories as $value) {
            if ($value->url_icon) {
                $value->url_icon = $url . $value->url_icon;
            }
        }
        $this->apiResponse = $userCategories;
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
			if(is_float($value) && strlen($value) <= 8) { $value = (float)$value;}

			if(is_int($value) && strlen($value) <= 8) { $value = (int)$value;}
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

    public function updatePrices() {
        $token = $this->jwtPayload;
        $client = $this->Clients->get($token->id);

        $users_categories = $this->request->data('users_categories');
        if($users_categories) {
            $users_categories = json_decode($users_categories);
            foreach ($users_categories as $value) {
                $user_categorie = $this->UsersCategories->get($value->id);
                $user_categorie->Price = $value->Price;
                $this->UsersCategories->save($user_categorie);
            }
        }
        $this->apiResponse = "Preços atualizados com sucesso.";
    }
}
