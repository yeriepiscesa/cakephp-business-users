<?php
declare(strict_types=1);

use Cake\Core\Plugin;
use Cake\Datasource\FactoryLocator;
use JsonMachine\Items;
use Migrations\BaseSeed;

/**
 * States seed.
 */
class StatesSeed extends BaseSeed
{
    public function run(): void
    {
        $table = $this->table('states');
        $tCountries = FactoryLocator::get('Table')->get('BusinessUsers.Countries');
        $path = Plugin::path('BusinessUsers') . 'config' . DS . 'data' . DS . 'countries+states+cities.json';
        $countries = Items::fromFile($path);

        foreach ($countries as $row) {
            $data = [];
            $c = $tCountries->find()->where(['iso' => $row->iso2])->first();
            if ($c) {
                $country_id = $c->id;
                foreach ($row->states as $state) {
                    $data[] = [
                        'id' => $state->id,
                        'country_id' => $country_id,
                        'state_code' => $state->state_code,
                        'name' => $state->name,
                        'latitude' => $state->latitude,
                        'longitude' => $state->longitude,
                    ];
                }
            }
            if ($data !== []) {
                $table->insert($data)->save();
            }
        }
    }
}
