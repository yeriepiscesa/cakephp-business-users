<?php
declare(strict_types=1);

namespace BusinessUsers\Domain\Enum;

/**
 * Platform-level user roles for the CakeDC/Users `users.role` column.
 *
 * These roles control access at the application level, independent of any
 * business tenant context.
 */
enum UserRole: string
{
    /** Regular authenticated user. Default role on registration. */
    case User = 'user';

    /** Application administrator. Full access to admin area. */
    case Admin = 'admin';

    /** Super user. Bypasses all authorization checks. */
    case Superuser = 'superuser';

    /**
     * Returns the human-readable label for the role.
     */
    public function label(): string
    {
        return match ($this) {
            self::User => 'User',
            self::Admin => 'Admin',
            self::Superuser => 'Super User',
        };
    }

    /**
     * Returns all roles as an associative array [value => label] suitable
     * for use in select inputs.
     *
     * @return array<string, string>
     */
    public static function toOptions(): array
    {
        return array_column(
            array_map(
                fn(self $role) => ['value' => $role->value, 'label' => $role->label()],
                self::cases(),
            ),
            'label',
            'value',
        );
    }
}
