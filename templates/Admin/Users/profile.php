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
$this->set('devScripts', ['resources/js/admin/form.js']);
$this->set('prodScripts', ['admin/form.js']);
$avatarUrl = $this->Url->build(['plugin' => 'BusinessUsers', 'prefix' => false, 'controller' => 'ProfilePhotos', 'action' => 'view', $user->id]);
?>

<div class="uk-grid" uk-grid>
    <div class="uk-width-medium">
        <div class="uk-card uk-card-default uk-text-center">
            <div class="uk-card-body uk-padding-small">
                <?php if ($isCurrentUser): ?>
                    <?= $this->Form->create(null, ['type' => 'file', 'url' => ['plugin' => 'BusinessUsers', 'prefix' => false, 'controller' => 'ProfilePhotos', 'action' => 'upload'], 'class' => 'uk-form-stacked']) ?>
                        <?= $this->Form->hidden('return_to', ['value' => 'admin']) ?>
                        <?= $this->ImageUpload->control('avatar_file', [
                            'label' => __('Profile photo'), 'width' => 140, 'height' => 140, 'shape' => 'circle',
                            'currentImage' => $avatarUrl, 'showDeleteCheckbox' => false, 'required' => true,
                            'accept' => 'image/jpeg,image/png,image/webp', 'help' => __('JPEG, PNG, or WebP; maximum 2 MB.'),
                        ]) ?>
                        <?= $this->Form->button(__('Upload photo'), ['class' => 'uk-button uk-button-default uk-width-1-1']) ?>
                    <?= $this->Form->end() ?>
                <?php else: ?>
                    <?= $this->Html->image($avatarUrl, ['alt' => __('Profile photo'), 'class' => 'uk-border-circle', 'width' => 140, 'height' => 140]) ?>
                <?php endif; ?>
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
                <?php if ($isCurrentUser): ?>
                <?= $this->Form->create($user, ['class' => 'uk-form-stacked', 'url' => ['action' => 'profile']]) ?>
                    <p><strong><?= __d('cake_d_c/users', 'Email') ?>:</strong> <?= h($user->email) ?></p>
                    <div class="uk-margin"><?= $this->Form->control('first_name', ['label' => __d('cake_d_c/users', 'First Name'), 'class' => 'uk-input']) ?></div>
                    <div class="uk-margin"><?= $this->Form->control('last_name', ['label' => __d('cake_d_c/users', 'Last Name'), 'class' => 'uk-input']) ?></div>
                    <p><strong><?= __d('cake_d_c/users', 'Role') ?>:</strong> <?= h($user->role) ?></p>
                    <?= $this->Form->button(__('Save changes'), ['class' => 'uk-button uk-button-primary']) ?>
                <?= $this->Form->end() ?>
                <?php else: ?>
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
                <?php endif; ?>
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

