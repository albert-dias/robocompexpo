<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HistoryMachineTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HistoryMachineTable Test Case
 */
class HistoryMachineTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\HistoryMachineTable
     */
    public $HistoryMachine;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.HistoryMachine',
        'app.Clients'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('HistoryMachine') ? [] : ['className' => HistoryMachineTable::class];
        $this->HistoryMachine = TableRegistry::getTableLocator()->get('HistoryMachine', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->HistoryMachine);

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
