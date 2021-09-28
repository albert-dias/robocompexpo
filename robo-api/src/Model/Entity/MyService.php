<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MyService Entity
 *
 * @property int $id
 * @property string $cpf
 * @property string $service_name
 * @property float $price
 * @property string|null $description
 * @property string|null $photo
 *
 * @property \App\Model\Entity\User $user
 */
class MyService extends Entity
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
        'cpf' => true,
        'service_name' => true,
        'price' => true,
        'description' => true,
        'photo' => true,
        'user' => true
    ];
}
