<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\ErrorListComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\ErrorListComponent Test Case
 */
class ErrorListComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\ErrorListComponent
     */
    public $ErrorList;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->ErrorList = new ErrorListComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ErrorList);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
