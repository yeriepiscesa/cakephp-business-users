<?php
declare(strict_types=1);

namespace BusinessUsers\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GroupRolesFixture
 */
class GroupRolesFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'business_users_group_roles';
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
                'created_by' => 'cfc390cc-3543-4799-9089-0f477d712117',
                'modified' => '2026-05-14 04:50:39',
                'modified_by' => 'b5d6d0d0-5096-4b13-bb41-a71893209b43',
                'business_users_group_id' => 1,
                'business_users_role_id' => 1,
            ],
        ];
        parent::init();
    }
}
