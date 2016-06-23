<?php
namespace App\Test\TestCase\Controller;

use App\Controller\PaymentstatusesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\PaymentstatusesController Test Case
 */
class PaymentstatusesControllerTest extends IntegrationTestCase
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
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
