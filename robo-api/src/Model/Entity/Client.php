<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Client Entity
 *
 * @property int $id
 * @property int $person_id
 * @property string $acting_region
 * @property int $companies_id
 * @property float $balance
 * @property bool $active
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Person $person
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\LogAccountBalance[] $log_account_balance
 */
class Client extends Entity
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
        'person_id' => true,
        'acting_region' => true,
        'companies_id' => true,
        'balance' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'person' => true,
        'company' => true,
        'log_account_balance' => true
    ];
}
