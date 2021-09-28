<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ServiceOrdersImages Model
 *
 * @property \App\Model\Table\ServiceOrdersTable|\Cake\ORM\Association\BelongsTo $ServiceOrders
 *
 * @method \App\Model\Entity\ServiceOrdersImage get($primaryKey, $options = [])
 * @method \App\Model\Entity\ServiceOrdersImage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ServiceOrdersImage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ServiceOrdersImage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ServiceOrdersImage|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ServiceOrdersImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ServiceOrdersImage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ServiceOrdersImage findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CollectionOrdersImagesTable extends Table
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

        $this->setTable('collection_orders_images');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('CollectionOrders', [
            'foreignKey' => 'collection_orders_id',
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
            ->allowEmptyString('path', false)
            ->add('path', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['path']));
        $rules->add($rules->existsIn(['collection_orders_id'], 'CollectionOrders'));

        return $rules;
    }
}
