<?php
declare(strict_types=1);

namespace BusinessUsers\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RolePermissionsFixture
 */
class RolePermissionsFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'business_users_role_permissions';
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
                'created' => '2026-05-14 04:50:38',
                'created_by' => 'a85a1423-5d66-4830-8c15-9beff5d6026b',
                'modified' => '2026-05-14 04:50:38',
                'modified_by' => 'e45cdf14-1c43-4675-84c2-cb5ef8a7853e',
                'business_users_role_id' => 1,
                'business_users_permission_id' => 1,
            ],
        ];
        parent::init();
    }
}
