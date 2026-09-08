<?php
declare(strict_types=1);

namespace BusinessUsers\Application\UseCase\UpdateUserRole;

use BusinessUsers\Domain\Enum\UserRole;

/**
 * Input value object for the UpdateUserRole use case.
 */
final class UpdateUserRoleInput
{
    /**
     * @param string $userId UUID of the user whose role will change.
     * @param string $role   New role value; must be a valid UserRole case.
     * @throws \InvalidArgumentException When the role value is not valid.
     */
    public function __construct(
        public readonly string $userId,
        public readonly string $role,
    ) {
        if ($this->userId === '') {
            throw new \InvalidArgumentException('User ID must not be empty.');
        }
        if (UserRole::tryFrom($this->role) === null) {
            throw new \InvalidArgumentException(
                sprintf('"%s" is not a valid role.', $this->role),
            );
        }
    }
}
