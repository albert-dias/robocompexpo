<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MyServicesCategories Model
 *
 * @method \App\Model\Entity\MyServicesCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\MyServicesCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MyServicesCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MyServicesCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MyServicesCategory|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MyServicesCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MyServicesCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MyServicesCategory findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MyServicesCategoriesTable extends Table
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

        $this->setTable('my_services_categories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('category_name')
            ->maxLength('category_name', 100)
            ->requirePresence('category_name', 'create')
            ->allowEmptyString('category_name', false);

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('category_icon')
            ->maxLength('category_icon', 200)
            ->requirePresence('category_icon', 'create')
            ->allowEmptyString('category_icon', false);

        return $validator;
    }
}
