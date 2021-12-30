<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProvidersImage Entity
 *
 * @property int $id
 * @property int $providers_id
 * @property string|null $image
 * @property string|null $type
 *
 * @property \App\Model\Entity\Provider $provider
 */
class ProvidersImage extends Entity
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
        'providers_id' => true,
        'image' => true,
        'type' => true,
        'provider' => true
    ];
}
