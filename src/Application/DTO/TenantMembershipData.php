<?php
declare(strict_types=1);

namespace BusinessUsers\Application\DTO;

/**
 * Immutable DTO representing a user's membership in a single tenant,
 * including all groups and roles assigned within that tenant.
 */
final class TenantMembershipData
{
    /**
     * @param list<GroupData> $groups  Groups the user belongs to in this tenant.
     * @param list<RoleData>  $roles   Roles directly assigned to the user in this tenant.
     */
    public function __construct(
        public readonly int $tenantUserId,
        public readonly string $userId,
        public readonly TenantData $tenant,
        public readonly string $status,
        public readonly bool $isOwner,
        public readonly ?string $joinedAt,
        public readonly array $groups,
        public readonly array $roles,
    ) {}

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'tenant_user_id' => $this->tenantUserId,
            'user_id' => $this->userId,
            'tenant' => $this->tenant->toArray(),
            'status' => $this->status,
            'is_owner' => $this->isOwner,
            'joined_at' => $this->joinedAt,
            'groups' => array_map(fn(GroupData $g) => $g->toArray(), $this->groups),
            'roles' => array_map(fn(RoleData $r) => $r->toArray(), $this->roles),
        ];
    }
}
