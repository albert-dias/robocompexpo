<?php
namespace App\Model\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property int $company_id
 * @property bool $active
 * @property string $image
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $users_types_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\UsersType $users_type
 * @property \App\Model\Entity\VwUsersModule[] $vw_users_modules
 */
class Developer extends Entity
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
        'company_id' => true,
        'active' => true,
        'image' => true,
        'name' => true,
        'email' => true,
        'password' => true,
        'users_types_id' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'users_type' => true,
        'vw_users_modules' => true
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
