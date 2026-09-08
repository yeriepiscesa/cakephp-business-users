<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Countries Model
 *
 * @property \BusinessUsers\Model\Table\StatesTable&\Cake\ORM\Association\HasMany $States
 *
 * @method \BusinessUsers\Model\Entity\Country newEmptyEntity()
 * @method \BusinessUsers\Model\Entity\Country newEntity(array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\Country> newEntities(array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\Country get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \BusinessUsers\Model\Entity\Country findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \BusinessUsers\Model\Entity\Country patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\BusinessUsers\Model\Entity\Country> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \BusinessUsers\Model\Entity\Country|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \BusinessUsers\Model\Entity\Country saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Country>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Country>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Country>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Country> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Country>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Country>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\BusinessUsers\Model\Entity\Country>|\Cake\Datasource\ResultSetInterface<\BusinessUsers\Model\Entity\Country> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CountriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('countries');
        $this->setEntityClass('BusinessUsers.Country');
        $this->setDisplayField('nicename');
        $this->setPrimaryKey('id');

        $this->addBehavior('Search.Search');
        $this->getBehavior('Search')->searchManager()
            ->add('search', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardMode' => 'both',
                'fields' => ['iso', 'name', 'nicename'],
            ]);

        $this->hasMany('States', [
            'className' => 'BusinessUsers.States',
            'foreignKey' => 'country_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('iso')
            ->maxLength('iso', 2)
            ->requirePresence('iso', 'create')
            ->notEmptyString('iso');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('nicename')
            ->maxLength('nicename', 150)
            ->requirePresence('nicename', 'create')
            ->notEmptyString('nicename');

        $validator
            ->scalar('iso3')
            ->maxLength('iso3', 3)
            ->allowEmptyString('iso3');

        $validator
            ->integer('numcode')
            ->allowEmptyString('numcode');

        $validator
            ->integer('phonecode')
            ->requirePresence('phonecode', 'create')
            ->notEmptyString('phonecode');

        return $validator;
    }

    public function findLookup(SelectQuery $query): SelectQuery
    {
        return $query->select(['id', 'iso', 'nicename']);
    }
}
