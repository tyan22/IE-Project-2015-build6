<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StashesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StashesTable Test Case
 */
class StashesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Stashes' => 'app.stashes',
        'Orders' => 'app.orders',
        'Customers' => 'app.customers',
        'States' => 'app.states',
        'Vendors' => 'app.vendors',
        'Titles' => 'app.titles',
        'Anniversaries' => 'app.anniversaries',
        'Anniversarytypes' => 'app.anniversarytypes',
        'Monthbirthstones' => 'app.monthbirthstones',
        'Zodiacbirthstones' => 'app.zodiacbirthstones',
        'Orderstatuses' => 'app.orderstatuses',
        'Paymentstatuses' => 'app.paymentstatuses',
        'Payments' => 'app.payments',
        'Paymenttypes' => 'app.paymenttypes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Stashes') ? [] : ['className' => 'App\Model\Table\StashesTable'];        $this->Stashes = TableRegistry::get('Stashes', $config);    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Stashes);

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
