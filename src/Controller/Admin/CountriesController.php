<?php
declare(strict_types=1);

namespace BusinessUsers\Controller\Admin;

use BusinessUsers\Controller\CrudController;

class CountriesController extends CrudController
{
    protected ?string $defaultTable = 'BusinessUsers.Countries';

    public function initialize(): void
    {
        parent::initialize();
        $this->Crud->action('Lookup')->setConfig('findMethod', 'lookup');
        $this->lookupView = 'tom_select';
    }
}
