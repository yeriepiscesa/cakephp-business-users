<?php
declare(strict_types=1);

use Migrations\BaseMigration;
use Migrations\Db\Table;

class CreateBusinessUsersAccessTables extends BaseMigration
{
    public function change(): void
    {
        $tenantsTable = $this->table('business_users_tenants');
        $this->addAuditColumns($tenantsTable)
            ->addColumn('name', 'string', [
                'limit' => 191,
                'null' => false,
            ])
            ->addColumn('code', 'string', [
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'limit' => 30,
                'default' => 'active',
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('settings', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->addIndex(['code'], [
                'unique' => true,
                'name' => 'UNQ_BUSINESS_USERS_TENANTS_CODE',
            ]);
        $this->addAuditForeignKeys($tenantsTable)->create();

        $modulesTable = $this->table('business_users_modules');
        $this->addAuditColumns($modulesTable)
            ->addColumn('name', 'string', [
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('code', 'string', [
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('is_active', 'boolean', [
                'default' => true,
                'null' => false,
            ])
            ->addColumn('sort_order', 'integer', [
                'default' => 0,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('settings', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->addIndex(['code'], [
                'unique' => true,
                'name' => 'UNQ_BUSINESS_USERS_MODULES_CODE',
            ]);
        $this->addAuditForeignKeys($modulesTable)->create();

        $permissionsTable = $this->table('business_users_permissions');
        $this->addAuditColumns($permissionsTable)
            ->addColumn('business_users_module_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('code', 'string', [
                'limit' => 191,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('is_active', 'boolean', [
                'default' => true,
                'null' => false,
            ])
            ->addColumn('sort_order', 'integer', [
                'default' => 0,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(['business_users_module_id'], [
                'name' => 'IDX_BUSINESS_USERS_PERMISSIONS_MODULE_ID',
            ])
            ->addIndex(['code'], [
                'unique' => true,
                'name' => 'UNQ_BUSINESS_USERS_PERMISSIONS_CODE',
            ])
            ->addForeignKey('business_users_module_id', 'business_users_modules', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]);
        $this->addAuditForeignKeys($permissionsTable)->create();

        $tenantUsersTable = $this->table('business_users_tenant_users');
        $this->addAuditColumns($tenantUsersTable)
            ->addColumn('business_users_tenant_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('user_id', 'uuid', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'limit' => 30,
                'default' => 'active',
                'null' => false,
            ])
            ->addColumn('is_owner', 'boolean', [
                'default' => false,
                'null' => false,
            ])
            ->addColumn('joined', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('metadata', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->addIndex(['business_users_tenant_id'], [
                'name' => 'IDX_BUSINESS_USERS_TENANT_USERS_TENANT_ID',
            ])
            ->addIndex(['user_id'], [
                'name' => 'IDX_BUSINESS_USERS_TENANT_USERS_USER_ID',
            ])
            ->addIndex(['business_users_tenant_id', 'user_id'], [
                'unique' => true,
                'name' => 'UNQ_BUSINESS_USERS_TENANT_USERS_TENANT_USER',
            ])
            ->addForeignKey('business_users_tenant_id', 'business_users_tenants', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('user_id', 'users', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]);
        $this->addAuditForeignKeys($tenantUsersTable)->create();

        $groupsTable = $this->table('business_users_groups');
        $this->addAuditColumns($groupsTable)
            ->addColumn('business_users_tenant_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('code', 'string', [
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('is_default', 'boolean', [
                'default' => false,
                'null' => false,
            ])
            ->addColumn('is_active', 'boolean', [
                'default' => true,
                'null' => false,
            ])
            ->addColumn('sort_order', 'integer', [
                'default' => 0,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(['business_users_tenant_id'], [
                'name' => 'IDX_BUSINESS_USERS_GROUPS_TENANT_ID',
            ])
            ->addIndex(['business_users_tenant_id', 'code'], [
                'unique' => true,
                'name' => 'UNQ_BUSINESS_USERS_GROUPS_TENANT_CODE',
            ])
            ->addForeignKey('business_users_tenant_id', 'business_users_tenants', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]);
        $this->addAuditForeignKeys($groupsTable)->create();

        $rolesTable = $this->table('business_users_roles');
        $this->addAuditColumns($rolesTable)
            ->addColumn('business_users_tenant_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('code', 'string', [
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('level', 'integer', [
                'default' => 1,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('is_default', 'boolean', [
                'default' => false,
                'null' => false,
            ])
            ->addColumn('is_active', 'boolean', [
                'default' => true,
                'null' => false,
            ])
            ->addColumn('sort_order', 'integer', [
                'default' => 0,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(['business_users_tenant_id'], [
                'name' => 'IDX_BUSINESS_USERS_ROLES_TENANT_ID',
            ])
            ->addIndex(['business_users_tenant_id', 'code'], [
                'unique' => true,
                'name' => 'UNQ_BUSINESS_USERS_ROLES_TENANT_CODE',
            ])
            ->addIndex(['business_users_tenant_id', 'level'], [
                'name' => 'IDX_BUSINESS_USERS_ROLES_TENANT_LEVEL',
            ])
            ->addForeignKey('business_users_tenant_id', 'business_users_tenants', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]);
        $this->addAuditForeignKeys($rolesTable)->create();

        $tenantModulesTable = $this->table('business_users_tenant_modules');
        $this->addAuditColumns($tenantModulesTable)
            ->addColumn('business_users_tenant_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('business_users_module_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('is_enabled', 'boolean', [
                'default' => true,
                'null' => false,
            ])
            ->addColumn('starts_at', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('ends_at', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('settings', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->addIndex(['business_users_tenant_id', 'business_users_module_id'], [
                'unique' => true,
                'name' => 'UNQ_BUSINESS_USERS_TENANT_MODULES_TENANT_MODULE',
            ])
            ->addForeignKey('business_users_tenant_id', 'business_users_tenants', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('business_users_module_id', 'business_users_modules', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]);
        $this->addAuditForeignKeys($tenantModulesTable)->create();

        $rolePermissionsTable = $this->table('business_users_role_permissions');
        $this->addAuditColumns($rolePermissionsTable)
            ->addColumn('business_users_role_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('business_users_permission_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(['business_users_role_id', 'business_users_permission_id'], [
                'unique' => true,
                'name' => 'UNQ_BUSINESS_USERS_ROLE_PERMISSIONS_ROLE_PERMISSION',
            ])
            ->addForeignKey('business_users_role_id', 'business_users_roles', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('business_users_permission_id', 'business_users_permissions', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]);
        $this->addAuditForeignKeys($rolePermissionsTable)->create();

        $tenantUserRolesTable = $this->table('business_users_tenant_user_roles');
        $this->addAuditColumns($tenantUserRolesTable)
            ->addColumn('business_users_tenant_user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('business_users_role_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(['business_users_tenant_user_id', 'business_users_role_id'], [
                'unique' => true,
                'name' => 'UNQ_BUSINESS_USERS_TENANT_USER_ROLES_USER_ROLE',
            ])
            ->addForeignKey('business_users_tenant_user_id', 'business_users_tenant_users', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('business_users_role_id', 'business_users_roles', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]);
        $this->addAuditForeignKeys($tenantUserRolesTable)->create();

        $groupMembersTable = $this->table('business_users_group_members');
        $this->addAuditColumns($groupMembersTable)
            ->addColumn('business_users_group_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('business_users_tenant_user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(['business_users_group_id', 'business_users_tenant_user_id'], [
                'unique' => true,
                'name' => 'UNQ_BUSINESS_USERS_GROUP_MEMBERS_GROUP_USER',
            ])
            ->addForeignKey('business_users_group_id', 'business_users_groups', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('business_users_tenant_user_id', 'business_users_tenant_users', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]);
        $this->addAuditForeignKeys($groupMembersTable)->create();

        $groupRolesTable = $this->table('business_users_group_roles');
        $this->addAuditColumns($groupRolesTable)
            ->addColumn('business_users_group_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('business_users_role_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(['business_users_group_id', 'business_users_role_id'], [
                'unique' => true,
                'name' => 'UNQ_BUSINESS_USERS_GROUP_ROLES_GROUP_ROLE',
            ])
            ->addForeignKey('business_users_group_id', 'business_users_groups', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('business_users_role_id', 'business_users_roles', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]);
        $this->addAuditForeignKeys($groupRolesTable)->create();

        $tenantUserModulesTable = $this->table('business_users_tenant_user_modules');
        $this->addAuditColumns($tenantUserModulesTable)
            ->addColumn('business_users_tenant_user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('business_users_module_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('is_granted', 'boolean', [
                'default' => true,
                'null' => false,
            ])
            ->addIndex(['business_users_tenant_user_id', 'business_users_module_id'], [
                'unique' => true,
                'name' => 'UNQ_BUSINESS_USERS_TENANT_USER_MODULES_USER_MODULE',
            ])
            ->addForeignKey('business_users_tenant_user_id', 'business_users_tenant_users', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('business_users_module_id', 'business_users_modules', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]);
        $this->addAuditForeignKeys($tenantUserModulesTable)->create();

        $tenantUserPermissionsTable = $this->table('business_users_tenant_user_permissions');
        $this->addAuditColumns($tenantUserPermissionsTable)
            ->addColumn('business_users_tenant_user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('business_users_permission_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('effect', 'string', [
                'limit' => 10,
                'default' => 'allow',
                'null' => false,
            ])
            ->addIndex(['business_users_tenant_user_id', 'business_users_permission_id'], [
                'unique' => true,
                'name' => 'UNQ_BUSINESS_USERS_TENANT_USER_PERMS_USER_PERMISSION',
            ])
            ->addForeignKey('business_users_tenant_user_id', 'business_users_tenant_users', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('business_users_permission_id', 'business_users_permissions', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]);
        $this->addAuditForeignKeys($tenantUserPermissionsTable)->create();
    }

    private function addAuditColumns(Table $table): Table
    {
        return $table
            ->addColumn('created', 'datetime', [
                'null' => false,
            ])
            ->addColumn('created_by', 'uuid', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'null' => false,
            ])
            ->addColumn('modified_by', 'uuid', [
                'default' => null,
                'null' => true,
            ]);
    }

    private function addAuditForeignKeys(Table $table): Table
    {
        return $table
            ->addForeignKey('created_by', 'users', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('modified_by', 'users', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'CASCADE',
            ]);
    }
}