<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DenunciationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DenunciationsTable Test Case
 */
class DenunciationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DenunciationsTable
     */
    public $Denunciations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Denunciations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Denunciations') ? [] : ['className' => DenunciationsTable::class];
        $this->Denunciations = TableRegistry::getTableLocator()->get('Denunciations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Denunciations);

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
