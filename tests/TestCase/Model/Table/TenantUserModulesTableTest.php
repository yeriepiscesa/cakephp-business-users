<?php
declare(strict_types=1);

namespace BusinessUsers\Test\TestCase\Model\Table;

use BusinessUsers\Model\Table\TenantUserModulesTable;
use Cake\TestSuite\TestCase;

/**
 * BusinessUsers\Model\Table\TenantUserModulesTable Test Case
 */
class TenantUserModulesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \BusinessUsers\Model\Table\TenantUserModulesTable
     */
    protected $TenantUserModules;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.BusinessUsers.TenantUserModules',
        'plugin.BusinessUsers.TenantUsers',
        'plugin.BusinessUsers.Modules',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TenantUserModules') ? [] : ['className' => TenantUserModulesTable::class];
        $this->TenantUserModules = $this->getTableLocator()->get('TenantUserModules', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TenantUserModules);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \BusinessUsers\Model\Table\TenantUserModulesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \BusinessUsers\Model\Table\TenantUserModulesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
