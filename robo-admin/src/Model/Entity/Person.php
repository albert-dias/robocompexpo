<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Person Entity
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $cpf
 * @property string $rg
 * @property string|null $institution_rg
 * @property \Cake\I18n\FrozenDate $date_of_birth
 * @property string $email
 * @property string $number_contact
 * @property string $address
 * @property string $number
 * @property string $district
 * @property bool $active
 * @property string $cep
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Provider[] $providers
 * @property \App\Model\Entity\User[] $users
 */
class Person extends Entity
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
    // protected $_accessible = [
    //     'company_id' => true,
    //     'name' => true,
    //     'cpf' => true,
    //     'rg' => true,
    //     'institution_rg' => true,
    //     'date_of_birth' => true,
    //     'email' => true,
    //     'number_contact' => true,
    //     'address' => true,
    //     'number' => true,
    //     'district' => true,
    //     'active' => true,
    //     'cep' => true,
    //     'created' => true,
    //     'modified' => true,
    //     'company' => true,
    //     'providers' => true,
    //     'users' => true
    // ];

    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
