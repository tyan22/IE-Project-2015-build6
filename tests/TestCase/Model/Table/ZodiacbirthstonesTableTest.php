<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ZodiacbirthstonesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ZodiacbirthstonesTable Test Case
 */
class ZodiacbirthstonesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Zodiacbirthstones' => 'app.zodiacbirthstones',
        'Customers' => 'app.customers',
        'States' => 'app.states',
        'Titles' => 'app.titles',
        'Anniversaries' => 'app.anniversaries',
        'Anniversarytypes' => 'app.anniversarytypes',
        'Zodiacs' => 'app.zodiacs',
        'Monthbirthstones' => 'app.monthbirthstones'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Zodiacbirthstones') ? [] : ['className' => 'App\Model\Table\ZodiacbirthstonesTable'];        $this->Zodiacbirthstones = TableRegistry::get('Zodiacbirthstones', $config);    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Zodiacbirthstones);

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
