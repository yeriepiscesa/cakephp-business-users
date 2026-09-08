<?php
declare(strict_types=1);

namespace BusinessUsers\Domain\Repository;

use BusinessUsers\Application\DTO\TenantMembershipData;

/**
 * Contract for retrieving TenantUser (membership) data by user.
 *
 * Implementations live in the Infrastructure layer.
 */
interface TenantUserRepositoryInterface
{
    /**
     * Returns all tenant memberships for the given user, each enriched
     * with the tenant details, the user's groups, and the user's roles
     * within that tenant.
     *
     * @param string $userId  UUID from the CakeDC/Users `users.id` column.
     * @return list<TenantMembershipData>
     */
    public function findByUserId(string $userId): array;

    /**
     * Returns the membership for a specific user in a specific tenant,
     * or null when the user is not a member.
     *
     * @param string $userId
     * @param int    $tenantId
     * @return TenantMembershipData|null
     */
    public function findByUserAndTenant(string $userId, int $tenantId): ?TenantMembershipData;
}
