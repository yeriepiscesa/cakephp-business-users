<?php
declare(strict_types=1);

namespace BusinessUsers\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PermissionsFixture
 */
class PermissionsFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'business_users_permissions';
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
                'created' => '2026-05-14 04:50:37',
                'created_by' => '6b6f84cf-7d59-45c1-a709-0c4080e02e94',
                'modified' => '2026-05-14 04:50:37',
                'modified_by' => 'fd238697-4eae-4959-8bed-0d1db129c1dd',
                'business_users_module_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'code' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'is_active' => 1,
                'sort_order' => 1,
            ],
        ];
        parent::init();
    }
}
