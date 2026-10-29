<?php
declare(strict_types=1);

namespace BusinessUsers\Controller\Admin;

use BusinessUsers\Controller\CrudController;
use Cake\Event\EventInterface;

class CitiesController extends CrudController
{
    protected ?string $defaultTable = 'BusinessUsers.Cities';

    public function initialize(): void
    {
        parent::initialize();
        $this->Crud->action('Lookup')->setConfig('findMethod', 'lookup');
        $this->lookupView = 'tom_select';
    }

    public function index()
    {
        $this->Crud->on('beforePaginate', function (EventInterface $event): void {
            $event->getSubject()->query->contain(['States' => ['Countries']]);
            $countryIds = array_filter((array)$this->request->getQuery('country_id'), static fn($id) => is_scalar($id) && ctype_digit((string)$id) && (int)$id > 0);
            $countries = $countryIds ? $this->fetchTable('BusinessUsers.Countries')->find('list', keyField: 'id', valueField: 'nicename')
                ->where(['Countries.id IN' => array_values($countryIds)])->toArray() : [];
            $stateIds = array_filter((array)$this->request->getQuery('state_id'), static fn($id) => is_scalar($id) && ctype_digit((string)$id) && (int)$id > 0);
            $states = [];
            if ($stateIds) {
                foreach ($this->fetchTable('BusinessUsers.States')->find()->contain(['Countries'])
                    ->where(['States.id IN' => array_values($stateIds)]) as $state) {
                    $states[$state->id] = implode(', ', array_filter([$state->name, $state->country?->nicename]));
                }
            }
            $this->set(['selectedCountries' => $countries, 'selectedStates' => $states]);
        });

        return $this->Crud->execute();
    }

    public function view($id = null)
    {
        $this->Crud->on('beforeFind', function (EventInterface $event): void {
            $event->getSubject()->query->contain(['States' => ['Countries']]);
        });

        return $this->Crud->execute();
    }

    public function edit($id = null)
    {
        $this->Crud->on('beforeFind', function (EventInterface $event): void {
            $event->getSubject()->query->contain(['States' => ['Countries']]);
        });

        return $this->Crud->execute();
    }
}
