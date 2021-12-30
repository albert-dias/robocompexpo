<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\RatingComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\RatingComponent Test Case
 */
class RatingComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\RatingComponent
     */
    public $Rating;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Rating = new RatingComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Rating);

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
