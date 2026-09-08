<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Entity;

use Cake\ORM\Entity;

/**
 * Permission Entity
 *
 * @property int $id
 * @property \Cake\I18n\DateTime $created
 * @property string|null $created_by
 * @property \Cake\I18n\DateTime $modified
 * @property string|null $modified_by
 * @property int $business_users_module_id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property bool $is_active
 * @property int $sort_order
 *
 * @property \BusinessUsers\Model\Entity\Module $module
 * @property \BusinessUsers\Model\Entity\RolePermission[] $role_permissions
 * @property \BusinessUsers\Model\Entity\TenantUserPermission[] $tenant_user_permissions
 */
class Permission extends Entity
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
        'business_users_module_id' => true,
        'name' => true,
        'code' => true,
        'description' => true,
        'is_active' => true,
        'sort_order' => true,
        'module' => true,
        'role_permissions' => true,
        'tenant_user_permissions' => true,
    ];
}
