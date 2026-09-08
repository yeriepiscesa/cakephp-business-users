<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tenants Model
 *
 * @property \BusinessUsers\Model\Table\GroupsTable&\Cake\ORM\Association\HasMany $Groups
 * @property \BusinessUsers\Model\Table\RolesTable&\Cake\ORM\Association\HasMany $Roles
 * @property \BusinessUsers\Model\Table\TenantModulesTable&\Cake\ORM\Association\HasMany $TenantModules
 * @property \BusinessUsers\Model\Table\TenantUsersTable&\Cake\ORM\Association\HasMany $TenantUsers
 *
 * @method \BusinessUsers\Model\Entity\Tenant newEmptyEntity()
 * @method \BusinessUsers\Model\Entity\Tenant newEntity(array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\Tenant> newEntities(array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\Tenant get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \BusinessUsers\Model\Entity\Tenant findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \BusinessUsers\Model\Entity\Tenant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\Tenant> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\Tenant|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \BusinessUsers\Model\Entity\Tenant saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Tenant>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Tenant>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Tenant>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Tenant> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Tenant>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Tenant>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Tenant>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Tenant> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TenantsTable extends Table
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

        $this->setTable('business_users_tenants');
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

        $this->hasMany('Groups', [
            'foreignKey' => 'business_users_tenant_id',
            'className' => 'BusinessUsers.Groups',
        ]);
        $this->hasMany('Roles', [
            'foreignKey' => 'business_users_tenant_id',
            'className' => 'BusinessUsers.Roles',
        ]);
        $this->hasMany('TenantModules', [
            'foreignKey' => 'business_users_tenant_id',
            'className' => 'BusinessUsers.TenantModules',
        ]);
        $this->hasMany('TenantUsers', [
            'foreignKey' => 'business_users_tenant_id',
            'className' => 'BusinessUsers.TenantUsers',
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
            ->scalar('name')
            ->maxLength('name', 191)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('code')
            ->maxLength('code', 100)
            ->requirePresence('code', 'create')
            ->notEmptyString('code')
            ->add('code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->notEmptyString('status');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('settings')
            ->allowEmptyString('settings');

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
        $rules->add($rules->isUnique(['code']), ['errorField' => 'code']);

        return $rules;
    }
}
