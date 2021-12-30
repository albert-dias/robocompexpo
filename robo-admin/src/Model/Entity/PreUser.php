<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PreUser Entity
 *
 * @property int $id
 * @property int $company_id
 * @property int $users_type_id
 * @property int $people_id
 * @property string $email
 * @property bool $used
 * @property string $type_action
 * @property string $hash
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\UsersType $users_type
 */
class PreUser extends Entity
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
        'users_type_id' => true,
        'people_id' => true,
        'email' => true,
        'used' => true,
        'type_action' => true,
        'hash' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'users_type' => true
    ];
}
