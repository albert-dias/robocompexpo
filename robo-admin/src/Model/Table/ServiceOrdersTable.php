<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ServiceOrders Model
 *
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\ClientsTable&\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\ProvidersTable&\Cake\ORM\Association\BelongsTo $Providers
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\SubcategoriesTable&\Cake\ORM\Association\BelongsTo $Subcategories
 *
 * @method \App\Model\Entity\ServiceOrder get($primaryKey, $options = [])
 * @method \App\Model\Entity\ServiceOrder newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ServiceOrder[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ServiceOrder|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ServiceOrder saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ServiceOrder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ServiceOrder[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ServiceOrder findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ServiceOrdersTable extends Table
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

        $this->setTable('service_orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Companies', [
            'foreignKey' => 'companies_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Clients', [
            'foreignKey' => 'clients_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Providers', [
            'foreignKey' => 'providers_id',
            'joinType' => 'INNER'
        ]);
       
        $this->belongsTo('ProvidersLeft', [
            'className'  => 'Providers',
            'foreignKey' => 'providers_id',
            'joinType' => 'LEFT'
        ]);
        
        $this->hasMany('ServiceOrdersImages', [
            'foreignKey' => 'service_orders_id',
        ]);
        
        $this->belongsTo('Categories', [
            'foreignKey' => 'categories_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Subcategories', [
            'foreignKey' => 'subcategories_id',
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->dateTime('date_service_ordes')
            ->requirePresence('date_service_ordes', 'create')
            ->notEmptyDateTime('date_service_ordes');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->numeric('value_initial')
            ->requirePresence('value_initial', 'create')
            ->notEmptyString('value_initial');

        $validator
            ->scalar('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->boolean('pay')
            ->notEmptyString('pay');

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
        $rules->add($rules->existsIn(['companies_id'], 'Companies'));
        $rules->add($rules->existsIn(['clients_id'], 'Clients'));
        $rules->add($rules->existsIn(['providers_id'], 'Providers'));
        $rules->add($rules->existsIn(['categories_id'], 'Categories'));
        $rules->add($rules->existsIn(['subcategories_id'], 'Subcategories'));

        return $rules;
    }
}
