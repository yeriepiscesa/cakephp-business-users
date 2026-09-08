<?php
declare(strict_types=1);

namespace BusinessUsers\Domain\Repository;

use BusinessUsers\Application\DTO\RoleData;

/**
 * Contract for retrieving Role data from any persistence mechanism.
 *
 * Implementations live in the Infrastructure layer (e.g. OrmRoleRepository).
 * Use cases and other application-layer code depend ONLY on this interface.
 */
interface RoleRepositoryInterface
{
    /**
     * Returns all active roles, optionally filtered by tenant.
     *
     * @param int|null $tenantId  Filter by tenant. Null = all tenants.
     * @param bool|null $isActive Filter by active status. Null = no filter.
     * @return list<RoleData>
     */
    public function findAll(?int $tenantId = null, ?bool $isActive = null): array;

    /**
     * Finds a single role by its primary key.
     *
     * @param int $id
     * @return RoleData|null Null when not found.
     */
    public function findById(int $id): ?RoleData;

    /**
     * Finds a role by tenant + code combination.
     *
     * @param int    $tenantId
     * @param string $code
     * @return RoleData|null
     */
    public function findByTenantAndCode(int $tenantId, string $code): ?RoleData;
}
