<?php
declare(strict_types=1);

namespace BusinessUsers\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GroupMembersFixture
 */
class GroupMembersFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'business_users_group_members';
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
                'created_by' => '891b93f9-0306-4b8c-96b7-85bcc36b53c6',
                'modified' => '2026-05-14 04:50:39',
                'modified_by' => 'b71a197f-4f20-4b88-8202-fe8e80a0755b',
                'business_users_group_id' => 1,
                'business_users_tenant_user_id' => 1,
            ],
        ];
        parent::init();
    }
}
