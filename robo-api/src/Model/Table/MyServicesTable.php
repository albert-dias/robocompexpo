<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class MyServicesTable extends Table {

  public function initialize(array $config) {
    parent::initialize($config);

    $this->setTable('my_services');
    $this->setPrimaryKey('id');

    $this->belongsTo('Users', [
      'foreignKey' => 'cpf'
      ]);
  }

  /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        return $validator;
    }
}