<?php
declare(strict_types=1);

namespace BusinessUsers\Test\TestCase\Model\Table;

use BusinessUsers\Model\Table\TenantModulesTable;
use Cake\TestSuite\TestCase;

/**
 * BusinessUsers\Model\Table\TenantModulesTable Test Case
 */
class TenantModulesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \BusinessUsers\Model\Table\TenantModulesTable
     */
    protected $TenantModules;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.BusinessUsers.TenantModules',
        'plugin.BusinessUsers.Tenants',
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
        $config = $this->getTableLocator()->exists('TenantModules') ? [] : ['className' => TenantModulesTable::class];
        $this->TenantModules = $this->getTableLocator()->get('TenantModules', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TenantModules);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \BusinessUsers\Model\Table\TenantModulesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \BusinessUsers\Model\Table\TenantModulesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
