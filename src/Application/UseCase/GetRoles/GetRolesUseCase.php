<?php
declare(strict_types=1);

namespace BusinessUsers\Application\UseCase\GetRoles;

use BusinessUsers\Domain\Repository\RoleRepositoryInterface;

/**
 * Use case: retrieve a paginated list of business roles.
 *
 * This class contains ONLY business-rule orchestration. It has no knowledge of
 * HTTP, ORM, or any framework internals — only the domain repository contract.
 */
final class GetRolesUseCase
{
    public function __construct(
        private readonly RoleRepositoryInterface $roleRepository,
    ) {}

    public function execute(GetRolesInput $input): GetRolesOutput
    {
        $all = $this->roleRepository->findAll($input->tenantId, $input->isActive);

        $total = count($all);

        // Manual pagination over the in-memory result set.
        // For very large datasets, move pagination into the repository query.
        $offset = ($input->page - 1) * $input->limit;
        $paged = array_slice($all, $offset, $input->limit);

        return new GetRolesOutput(
            roles: $paged,
            total: $total,
            page: $input->page,
            limit: $input->limit,
        );
    }
}
