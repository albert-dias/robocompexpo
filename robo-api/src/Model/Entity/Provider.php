<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Provider Entity
 *
 * @property int $id
 * @property int $companies_id
 * @property int $person_id
 * @property int|null $category_id
 * @property int|null $subcategory_id
 * @property string $acting_region
 * @property bool $active
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Person $person
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Subcategory $subcategory
 */
class Provider extends Entity
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
        'person_id' => true,
        'category_id' => true,
        'subcategory_id' => true,
        'acting_region' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'person' => true,
        'category' => true,
        'subcategory' => true
    ];
}
