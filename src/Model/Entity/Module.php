<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Entity;

use Cake\ORM\Entity;

/**
 * Module Entity
 *
 * @property int $id
 * @property \Cake\I18n\DateTime $created
 * @property string|null $created_by
 * @property \Cake\I18n\DateTime $modified
 * @property string|null $modified_by
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property bool $is_active
 * @property int $sort_order
 * @property string|null $settings
 *
 * @property \BusinessUsers\Model\Entity\Permission[] $permissions
 * @property \BusinessUsers\Model\Entity\TenantModule[] $tenant_modules
 * @property \BusinessUsers\Model\Entity\TenantUserModule[] $tenant_user_modules
 */
class Module extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        'name' => true,
        'code' => true,
        'description' => true,
        'is_active' => true,
        'sort_order' => true,
        'settings' => true,
        'permissions' => true,
        'tenant_modules' => true,
        'tenant_user_modules' => true,
    ];
}
