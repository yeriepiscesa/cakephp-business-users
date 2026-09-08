<?php
declare(strict_types=1);

namespace BusinessUsers\Application\Port;

/**
 * Port: contract for providing platform-level user role options.
 *
 * Consumers (controllers, views, other plugins) depend ONLY on this interface.
 * The concrete implementation lives in the Infrastructure layer.
 *
 * Cross-plugin usage pattern:
 *   1. Inject this interface via constructor (resolved by CakePHP DI container).
 *   2. Do NOT import the concrete enum or adapter class from outside BusinessUsers.
 *
 * @see \BusinessUsers\Infrastructure\Adapter\EnumUserRoleProvider
 */
interface UserRoleProviderInterface
{
    /**
     * Returns all available platform roles as a [value => label] map,
     * ready for use in select inputs.
     *
     * @return array<string, string>
     */
    public function getOptions(): array;
}
