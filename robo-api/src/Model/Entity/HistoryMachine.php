<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HistoryMachine Entity
 *
 * @property int $id
 * @property int $client_id
 * @property int $company_ id
 * @property string $machine_name
 * @property string $serial_code
 * @property string $problem
 * @property string $description
 * @property string|null $suggestion
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Client $client
 */
class HistoryMachine extends Entity
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
        'client_id' => true,
        'company_ id' => true,
        'machine_name' => true,
        'serial_code' => true,
        'problem' => true,
        'description' => true,
        'suggestion' => true,
        'created' => true,
        'client' => true
    ];
}
