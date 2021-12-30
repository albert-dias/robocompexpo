<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity
 *
 * @property int $id
 * @property int $service_orders_id
 * @property float $value
 * @property string $transaction_number
 * @property \Cake\I18n\FrozenTime $date_pay
 * @property string $type_payment
 * @property float $providers_value
 * @property bool $providers_transfer
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\ServiceOrde $service_orde
 */
class Payment extends Entity
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
        'value' => true,
        'transaction_number' => true,
        'date_pay' => true,
        'type_payment' => true,
        'providers_value' => true,
        'providers_transfer' => true,
        'created' => true,
        'modified' => true,
        'service_orde' => true
    ];
}
