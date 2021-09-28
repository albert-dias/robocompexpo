<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Auth\DefaultPasswordHasher; 
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UnregisteredUsersTable extends Table {

  public function initialize(array $config) {
    parent::initialize($config);

    $this->setTable('unregistered_users');
    $this->setDisplayField('name');
    $this->setPrimaryKey('id');

    $this->addBehavior('Timestamp');
  }
}