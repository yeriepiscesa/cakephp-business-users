<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Entity;

use Cake\ORM\Entity;

/**
 * City Entity
 *
 * @property int $id
 * @property int $state_id
 * @property string $name
 * @property string|null $latitude
 * @property string|null $longitude
 *
 * @property \BusinessUsers\Model\Entity\State $state
 */
class City extends Entity
{
    protected array $_accessible = [
        'state_id' => true,
        'name' => true,
        'latitude' => true,
        'longitude' => true,
        'state' => true,
    ];
}
