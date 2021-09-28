<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class CollectionOrdersCategoriesTable extends Table {

  public function initialize(array $config) {
    parent::initialize($config);

    $this->setTable('collection_orders_categories');
    $this->setPrimaryKey('id');
  }
}