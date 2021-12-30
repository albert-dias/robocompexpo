<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProvidersImagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProvidersImagesTable Test Case
 */
class ProvidersImagesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProvidersImagesTable
     */
    public $ProvidersImages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ProvidersImages',
        'app.Providers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProvidersImages') ? [] : ['className' => ProvidersImagesTable::class];
        $this->ProvidersImages = TableRegistry::getTableLocator()->get('ProvidersImages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProvidersImages);

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
