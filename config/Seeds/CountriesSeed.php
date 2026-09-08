<?php
declare(strict_types=1);

use Cake\Core\Plugin;
use JsonMachine\Items;
use Migrations\BaseSeed;

/**
 * Countries seed.
 */
class CountriesSeed extends BaseSeed
{
    public function run(): void
    {
        $table = $this->table('countries');
        $path = Plugin::path('BusinessUsers') . 'config' . DS . 'data' . DS . 'countries+states+cities.json';
        $countries = Items::fromFile($path);

        foreach ($countries as $row) {
            $data = [[
                'id' => $row->id,
                'iso' => $row->iso2,
                'name' => strtoupper((string)$row->name),
                'nicename' => $row->name,
                'iso3' => $row->iso3 ?? null,
                'numcode' => isset($row->numeric_code) ? (int)$row->numeric_code : null,
                'phonecode' => (int)$row->phone_code,
            ]];
            $table->insert($data)->save();
        }
    }
}
