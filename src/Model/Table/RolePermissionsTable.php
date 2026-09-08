<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RolePermissions Model
 *
 * @property \BusinessUsers\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @property \BusinessUsers\Model\Table\PermissionsTable&\Cake\ORM\Association\BelongsTo $Permissions
 *
 * @method \BusinessUsers\Model\Entity\RolePermission newEmptyEntity()
 * @method \BusinessUsers\Model\Entity\RolePermission newEntity(array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\RolePermission> newEntities(array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\RolePermission get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \BusinessUsers\Model\Entity\RolePermission findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \BusinessUsers\Model\Entity\RolePermission patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\RolePermission> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\RolePermission|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \BusinessUsers\Model\Entity\RolePermission saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\RolePermission>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\RolePermission>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\RolePermission>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\RolePermission> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\RolePermission>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\RolePermission>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\RolePermission>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\RolePermission> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RolePermissionsTable extends Table
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

        $this->setTable('business_users_role_permissions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('AuditStash.AuditLog', [
            'blacklist' => ['created', 'modified', 'created_by', 'modified_by'],
        ]);

        $this->belongsTo('Roles', [
            'foreignKey' => 'business_users_role_id',
            'joinType' => 'INNER',
            'className' => 'BusinessUsers.Roles',
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
            ->integer('business_users_role_id')
            ->notEmptyString('business_users_role_id');

        $validator
            ->integer('business_users_permission_id')
            ->notEmptyString('business_users_permission_id');

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
        $rules->add($rules->isUnique(['business_users_role_id', 'business_users_permission_id']), ['errorField' => 'business_users_role_id', 'message' => __('This combination of business_users_role_id and business_users_permission_id already exists')]);
        $rules->add($rules->existsIn(['business_users_role_id'], 'Roles'), ['errorField' => 'business_users_role_id']);
        $rules->add($rules->existsIn(['business_users_permission_id'], 'Permissions'), ['errorField' => 'business_users_permission_id']);

        return $rules;
    }
}
