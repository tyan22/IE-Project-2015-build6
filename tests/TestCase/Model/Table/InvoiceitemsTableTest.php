<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InvoiceitemsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InvoiceitemsTable Test Case
 */
class InvoiceitemsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.invoiceitems',
        'app.invoices',
        'app.orders',
        'app.customers',
        'app.states',
        'app.vendors',
        'app.titles',
        'app.anniversaries',
        'app.anniversarytypes',
        'app.monthbirthstones',
        'app.zodiacbirthstones',
        'app.orderstatuses',
        'app.paymentstatuses',
        'app.payments',
        'app.paymenttypes',
        'app.stashes',
        'app.messages'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Invoiceitems') ? [] : ['className' => 'App\Model\Table\InvoiceitemsTable'];
        $this->Invoiceitems = TableRegistry::get('Invoiceitems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Invoiceitems);

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
