<?php
declare(strict_types=1);

namespace BusinessUsers\Application\UseCase\GetUserBusinessProfile;

use BusinessUsers\Domain\Repository\TenantUserRepositoryInterface;

/**
 * Use case: retrieve a user's complete business profile.
 *
 * Returns all tenants the user belongs to, with their groups and roles
 * within each tenant. Optionally scoped to a single tenant.
 *
 * This class orchestrates only — no ORM, HTTP, or framework knowledge here.
 */
final class GetUserBusinessProfileUseCase
{
    public function __construct(
        private readonly TenantUserRepositoryInterface $tenantUserRepository,
    ) {}

    public function execute(GetUserBusinessProfileInput $input): GetUserBusinessProfileOutput
    {
        if ($input->tenantId !== null) {
            $membership = $this->tenantUserRepository->findByUserAndTenant(
                $input->userId,
                $input->tenantId,
            );
            $memberships = $membership !== null ? [$membership] : [];
        } else {
            $memberships = $this->tenantUserRepository->findByUserId($input->userId);
        }

        return new GetUserBusinessProfileOutput(
            userId: $input->userId,
            memberships: $memberships,
        );
    }
}
