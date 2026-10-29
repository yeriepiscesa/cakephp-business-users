<?php
declare(strict_types=1);

namespace BusinessUsers\Test\TestCase\Model\Table;

use BusinessUsers\Model\Table\StatesTable;
use Cake\TestSuite\TestCase;

/**
 * BusinessUsers\Model\Table\StatesTable Test Case
 */
class StatesTableTest extends TestCase
{
    public function testSearchFiltersByCountry(): void
    {
        $this->assertSame(1, $this->States->find('search', search: ['country_id' => '1'])->count());
        $this->assertSame(0, $this->States->find('search', search: ['country_id' => '2'])->count());
        $this->assertSame(1, $this->States->find('search', search: ['country_id' => ''])->count());
        $this->assertSame(1, $this->States->find('search', search: ['country_id' => ['1', '2']])->count());
        $this->assertSame(0, $this->States->find('search', search: ['country_id' => ['2', '3']])->count());
    }

    public function testSearchIncludesStatesFromMultipleCountries(): void
    {
        $connection = $this->States->getConnection();
        $connection->insert('countries', ['id' => 2, 'iso' => 'US', 'name' => 'United States', 'nicename' => 'United States', 'iso3' => 'USA', 'numcode' => 2, 'phonecode' => 1]);
        $connection->insert('states', ['id' => 2, 'country_id' => 2, 'name' => 'California', 'state_code' => 'CA']);

        $this->assertSame(2, $this->States->find('search', search: ['country_id' => ['1', '2']])->count());
        $this->assertSame(1, $this->States->find('search', search: ['country_id' => ['2']])->count());
    }
    /**
     * Test subject
     *
     * @var \BusinessUsers\Model\Table\StatesTable
     */
    protected $States;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.BusinessUsers.States',
        'plugin.BusinessUsers.Countries',
        'plugin.BusinessUsers.Cities',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('States') ? [] : ['className' => StatesTable::class];
        $this->States = $this->getTableLocator()->get('States', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->States);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \BusinessUsers\Model\Table\StatesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \BusinessUsers\Model\Table\StatesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
