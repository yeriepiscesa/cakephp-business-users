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

$this->assign('title', __d('cake_d_c/users', 'My Profile'));
?>

<div class="uk-grid" uk-grid>
    <div class="uk-width-medium">
        <div class="uk-card uk-card-default uk-text-center">
            <div class="uk-card-media-top">
                <?= $this->Html->image(
                    empty($user->avatar) ? $avatarPlaceholder : $user->avatar,
                    ['class' => 'uk-width-1-1']
                ) ?>
            </div>
            <div class="uk-card-body uk-padding-small">
                <h3 class="uk-card-title">
                    <?= h(trim((string)$user->first_name . ' ' . (string)$user->last_name) ?: $user->email) ?>
                </h3>
                <p class="uk-text-muted uk-margin-small-top">
                    <?= h($user->email) ?>
                </p>
            </div>
            <div class="uk-card-footer uk-padding-small">
                <?= $this->Html->link(__d('cake_d_c/users', 'Change Password'), ['action' => 'changePassword'], ['class' => 'uk-button uk-button-primary uk-width-1-1']) ?>
            </div>
        </div>
    </div>

    <div class="uk-width-expand">
        <div class="uk-card uk-card-default">
            <div class="uk-card-header">
                <h3 class="uk-card-title">
                    <span uk-icon="icon: info"></span> <?= __d('cake_d_c/users', 'Profile Information') ?>
                </h3>
            </div>

            <div class="uk-card-body">
                <div class="uk-grid-small uk-child-width-1-1" uk-grid>
                    <div>
                        <p><strong><?= __d('cake_d_c/users', 'Email') ?>:</strong></p>
                        <p><?= h($user->email) ?></p>
                    </div>

                    <div>
                        <p><strong><?= __d('cake_d_c/users', 'First Name') ?>:</strong></p>
                        <p><?= h($user->first_name) ?></p>
                    </div>

                    <div>
                        <p><strong><?= __d('cake_d_c/users', 'Last Name') ?>:</strong></p>
                        <p><?= h($user->last_name) ?></p>
                    </div>

                    <div>
                        <p><strong><?= __d('cake_d_c/users', 'Role') ?>:</strong></p>
                        <p><?= h($user->role) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($user->social_accounts)): ?>
            <div class="uk-margin-top">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        <h4 class="uk-card-title">
                            <span uk-icon="icon: social"></span> <?= __d('cake_d_c/users', 'Social Accounts') ?>
                        </h4>
                    </div>

                    <div class="uk-card-body uk-padding-remove">
                        <div class="uk-overflow-auto">
                            <table class="uk-table uk-table-striped uk-table-small">
                                <thead>
                                    <tr>
                                        <th><?= __d('cake_d_c/users', 'Avatar') ?></th>
                                        <th><?= __d('cake_d_c/users', 'Provider') ?></th>
                                        <th><?= __d('cake_d_c/users', 'Username') ?></th>
                                        <th><?= __d('cake_d_c/users', 'Link') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($user->social_accounts as $socialAccount): ?>
                                        <?php
                                        $escapedUsername = h($socialAccount->username);
                                        $linkText = empty($escapedUsername) ? __d('cake_d_c/users', 'Link to {0}', h($socialAccount->provider)) : h($socialAccount->username);
                                        ?>
                                        <tr>
                                            <td>
                                                <?php if ($socialAccount->avatar): ?>
                                                    <?= $this->Html->image($socialAccount->avatar, ['width' => 40, 'height' => 40, 'class' => 'uk-border-circle']) ?>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td><?= h($socialAccount->provider) ?></td>
                                            <td><?= $escapedUsername ?: '-' ?></td>
                                            <td>
                                                <?= $socialAccount->link && $socialAccount->link !== '#' ? $this->Html->link(
                                                    $linkText,
                                                    $socialAccount->link,
                                                    ['target' => '_blank', 'class' => 'uk-link']
                                                ) : '-' ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

