<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Subcategory Entity
 *
 * @property int $id
 * @property int $company_id
 * @property int $category_id
 * @property string $name
 * @property bool|null $active
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Category $category
 */
class Subcategory extends Entity
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
        'company_id' => true,
        'category_id' => true,
        'name' => true,
        'margin' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'category' => true
    ];
}
