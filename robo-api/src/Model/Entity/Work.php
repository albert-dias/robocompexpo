<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Work Entity
 *
 * @property int $id
 * @property int $code_tec
 * @property bool $accepted
 * @property int $code_work
 * @property int $day
 * @property int $month
 * @property int $year
 * @property int $hour
 * @property int $time
 */
class Work extends Entity
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
        'code_tec' => true,
        'accepted' => true,
        'code_work' => true,
        'day' => true,
        'month' => true,
        'year' => true,
        'hour' => true,
        'time' => true
    ];
}
