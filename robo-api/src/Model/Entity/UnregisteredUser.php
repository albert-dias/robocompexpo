<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class UnregisteredUser extends Entity {

  protected $_accessible = [
    'users_types_id' => true,
    'name' => true,
    'nickname' => true,
    'number_contact' => true,
    'gender' => true,
    'date_of_birth' => true,
    'email' => true,
    'cpf' => true,
    'password' => true,
    'created' => true,
    'modified' => true
  ];
}