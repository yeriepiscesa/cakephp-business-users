<?php
declare(strict_types=1);

namespace BusinessUsers\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture
{
    public string $table = 'users';

    public function init(): void
    {
        $this->records = [
            [
                'id' => '11111111-1111-1111-1111-111111111111',
                'username' => 'business-user',
                'email' => 'business-user@example.com',
                'password' => '$2y$10$abcdefghijklmnopqrstuvABCDEFGHIJKLMNOQRSTUV1234567890',
                'first_name' => 'Business',
                'last_name' => 'User',
                'token' => null,
                'token_expires' => null,
                'api_token' => null,
                'activation_date' => null,
                'secret' => null,
                'secret_verified' => null,
                'tos_date' => null,
                'active' => 1,
                'is_superuser' => 0,
                'role' => 'user',
                'created' => '2026-05-14 00:00:00',
                'modified' => '2026-05-14 00:00:00',
                'additional_data' => null,
                'last_login' => null,
                'lockout_time' => null,
                'login_token' => null,
                'login_token_date' => null,
                'token_send_requested' => 0,
            ],
        ];

        parent::init();
    }
}