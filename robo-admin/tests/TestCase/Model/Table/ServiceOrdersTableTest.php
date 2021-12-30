<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ServiceOrdersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ServiceOrdersTable Test Case
 */
class ServiceOrdersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ServiceOrdersTable
     */
    public $ServiceOrders;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ServiceOrders',
        'app.Companies',
        'app.Clients',
        'app.Providers',
        'app.Categories',
        'app.Subcategories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ServiceOrders') ? [] : ['className' => ServiceOrdersTable::class];
        $this->ServiceOrders = TableRegistry::getTableLocator()->get('ServiceOrders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ServiceOrders);

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
