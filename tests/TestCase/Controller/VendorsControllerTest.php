<?php
namespace App\Test\TestCase\Controller;

use App\Controller\VendorsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\VendorsController Test Case
 */
class VendorsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Vendors' => 'app.vendors',
        'States' => 'app.states',
        'Customers' => 'app.customers',
        'Titles' => 'app.titles',
        'Anniversaries' => 'app.anniversaries',
        'Anniversarytypes' => 'app.anniversarytypes',
        'Orders' => 'app.orders',
        'PaymentTypes' => 'app.payment_types',
        'Zodiacs' => 'app.zodiacs',
        'Monthbirthstones' => 'app.monthbirthstones',
        'Zodiacbirthstones' => 'app.zodiacbirthstones'
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
