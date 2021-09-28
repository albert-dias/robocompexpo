<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MyServiceOrdersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MyServiceOrdersTable Test Case
 */
class MyServiceOrdersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MyServiceOrdersTable
     */
    public $MyServiceOrders;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MyServiceOrders',
        'app.Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MyServiceOrders') ? [] : ['className' => MyServiceOrdersTable::class];
        $this->MyServiceOrders = TableRegistry::getTableLocator()->get('MyServiceOrders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MyServiceOrders);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
