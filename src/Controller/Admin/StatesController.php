<?php
declare(strict_types=1);

namespace BusinessUsers\Controller\Admin;

use BusinessUsers\Controller\CrudController;
use Cake\Event\EventInterface;

class StatesController extends CrudController
{
    protected ?string $defaultTable = 'BusinessUsers.States';

    protected array $paginate = ['limit' => 25];

    public function initialize(): void
    {
        parent::initialize();
        $this->Crud->action('Lookup')->setConfig('findMethod', 'lookup');
        $this->lookupView = 'tom_select';
    }

    public function index()
    {
        $this->Crud->on('beforePaginate', function (EventInterface $event): void {
            $event->getSubject()->query->contain(['Countries']);
            $countryIds = array_filter((array)$this->request->getQuery('country_id'), static fn($id) => is_scalar($id) && ctype_digit((string)$id) && (int)$id > 0);
            $countries = $countryIds ? $this->fetchTable('BusinessUsers.Countries')->find('list', keyField: 'id', valueField: 'nicename')
                ->where(['Countries.id IN' => array_values($countryIds)])->toArray() : [];
            $this->set('selectedCountries', $countries);
        });

        return $this->Crud->execute();
    }

    public function view($id = null)
    {
        $this->Crud->on('beforeFind', function (EventInterface $event): void {
            $event->getSubject()->query->contain(['Countries']);
        });

        return $this->Crud->execute();
    }

    public function edit($id = null)
    {
        $this->Crud->on('beforeFind', function (EventInterface $event): void {
            $event->getSubject()->query->contain(['Countries']);
        });

        return $this->Crud->execute();
    }
}
