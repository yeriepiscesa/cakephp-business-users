<?php
declare(strict_types=1);

namespace BusinessUsers\Infrastructure\Repository;

use BusinessUsers\Application\Port\PlatformUserRepositoryInterface;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * CakePHP-ORM implementation of PlatformUserRepositoryInterface.
 *
 * Accesses the CakeDC/Users `users` table directly to bypass the
 * `role => false` mass-assignment protection on the User entity.
 * Only this class may touch the platform user table for role changes.
 */
final class OrmPlatformUserRepository implements PlatformUserRepositoryInterface
{
    use LocatorAwareTrait;

    /**
     * Updates the platform role of a user.
     *
     * Sets `role` via `Entity::set()` (not patchEntity), which bypasses
     * the mass-assignment guard in CakeDC/Users User entity.
     *
     * @param string $userId UUID of the user to update.
     * @param string $role   Role value (e.g. 'admin', 'user').
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \RuntimeException
     */
    public function updateRole(string $userId, string $role): void
    {
        $table = $this->fetchTable('Users');

        /** @var \CakeDC\Users\Model\Entity\User $user */
        $user = $table->get($userId);

        // Use Entity::set() directly — intentionally bypassing $accessible guard.
        $user->set('role', $role);

        if (!$table->save($user)) {
            throw new \RuntimeException(
                sprintf('Could not update role for user %s.', $userId),
            );
        }
    }
}
