<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MyServiceOrder Entity
 *
 * @property int $id
 * @property int $users_id
 * @property string $service_name
 * @property float $price
 * @property string $description
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\User $user
 */
class MyServiceOrder extends Entity
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
        'id' => true,
        'users_id' => true,
        'service_name' => true,
        'price' => true,
        'description' => true,
        'created' => true,
        'user' => true
    ];
}
