<?php
declare(strict_types=1);

namespace BusinessUsers\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TenantModulesFixture
 */
class TenantModulesFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'business_users_tenant_modules';
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
                'created_by' => '3530066d-94b3-48b3-8425-416e79724c1b',
                'modified' => '2026-05-14 04:50:38',
                'modified_by' => '503c565c-f645-41c3-9855-db6cff1be05e',
                'business_users_tenant_id' => 1,
                'business_users_module_id' => 1,
                'is_enabled' => 1,
                'starts_at' => '2026-05-14 04:50:38',
                'ends_at' => '2026-05-14 04:50:38',
                'settings' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            ],
        ];
        parent::init();
    }
}
