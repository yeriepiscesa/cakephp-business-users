<?php
declare(strict_types=1);

namespace BusinessUsers\Test\TestCase\Controller\Admin;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class ProfileTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = ['plugin.BusinessUsers.Users'];
    private const USER_ID = '11111111-1111-1111-1111-111111111111';

    protected function setUp(): void
    {
        $this->getTableLocator()->setConfig('Users', ['className' => \BusinessUsers\Model\Table\UsersTable::class]);
        parent::setUp();
        $this->session(['Auth' => [
            'id' => self::USER_ID, 'email' => 'business-user@example.com',
            'first_name' => 'Business', 'last_name' => 'User', 'role' => 'user',
            'active' => true, 'is_superuser' => false,
        ]]);
        $this->enableCsrfToken();
        $this->enableSecurityToken();
    }

    public function testProfileShowsOwnEditAndPhotoForms(): void
    {
        $this->get('/admin/users/profile');
        $this->assertResponseOk();
        $this->assertResponseContains('name="first_name"');
        $this->assertResponseContains('name="avatar_file"');
        $this->assertResponseContains('/users/avatar');
        $this->assertResponseContains('href="/admin/users/profile"');
        $this->assertResponseContains('<h4 class="admin-user-name uk-margin-remove"><a href="/admin/users/profile">');
        $this->assertResponseContains(':style="containerStyle" class="uk-margin-auto"');
        $this->assertResponseContains('&quot;width&quot;:180');
    }

    public function testAdminProfileUsesSelectedIndonesianLanguage(): void
    {
        $this->session(['App' => ['locale' => 'id_ID']]);
        $this->get('/admin/users/profile');
        $this->assertResponseOk();
        $this->assertResponseContains('Profil Saya');
        $this->assertResponseContains('Nama Depan');
        $this->assertResponseContains('Simpan perubahan');
    }

    public function testProfileChangesOnlyAllowedFields(): void
    {
        $this->post('/admin/users/profile', [
            'first_name' => 'Updated', 'last_name' => 'Name',
            'email' => 'attacker@example.com', 'role' => 'admin', 'is_superuser' => 1,
        ]);
        $this->assertRedirectContains('/admin/users/profile');
        $user = $this->getTableLocator()->get('BusinessUsers.Users')->get(self::USER_ID);
        self::assertSame('Updated', $user->get('first_name'));
        self::assertSame('Name', $user->get('last_name'));
        self::assertSame('business-user@example.com', $user->get('email'));
        self::assertSame('user', $user->get('role'));
        self::assertFalse((bool)$user->get('is_superuser'));
    }

    public function testCannotUpdateAnotherUsersProfile(): void
    {
        $this->post('/admin/users/profile/22222222-2222-2222-2222-222222222222', ['first_name' => 'No']);
        $this->assertResponseCode(403);
    }

    public function testInvalidPhotoReturnsToAdminProfile(): void
    {
        $this->post('/users/avatar', ['return_to' => 'admin']);
        $this->assertRedirectContains('/admin/users/profile');
        $this->assertFlashMessage('Please select an image to upload.');
    }
}
