<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Work Model
 *
 * @method \App\Model\Entity\Work get($primaryKey, $options = [])
 * @method \App\Model\Entity\Work newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Work[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Work|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Work|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Work patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Work[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Work findOrCreate($search, callable $callback = null, $options = [])
 */
class WorkTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('work');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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

        $validator
            ->integer('code_tec')
            ->requirePresence('code_tec', 'create')
            ->allowEmptyString('code_tec', false);

        $validator
            ->boolean('accepted')
            ->requirePresence('accepted', 'create')
            ->allowEmptyString('accepted', false);

        $validator
            ->integer('code_work')
            ->requirePresence('code_work', 'create')
            ->allowEmptyString('code_work', false);

        $validator
            ->integer('day')
            ->requirePresence('day', 'create')
            ->allowEmptyString('day', false);

        $validator
            ->integer('month')
            ->requirePresence('month', 'create')
            ->allowEmptyString('month', false);

        $validator
            ->integer('year')
            ->requirePresence('year', 'create')
            ->allowEmptyString('year', false);

        $validator
            ->integer('hour')
            ->requirePresence('hour', 'create')
            ->allowEmptyString('hour', false);

        $validator
            ->integer('time')
            ->requirePresence('time', 'create')
            ->allowEmptyString('time', false);

        return $validator;
    }
}
