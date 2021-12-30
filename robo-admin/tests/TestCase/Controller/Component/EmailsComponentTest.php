<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\EmailsComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\EmailsComponent Test Case
 */
class EmailsComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\EmailsComponent
     */
    public $Emails;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Emails = new EmailsComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Emails);

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
