<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validation;
use RestApi\Controller\ApiController;

class  UnregisteredUsersController extends ApiController {

  public function initialize() {
    $this->loadModel('UnregisteredUsers');
    return parent::initialize();
  }

  public function insert($id = 0) {
    $unregistered_user = ($id === 0) ? $this->UnregisteredUsers->newEntity() : $this->UnregisteredUsers->get(intval($id));

    if($this->request->data('name'))
      $unregistered_user->name = $this->request->data('name');
    if($this->request->data('nickname'))
      $unregistered_user->nickname = $this->request->data('nickname');
    if($this->request->data('number_contact'))
      $unregistered_user->number_contact = $this->request->data('number_contact');
    if($this->request->data('user_type'))
      $unregistered_user->users_types_id = $this->request->data('user_type');
    if($this->request->data('numero_cpf'))
      $unregistered_user->cpf = $this->request->data('numero_cpf');
    if($this->request->data('gender'))
      $unregistered_user->gender = $this->request->data('gender');
    if($this->request->data('date_of_birth'))
      $unregistered_user->date_of_birth = $this->request->data('date_of_birth');
    if($this->request->data('email'))
      $unregistered_user->email = $this->request->data('email');
    if($this->request->data('address'))
      $unregistered_user->address = $this->request->data('address');
    if($this->request->data('number'))
      $unregistered_user->number = $this->request->data('number');
    if($this->request->data('complement'))
      $unregistered_user->complement = $this->request->data('complement');
    if($this->request->data('password'))
      $unregistered_user->password = $this->request->data('password');
    if($this->request->data('city'))
      $unregistered_user->city = $this->request->data('city');
    if($this->request->data('state'))
      $unregistered_user->state = $this->request->data('state');

    if(($id === 0) && $this->UnregisteredUsers->save($unregistered_user)) {
      $this->apiResponse['id'] = $unregistered_user->id;
    } else {
      $this->apiResponse['id'] = $id;
    }

    return;
  }

  public function update($id = NULL) {
    if($id) {
      $unregistered_users = $this->UnregisteredUsers->get($id);

      $unregistered_users->gender = $this->request->data('gender');
      $unregistered_users->date_of_birth = $this->request->data('date_of_birth');
      $unregistered_users->email = $this->request->data('email');
      
      $cpf = $this->request->data('numero_cpf');
      if(isset($cpf)) {
        $unregistered_users->cpf = $this->request->data('numero_cpf');
      }
      
      $unregistered_users->address = $this->request->data('address');
      $unregistered_users->number = $this->request->data('number');
      $unregistered_users->complement = $this->request->data('complement');
      $unregistered_users->password = $this->request->data('password');

      $this->UnregisteredUsers->save($unregistered_users);

      return;
    }
  }

  public function delete($id) {
    $unregistered_users = $this->UnregisteredUsers->get($id);
    $result = $this->UnregisteredUsers->delete($unregistered_users);
    return;
  }
}