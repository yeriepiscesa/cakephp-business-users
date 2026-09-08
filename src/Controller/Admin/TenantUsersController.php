<?php
declare(strict_types=1);

namespace BusinessUsers\Controller\Admin;

use BusinessUsers\Controller\CrudController;
use Crud\Listener\RelatedModelsListener;

class TenantUsersController extends CrudController
{
    protected ?string $defaultTable = 'BusinessUsers.TenantUsers';

    public function initialize(): void
    {
        parent::initialize();

        /** @var RelatedModelsListener $relatedListener */
        $relatedListener = $this->Crud->listener('relatedModels');
        $relatedListener->relatedModels(true);
    }

    public function index()
    {
        $this->Crud->on('beforePaginate', function (\Cake\Event\EventInterface $event): void {
            $event->getSubject()->query->contain(['Tenants']);
        });

        return $this->Crud->execute();
    }

    public function view($id = null)
    {
        $this->Crud->on('beforeFind', function (\Cake\Event\EventInterface $event): void {
            $event->getSubject()->query->contain(['Tenants', 'TenantUserRoles', 'GroupMembers']);
        });

        return $this->Crud->execute();
    }
}
