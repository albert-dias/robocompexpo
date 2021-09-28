<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class MyServiceOrdersImagesTable extends Table
{

    /**
     * Initialize method
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('my_service_orders_images');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('MyServiceOrders', [
            'foreignKey' => 'my_service_orders_id',
            'joinType' => 'INNER'
        ]);
    }
}
