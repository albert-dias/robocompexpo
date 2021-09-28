<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Worktime Entity
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $opcao
 * @property string|null $active
 * @property string|null $start_time
 * @property string|null $finish_time
 *
 * @property \App\Model\Entity\Company $company
 */
class Worktime extends Entity
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
        'opcao' => true,
        'active' => true,
        'start_time' => true,
        'finish_time' => true,
        'company' => true
    ];
}
