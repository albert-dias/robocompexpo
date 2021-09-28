<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\S3ToolsComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\S3ToolsComponent Test Case
 */
class S3ToolsComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\S3ToolsComponent
     */
    public $S3Tools;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->S3Tools = new S3ToolsComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->S3Tools);

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
