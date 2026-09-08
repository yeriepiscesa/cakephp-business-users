<?php
declare(strict_types=1);

namespace BusinessUsers\Application\UseCase\GetUserBusinessProfile;

/**
 * Input value object for the GetUserBusinessProfile use case.
 */
final class GetUserBusinessProfileInput
{
    /**
     * @param string   $userId    UUID of the authenticated user (from users.id).
     * @param int|null $tenantId  When provided, return only the membership for
     *                            this specific tenant instead of all memberships.
     */
    public function __construct(
        public readonly string $userId,
        public readonly ?int $tenantId = null,
    ) {
        if (trim($this->userId) === '') {
            throw new \InvalidArgumentException('userId must not be empty.');
        }
    }
}
