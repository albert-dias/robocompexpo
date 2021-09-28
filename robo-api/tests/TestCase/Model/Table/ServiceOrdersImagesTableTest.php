<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ServiceOrdersImagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ServiceOrdersImagesTable Test Case
 */
class ServiceOrdersImagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ServiceOrdersImagesTable
     */
    public $ServiceOrdersImages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ServiceOrdersImages',
        'app.ServiceOrders'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ServiceOrdersImages') ? [] : ['className' => ServiceOrdersImagesTable::class];
        $this->ServiceOrdersImages = TableRegistry::getTableLocator()->get('ServiceOrdersImages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ServiceOrdersImages);

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
