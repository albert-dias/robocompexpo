<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class PlansTable extends Table {

  public function initialize(array $config) {
    $this->setTable('plans');
    $this->setPrimaryKey('id');
  }

}