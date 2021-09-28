<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShoppingCartTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShoppingCartTable Test Case
 */
class ShoppingCartTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ShoppingCartTable
     */
    public $ShoppingCart;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ShoppingCart',
        'app.Clients',
        'app.Services'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ShoppingCart') ? [] : ['className' => ShoppingCartTable::class];
        $this->ShoppingCart = TableRegistry::getTableLocator()->get('ShoppingCart', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShoppingCart);

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
