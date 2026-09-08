<?php
declare(strict_types=1);

namespace BusinessUsers\Controller\Admin;

use BusinessUsers\Controller\CrudController;

class ModulesController extends CrudController
{
    protected ?string $defaultTable = 'BusinessUsers.Modules';

    public function view($id = null)
    {
        $this->Crud->on('beforeFind', function (\Cake\Event\EventInterface $event): void {
            $event->getSubject()->query->contain(['Permissions']);
        });

        return $this->Crud->execute();
    }
}
