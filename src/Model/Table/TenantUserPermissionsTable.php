<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TenantUserPermissions Model
 *
 * @property \BusinessUsers\Model\Table\TenantUsersTable&\Cake\ORM\Association\BelongsTo $TenantUsers
 * @property \BusinessUsers\Model\Table\PermissionsTable&\Cake\ORM\Association\BelongsTo $Permissions
 *
 * @method \BusinessUsers\Model\Entity\TenantUserPermission newEmptyEntity()
 * @method \BusinessUsers\Model\Entity\TenantUserPermission newEntity(array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\TenantUserPermission> newEntities(array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\TenantUserPermission get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \BusinessUsers\Model\Entity\TenantUserPermission findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \BusinessUsers\Model\Entity\TenantUserPermission patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\TenantUserPermission> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\TenantUserPermission|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \BusinessUsers\Model\Entity\TenantUserPermission saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\TenantUserPermission>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\TenantUserPermission>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\TenantUserPermission>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\TenantUserPermission> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\TenantUserPermission>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\TenantUserPermission>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\TenantUserPermission>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\TenantUserPermission> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TenantUserPermissionsTable extends Table
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

        $this->setTable('business_users_tenant_user_permissions');
        $this->setDisplayField('effect');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('AuditStash.AuditLog', [
            'blacklist' => ['created', 'modified', 'created_by', 'modified_by'],
        ]);

        $this->belongsTo('TenantUsers', [
            'foreignKey' => 'business_users_tenant_user_id',
            'joinType' => 'INNER',
            'className' => 'BusinessUsers.TenantUsers',
        ]);
        $this->belongsTo('Permissions', [
            'foreignKey' => 'business_users_permission_id',
            'joinType' => 'INNER',
            'className' => 'BusinessUsers.Permissions',
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
            ->integer('business_users_tenant_user_id')
            ->notEmptyString('business_users_tenant_user_id');

        $validator
            ->integer('business_users_permission_id')
            ->notEmptyString('business_users_permission_id');

        $validator
            ->scalar('effect')
            ->maxLength('effect', 10)
            ->notEmptyString('effect');

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
        $rules->add($rules->isUnique(['business_users_tenant_user_id', 'business_users_permission_id']), ['errorField' => 'business_users_tenant_user_id', 'message' => __('This combination of business_users_tenant_user_id and business_users_permission_id already exists')]);
        $rules->add($rules->existsIn(['business_users_tenant_user_id'], 'TenantUsers'), ['errorField' => 'business_users_tenant_user_id']);
        $rules->add($rules->existsIn(['business_users_permission_id'], 'Permissions'), ['errorField' => 'business_users_permission_id']);

        return $rules;
    }
}
