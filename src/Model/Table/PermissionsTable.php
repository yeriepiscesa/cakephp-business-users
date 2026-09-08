<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Permissions Model
 *
 * @property \BusinessUsers\Model\Table\ModulesTable&\Cake\ORM\Association\BelongsTo $Modules
 * @property \BusinessUsers\Model\Table\RolePermissionsTable&\Cake\ORM\Association\HasMany $RolePermissions
 * @property \BusinessUsers\Model\Table\TenantUserPermissionsTable&\Cake\ORM\Association\HasMany $TenantUserPermissions
 *
 * @method \BusinessUsers\Model\Entity\Permission newEmptyEntity()
 * @method \BusinessUsers\Model\Entity\Permission newEntity(array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\Permission> newEntities(array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\Permission get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \BusinessUsers\Model\Entity\Permission findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \BusinessUsers\Model\Entity\Permission patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\Permission> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\Permission|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \BusinessUsers\Model\Entity\Permission saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Permission>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Permission>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Permission>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Permission> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Permission>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Permission>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Permission>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Permission> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PermissionsTable extends Table
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

        $this->setTable('business_users_permissions');
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

        $this->belongsTo('Modules', [
            'foreignKey' => 'business_users_module_id',
            'joinType' => 'INNER',
            'className' => 'BusinessUsers.Modules',
        ]);
        $this->hasMany('RolePermissions', [
            'foreignKey' => 'business_users_permission_id',
            'className' => 'BusinessUsers.RolePermissions',
        ]);
        $this->hasMany('TenantUserPermissions', [
            'foreignKey' => 'business_users_permission_id',
            'className' => 'BusinessUsers.TenantUserPermissions',
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
            ->integer('business_users_module_id')
            ->notEmptyString('business_users_module_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('code')
            ->maxLength('code', 191)
            ->requirePresence('code', 'create')
            ->notEmptyString('code')
            ->add('code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

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
        $rules->add($rules->isUnique(['code']), ['errorField' => 'code']);
        $rules->add($rules->existsIn(['business_users_module_id'], 'Modules'), ['errorField' => 'business_users_module_id']);

        return $rules;
    }
}
