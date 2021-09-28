<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Rating Entity
 *
 * @property int $id
 * @property int $companies_id
 * @property int $service_orders_id
 * @property int|null $clients_id
 * @property int|null $providers_id
 * @property int $stars
 * @property string $type
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\ServiceOrder $service_order
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\Provider $provider
 */
class Rating extends Entity
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
        'companies_id' => true,
        'service_orders_id' => true,
        'clients_id' => true,
        'providers_id' => true,
        'stars' => true,
        'type' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'service_order' => true,
        'client' => true,
        'provider' => true
    ];
}
