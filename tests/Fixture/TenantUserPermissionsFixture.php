<?php
declare(strict_types=1);

namespace BusinessUsers\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TenantUserPermissionsFixture
 */
class TenantUserPermissionsFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'business_users_tenant_user_permissions';
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
                'created' => '2026-05-14 04:50:40',
                'created_by' => '26e9a102-bfd0-405c-b69a-0cc17336e854',
                'modified' => '2026-05-14 04:50:40',
                'modified_by' => '2ba26b6f-ae5d-4eb8-8ef4-fbe626a95f8d',
                'business_users_tenant_user_id' => 1,
                'business_users_permission_id' => 1,
                'effect' => 'Lorem ip',
            ],
        ];
        parent::init();
    }
}
