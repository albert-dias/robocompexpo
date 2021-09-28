<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Denunciation Entity
 *
 * @property int $id
 * @property int $id_users
 * @property string $title
 * @property string $address
 * @property string $number
 * @property string|null $complement
 * @property string $city
 * @property string $state
 * @property bool $active
 * @property string|null $comment
 */
class Denunciation extends Entity
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
        'id_users' => true,
        'title' => true,
        'address' => true,
        'number' => true,
        'complement' => true,
        'city' => true,
        'state' => true,
        'active' => true,
        'comment' => true
    ];
}
