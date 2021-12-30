<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UsersTypesHasModules Model
 *
 * @property \App\Model\Table\UsersTypesTable|\Cake\ORM\Association\BelongsTo $UsersTypes
 * @property \App\Model\Table\ModulesTable|\Cake\ORM\Association\BelongsTo $Modules
 *
 * @method \App\Model\Entity\UsersTypesHasModule get($primaryKey, $options = [])
 * @method \App\Model\Entity\UsersTypesHasModule newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UsersTypesHasModule[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UsersTypesHasModule|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UsersTypesHasModule|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UsersTypesHasModule patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UsersTypesHasModule[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UsersTypesHasModule findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTypesHasModulesTable extends Table
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

        $this->setTable('users_types_has_modules');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('UsersTypes', [
            'foreignKey' => 'users_types_id'
        ]);
        $this->belongsTo('Modules', [
            'foreignKey' => 'modules_id'
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
        $rules->add($rules->existsIn(['users_types_id'], 'UsersTypes'));
        $rules->add($rules->existsIn(['modules_id'], 'Modules'));

        return $rules;
    }
}
