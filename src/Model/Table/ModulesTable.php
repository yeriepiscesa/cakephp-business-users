<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Modules Model
 *
 * @property \BusinessUsers\Model\Table\PermissionsTable&\Cake\ORM\Association\HasMany $Permissions
 * @property \BusinessUsers\Model\Table\TenantModulesTable&\Cake\ORM\Association\HasMany $TenantModules
 * @property \BusinessUsers\Model\Table\TenantUserModulesTable&\Cake\ORM\Association\HasMany $TenantUserModules
 *
 * @method \BusinessUsers\Model\Entity\Module newEmptyEntity()
 * @method \BusinessUsers\Model\Entity\Module newEntity(array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\Module> newEntities(array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\Module get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \BusinessUsers\Model\Entity\Module findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \BusinessUsers\Model\Entity\Module patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\Module> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\Module|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \BusinessUsers\Model\Entity\Module saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Module>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Module>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Module>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Module> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Module>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Module>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Module>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Module> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ModulesTable extends Table
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

        $this->setTable('business_users_modules');
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

        $this->hasMany('Permissions', [
            'foreignKey' => 'business_users_module_id',
            'className' => 'BusinessUsers.Permissions',
        ]);
        $this->hasMany('TenantModules', [
            'foreignKey' => 'business_users_module_id',
            'className' => 'BusinessUsers.TenantModules',
        ]);
        $this->hasMany('TenantUserModules', [
            'foreignKey' => 'business_users_module_id',
            'className' => 'BusinessUsers.TenantUserModules',
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
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('code')
            ->maxLength('code', 100)
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
