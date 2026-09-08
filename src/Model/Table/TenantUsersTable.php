<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TenantUsers Model
 *
 * @property \BusinessUsers\Model\Table\TenantsTable&\Cake\ORM\Association\BelongsTo $Tenants
 * @property \CakeDC\Users\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \BusinessUsers\Model\Table\GroupMembersTable&\Cake\ORM\Association\HasMany $GroupMembers
 * @property \BusinessUsers\Model\Table\TenantUserModulesTable&\Cake\ORM\Association\HasMany $TenantUserModules
 * @property \BusinessUsers\Model\Table\TenantUserPermissionsTable&\Cake\ORM\Association\HasMany $TenantUserPermissions
 * @property \BusinessUsers\Model\Table\TenantUserRolesTable&\Cake\ORM\Association\HasMany $TenantUserRoles
 *
 * @method \BusinessUsers\Model\Entity\TenantUser newEmptyEntity()
 * @method \BusinessUsers\Model\Entity\TenantUser newEntity(array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\TenantUser> newEntities(array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\TenantUser get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \BusinessUsers\Model\Entity\TenantUser findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \BusinessUsers\Model\Entity\TenantUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\TenantUser> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\TenantUser|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \BusinessUsers\Model\Entity\TenantUser saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\TenantUser>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\TenantUser>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\TenantUser>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\TenantUser> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\TenantUser>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\TenantUser>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\TenantUser>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\TenantUser> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TenantUsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('business_users_tenant_users');
        $this->setDisplayField('status');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('AuditStash.AuditLog', [
            'blacklist' => ['created', 'modified', 'created_by', 'modified_by'],
        ]);

        $this->addBehavior('Search.Search');
        /** @var \Search\Model\Behavior\SearchBehavior $searchBehavior */
        $searchBehavior = $this->getBehavior('Search');
        $searchBehavior->searchManager()
            ->add('search', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardMode' => 'both',
                'fields' => ['user_id', 'status'],
            ]);

        $this->belongsTo('Tenants', [
            'foreignKey' => 'business_users_tenant_id',
            'joinType' => 'INNER',
            'className' => 'BusinessUsers.Tenants',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'CakeDC/Users.Users',
        ]);
        $this->hasMany('GroupMembers', [
            'foreignKey' => 'business_users_tenant_user_id',
            'className' => 'BusinessUsers.GroupMembers',
        ]);
        $this->hasMany('TenantUserModules', [
            'foreignKey' => 'business_users_tenant_user_id',
            'className' => 'BusinessUsers.TenantUserModules',
        ]);
        $this->hasMany('TenantUserPermissions', [
            'foreignKey' => 'business_users_tenant_user_id',
            'className' => 'BusinessUsers.TenantUserPermissions',
        ]);
        $this->hasMany('TenantUserRoles', [
            'foreignKey' => 'business_users_tenant_user_id',
            'className' => 'BusinessUsers.TenantUserRoles',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->uuid('created_by')
            ->allowEmptyString('created_by');

        $validator
            ->uuid('modified_by')
            ->allowEmptyString('modified_by');

        $validator
            ->integer('business_users_tenant_id')
            ->notEmptyString('business_users_tenant_id');

        $validator
            ->uuid('user_id')
            ->notEmptyString('user_id');

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->notEmptyString('status');

        $validator
            ->boolean('is_owner')
            ->notEmptyString('is_owner');

        $validator
            ->dateTime('joined')
            ->allowEmptyDateTime('joined');

        $validator
            ->scalar('metadata')
            ->allowEmptyString('metadata');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['business_users_tenant_id', 'user_id']), ['errorField' => 'business_users_tenant_id', 'message' => __('This combination of business_users_tenant_id and user_id already exists')]);
        $rules->add($rules->existsIn(['business_users_tenant_id'], 'Tenants'), ['errorField' => 'business_users_tenant_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
