<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Company Entity
 *
 * @property int $id
 * @property string $name
 * @property int $number_users
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool $active
 * @property string $image
 * @property int $resale_plans_id
 *
 * @property \App\Model\Entity\ResalePlan $resale_plan
 * @property \App\Model\Entity\ModulesHasCompany[] $modules_has_companies
 */
class Company extends Entity
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
//    protected $_accessible = [
//        'name' => true,
//        'number_users' => true,
//        'created' => true,
//        'modified' => true,
//        'active' => true,
//        'image' => true,
//        'resale_plans_id' => true,
//        'resale_plan' => true,
//        'modules_has_companies' => true
//    ];
        protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
