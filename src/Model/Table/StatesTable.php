<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * States Model
 *
 * @property \BusinessUsers\Model\Table\CountriesTable&\Cake\ORM\Association\BelongsTo $Countries
 * @property \BusinessUsers\Model\Table\CitiesTable&\Cake\ORM\Association\HasMany $Cities
 *
 * @method \BusinessUsers\Model\Entity\State newEmptyEntity()
 * @method \BusinessUsers\Model\Entity\State newEntity(array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\State> newEntities(array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\State get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \BusinessUsers\Model\Entity\State findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \BusinessUsers\Model\Entity\State patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\State> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\State|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \BusinessUsers\Model\Entity\State saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\State>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\State>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\State>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\State> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\State>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\State>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\State>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\State> deleteManyOrFail(iterable $entities, array $options = [])
 */
class StatesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('states');
        $this->setEntityClass('BusinessUsers.State');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Search.Search');
        $this->getBehavior('Search')->searchManager()
            ->add('search', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardMode' => 'both',
                'fields' => ['name', 'state_code'],
            ]);

        $this->belongsTo('Countries', [
            'className' => 'BusinessUsers.Countries',
            'foreignKey' => 'country_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Cities', [
            'className' => 'BusinessUsers.Cities',
            'foreignKey' => 'state_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('country_id')
            ->notEmptyString('country_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('state_code')
            ->maxLength('state_code', 5)
            ->allowEmptyString('state_code');

        $validator
            ->scalar('longitude')
            ->maxLength('longitude', 20)
            ->allowEmptyString('longitude');

        $validator
            ->scalar('latitude')
            ->maxLength('latitude', 20)
            ->allowEmptyString('latitude');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['country_id'], 'Countries'), ['errorField' => 'country_id']);

        return $rules;
    }

    public function findLookup(SelectQuery $query): SelectQuery
    {
        return $query->contain([
            'Countries' => [
                'fields' => ['id', 'iso', 'nicename'],
            ],
        ]);
    }
}
