<?php
namespace App\Model\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $person_id
 * @property int|null $users_types_id
 * @property bool $active
 * @property string|null $image
 * @property string|null $image_dir
 * @property string|null $photo
 * @property string $name
 * @property string $email
 * @property string $password
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Person $person
 * @property \App\Model\Entity\UsersType $users_type
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'id'=> true,
        'company_id' => true,
        'users_types_id' => true,
        'person_id' => true,
        'active' => true,
        'image' => true,
        'image_dir' => true,
        'photo' => true,
        'name' => true,
        'email' => true,
        'password' => true,
        'created' => true,
        'modified' => true,
        'nickname'=>true,
        'plan_id'=>true,
        'num_rating'=>true,
        'tot_rating'=>true
    ];
    
    protected function _setPassword($password) {
        return (new DefaultPasswordHasher)->hash($password);
    }

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
