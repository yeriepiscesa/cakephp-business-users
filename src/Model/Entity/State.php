<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Entity;

use Cake\ORM\Entity;

/**
 * State Entity
 *
 * @property int $id
 * @property int $country_id
 * @property string $name
 * @property string|null $state_code
 * @property string|null $longitude
 * @property string|null $latitude
 *
 * @property \BusinessUsers\Model\Entity\Country $country
 * @property \BusinessUsers\Model\Entity\City[] $cities
 */
class State extends Entity
{
    protected array $_accessible = [
        'country_id' => true,
        'name' => true,
        'state_code' => true,
        'longitude' => true,
        'latitude' => true,
        'country' => true,
        'cities' => true,
    ];
}
