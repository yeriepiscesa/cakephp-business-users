<?php
declare(strict_types=1);

namespace BusinessUsers\Application\UseCase\GetRoles;

/**
 * Input value object for the GetRoles use case.
 */
final class GetRolesInput
{
    /**
     * @param int|null  $tenantId  Scope results to a specific tenant. Null = all.
     * @param bool|null $isActive  Filter by active flag. Null = no filter.
     * @param int       $page      1-based page number for pagination.
     * @param int       $limit     Maximum number of results per page (1–100).
     */
    public function __construct(
        public readonly ?int $tenantId = null,
        public readonly ?bool $isActive = null,
        public readonly int $page = 1,
        public readonly int $limit = 20,
    ) {
        if ($this->page < 1) {
            throw new \InvalidArgumentException('Page must be >= 1.');
        }
        if ($this->limit < 1 || $this->limit > 100) {
            throw new \InvalidArgumentException('Limit must be between 1 and 100.');
        }
    }
}
