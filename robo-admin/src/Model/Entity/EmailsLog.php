<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailsLog Entity
 *
 * @property int $id
 * @property string $email
 * @property array $send
 * @property array $received
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class EmailsLog extends Entity
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
        'email' => true,
        'send' => true,
        'received' => true,
        'created' => true,
        'modified' => true
    ];
}
