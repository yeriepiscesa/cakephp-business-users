<?php
declare(strict_types=1);

namespace BusinessUsers\Controller\Api\V1;

use BusinessUsers\Application\UseCase\GetRoles\GetRolesInput;
use BusinessUsers\Application\UseCase\GetRoles\GetRolesUseCase;
use BusinessUsers\Controller\ApiController;
use BusinessUsers\Domain\Enum\BusinessRole;
use BusinessUsers\Domain\Enum\UserRole;
use BusinessUsers\Infrastructure\Repository\OrmRoleRepository;

/**
 * REST API controller for role resources — API v1.
 *
 * Interface layer: translates HTTP concerns into use-case calls.
 * No business logic lives here.
 *
 * Routes (registered in BusinessUsersPlugin::routes()):
 *   GET  /api/business-users/v1/roles         → index()
 *   GET  /api/business-users/v1/roles/enums   → enums()
 */
class RolesController extends ApiController
{
    /**
     * GET /api/business-users/v1/roles
     *
     * Query parameters:
     *   - tenant_id  (int, optional)     Scope to a specific tenant.
     *   - is_active  (1/0, optional)     Filter by active flag.
     *   - page       (int, default 1)
     *   - limit      (int, default 20, max 100)
     */
    public function index(): void
    {
        $query = $this->request->getQueryParams();

        $tenantId = isset($query['tenant_id']) ? (int)$query['tenant_id'] : null;
        $isActive = isset($query['is_active'])
            ? filter_var($query['is_active'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
            : null;
        $page = max(1, (int)($query['page'] ?? 1));
        $limit = min(100, max(1, (int)($query['limit'] ?? 20)));

        try {
            $input = new GetRolesInput(
                tenantId: $tenantId,
                isActive: $isActive,
                page: $page,
                limit: $limit,
            );
        } catch (\InvalidArgumentException $e) {
            $this->sendError(400, $e->getMessage());

            return;
        }

        $output = (new GetRolesUseCase(new OrmRoleRepository()))->execute($input);

        $this->sendJson([
            'data' => array_map(fn($r) => $r->toArray(), $output->roles),
            'meta' => [
                'total' => $output->total,
                'page' => $output->page,
                'limit' => $output->limit,
                'pages' => $output->limit > 0 ? (int)ceil($output->total / $output->limit) : 1,
            ],
        ]);
    }

    /**
     * GET /api/business-users/v1/roles/enums
     *
     * Returns all canonical role codes from the BusinessRole and UserRole enums.
     * Useful for populating dropdowns without a DB round-trip.
     */
    public function enums(): void
    {
        $businessRoles = array_map(
            fn(BusinessRole $r) => [
                'code' => $r->value,
                'label' => $r->label(),
                'level' => $r->level(),
                'tenant_type' => $r->tenantType(),
            ],
            BusinessRole::cases(),
        );

        $userRoles = array_map(
            fn(UserRole $r) => [
                'code' => $r->value,
                'label' => $r->label(),
            ],
            UserRole::cases(),
        );

        $this->sendJson([
            'business_roles' => $businessRoles,
            'user_roles' => $userRoles,
        ]);
    }
}
