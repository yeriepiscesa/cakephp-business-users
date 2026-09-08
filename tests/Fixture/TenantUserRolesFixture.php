<?php
declare(strict_types=1);

namespace BusinessUsers\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TenantUserRolesFixture
 */
class TenantUserRolesFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'business_users_tenant_user_roles';
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
                'created_by' => 'f415e491-ba29-4302-affb-de36bf7cb8c6',
                'modified' => '2026-05-14 04:50:39',
                'modified_by' => 'f92bd440-60e5-4668-b2a7-b4255d7036cc',
                'business_users_tenant_user_id' => 1,
                'business_users_role_id' => 1,
            ],
        ];
        parent::init();
    }
}
