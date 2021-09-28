<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Budget Entity
 *
 * @property int $id
 * @property int $service_orders_id
 * @property int $providers_id
 * @property float $value
 * @property \Cake\I18n\FrozenTime $date_suggestion
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\ServiceOrder $service_order
 * @property \App\Model\Entity\Provider $provider
 */
class Budget extends Entity
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
        'service_orders_id' => true,
        'providers_id' => true,
        'value' => true,
        'date_suggestion' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'service_order' => true,
        'provider' => true
    ];
}
