<?php
declare(strict_types=1);

namespace BusinessUsers\Application\UseCase\UpdateUserRole;

use BusinessUsers\Application\Port\PlatformUserRepositoryInterface;

/**
 * Use case: update the platform-level role of a user.
 *
 * Bypasses the CakeDC/Users mass-assignment guard by delegating
 * to PlatformUserRepositoryInterface, which sets the field directly
 * on the entity before saving.
 *
 * No HTTP, ORM, or framework knowledge lives here.
 */
final class UpdateUserRoleUseCase
{
    public function __construct(
        private readonly PlatformUserRepositoryInterface $platformUserRepository,
    ) {}

    public function execute(UpdateUserRoleInput $input): UpdateUserRoleOutput
    {
        $this->platformUserRepository->updateRole($input->userId, $input->role);

        return new UpdateUserRoleOutput(
            userId: $input->userId,
            newRole: $input->role,
        );
    }
}
