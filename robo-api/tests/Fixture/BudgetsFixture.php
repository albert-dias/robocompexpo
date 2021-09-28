<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BudgetsFixture
 *
 */
class BudgetsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'service_orders_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'providers_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'value' => ['type' => 'decimal', 'length' => 15, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'date_suggestion' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'status' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'service_orders_id' => ['type' => 'index', 'columns' => ['service_orders_id'], 'length' => []],
            'providers_id' => ['type' => 'index', 'columns' => ['providers_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'service_orders_id_2' => ['type' => 'unique', 'columns' => ['service_orders_id', 'providers_id'], 'length' => []],
            'budgets_ibfk_1' => ['type' => 'foreign', 'columns' => ['service_orders_id'], 'references' => ['service_orders', 'id'], 'update' => 'noAction', 'delete' => 'restrict', 'length' => []],
            'budgets_ibfk_2' => ['type' => 'foreign', 'columns' => ['providers_id'], 'references' => ['providers', 'id'], 'update' => 'noAction', 'delete' => 'restrict', 'length' => []],
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
                'service_orders_id' => 1,
                'providers_id' => 1,
                'value' => 1.5,
                'date_suggestion' => '2019-11-20 09:57:56',
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2019-11-20 09:57:56',
                'modified' => '2019-11-20 09:57:56'
            ],
        ];
        parent::init();
    }
}
