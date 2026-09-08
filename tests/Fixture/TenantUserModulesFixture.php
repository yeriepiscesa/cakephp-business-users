<?php
declare(strict_types=1);

namespace BusinessUsers\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TenantUserModulesFixture
 */
class TenantUserModulesFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'business_users_tenant_user_modules';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'created' => '2026-05-14 04:50:39',
                'created_by' => '0c3614c1-234e-4e09-8944-6089bb076ae8',
                'modified' => '2026-05-14 04:50:39',
                'modified_by' => '3d740bf5-d76c-497a-bfb6-441bf221ba8e',
                'business_users_tenant_user_id' => 1,
                'business_users_module_id' => 1,
                'is_granted' => 1,
            ],
        ];
        parent::init();
    }
}
