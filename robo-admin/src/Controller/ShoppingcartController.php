<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Auth\DefaultPasswordHasher;
use RestApi\Utility\JwtToken;

/**
 * Users Controller
 *
 * @property \App\Model\Table\ShoppingcartTable $Users
 *
 * @method \App\Model\Entity\Shoppingcart[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

 class ShoppingcartController extends AppController
 {
    public function initialize() {
        parent::initialize();
        $this->loadModel('Users');
        $this->loadModel('People');
        $this->loadModel('Plans');
        $this->loadModel('UserRelationships');
        $this->loadModel('UsersCategories');
        $this->loadModel('Clients');
        $this->loadComponent('S3Tools');
        $this->loadComponent('Emails');
        $this->loadComponent('RequestHandler');
        $usertype = $this->request->session()->read('Auth.User.users_types_id');
        $this->set(compact('usertype'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */

    public function index()
    {    
        
        $name          = isset($this->request->data['name']) ? $this->request->data['name'] : NULL;
        $email         = isset($this->request->data['email']) ? $this->request->data['email'] : NULL;
        $cpf         = isset($this->request->data['cpf']) ? $this->request->data['cpf'] : NULL;
        $users_types_id = isset($this->request->data['users_types_id']) ? $this->request->data['users_types_id'] : NULL;
        $plan_id = isset($this->request->data['plan_id']) ? $this->request->data['plan_id'] : NULL;

        $conditions['Users.company_id'] = $this->request->session()->read('Auth.User.company_id');
        $conditions['UsersTypes.public']  = true;
        $conditions['Users.users_types_id'] = 6;
        // $conditions['Users.plan_id IS NOT'] = null;
        
        if ($email) {
            $conditions['Users.email'] = $email;
        }
        if ($cpf) {
            $conditions['Users.cpf'] = $cpf;
        }

        if ($name) {
            $conditions['Users.name LIKE '] = "%$name%";
        }
        
        if ($plan_id) {
            $conditions['Users.plan_id'] = $plan_id;
        }
        
        $this->paginate = [
            'contain'       => ['Companies', 'UsersTypes','People','Plans'],
            'conditions' => $conditions,
            'sortWhitelist' => [
                'UsersTypes.type' => 'type',
                'Users.email'     => 'email',
                'Users.name'      => 'name',
                'Users.id'        => 'id'
            ]
        ];
        $users = $this->paginate($this->Users, ['limit' => 10, 'order' => array( // sets a default order to sort by
            'id' => 'desc'
        )]);
        $plans = $this->Users->Plans->find('list')->all();
        $cliente = null;
        foreach ($users as $user){
            if($user->id != 1){
                
                $cliente = $this->Clients->find('all')->where(["person_id"=>$user->person_id])->first();
                
                if($cliente != null){
                    if($cliente['image'] != null){
                        $user->photo =$this->S3Tools->getUrlTemp($cliente['image'], 120);
                    }
                }
            }
            
        }

        $this->set(compact('users', 'plans'));
    }


    // Função do status NO CARRINHO
    public function carrinho() {
        $carrinho = $this->query("SELECT people.name, shopping_cart.* FROM shopping_cart INNER JOIN people WHERE status = 'carrinho' AND people.id = shopping_cart.client_id");
        // $this->d($carrinho);
        
        $horario = array();
        $cliente = array();
        $tecnico = array();

        for($i=0; $i < count($carrinho); $i++){
            $aux = explode('/',$carrinho[0]->dia);
            // $this->d($aux);
            $horario[$i] = $aux[2].'/'.$aux[1].'/'.$aux[0];
            $cliente[$i] = $this->query("SELECT people.name FROM people WHERE people.id = ". $carrinho[$i]->client_id)[0]->name;
            $tecnico[$i] = $this->query("SELECT people.name FROM people WHERE people.id = ". $carrinho[$i]->company_id)[0]->name;
        }

        $this->set(compact('carrinho','cliente','tecnico','horario'));
    }

    // Função do status EM ESPERA
    public function waiting() {
        $waiting = $this->query("SELECT people.name, shopping_cart.* FROM shopping_cart INNER JOIN people WHERE status = 'requisitado' AND people.id = shopping_cart.client_id");
        // $this->d($waiting);

        $horario = array();
        $cliente = array();
        $tecnico = array();
        for($i=0;$i < count($waiting); $i++){
            $aux = explode('/',$waiting[$i]->dia);
            // $this->d($aux);
            $horario[$i] = $aux[2].'/'.$aux[1].'/'.$aux[0];
            $cliente[$i] = $this->query("SELECT people.name FROM people WHERE people.id = ". $waiting[$i]->client_id)[0]->name;
            $tecnico[$i] = $this->query("SELECT people.name FROM people WHERE people.id = ". $waiting[$i]->company_id)[0]->name;
        }

        $this->set(compact('waiting','cliente','tecnico','horario'));
    }

    // Função do status EM ANDAMENTO
    public function ongoing(){
        $ongoing = $this->query("SELECT people.name, shopping_cart.* FROM shopping_cart INNER JOIN people WHERE status = 'aceito' AND status_cliente = 'aceito' AND people.id = shopping_cart.client_id");
        // $this->d($ongoing);

        $horario = array();
        $cliente = array();
        $tecnico = array();
        for($i=0;$i < count($ongoing); $i++){
            $aux = explode('/',$ongoing[$i]->dia);
            // $this->d($aux);
            $horario[$i] = $aux[2].'/'.$aux[1].'/'.$aux[0];
            $cliente[$i] = $this->query("SELECT people.name FROM people WHERE people.id = ". $ongoing[$i]->client_id)[0]->name;
            $tecnico[$i] = $this->query("SELECT people.name FROM people WHERE people.id = ". $ongoing[$i]->company_id)[0]->name;
        }
        
        // $this->d($horario);
        // $this->d($cliente);
        // $this->d($tecnico);

        $this->set(compact('ongoing','cliente','tecnico','horario'));
    }

    // Função do status FINALIZADO
    public function finished(){
        $finished = $this->query("SELECT people.name, shopping_cart.* FROM shopping_cart INNER JOIN people WHERE (status = 'finalizado' OR status_cliente = 'finalizado') AND people.id = shopping_cart.client_id");

        // $this->d($finished);

        $horario = array();
        $cliente = array();
        $tecnico = array();
        for($i=0;$i < count($finished); $i++){
            $aux = explode('/',$finished[$i]->dia);
            // $this->d($aux);
            $horario[$i] = $aux[2].'/'.$aux[1].'/'.$aux[0];
            $cliente[$i] = $this->query("SELECT people.name FROM people WHERE people.id = ". $finished[$i]->client_id)[0]->name;
            $tecnico[$i] = $this->query("SELECT people.name FROM people WHERE people.id = ". $finished[$i]->company_id)[0]->name;
        }
        
        // $this->d($horario);
        // $this->d($cliente);
        // $this->d($tecnico);

        $this->set(compact('finished','cliente','tecnico','horario'));
    }

    // Função do status AVALIADO
    public function evaluate(){
        $evaluate = $this->query("SELECT people.name, shopping_cart.* FROM shopping_cart INNER JOIN people WHERE (status = 'avaliado' OR status_cliente = 'avaliado') AND people.id = shopping_cart.client_id");
        
        // $this->d($evaluate);

        $horario = array();
        $cliente = array();
        $tecnico = array();
        for($i=0;$i < count($evaluate); $i++){
            $aux = explode('/',$evaluate[$i]->dia);
            // $this->d($aux);
            $horario[$i] = $aux[2].'/'.$aux[1].'/'.$aux[0];
            $cliente[$i] = $this->query("SELECT people.name FROM people WHERE people.id = ". $evaluate[$i]->client_id)[0]->name;
            $tecnico[$i] = $this->query("SELECT people.name FROM people WHERE people.id = ". $evaluate[$i]->company_id)[0]->name;
        }
        
        // $this->d($horario);
        // $this->d($cliente);
        // $this->d($tecnico);

        $this->set(compact('evaluate','cliente','tecnico','horario'));
    }

    public function denied(){
        $denied = $this->query("SELECT people.name, shopping_cart.* FROM shopping_cart INNER JOIN people WHERE status = 'negado' AND people.id = shopping_cart.client_id");
        // $this->d($denied);

        $horario = array();
        $cliente = array();
        $tecnico = array();

        for($i=0;$i < count($denied); $i++){
            $aux = explode('/',$denied[$i]->dia);
            // $this->d($aux);
            $horario[$i] = $aux[2].'/'.$aux[1].'/'.$aux[0];
            $cliente[$i] = $this->query("SELECT people.name FROM people WHERE people.id = ". $denied[$i]->client_id)[0]->name;
            $tecnico[$i] = $this->query("SELECT people.name FROM people WHERE people.id = ". $denied[$i]->company_id)[0]->name;
        }

        // $this->d($horario);
        // $this->d($cliente);
        // $this->d($tecnico);
        $this->set(compact('denied','cliente','tecnico','horario'));
    }

    public function d($value,$message = null){
		debug($value);
		if(isset($message)){
			throw new Exception($message);
		}
		exit();
	}
 }