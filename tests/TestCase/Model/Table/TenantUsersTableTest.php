<?php
declare(strict_types=1);

namespace BusinessUsers\Test\TestCase\Model\Table;

use BusinessUsers\Model\Table\TenantUsersTable;
use Cake\TestSuite\TestCase;

/**
 * BusinessUsers\Model\Table\TenantUsersTable Test Case
 */
class TenantUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \BusinessUsers\Model\Table\TenantUsersTable
     */
    protected $TenantUsers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.BusinessUsers.TenantUsers',
        'plugin.BusinessUsers.Tenants',
        'plugin.BusinessUsers.Users',
        'plugin.BusinessUsers.GroupMembers',
        'plugin.BusinessUsers.TenantUserModules',
        'plugin.BusinessUsers.TenantUserPermissions',
        'plugin.BusinessUsers.TenantUserRoles',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TenantUsers') ? [] : ['className' => TenantUsersTable::class];
        $this->TenantUsers = $this->getTableLocator()->get('TenantUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TenantUsers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \BusinessUsers\Model\Table\TenantUsersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \BusinessUsers\Model\Table\TenantUsersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
