<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GatwaysTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GatwaysTable Test Case
 */
class GatwaysTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GatwaysTable
     */
    public $Gatways;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Gatways'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Gatways') ? [] : ['className' => GatwaysTable::class];
        $this->Gatways = TableRegistry::getTableLocator()->get('Gatways', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Gatways);

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
