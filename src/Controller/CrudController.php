<?php
declare(strict_types=1);

namespace BusinessUsers\Controller;

use CrudConnect\Controller\CrudController as BaseCrudController;
use Cake\Core\Configure;
use Cake\Event\EventInterface;

class CrudController extends BaseCrudController
{
    public function beforeRender(EventInterface $event): void
    {
        parent::beforeRender($event);

        $theme = (string)Configure::read('BusinessUsers.theme', 'Uikit');
        $this->viewBuilder()->setTheme($theme);

        $prefix = $this->request->getParam('prefix');
        $action = $this->request->getParam('action');
        if ($prefix === 'Admin') {
            $layout = $action === 'lookup' ? 'ajax' : $theme . '.admin';
            $this->viewBuilder()->setLayout($layout);
        }
    }
}
