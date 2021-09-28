<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class CollectionOrdersResponsesTable extends Table {
  public function initialize(array $config) {
    $this->setTable('collection_orders_responses');
    $this->setPrimaryKey('id');
  }
}