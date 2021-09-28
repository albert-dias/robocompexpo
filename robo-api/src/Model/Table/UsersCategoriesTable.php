<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class UsersCategoriesTable extends Table {

  public function initialize(array $config) {
    parent::initialize($config);

    $this->setTable('users_categories');
    $this->setPrimaryKey('id');
  }
}