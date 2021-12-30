<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class AdsTable extends Table{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('ads');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        
        $this->belongsTo('user', [
            'foreignKey' => 'id_user',
            'joinType' => 'INNER'
        ]);
    }

        
}