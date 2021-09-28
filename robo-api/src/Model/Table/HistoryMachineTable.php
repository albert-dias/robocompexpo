<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HistoryMachine Model
 *
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 *
 * @method \App\Model\Entity\HistoryMachine get($primaryKey, $options = [])
 * @method \App\Model\Entity\HistoryMachine newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\HistoryMachine[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HistoryMachine|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HistoryMachine|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HistoryMachine patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HistoryMachine[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\HistoryMachine findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class HistoryMachineTable extends Table
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

        $this->setTable('history_machine');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER'
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

        $validator
            ->integer('company_ id')
            ->requirePresence('company_ id', 'create')
            ->allowEmptyString('company_ id', false);

        $validator
            ->scalar('machine_name')
            ->maxLength('machine_name', 50)
            ->requirePresence('machine_name', 'create')
            ->allowEmptyString('machine_name', false);

        $validator
            ->scalar('serial_code')
            ->maxLength('serial_code', 30)
            ->requirePresence('serial_code', 'create')
            ->allowEmptyString('serial_code', false);

        $validator
            ->scalar('problem')
            ->maxLength('problem', 255)
            ->requirePresence('problem', 'create')
            ->allowEmptyString('problem', false);

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->requirePresence('description', 'create')
            ->allowEmptyString('description', false);

        $validator
            ->scalar('suggestion')
            ->maxLength('suggestion', 255)
            ->allowEmptyString('suggestion');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['client_id'], 'Clients'));

        return $rules;
    }
}
