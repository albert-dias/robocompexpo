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
class UsersCategoriesTable extends Table
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

        $this->setTable('users_categories');
        $this->setPrimaryKey('id');

        // $this->addBehavior('Timestamp');

        $this->belongsTo('Categories', [
            'foreignKey' => 'categorie_id',
            'joinType' => 'INNER'

        ]);

        
    }

 

}
