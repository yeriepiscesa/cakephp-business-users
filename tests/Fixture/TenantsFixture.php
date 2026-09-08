<?php
declare(strict_types=1);

namespace BusinessUsers\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TenantsFixture
 */
class TenantsFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'business_users_tenants';
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
                'created' => '2026-05-14 04:40:17',
                'created_by' => 'ba4e8683-f749-407a-a892-d8cd844227f2',
                'modified' => '2026-05-14 04:40:17',
                'modified_by' => '573d23fa-a4d7-46f2-8d14-f0a917b93ce5',
                'name' => 'Lorem ipsum dolor sit amet',
                'code' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'settings' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            ],
        ];
        parent::init();
    }
}
