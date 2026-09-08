<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Table;

use BusinessUsers\Domain\Enum\BusinessRole;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Roles Model
 *
 * @property \BusinessUsers\Model\Table\TenantsTable&\Cake\ORM\Association\BelongsTo $Tenants
 * @property \BusinessUsers\Model\Table\GroupRolesTable&\Cake\ORM\Association\HasMany $GroupRoles
 * @property \BusinessUsers\Model\Table\RolePermissionsTable&\Cake\ORM\Association\HasMany $RolePermissions
 * @property \BusinessUsers\Model\Table\TenantUserRolesTable&\Cake\ORM\Association\HasMany $TenantUserRoles
 *
 * @method \BusinessUsers\Model\Entity\Role newEmptyEntity()
 * @method \BusinessUsers\Model\Entity\Role newEntity(array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\Role> newEntities(array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\Role get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \BusinessUsers\Model\Entity\Role findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \BusinessUsers\Model\Entity\Role patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\Role> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\Role|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \BusinessUsers\Model\Entity\Role saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Role>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Role>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Role>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Role> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Role>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Role>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Role>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Role> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RolesTable extends Table
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

        $this->setTable('business_users_roles');
        $this->setDisplayField('name');
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
                'fields' => ['name', 'code'],
            ]);

        $this->belongsTo('Tenants', [
            'foreignKey' => 'business_users_tenant_id',
            'joinType' => 'INNER',
            'className' => 'BusinessUsers.Tenants',
        ]);
        $this->hasMany('GroupRoles', [
            'foreignKey' => 'business_users_role_id',
            'className' => 'BusinessUsers.GroupRoles',
        ]);
        $this->hasMany('RolePermissions', [
            'foreignKey' => 'business_users_role_id',
            'className' => 'BusinessUsers.RolePermissions',
        ]);
        $this->hasMany('TenantUserRoles', [
            'foreignKey' => 'business_users_role_id',
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
            ->scalar('name')
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $canonicalCodes = array_map(fn(BusinessRole $r) => $r->value, BusinessRole::cases());

        $validator
            ->scalar('code')
            ->maxLength('code', 100)
            ->requirePresence('code', 'create')
            ->notEmptyString('code')
            ->add('code', 'canonicalCode', [
                'rule' => function (string $value) use ($canonicalCodes): bool {
                    // Allow custom codes; only warn when the code is close to but
                    // not matching a canonical code. Returns true to permit saving.
                    return true;
                },
                'message' => __('Role code should ideally match a canonical BusinessRole value.'),
            ]);

        $validator
            ->integer('level')
            ->notEmptyString('level');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->boolean('is_default')
            ->notEmptyString('is_default');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        $validator
            ->integer('sort_order')
            ->notEmptyString('sort_order');

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
        $rules->add($rules->isUnique(['business_users_tenant_id', 'code']), ['errorField' => 'business_users_tenant_id', 'message' => __('This combination of business_users_tenant_id and code already exists')]);
        $rules->add($rules->existsIn(['business_users_tenant_id'], 'Tenants'), ['errorField' => 'business_users_tenant_id']);

        return $rules;
    }
}
