<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PreUsers Model
 *
 * @property \App\Model\Table\CompaniesTable|\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\UsersTypesTable|\Cake\ORM\Association\BelongsTo $UsersTypes
 * @property |\Cake\ORM\Association\BelongsTo $People
 *
 * @method \App\Model\Entity\PreUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\PreUser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PreUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PreUser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PreUser|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PreUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PreUser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PreUser findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PreUsersTable extends Table
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

        $this->setTable('pre_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('UsersTypes', [
            'foreignKey' => 'users_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('People', [
            'foreignKey' => 'people_id'
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
            ->allowEmpty('id', 'create');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->boolean('used')
            ->requirePresence('used', 'create')
            ->notEmpty('used');

        $validator
            ->scalar('type_action')
            ->requirePresence('type_action', 'create')
            ->notEmpty('type_action');

        $validator
            ->scalar('hash')
            ->maxLength('hash', 64)
            ->requirePresence('hash', 'create')
            ->notEmpty('hash');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['company_id'], 'Companies'));
        $rules->add($rules->existsIn(['users_type_id'], 'UsersTypes'));
        $rules->add($rules->existsIn(['people_id'], 'People'));

        return $rules;
    }
}
