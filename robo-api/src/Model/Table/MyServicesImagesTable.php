<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MyServicesImages Model
 *
 * @property \App\Model\Table\MyServicesTable|\Cake\ORM\Association\BelongsTo $MyServices
 *
 * @method \App\Model\Entity\MyServicesImage get($primaryKey, $options = [])
 * @method \App\Model\Entity\MyServicesImage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MyServicesImage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MyServicesImage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MyServicesImage|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MyServicesImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MyServicesImage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MyServicesImage findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MyServicesImagesTable extends Table
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

        $this->setTable('my_services_images');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('MyServices', [
            'foreignKey' => 'my_services_id',
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
            ->scalar('path')
            ->maxLength('path', 200)
            ->requirePresence('path', 'create')
            ->allowEmptyString('path', false);

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
        $rules->add($rules->existsIn(['my_services_id'], 'MyServices'));

        return $rules;
    }
}
