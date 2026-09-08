<?php
declare(strict_types=1);

namespace BusinessUsers\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TenantUsersFixture
 */
class TenantUsersFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'business_users_tenant_users';
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
                'created_by' => 'c63ed04c-14f1-4266-82a0-aa60d4e6421f',
                'modified' => '2026-05-14 04:50:38',
                'modified_by' => 'd9435aa1-fd6e-49a5-99d9-35cdcbede4fa',
                'business_users_tenant_id' => 1,
                'user_id' => 'bb7d2926-313b-4f1c-816e-fa7594dabb2a',
                'status' => 'Lorem ipsum dolor sit amet',
                'is_owner' => 1,
                'joined' => '2026-05-14 04:50:38',
                'metadata' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            ],
        ];
        parent::init();
    }
}
