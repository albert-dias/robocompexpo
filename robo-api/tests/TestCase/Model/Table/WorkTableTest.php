<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WorkTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WorkTable Test Case
 */
class WorkTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WorkTable
     */
    public $Work;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Work'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Work') ? [] : ['className' => WorkTable::class];
        $this->Work = TableRegistry::getTableLocator()->get('Work', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Work);

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
}
