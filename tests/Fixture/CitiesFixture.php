<?php
declare(strict_types=1);

namespace BusinessUsers\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CitiesFixture
 */
class CitiesFixture extends TestFixture
{
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
                'state_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'latitude' => 'Lorem ipsum dolor ',
                'longitude' => 'Lorem ipsum dolor ',
            ],
        ];
        parent::init();
    }
}
