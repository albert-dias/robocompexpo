<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Lead Entity
 *
 * @property int $id
 * @property int $companies_id
 * @property string $origin
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property array $others_data
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Company $company
 */
class Lead extends Entity
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
        'origin' => true,
        'name' => true,
        'email' => true,
        'phone' => true,
        'others_data' => true,
        'created' => true,
        'modified' => true,
        'company' => true
    ];
}
