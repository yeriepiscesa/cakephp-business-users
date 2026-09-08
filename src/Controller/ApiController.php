<?php
declare(strict_types=1);

namespace BusinessUsers\Controller;

use CrudConnect\Controller\ApiController as BaseApiController;

/**
 * BusinessUsers plugin API controller.
 *
 * Thin extension of the application-level ApiController so that BusinessUsers
 * API controllers pick up the shared JSON view / envelope behaviour while
 * remaining scoped to the plugin namespace.
 *
 * All logic lives in CrudConnect\Controller\ApiController — add plugin-specific
 * API middleware or helpers here only if needed.
 */
class ApiController extends BaseApiController
{
}
