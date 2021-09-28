<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BudgetsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BudgetsTable Test Case
 */
class BudgetsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BudgetsTable
     */
    public $Budgets;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Budgets',
        'app.ServiceOrders',
        'app.Providers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Budgets') ? [] : ['className' => BudgetsTable::class];
        $this->Budgets = TableRegistry::getTableLocator()->get('Budgets', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Budgets);

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
