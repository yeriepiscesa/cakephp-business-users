<?php
declare(strict_types=1);

namespace BusinessUsers\Infrastructure\Repository;

use BusinessUsers\Application\DTO\RoleData;
use BusinessUsers\Domain\Repository\RoleRepositoryInterface;
use BusinessUsers\Model\Entity\Role;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * CakePHP ORM implementation of RoleRepositoryInterface.
 *
 * Lives in the Infrastructure layer — this is the ONLY place that knows about
 * the ORM. Domain and Application layers are entirely decoupled from CakePHP.
 */
final class OrmRoleRepository implements RoleRepositoryInterface
{
    use LocatorAwareTrait;

    /**
     * @return list<RoleData>
     */
    public function findAll(?int $tenantId = null, ?bool $isActive = null): array
    {
        /** @var \BusinessUsers\Model\Table\RolesTable $table */
        $table = $this->fetchTable('BusinessUsers.Roles');

        $query = $table->find()
            ->contain(['Tenants'])
            ->orderByAsc('level')
            ->orderByAsc('sort_order');

        if ($tenantId !== null) {
            $query = $query->where(['business_users_tenant_id' => $tenantId]);
        }

        if ($isActive !== null) {
            $query = $query->where(['is_active' => $isActive]);
        }

        /** @var iterable<Role> $results */
        $results = $query->all();

        return array_map(
            fn(Role $role) => $this->toDto($role),
            iterator_to_array($results),
        );
    }

    public function findById(int $id): ?RoleData
    {
        /** @var \BusinessUsers\Model\Table\RolesTable $table */
        $table = $this->fetchTable('BusinessUsers.Roles');

        /** @var Role|null $role */
        $role = $table->find()
            ->contain(['Tenants'])
            ->where(['BusinessUsers_Roles.id' => $id])
            ->first();

        return $role !== null ? $this->toDto($role) : null;
    }

    public function findByTenantAndCode(int $tenantId, string $code): ?RoleData
    {
        /** @var \BusinessUsers\Model\Table\RolesTable $table */
        $table = $this->fetchTable('BusinessUsers.Roles');

        /** @var Role|null $role */
        $role = $table->find()
            ->where([
                'business_users_tenant_id' => $tenantId,
                'code' => $code,
            ])
            ->first();

        return $role !== null ? $this->toDto($role) : null;
    }

    /**
     * Maps a CakePHP ORM Role entity to a framework-agnostic RoleData DTO.
     */
    private function toDto(Role $role): RoleData
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
