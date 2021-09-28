<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MyServicesImage Entity
 *
 * @property int $id
 * @property int $my_services_id
 * @property string $path
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\MyService $my_service
 */
class MyServicesImage extends Entity
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
        'my_services_id' => true,
        'path' => true,
        'created' => true,
        'my_service' => true
    ];
}
