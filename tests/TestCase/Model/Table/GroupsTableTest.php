<?php
declare(strict_types=1);

namespace BusinessUsers\Test\TestCase\Model\Table;

use BusinessUsers\Model\Table\GroupsTable;
use Cake\TestSuite\TestCase;

/**
 * BusinessUsers\Model\Table\GroupsTable Test Case
 */
class GroupsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \BusinessUsers\Model\Table\GroupsTable
     */
    protected $Groups;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.BusinessUsers.Groups',
        'plugin.BusinessUsers.Tenants',
        'plugin.BusinessUsers.GroupMembers',
        'plugin.BusinessUsers.GroupRoles',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Groups') ? [] : ['className' => GroupsTable::class];
        $this->Groups = $this->getTableLocator()->get('Groups', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Groups);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \BusinessUsers\Model\Table\GroupsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \BusinessUsers\Model\Table\GroupsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
