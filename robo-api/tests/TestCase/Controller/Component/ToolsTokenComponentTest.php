<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\ToolsTokenComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\ToolsTokenComponent Test Case
 */
class ToolsTokenComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\ToolsTokenComponent
     */
    public $ToolsToken;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->ToolsToken = new ToolsTokenComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ToolsToken);

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
