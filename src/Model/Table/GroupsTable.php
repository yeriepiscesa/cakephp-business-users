<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Groups Model
 *
 * @property \BusinessUsers\Model\Table\TenantsTable&\Cake\ORM\Association\BelongsTo $Tenants
 * @property \BusinessUsers\Model\Table\GroupMembersTable&\Cake\ORM\Association\HasMany $GroupMembers
 * @property \BusinessUsers\Model\Table\GroupRolesTable&\Cake\ORM\Association\HasMany $GroupRoles
 *
 * @method \BusinessUsers\Model\Entity\Group newEmptyEntity()
 * @method \BusinessUsers\Model\Entity\Group newEntity(array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\Group> newEntities(array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\Group get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \BusinessUsers\Model\Entity\Group findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \BusinessUsers\Model\Entity\Group patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\Group> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\Group|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \BusinessUsers\Model\Entity\Group saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Group>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Group>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Group>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Group> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Group>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Group>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Group>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Group> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GroupsTable extends Table
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

        $this->setTable('business_users_groups');
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
        $this->hasMany('GroupMembers', [
            'foreignKey' => 'business_users_group_id',
            'className' => 'BusinessUsers.GroupMembers',
        ]);
        $this->hasMany('GroupRoles', [
            'foreignKey' => 'business_users_group_id',
            'className' => 'BusinessUsers.GroupRoles',
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

        $validator
            ->scalar('code')
            ->maxLength('code', 100)
            ->requirePresence('code', 'create')
            ->notEmptyString('code');

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
