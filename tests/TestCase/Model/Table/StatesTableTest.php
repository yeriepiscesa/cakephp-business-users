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
