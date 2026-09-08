<?php
declare(strict_types=1);

namespace BusinessUsers;

use BusinessUsers\Controller\Admin\UsersController;
use BusinessUsers\Application\Port\PlatformUserRepositoryInterface;
use BusinessUsers\Application\Port\UserRoleProviderInterface;
use BusinessUsers\Application\UseCase\UpdateUserRole\UpdateUserRoleUseCase;
use BusinessUsers\Domain\Repository\TenantUserRepositoryInterface;
use BusinessUsers\Infrastructure\Adapter\EnumUserRoleProvider;
use BusinessUsers\Infrastructure\Repository\OrmPlatformUserRepository;
use BusinessUsers\Infrastructure\Repository\OrmTenantUserRepository;
use Cake\Console\CommandCollection;
use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Route\DashedRoute;

/**
 * Plugin for BusinessUsers
 */
class BusinessUsersPlugin extends BasePlugin
{
    /**
     * Load all the plugin configuration and bootstrap logic.
     *
     * The host application is provided as an argument. This allows you to load
     * additional plugin dependencies, or attach events.
     *
     * @param \Cake\Core\PluginApplicationInterface $app The host application
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        $adapters = (array)Configure::read('Menu.adminAdapters', []);
        $adapters[] = \BusinessUsers\Menu\AdminMenuAdapter::class;
        Configure::write('Menu.adminAdapters', array_values(array_unique($adapters)));

        $locator = TableRegistry::getTableLocator();
        foreach (['Users', 'CakeDC/Users.Users'] as $modelKey) {
            $locator->setConfig($modelKey, ['className' => 'BusinessUsers.Users']);
        }

        if (!$app->getPlugins()->has('CakeDC/Users')) {
            $extra = (array)Configure::read('Users.config');
            Configure::write('Users.config', array_values(array_unique(array_merge(
                ['BusinessUsers.users'],
                $extra,
            ))));
            $app->addPlugin(\CakeDC\Users\Plugin::class);
        }
    }

    /**
     * Add routes for the plugin.
     *
     * If your plugin has many routes and you would like to isolate them into a separate file,
     * you can create `$plugin/config/routes.php` and delete this method.
     *
     * @param \Cake\Routing\RouteBuilder $routes The route builder to update.
     * @return void
     */
    public function routes(RouteBuilder $routes): void
    {
        // Plugin frontend routes
        $routes->plugin(
            'BusinessUsers',
            ['path' => '/business-users'],
            function (RouteBuilder $builder) {
                $builder->fallbacks();
            }
        );

        // Plugin admin routes under /admin/business-users/*
        $routes->scope(
            '/admin/business-users',
            ['plugin' => 'BusinessUsers', 'prefix' => 'Admin'],
            function (RouteBuilder $builder): void {
                $builder->setExtensions(['json', 'xml']);
                $builder->fallbacks(DashedRoute::class);
            }
        );

        // Public CakeDC/Users routes (dashed URLs)
        $routes->scope('/', function (RouteBuilder $builder): void {
            $builder->connect('/users/register', ['controller' => 'Users', 'action' => 'register', 'plugin' => 'CakeDC/Users']);
            $builder->connect('/users/login', ['controller' => 'Users', 'action' => 'login', 'plugin' => 'CakeDC/Users']);
            $builder->connect('/users/logout', ['controller' => 'Users', 'action' => 'logout', 'plugin' => 'CakeDC/Users']);
            $builder->connect('/users/request-reset-password', ['controller' => 'Users', 'action' => 'requestResetPassword', 'plugin' => 'CakeDC/Users']);
            $builder->connect('/users/request-login-link', ['controller' => 'Users', 'action' => 'requestLoginLink', 'plugin' => 'CakeDC/Users']);
        });

        // CakeDC/Users admin wrapper at /admin/users/*
        $routes->scope(
            '/admin/users',
            ['plugin' => 'BusinessUsers', 'prefix' => 'Admin', 'controller' => 'Users'],
            function (RouteBuilder $builder): void {
                $builder->setExtensions(['json', 'xml']);
                $builder->connect('/change-password/{id}', ['action' => 'changePassword'], ['pass' => ['id']]);
                $builder->connect('/reset-one-time-password-authenticator/{id}', ['action' => 'resetOneTimePasswordAuthenticator'], ['pass' => ['id']]);
                $builder->connect('/update-role/{id}', ['action' => 'updateRole'], ['pass' => ['id']]);
                $builder->connect('/', ['action' => 'index']);
                $builder->connect('/{action}/*', []);
            }
        );

        // REST API v1 routes under /api/business-users/v1/*
        $routes->scope(
            '/api/business-users/v1',
            ['plugin' => 'BusinessUsers', 'prefix' => 'Api/V1'],
            function (RouteBuilder $builder): void {
                $builder->setExtensions(['json']);

                // GET /api/business-users/v1/roles/enums  (must be before /roles to avoid ambiguity)
                $builder->get('/roles/enums', ['controller' => 'Roles', 'action' => 'enums']);
                // GET /api/business-users/v1/roles
                $builder->get('/roles', ['controller' => 'Roles', 'action' => 'index']);
            }
        );

        parent::routes($routes);
    }

    /**
     * Add middleware for the plugin.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to update.
     * @return \Cake\Http\MiddlewareQueue
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        // Add your middlewares here
        $middlewareQueue->add(new \BusinessUsers\Middleware\BeforeLoginMiddleware());

        return $middlewareQueue;
    }

    /**
     * Add commands for the plugin.
     *
     * @param \Cake\Console\CommandCollection $commands The command collection to update.
     * @return \Cake\Console\CommandCollection
     */
    public function console(CommandCollection $commands): CommandCollection
    {
        // Add your commands here
        // remove this method hook if you don't need it

        $commands = parent::console($commands);

        return $commands;
    }

    /**
     * Register application container services.
     *
     * @param \Cake\Core\ContainerInterface $container The Container to update.
     * @return void
     * @link https://book.cakephp.org/5/en/development/dependency-injection.html#dependency-injection
     */
    public function services(ContainerInterface $container): void
    {
        // --- Cross-plugin ports (consumers depend on these interfaces only) ---

        // UserRoleProvider: returns platform role options for select inputs.
        $container->addShared(UserRoleProviderInterface::class, EnumUserRoleProvider::class);

        // PlatformUserRepository: low-level user-record operations.
        $container->addShared(PlatformUserRepositoryInterface::class, OrmPlatformUserRepository::class);

        // TenantUserRepository: membership lookup for cross-plugin consumers.
        $container->addShared(TenantUserRepositoryInterface::class, OrmTenantUserRepository::class);

        // UpdateUserRole use case (injected into BusinessUsers\Controller\Admin\UsersController).
        $container->addShared(UpdateUserRoleUseCase::class)
            ->addArgument(PlatformUserRepositoryInterface::class);

        $container->add(UsersController::class)
            ->addArgument(ServerRequest::class)
            ->addArgument(UserRoleProviderInterface::class)
            ->addArgument(UpdateUserRoleUseCase::class);
    }
}
