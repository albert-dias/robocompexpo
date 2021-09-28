<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DenunciationsImage Model
 *
 * @method \App\Model\Entity\DenunciationsImage get($primaryKey, $options = [])
 * @method \App\Model\Entity\DenunciationsImage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DenunciationsImage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DenunciationsImage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DenunciationsImage|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DenunciationsImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DenunciationsImage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DenunciationsImage findOrCreate($search, callable $callback = null, $options = [])
 */
class DenunciationsImageTable extends Table
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

        $this->setTable('denunciations_image');
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
            ->integer('id_denunciations')
            ->requirePresence('id_denunciations', 'create')
            ->allowEmptyString('id_denunciations', false);

        $validator
            ->scalar('image')
            ->maxLength('image', 255)
            ->requirePresence('image', 'create')
            ->allowEmptyFile('image', false);

        return $validator;
    }
}
