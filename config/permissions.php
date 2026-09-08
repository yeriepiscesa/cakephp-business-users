<?php
/**
 * Copyright 2010 - 2019, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2018, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

return [
    'CakeDC/Auth.permissions' => [
        [
            'prefix' => false,
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => [
                'socialLogin',
                'login',
                'logout',
                'socialEmail',
                'verify',
                'register',
                'validateEmail',
                'changePassword',
                'resetPassword',
                'requestResetPassword',
                'resendTokenValidation',
                'linkSocial',
                'webauthn2fa',
                'webauthn2faRegister',
                'webauthn2faRegisterOptions',
                'webauthn2faAuthenticate',
                'webauthn2faAuthenticateOptions',
                'requestLoginLink',
                'sendLoginLink',
                'singleTokenLogin',
            ],
            'bypassAuth' => true,
        ],
        [
            'prefix' => false,
            'plugin' => 'CakeDC/Users',
            'controller' => 'SocialAccounts',
            'action' => [
                'validateAccount',
                'resendValidation',
            ],
            'bypassAuth' => true,
        ],
        [
            'role' => \CakeDC\Users\Model\Table\UsersTable::ROLE_ADMIN,
            'prefix' => '*',
            'extension' => '*',
            'plugin' => '*',
            'controller' => '*',
            'action' => '*',
        ],
        [
            'role' => '*',
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => ['profile', 'logout', 'linkSocial', 'callbackLinkSocial'],
        ],
        [
            'role' => '*',
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => 'resetOneTimePasswordAuthenticator',
            'allowed' => function (array $user, $role, \Cake\Http\ServerRequest $request) {
                $userId = \Cake\Utility\Hash::get($request->getAttribute('params'), 'pass.0');
                if (!empty($userId) && !empty($user)) {
                    return $userId === $user['id'];
                }

                return false;
            },
        ],
        [
            'prefix' => 'Admin',
            'plugin' => 'BusinessUsers',
            'controller' => ['Countries', 'States', 'Cities'],
            'action' => ['index', 'add', 'edit', 'view', 'delete'],
            'allowed' => function (array $user) {
                return \BusinessUsers\Authorization\PlatformUserAuthorization::isSuperAdmin($user);
            },
        ],
        [
            'role' => 'admin',
            'prefix' => 'Admin',
            'plugin' => 'BusinessUsers',
            'controller' => ['Countries', 'States', 'Cities'],
            'action' => ['index', 'add', 'edit', 'view', 'delete'],
            'allowed' => false,
        ],
    ],
];
