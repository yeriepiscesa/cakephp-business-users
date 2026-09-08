<?php
declare(strict_types=1);

namespace BusinessUsers\Application\UseCase\UpdateUserRole;

/**
 * Output value object for the UpdateUserRole use case.
 */
final class UpdateUserRoleOutput
{
    /**
     * @param string $userId  UUID of the updated user.
     * @param string $newRole New role value that was persisted.
     */
    public function __construct(
        public readonly string $userId,
        public readonly string $newRole,
    ) {}
}
