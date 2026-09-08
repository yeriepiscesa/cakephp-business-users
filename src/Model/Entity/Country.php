<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Entity;

use Cake\ORM\Entity;

/**
 * Country Entity
 *
 * @property int $id
 * @property string $iso
 * @property string $name
 * @property string $nicename
 * @property string|null $iso3
 * @property int|null $numcode
 * @property int $phonecode
 *
 * @property \BusinessUsers\Model\Entity\State[] $states
 */
class Country extends Entity
{
    protected array $_accessible = [
        'iso' => true,
        'name' => true,
        'nicename' => true,
        'iso3' => true,
        'numcode' => true,
        'phonecode' => true,
        'states' => true,
    ];
}
