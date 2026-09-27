<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Table;

use ArrayObject;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\Validation\Validator;
use CakeDC\Users\Model\Table\UsersTable as CakeDCUsersTable;

/**
 * Application Users table.
 *
 * Uses email as the public identity. When Users.Username.useEmail is enabled,
 * username is filled from email so CakeDC unique/login constraints stay valid.
 */
class UsersTable extends CakeDCUsersTable
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // The CakeDC entity hashes password assignments via _setPassword().
        $this->setEntityClass(\CakeDC\Users\Model\Entity\User::class);
        $this->setDisplayField('email');
        $this->isValidateEmail = (bool)Configure::read('Users.Email.required', true);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator = parent::validationDefault($validator);

        if (!Configure::read('Users.Username.required', true)) {
            $validator->remove('username');
            $validator->allowEmptyString('username');
        }

        $validator
            ->email('email', false, __d('cake_d_c/users', 'Please enter a valid email'))
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        return $validator;
    }

    public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options): void
    {
        $this->copyEmailToUsername($data);
    }

    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options): void
    {
        if (!Configure::read('Users.Username.useEmail', false)) {
            return;
        }

        $email = trim((string)$entity->get('email'));
        if ($email === '') {
            return;
        }

        if ($entity->isNew() || $entity->isDirty('email') || trim((string)$entity->get('username')) === '') {
            $entity->set('username', $email);
        }
    }

    /**
     * @param \ArrayObject<string, mixed> $data Request data being marshalled.
     */
    private function copyEmailToUsername(ArrayObject $data): void
    {
        if (!Configure::read('Users.Username.useEmail', false)) {
            return;
        }

        $email = trim((string)($data['email'] ?? ''));
        if ($email === '') {
            return;
        }

        if (trim((string)($data['username'] ?? '')) === '') {
            $data['username'] = $email;
        }
    }
}
