<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cities Model
 *
 * @property \BusinessUsers\Model\Table\StatesTable&\Cake\ORM\Association\BelongsTo $States
 *
 * @method \BusinessUsers\Model\Entity\City newEmptyEntity()
 * @method \BusinessUsers\Model\Entity\City newEntity(array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\City> newEntities(array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\City get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \BusinessUsers\Model\Entity\City findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \BusinessUsers\Model\Entity\City patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\City> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\City|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \BusinessUsers\Model\Entity\City saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\City>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\City>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\City>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\City> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\City>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\City>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\City>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\City> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CitiesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('cities');
        $this->setEntityClass('BusinessUsers.City');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

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
                'fields' => ['name'],
            ]);

        $this->belongsTo('States', [
            'className' => 'BusinessUsers.States',
            'foreignKey' => 'state_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('state_id')
            ->notEmptyString('state_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('latitude')
            ->maxLength('latitude', 20)
            ->allowEmptyString('latitude');

        $validator
            ->scalar('longitude')
            ->maxLength('longitude', 20)
            ->allowEmptyString('longitude');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['state_id'], 'States'), ['errorField' => 'state_id']);

        return $rules;
    }

    public function findLookup(SelectQuery $query): SelectQuery
    {
        return $query->contain([
            'States' => [
                'fields' => ['id', 'name', 'state_code'],
                'Countries' => [
                    'fields' => ['id', 'iso', 'nicename'],
                ],
            ],
        ]);
    }
}
