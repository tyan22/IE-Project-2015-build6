<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PaymentstatusesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PaymentstatusesTable Test Case
 */
class PaymentstatusesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Paymentstatuses' => 'app.paymentstatuses',
        'Orders' => 'app.orders',
        'Customers' => 'app.customers',
        'States' => 'app.states',
        'Titles' => 'app.titles',
        'Anniversaries' => 'app.anniversaries',
        'Anniversarytypes' => 'app.anniversarytypes',
        'Zodiacs' => 'app.zodiacs',
        'Monthbirthstones' => 'app.monthbirthstones',
        'Zodiacbirthstones' => 'app.zodiacbirthstones',
        'Vendors' => 'app.vendors',
        'PaymentTypes' => 'app.payment_types',
        'Payments' => 'app.payments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Paymentstatuses') ? [] : ['className' => 'App\Model\Table\PaymentstatusesTable'];        $this->Paymentstatuses = TableRegistry::get('Paymentstatuses', $config);    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Paymentstatuses);

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
