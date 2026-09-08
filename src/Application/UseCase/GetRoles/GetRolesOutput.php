<?php
declare(strict_types=1);

namespace BusinessUsers\Application\UseCase\GetRoles;

use BusinessUsers\Application\DTO\RoleData;

/**
 * Output value object returned by the GetRoles use case.
 */
final class GetRolesOutput
{
    /**
     * @param list<RoleData> $roles
     * @param int            $total  Total records matching the query (before pagination).
     * @param int            $page   Current page.
     * @param int            $limit  Page size.
     */
    public function __construct(
        public readonly array $roles,
        public readonly int $total,
        public readonly int $page,
        public readonly int $limit,
    ) {}

    /**
     * Serialises the output to a plain array for JSON responses.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'data' => array_map(fn(RoleData $r) => $r->toArray(), $this->roles),
            'meta' => [
                'total' => $this->total,
                'page' => $this->page,
                'limit' => $this->limit,
                'pages' => $this->limit > 0 ? (int)ceil($this->total / $this->limit) : 1,
            ],
        ];
    }
}
