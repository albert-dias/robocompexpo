<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DenunciationsImageTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DenunciationsImageTable Test Case
 */
class DenunciationsImageTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DenunciationsImageTable
     */
    public $DenunciationsImage;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DenunciationsImage'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DenunciationsImage') ? [] : ['className' => DenunciationsImageTable::class];
        $this->DenunciationsImage = TableRegistry::getTableLocator()->get('DenunciationsImage', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DenunciationsImage);

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
