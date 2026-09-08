<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TenantModules Model
 *
 * @property \BusinessUsers\Model\Table\TenantsTable&\Cake\ORM\Association\BelongsTo $Tenants
 * @property \BusinessUsers\Model\Table\ModulesTable&\Cake\ORM\Association\BelongsTo $Modules
 *
 * @method \BusinessUsers\Model\Entity\TenantModule newEmptyEntity()
 * @method \BusinessUsers\Model\Entity\TenantModule newEntity(array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\TenantModule> newEntities(array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\TenantModule get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \BusinessUsers\Model\Entity\TenantModule findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \BusinessUsers\Model\Entity\TenantModule patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\TenantModule> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\TenantModule|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \BusinessUsers\Model\Entity\TenantModule saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\TenantModule>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\TenantModule>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\TenantModule>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\TenantModule> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\TenantModule>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\TenantModule>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\TenantModule>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\TenantModule> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TenantModulesTable extends Table
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

        $this->setTable('business_users_tenant_modules');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('AuditStash.AuditLog', [
            'blacklist' => ['created', 'modified', 'created_by', 'modified_by'],
        ]);

        $this->belongsTo('Tenants', [
            'foreignKey' => 'business_users_tenant_id',
            'joinType' => 'INNER',
            'className' => 'BusinessUsers.Tenants',
        ]);
        $this->belongsTo('Modules', [
            'foreignKey' => 'business_users_module_id',
            'joinType' => 'INNER',
            'className' => 'BusinessUsers.Modules',
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
            ->integer('business_users_module_id')
            ->notEmptyString('business_users_module_id');

        $validator
            ->boolean('is_enabled')
            ->notEmptyString('is_enabled');

        $validator
            ->dateTime('starts_at')
            ->allowEmptyDateTime('starts_at');

        $validator
            ->dateTime('ends_at')
            ->allowEmptyDateTime('ends_at');

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
        $rules->add($rules->isUnique(['business_users_tenant_id', 'business_users_module_id']), ['errorField' => 'business_users_tenant_id', 'message' => __('This combination of business_users_tenant_id and business_users_module_id already exists')]);
        $rules->add($rules->existsIn(['business_users_tenant_id'], 'Tenants'), ['errorField' => 'business_users_tenant_id']);
        $rules->add($rules->existsIn(['business_users_module_id'], 'Modules'), ['errorField' => 'business_users_module_id']);

        return $rules;
    }
}
