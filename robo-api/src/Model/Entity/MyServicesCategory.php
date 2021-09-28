<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MyServicesCategory Entity
 *
 * @property int $id
 * @property string $category_name
 * @property string|null $description
 * @property string $category_icon
 * @property \Cake\I18n\FrozenTime $created
 */
class MyServicesCategory extends Entity
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
        'category_name' => true,
        'description' => true,
        'category_icon' => true,
        'created' => true
    ];
}
