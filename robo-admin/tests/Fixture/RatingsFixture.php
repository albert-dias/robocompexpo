<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RatingsFixture
 */
class RatingsFixture extends TestFixture
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
        'service_orders_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'clients_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'providers_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'stars' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'type' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'companies_id' => ['type' => 'index', 'columns' => ['companies_id'], 'length' => []],
            'service_orders_id' => ['type' => 'index', 'columns' => ['service_orders_id'], 'length' => []],
            'clients_id' => ['type' => 'index', 'columns' => ['clients_id'], 'length' => []],
            'providers_id' => ['type' => 'index', 'columns' => ['providers_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'ratings_ibfk_1' => ['type' => 'foreign', 'columns' => ['companies_id'], 'references' => ['companies', 'id'], 'update' => 'noAction', 'delete' => 'cascade', 'length' => []],
            'ratings_ibfk_2' => ['type' => 'foreign', 'columns' => ['providers_id'], 'references' => ['providers', 'id'], 'update' => 'noAction', 'delete' => 'restrict', 'length' => []],
            'ratings_ibfk_3' => ['type' => 'foreign', 'columns' => ['clients_id'], 'references' => ['clients', 'id'], 'update' => 'noAction', 'delete' => 'restrict', 'length' => []],
            'ratings_ibfk_4' => ['type' => 'foreign', 'columns' => ['service_orders_id'], 'references' => ['service_orders', 'id'], 'update' => 'noAction', 'delete' => 'restrict', 'length' => []],
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
                'service_orders_id' => 1,
                'clients_id' => 1,
                'providers_id' => 1,
                'stars' => 1,
                'type' => 'Lorem ipsum dolor sit amet',
                'created' => '2019-11-02 08:30:22',
                'modified' => '2019-11-02 08:30:22'
            ],
        ];
        parent::init();
    }
}
