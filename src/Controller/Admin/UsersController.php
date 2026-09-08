<?php
declare(strict_types=1);

namespace BusinessUsers\Controller\Admin;

use BusinessUsers\Application\Port\UserRoleProviderInterface;
use BusinessUsers\Application\UseCase\UpdateUserRole\UpdateUserRoleInput;
use BusinessUsers\Application\UseCase\UpdateUserRole\UpdateUserRoleUseCase;
use BusinessUsers\Domain\Enum\UserRole;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Event\EventManagerInterface;
use Cake\Http\ServerRequest;
use Cake\Utility\Inflector;
use CakeDC\Users\Controller\UsersController as BaseUsersController;

/**
 * Admin Users Controller
 *
 * Wraps CakeDC/Users plugin controller under BusinessUsers Admin prefix.
 * Routes /admin/users/* resolve here (prefix=Admin, plugin=BusinessUsers).
 *
 * Cross-plugin dependencies are injected via the CakePHP DI container:
 *   - UserRoleProviderInterface  → EnumUserRoleProvider  (BusinessUsers plugin)
 *   - UpdateUserRoleUseCase      → registered in BusinessUsersPlugin::services()
 */
class UsersController extends BaseUsersController
{
    public function __construct(
        ServerRequest $request,
        private readonly UserRoleProviderInterface $userRoleProvider,
        private readonly UpdateUserRoleUseCase $updateUserRoleUseCase,
        ?string $name = null,
        ?EventManagerInterface $eventManager = null,
        ?ComponentRegistry $components = null,
    ) {
        parent::__construct($request, $name, $eventManager, $components);
    }

    public function beforeRender(EventInterface $event): void
    {
        parent::beforeRender($event);

        $theme = (string)Configure::read('BusinessUsers.theme', 'Uikit');
        $this->viewBuilder()->setTheme($theme);
        $this->viewBuilder()->setLayout($theme . '.admin');
        $this->viewBuilder()->addHelper('CakeDC/Users.User');

        $this->set('roles', $this->userRoleProvider->getOptions());
    }

    /**
     * Override add() to set the `role` field directly on the entity before save.
     *
     * SimpleCrudTrait::add() uses patchEntity(), which respects $accessible and
     * therefore silently drops `role` (CakeDC/Users sets it to false).
     * We replicate the trait logic and call $entity->set('role') explicitly.
     *
     * @return \Cake\Http\Response|null
     */
    public function add(): ?\Cake\Http\Response
    {
        $table = $this->fetchTable();
        $tableAlias = $table->getAlias();
        $entity = $table->newEmptyEntity();
        $this->set($tableAlias, $entity);
        $this->set('tableAlias', $tableAlias);
        $this->viewBuilder()->setOption('serialize', [$tableAlias, 'tableAlias']);

        if (!$this->getRequest()->is('post')) {
            return null;
        }

        $data = $this->getRequest()->getData();
        $entity = $table->patchEntity($entity, $data);
        $this->applyRoleFromData($entity, $data);

        $singular = Inflector::singularize(Inflector::humanize($tableAlias));
        if ($table->save($entity)) {
            $this->Flash->success(__d('cake_d_c/users', 'The {0} has been saved', $singular));

            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__d('cake_d_c/users', 'The {0} could not be saved', $singular));

        return null;
    }

    /**
     * Override edit() to set the `role` field directly on the entity before save.
     *
     * Same reason as add(): patchEntity() drops `role` due to $accessible guard.
     *
     * @param string|null $id User UUID.
     * @return \Cake\Http\Response|null
     */
    public function edit($id = null): ?\Cake\Http\Response
    {
        $table = $this->fetchTable();
        $tableAlias = $table->getAlias();
        $entity = $table->get($id, args: ['contain' => []]);
        $this->set($tableAlias, $entity);
        $this->set('tableAlias', $tableAlias);
        $this->viewBuilder()->setOption('serialize', [$tableAlias, 'tableAlias']);

        if (!$this->getRequest()->is(['patch', 'post', 'put'])) {
            return null;
        }

        $data = $this->getRequest()->getData();
        $entity = $table->patchEntity($entity, $data);
        $this->applyRoleFromData($entity, $data);

        $singular = Inflector::singularize(Inflector::humanize($tableAlias));
        if ($table->save($entity)) {
            $this->Flash->success(__d('cake_d_c/users', 'The {0} has been saved', $singular));

            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__d('cake_d_c/users', 'The {0} could not be saved', $singular));

        return null;
    }

    /**
     * Sets the `role` field on the entity directly, bypassing $accessible.
     *
     * Only applies if the submitted value is a valid UserRole case.
     * Called from add() and edit() after patchEntity().
     *
     * @param \CakeDC\Users\Model\Entity\User $entity
     * @param array<string, mixed> $data
     * @return void
     */
    private function applyRoleFromData(\CakeDC\Users\Model\Entity\User $entity, array $data): void
    {
        $raw = isset($data['role']) ? (string)$data['role'] : '';
        if ($raw !== '' && UserRole::tryFrom($raw) !== null) {
            $entity->set('role', $raw);
        }
    }

    /**
     * POST /admin/users/update-role/:id
     *
     * Updates the platform role of a user. The CakeDC/Users `role` field is not
     * mass-assignable, so a dedicated use case bypasses that guard safely.
     *
     * @param string $id User UUID.
     * @return \Cake\Http\Response
     */
    public function updateRole(string $id): \Cake\Http\Response
    {
        $this->getRequest()->allowMethod('post');

        $role = (string)$this->getRequest()->getData('role', '');

        try {
            $input = new UpdateUserRoleInput(userId: $id, role: $role);
            $this->updateUserRoleUseCase->execute($input);
            $this->Flash->success(__('Role updated successfully.'));
        } catch (\InvalidArgumentException $e) {
            $this->Flash->error($e->getMessage());
        } catch (\Cake\Datasource\Exception\RecordNotFoundException) {
            $this->Flash->error(__('User not found.'));
        } catch (\RuntimeException $e) {
            $this->Flash->error(__('Could not update role: {0}', $e->getMessage()));
        }

        return $this->redirect(['action' => 'index']);
    }
}
