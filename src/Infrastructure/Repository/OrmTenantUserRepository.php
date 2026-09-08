<?php
declare(strict_types=1);

namespace BusinessUsers\Infrastructure\Repository;

use BusinessUsers\Application\DTO\GroupData;
use BusinessUsers\Application\DTO\RoleData;
use BusinessUsers\Application\DTO\TenantData;
use BusinessUsers\Application\DTO\TenantMembershipData;
use BusinessUsers\Domain\Repository\TenantUserRepositoryInterface;
use BusinessUsers\Model\Entity\Group;
use BusinessUsers\Model\Entity\Role;
use BusinessUsers\Model\Entity\Tenant;
use BusinessUsers\Model\Entity\TenantUser;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * CakePHP ORM implementation of TenantUserRepositoryInterface.
 *
 * Single place where TenantUser, Tenant, Group, and Role ORM entities are
 * mapped to framework-agnostic DTOs used by the Application layer.
 */
final class OrmTenantUserRepository implements TenantUserRepositoryInterface
{
    use LocatorAwareTrait;

    /**
     * @return list<TenantMembershipData>
     */
    public function findByUserId(string $userId): array
    {
        $results = $this->buildBaseQuery()
            ->where(['TenantUsers.user_id' => $userId])
            ->all();

        return array_map(
            fn(TenantUser $tu) => $this->toDto($tu),
            iterator_to_array($results),
        );
    }

    public function findByUserAndTenant(string $userId, int $tenantId): ?TenantMembershipData
    {
        /** @var TenantUser|null $result */
        $result = $this->buildBaseQuery()
            ->where([
                'TenantUsers.user_id' => $userId,
                'TenantUsers.business_users_tenant_id' => $tenantId,
            ])
            ->first();

        return $result !== null ? $this->toDto($result) : null;
    }

    // ─── Private helpers ──────────────────────────────────────────────────────

    private function buildBaseQuery(): \Cake\ORM\Query\SelectQuery
    {
        /** @var \BusinessUsers\Model\Table\TenantUsersTable $table */
        $table = $this->fetchTable('BusinessUsers.TenantUsers');

        return $table->find()
            ->contain([
                'Tenants',
                'GroupMembers.Groups',
                'TenantUserRoles.Roles',
            ]);
    }

    private function toDto(TenantUser $tenantUser): TenantMembershipData
    {
        $groups = array_map(
            fn($gm) => $this->groupToDto($gm->group),
            $tenantUser->group_members ?? [],
        );

        $roles = array_map(
            fn($tur) => $this->roleToDto($tur->role),
            $tenantUser->tenant_user_roles ?? [],
        );

        return new TenantMembershipData(
            tenantUserId: $tenantUser->id,
            userId: $tenantUser->user_id,
            tenant: $this->tenantToDto($tenantUser->tenant),
            status: $tenantUser->status,
            isOwner: (bool)$tenantUser->is_owner,
            joinedAt: $tenantUser->joined?->toIso8601String() ?? null,
            groups: array_values($groups),
            roles: array_values($roles),
        );
    }

    private function tenantToDto(Tenant $tenant): TenantData
    {
        $settings = $tenant->settings;
        if (is_string($settings)) {
            $settings = (array)json_decode($settings, true);
        }

        return new TenantData(
            id: $tenant->id,
            name: $tenant->name,
            code: $tenant->code,
            status: $tenant->status,
            description: $tenant->description ?? null,
            settings: (array)$settings,
        );
    }

    private function groupToDto(Group $group): GroupData
    {
        return new GroupData(
            id: $group->id,
            tenantId: $group->business_users_tenant_id,
            name: $group->name,
            code: $group->code,
            description: $group->description ?? null,
            isDefault: (bool)$group->is_default,
            isActive: (bool)$group->is_active,
            sortOrder: (int)$group->sort_order,
        );
    }

    private function roleToDto(Role $role): RoleData
    {
        return new RoleData(
            id: $role->id,
            tenantId: $role->business_users_tenant_id,
            name: $role->name,
            code: $role->code,
            level: $role->level,
            description: $role->description ?? null,
            isDefault: (bool)$role->is_default,
            isActive: (bool)$role->is_active,
            sortOrder: (int)$role->sort_order,
            createdAt: $role->created?->toIso8601String() ?? '',
            modifiedAt: $role->modified?->toIso8601String() ?? '',
        );
    }
}
