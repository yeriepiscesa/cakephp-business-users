<?php
declare(strict_types=1);

namespace BusinessUsers\Controller\Admin;

use BusinessUsers\Controller\CrudController;
use Crud\Listener\RelatedModelsListener;

class PermissionsController extends CrudController
{
    protected ?string $defaultTable = 'BusinessUsers.Permissions';

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
            $event->getSubject()->query->contain(['Modules']);
        });

        return $this->Crud->execute();
    }
}
