<?php
declare(strict_types=1);

namespace BusinessUsers\Controller\Admin;

use BusinessUsers\Controller\CrudController;

class TenantsController extends CrudController
{
    protected ?string $defaultTable = 'BusinessUsers.Tenants';

    public function view($id = null)
    {
        $this->Crud->on('beforeFind', function (\Cake\Event\EventInterface $event): void {
            $event->getSubject()->query->contain(['Groups', 'Roles', 'TenantUsers']);
        });

        return $this->Crud->execute();
    }
}
