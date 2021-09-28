<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MyServicesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MyServicesTable Test Case
 */
class MyServicesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MyServicesTable
     */
    public $MyServices;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.MyServices',
        'app.Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MyServices') ? [] : ['className' => MyServicesTable::class];
        $this->MyServices = TableRegistry::getTableLocator()->get('MyServices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MyServices);

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
}
