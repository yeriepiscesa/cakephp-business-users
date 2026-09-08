<?php
declare(strict_types=1);

namespace BusinessUsers\Application\Port;

/**
 * Port: contract for platform-level user persistence operations.
 *
 * Only exposes operations that the Application layer actually needs.
 * The concrete CakePHP-ORM implementation lives in Infrastructure.
 *
 * @see \BusinessUsers\Infrastructure\Repository\OrmPlatformUserRepository
 */
interface PlatformUserRepositoryInterface
{
    /**
     * Updates the platform role of a user.
     *
     * Does NOT go through entity mass-assignment. Sets the `role` column
     * directly so that the field protection in CakeDC/Users User entity
     * is bypassed safely from within the application layer.
     *
     * @param string $userId UUID of the user to update.
     * @param string $role   Role value (must be a valid UserRole case value).
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When user not found.
     * @throws \RuntimeException When the save fails.
     */
    public function updateRole(string $userId, string $role): void;
}
