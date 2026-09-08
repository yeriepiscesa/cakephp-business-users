<?php
declare(strict_types=1);

use Cake\Core\Plugin;
use JsonMachine\Items;
use Migrations\BaseSeed;

/**
 * Cities seed.
 */
class CitiesSeed extends BaseSeed
{
    public function run(): void
    {
        $table = $this->table('cities');
        $path = Plugin::path('BusinessUsers') . 'config' . DS . 'data' . DS . 'countries+states+cities.json';
        $countries = Items::fromFile($path);

        foreach ($countries as $row) {
            foreach ($row->states as $state) {
                foreach ($state->cities as $city) {
                    $data = [[
                        'state_id' => $state->id,
                        'name' => $city->name,
                        'latitude' => $city->latitude,
                        'longitude' => $city->longitude,
                    ]];
                    $table->insert($data)->save();
                }
            }
        }
    }
}
