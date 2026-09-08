<?php
declare(strict_types=1);

namespace BusinessUsers\Test\TestCase\Model\Table;

use BusinessUsers\Model\Table\RolesTable;
use Cake\TestSuite\TestCase;

/**
 * BusinessUsers\Model\Table\RolesTable Test Case
 */
class RolesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \BusinessUsers\Model\Table\RolesTable
     */
    protected $Roles;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.BusinessUsers.Roles',
        'plugin.BusinessUsers.Tenants',
        'plugin.BusinessUsers.GroupRoles',
        'plugin.BusinessUsers.RolePermissions',
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
        $config = $this->getTableLocator()->exists('Roles') ? [] : ['className' => RolesTable::class];
        $this->Roles = $this->getTableLocator()->get('Roles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Roles);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \BusinessUsers\Model\Table\RolesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \BusinessUsers\Model\Table\RolesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
