<?php
declare(strict_types=1);

namespace BusinessUsers\Authorization;

/**
 * Platform-level authorization helpers for BusinessUsers.
 */
final class PlatformUserAuthorization
{
    /**
     * @param mixed $identity Authenticated identity (entity or array).
     */
    public static function isSuperAdmin(mixed $identity): bool
    {
        if ($identity === null) {
            return false;
        }

        $data = is_object($identity) && method_exists($identity, 'toArray')
            ? $identity->toArray()
            : (array)$identity;

        if (!empty($data['is_superuser'])) {
            return true;
        }

        $role = (string)($data['role'] ?? '');

        return in_array($role, ['superuser', 'superadmin'], true);
    }
}
