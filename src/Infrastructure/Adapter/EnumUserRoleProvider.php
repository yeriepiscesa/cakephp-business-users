<?php
declare(strict_types=1);

namespace BusinessUsers\Infrastructure\Adapter;

use BusinessUsers\Application\Port\UserRoleProviderInterface;
use BusinessUsers\Domain\Enum\UserRole;

/**
 * Adapter: fulfils UserRoleProviderInterface using the UserRole enum.
 *
 * Lives in Infrastructure — it is the only place that knows the enum directly.
 * Registered in the DI container in BusinessUsersPlugin::services().
 */
final class EnumUserRoleProvider implements UserRoleProviderInterface
{
    /**
     * @return array<string, string>
     */
    public function getOptions(): array
    {
        return UserRole::toOptions();
    }
}
