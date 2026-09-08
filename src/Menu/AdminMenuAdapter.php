<?php
declare(strict_types=1);

namespace BusinessUsers\Menu;

class AdminMenuAdapter
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function getAdminMenuItems(): array
    {
        return [
            [
                'id' => 'business_users',
                'label' => __('Business Users'),
                'route' => '#',
                'icon' => 'users',
                'children' => [
                    [
                        'id' => 'business_users_tenants',
                        'label' => __('Tenants'),
                        'route' => [
                            'plugin' => 'BusinessUsers',
                            'prefix' => 'Admin',
                            'controller' => 'Tenants',
                            'action' => 'index',
                        ],
                        'auth' => ['plugin' => 'BusinessUsers', 'controller' => 'Tenants'],
                    ],
                    [
                        'id' => 'business_users_tenant_users',
                        'label' => __('Tenant Users'),
                        'route' => [
                            'plugin' => 'BusinessUsers',
                            'prefix' => 'Admin',
                            'controller' => 'TenantUsers',
                            'action' => 'index',
                        ],
                        'auth' => ['plugin' => 'BusinessUsers', 'controller' => 'TenantUsers'],
                    ],
                    [
                        'id' => 'business_users_groups',
                        'label' => __('Groups'),
                        'route' => [
                            'plugin' => 'BusinessUsers',
                            'prefix' => 'Admin',
                            'controller' => 'Groups',
                            'action' => 'index',
                        ],
                        'auth' => ['plugin' => 'BusinessUsers', 'controller' => 'Groups'],
                    ],
                    [
                        'id' => 'business_users_roles',
                        'label' => __('Roles'),
                        'route' => [
                            'plugin' => 'BusinessUsers',
                            'prefix' => 'Admin',
                            'controller' => 'Roles',
                            'action' => 'index',
                        ],
                        'auth' => ['plugin' => 'BusinessUsers', 'controller' => 'Roles'],
                    ],
                    [
                        'id' => 'business_users_modules',
                        'label' => __('Modules'),
                        'route' => [
                            'plugin' => 'BusinessUsers',
                            'prefix' => 'Admin',
                            'controller' => 'Modules',
                            'action' => 'index',
                        ],
                        'auth' => ['plugin' => 'BusinessUsers', 'controller' => 'Modules'],
                    ],
                    [
                        'id' => 'business_users_permissions',
                        'label' => __('Permissions'),
                        'route' => [
                            'plugin' => 'BusinessUsers',
                            'prefix' => 'Admin',
                            'controller' => 'Permissions',
                            'action' => 'index',
                        ],
                        'auth' => ['plugin' => 'BusinessUsers', 'controller' => 'Permissions'],
                    ],
                ],
            ],
            [
                'id' => 'regions',
                'label' => __('Regions'),
                'route' => '#',
                'icon' => 'world',
                'auth' => [
                    'roles' => ['superuser', 'superadmin'],
                    'superuser' => true,
                ],
                'children' => [
                    [
                        'id' => 'regions_countries',
                        'label' => __('Countries'),
                        'route' => [
                            'plugin' => 'BusinessUsers',
                            'prefix' => 'Admin',
                            'controller' => 'Countries',
                            'action' => 'index',
                        ],
                        'auth' => [
                            'roles' => ['superuser', 'superadmin'],
                            'superuser' => true,
                        ],
                    ],
                    [
                        'id' => 'regions_states',
                        'label' => __('States'),
                        'route' => [
                            'plugin' => 'BusinessUsers',
                            'prefix' => 'Admin',
                            'controller' => 'States',
                            'action' => 'index',
                        ],
                        'auth' => [
                            'roles' => ['superuser', 'superadmin'],
                            'superuser' => true,
                        ],
                    ],
                    [
                        'id' => 'regions_cities',
                        'label' => __('Cities'),
                        'route' => [
                            'plugin' => 'BusinessUsers',
                            'prefix' => 'Admin',
                            'controller' => 'Cities',
                            'action' => 'index',
                        ],
                        'auth' => [
                            'roles' => ['superuser', 'superadmin'],
                            'superuser' => true,
                        ],
                    ],
                ],
            ],
        ];
    }
}
