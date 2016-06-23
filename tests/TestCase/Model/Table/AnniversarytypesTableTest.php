<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AnniversarytypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AnniversarytypesTable Test Case
 */
class AnniversarytypesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Anniversarytypes' => 'app.anniversarytypes',
        'Anniversaries' => 'app.anniversaries',
        'Customers' => 'app.customers',
        'States' => 'app.states',
        'CustomersAnniversaries' => 'app.customers_anniversaries'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Anniversarytypes') ? [] : ['className' => 'App\Model\Table\AnniversarytypesTable'];
        $this->Anniversarytypes = TableRegistry::get('Anniversarytypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Anniversarytypes);

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
