<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Entity;

use BusinessUsers\Domain\Enum\BusinessRole;
use Cake\ORM\Entity;

/**
 * Role Entity
 *
 * @property int $id
 * @property \Cake\I18n\DateTime $created
 * @property string|null $created_by
 * @property \Cake\I18n\DateTime $modified
 * @property string|null $modified_by
 * @property int $business_users_tenant_id
 * @property string $name
 * @property string $code
 * @property int $level
 * @property string|null $description
 * @property bool $is_default
 * @property bool $is_active
 * @property int $sort_order
 *
 * @property \BusinessUsers\Model\Entity\Tenant $tenant
 * @property \BusinessUsers\Model\Entity\GroupRole[] $group_roles
 * @property \BusinessUsers\Model\Entity\RolePermission[] $role_permissions
 * @property \BusinessUsers\Model\Entity\TenantUserRole[] $tenant_user_roles
 */
class Role extends Entity
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
        'business_users_tenant_id' => true,
        'name' => true,
        'code' => true,
        'level' => true,
        'description' => true,
        'is_default' => true,
        'is_active' => true,
        'sort_order' => true,
        'tenant' => true,
        'group_roles' => true,
        'role_permissions' => true,
        'tenant_user_roles' => true,
    ];

    /**
     * Resolves the canonical BusinessRole enum for this role's code.
     * Returns null when the code is a custom (non-canonical) role.
     */
    public function canonicalRole(): ?BusinessRole
    {
        return BusinessRole::tryFrom($this->code);
    }
}
