<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailsLogTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailsLogTable Test Case
 */
class EmailsLogTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailsLogTable
     */
    public $EmailsLog;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EmailsLog'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EmailsLog') ? [] : ['className' => EmailsLogTable::class];
        $this->EmailsLog = TableRegistry::getTableLocator()->get('EmailsLog', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailsLog);

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
