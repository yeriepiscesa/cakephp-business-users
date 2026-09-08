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
