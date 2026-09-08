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

use Cake\Core\Configure;

$this->assign('title', __d('cake_d_c/users', 'Change Password'));
?>

<div class="uk-width-medium uk-margin-auto">
    <?= $this->Form->create($user, ['class' => 'uk-form-stacked']) ?>
        <?php if ($validatePassword): ?>
            <div class="uk-margin">
                <label class="uk-form-label" for="current_password"><?= __d('cake_d_c/users', 'Current password') ?></label>
                <div class="uk-form-controls">
                    <?= $this->Form->control('current_password', [
                        'type' => 'password',
                        'required' => true,
                        'label' => false,
                        'class' => 'uk-input'
                    ]) ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="uk-margin">
            <label class="uk-form-label" for="new-password"><?= __d('cake_d_c/users', 'New password') ?></label>
            <div class="uk-form-controls">
                <?= $this->Form->control('password', [
                    'type' => 'password',
                    'required' => true,
                    'id' => 'new-password',
                    'label' => false,
                    'class' => 'uk-input'
                ]) ?>
            </div>
        </div>

        <?php if (Configure::read('Users.passwordMeter.enabled')): ?>
            <div class="uk-margin">
                <?= $this->User->addPasswordMeter() ?>
            </div>
        <?php endif; ?>

        <div class="uk-margin">
            <label class="uk-form-label" for="password_confirm"><?= __d('cake_d_c/users', 'Confirm password') ?></label>
            <div class="uk-form-controls">
                <?= $this->Form->control('password_confirm', [
                    'type' => 'password',
                    'required' => true,
                    'label' => false,
                    'class' => 'uk-input'
                ]) ?>
            </div>
        </div>

        <div class="uk-margin uk-flex uk-flex-center">
            <?= $this->Form->button(__d('cake_d_c/users', 'Submit'), ['class' => 'uk-button uk-button-primary']) ?>
            <?= $this->Html->link(__d('cake_d_c/users', 'Cancel'), ['action' => 'profile'], ['class' => 'uk-button uk-button-default']) ?>
        </div>
    <?= $this->Form->end() ?>
</div>
        </div>
    </div>
</div>

