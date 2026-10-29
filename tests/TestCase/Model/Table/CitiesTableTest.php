<?php
declare(strict_types=1);

namespace BusinessUsers\Test\TestCase\Model\Table;

use BusinessUsers\Model\Table\CitiesTable;
use Cake\TestSuite\TestCase;

/**
 * BusinessUsers\Model\Table\CitiesTable Test Case
 */
class CitiesTableTest extends TestCase
{
    public function testSearchFiltersByStateAndCountry(): void
    {
        $find = fn(array $filters) => $this->Cities->find('search', search: $filters)->count();

        $this->assertSame(1, $find(['state_id' => '1', 'country_id' => '1']));
        $this->assertSame(0, $find(['state_id' => '2']));
        $this->assertSame(0, $find(['country_id' => '2']));
        $this->assertSame(0, $find(['state_id' => '1', 'country_id' => '2']));
        $this->assertSame(1, $find(['state_id' => '', 'country_id' => '']));
        $this->assertSame(1, $find(['state_id' => ['1', '2'], 'country_id' => ['1', '2']]));
        $this->assertSame(0, $find(['state_id' => ['2', '3']]));
        $this->assertSame(0, $find(['country_id' => ['2', '3']]));
        $this->assertSame(0, $find(['state_id' => ['1', '2'], 'country_id' => ['2', '3']]));
    }

    public function testSearchIncludesCitiesFromMultipleCountriesAndStates(): void
    {
        $connection = $this->Cities->getConnection();
        $connection->insert('countries', ['id' => 2, 'iso' => 'US', 'name' => 'United States', 'nicename' => 'United States', 'iso3' => 'USA', 'numcode' => 2, 'phonecode' => 1]);
        $connection->insert('states', ['id' => 2, 'country_id' => 2, 'name' => 'California', 'state_code' => 'CA']);
        $connection->insert('cities', ['id' => 2, 'state_id' => 2, 'name' => 'Los Angeles']);

        $this->assertSame(2, $this->Cities->find('search', search: ['state_id' => ['1', '2'], 'country_id' => ['1', '2']])->count());
        $this->assertSame(1, $this->Cities->find('search', search: ['state_id' => ['1', '2'], 'country_id' => ['2']])->count());
    }
    /**
     * Test subject
     *
     * @var \BusinessUsers\Model\Table\CitiesTable
     */
    protected $Cities;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.BusinessUsers.Cities',
        'plugin.BusinessUsers.States',
        'plugin.BusinessUsers.Countries',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Cities') ? [] : ['className' => CitiesTable::class];
        $this->Cities = $this->getTableLocator()->get('Cities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Cities);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \BusinessUsers\Model\Table\CitiesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \BusinessUsers\Model\Table\CitiesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
