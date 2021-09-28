<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ServiceOrdersFixture
 *
 */
class ServiceOrdersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'companies_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'clients_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'providers_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'categories_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'subcategories_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'date_service_ordes' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'description' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '', 'precision' => null],
        'value_initial' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'status' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '', 'precision' => null, 'fixed' => null],
        'pay' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'companies_id' => ['type' => 'index', 'columns' => ['companies_id'], 'length' => []],
            'clients_id' => ['type' => 'index', 'columns' => ['clients_id'], 'length' => []],
            'providers_id' => ['type' => 'index', 'columns' => ['providers_id'], 'length' => []],
            'categories_id' => ['type' => 'index', 'columns' => ['categories_id'], 'length' => []],
            'subcategories_id' => ['type' => 'index', 'columns' => ['subcategories_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'service_orders_ibfk_1' => ['type' => 'foreign', 'columns' => ['companies_id'], 'references' => ['companies', 'id'], 'update' => 'noAction', 'delete' => 'restrict', 'length' => []],
            'service_orders_ibfk_2' => ['type' => 'foreign', 'columns' => ['categories_id'], 'references' => ['categories', 'id'], 'update' => 'noAction', 'delete' => 'restrict', 'length' => []],
            'service_orders_ibfk_3' => ['type' => 'foreign', 'columns' => ['clients_id'], 'references' => ['clients', 'id'], 'update' => 'noAction', 'delete' => 'restrict', 'length' => []],
            'service_orders_ibfk_4' => ['type' => 'foreign', 'columns' => ['subcategories_id'], 'references' => ['subcategories', 'id'], 'update' => 'noAction', 'delete' => 'restrict', 'length' => []],
            'service_orders_ibfk_5' => ['type' => 'foreign', 'columns' => ['providers_id'], 'references' => ['providers', 'id'], 'update' => 'noAction', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_bin'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'companies_id' => 1,
                'clients_id' => 1,
                'providers_id' => 1,
                'categories_id' => 1,
                'subcategories_id' => 1,
                'date_service_ordes' => '2019-11-13 09:35:39',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'value_initial' => 1,
                'status' => 'Lorem ipsum dolor sit amet',
                'pay' => 1,
                'created' => '2019-11-13 09:35:39',
                'modified' => '2019-11-13 09:35:39'
            ],
        ];
        parent::init();
    }
}
