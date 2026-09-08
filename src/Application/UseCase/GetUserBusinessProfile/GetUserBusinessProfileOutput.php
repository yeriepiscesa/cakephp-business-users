<?php
declare(strict_types=1);

namespace BusinessUsers\Application\UseCase\GetUserBusinessProfile;

use BusinessUsers\Application\DTO\TenantMembershipData;

/**
 * Output value object returned by the GetUserBusinessProfile use case.
 */
final class GetUserBusinessProfileOutput
{
    /**
     * @param string                   $userId      The queried user ID.
     * @param list<TenantMembershipData> $memberships All tenant memberships for the user.
     */
    public function __construct(
        public readonly string $userId,
        public readonly array $memberships,
    ) {}

    /**
     * Whether the user belongs to at least one tenant.
     */
    public function hasMemberships(): bool
    {
        return count($this->memberships) > 0;
    }

    /**
     * Whether the user is an owner in any of their tenants.
     */
    public function isOwnerInAnyTenant(): bool
    {
        foreach ($this->memberships as $m) {
            if ($m->isOwner) {
                return true;
            }
        }

        return false;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'memberships' => array_map(
                fn(TenantMembershipData $m) => $m->toArray(),
                $this->memberships,
            ),
        ];
    }
}
