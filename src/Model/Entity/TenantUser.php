<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Entity;

use Cake\ORM\Entity;

/**
 * TenantUser Entity
 *
 * @property int $id
 * @property \Cake\I18n\DateTime $created
 * @property string|null $created_by
 * @property \Cake\I18n\DateTime $modified
 * @property string|null $modified_by
 * @property int $business_users_tenant_id
 * @property string $user_id
 * @property string $status
 * @property bool $is_owner
 * @property \Cake\I18n\DateTime|null $joined
 * @property string|null $metadata
 *
 * @property \BusinessUsers\Model\Entity\Tenant $tenant
 * @property \CakeDC\Users\Model\Entity\User $user
 * @property \BusinessUsers\Model\Entity\GroupMember[] $group_members
 * @property \BusinessUsers\Model\Entity\TenantUserModule[] $tenant_user_modules
 * @property \BusinessUsers\Model\Entity\TenantUserPermission[] $tenant_user_permissions
 * @property \BusinessUsers\Model\Entity\TenantUserRole[] $tenant_user_roles
 */
class TenantUser extends Entity
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
        'user_id' => true,
        'status' => true,
        'is_owner' => true,
        'joined' => true,
        'metadata' => true,
        'tenant' => true,
        'user' => true,
        'group_members' => true,
        'tenant_user_modules' => true,
        'tenant_user_permissions' => true,
        'tenant_user_roles' => true,
    ];
}
