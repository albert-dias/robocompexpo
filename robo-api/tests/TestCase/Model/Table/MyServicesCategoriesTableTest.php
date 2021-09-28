<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MyServicesCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MyServicesCategoriesTable Test Case
 */
class MyServicesCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MyServicesCategoriesTable
     */
    public $MyServicesCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MyServicesCategories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MyServicesCategories') ? [] : ['className' => MyServicesCategoriesTable::class];
        $this->MyServicesCategories = TableRegistry::getTableLocator()->get('MyServicesCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MyServicesCategories);

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
