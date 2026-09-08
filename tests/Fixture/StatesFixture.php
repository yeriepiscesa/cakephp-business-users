<?php
declare(strict_types=1);

namespace BusinessUsers\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StatesFixture
 */
class StatesFixture extends TestFixture
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
                'country_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'state_code' => 'Lor',
                'longitude' => 'Lorem ipsum dolor ',
                'latitude' => 'Lorem ipsum dolor ',
            ],
        ];
        parent::init();
    }
}
