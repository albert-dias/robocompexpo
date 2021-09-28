<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClientsImagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClientsImagesTable Test Case
 */
class ClientsImagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ClientsImagesTable
     */
    public $ClientsImages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ClientsImages',
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
        $config = TableRegistry::getTableLocator()->exists('ClientsImages') ? [] : ['className' => ClientsImagesTable::class];
        $this->ClientsImages = TableRegistry::getTableLocator()->get('ClientsImages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ClientsImages);

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
