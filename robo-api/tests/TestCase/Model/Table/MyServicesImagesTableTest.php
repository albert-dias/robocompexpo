<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MyServicesImagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MyServicesImagesTable Test Case
 */
class MyServicesImagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MyServicesImagesTable
     */
    public $MyServicesImages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MyServicesImages',
        'app.MyServices'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MyServicesImages') ? [] : ['className' => MyServicesImagesTable::class];
        $this->MyServicesImages = TableRegistry::getTableLocator()->get('MyServicesImages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MyServicesImages);

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
