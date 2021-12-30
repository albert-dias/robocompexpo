<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ServiceOrder Entity
 *
 * @property int $id
 * @property int $companies_id
 * @property int $clients_id
 * @property int $providers_id
 * @property int $categories_id
 * @property int $subcategories_id
 * @property \Cake\I18n\FrozenTime $date_service_ordes
 * @property string $description
 * @property float $value_initial
 * @property string $status
 * @property bool $pay
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\Provider $provider
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Subcategory $subcategory
 */
class ServiceOrder extends Entity
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
        'clients_id' => true,
        'providers_id' => true,
        'categories_id' => true,
        'subcategories_id' => true,
        'date_service_ordes' => true,
        'description' => true,
        'value_initial' => true,
        'status' => true,
        'pay' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'client' => true,
        'provider' => true,
        'category' => true,
        'subcategory' => true
    ];
}
