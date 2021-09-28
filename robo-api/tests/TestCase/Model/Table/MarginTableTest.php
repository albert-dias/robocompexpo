<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MarginTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MarginTable Test Case
 */
class MarginTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MarginTable
     */
    public $Margin;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Margin'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Margin') ? [] : ['className' => MarginTable::class];
        $this->Margin = TableRegistry::getTableLocator()->get('Margin', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Margin);

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
