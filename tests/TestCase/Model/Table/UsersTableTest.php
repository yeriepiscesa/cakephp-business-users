<?php
declare(strict_types=1);

namespace BusinessUsers\Test\TestCase\Model\Table;

use BusinessUsers\Model\Table\UsersTable;
use Cake\TestSuite\TestCase;
use CakeDC\Users\Model\Entity\User;

class UsersTableTest extends TestCase
{
    public function testNewAndUpdatedPasswordsUseCakeDcHashing(): void
    {
        $table = $this->getTableLocator()->get('Users', ['className' => UsersTable::class]);

        $user = $table->newEntity([
            'email' => 'new-user@example.com',
            'password' => 'first-secret-password',
        ], ['validate' => false]);

        self::assertInstanceOf(User::class, $user);
        self::assertNotSame('first-secret-password', $user->password);
        self::assertTrue($user->checkPassword('first-secret-password', $user->password));

        $table->patchEntity($user, ['password' => 'updated-secret-password'], ['validate' => false]);

        self::assertTrue($user->checkPassword('updated-secret-password', $user->password));
        self::assertFalse($user->checkPassword('first-secret-password', $user->password));
    }
}
