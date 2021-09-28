<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ServiceOrdersImage Entity
 *
 * @property int $id
 * @property string $path
 * @property int $service_orders_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\ServiceOrder $service_order
 */
class ServiceOrdersImage extends Entity
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
        'path' => true,
        'service_orders_id' => true,
        'created' => true,
        'modified' => true,
        'service_order' => true
    ];
}
