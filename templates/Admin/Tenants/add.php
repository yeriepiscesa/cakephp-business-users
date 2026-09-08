<?php
/**
 * @var \App\View\AppView $this
 * @var \BusinessUsers\Model\Entity\Tenant $tenant
 */

$this->element('Uikit.page_header', ['title' => __('Add Tenant')]);
?>

<?= $this->Form->create($tenant, ['class' => 'uk-form-stacked']) ?>
<div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-2@m">
            <div class="uk-margin">
                <label class="uk-form-label"><?= __('Name') ?></label>
                <div class="uk-form-controls">
                    <?= $this->Form->control('name', ['label' => false, 'class' => 'uk-input', 'required' => true]) ?>
                </div>
            </div>
        </div>
        <div class="uk-width-1-2@m">
            <div class="uk-margin">
                <label class="uk-form-label"><?= __('Code') ?></label>
                <div class="uk-form-controls">
                    <?= $this->Form->control('code', ['label' => false, 'class' => 'uk-input', 'required' => true]) ?>
                </div>
            </div>
        </div>
        <div class="uk-width-1-2@m">
            <div class="uk-margin">
                <label class="uk-form-label"><?= __('Status') ?></label>
                <div class="uk-form-controls">
                    <?= $this->Form->control('status', [
                        'type' => 'select',
                        'label' => false,
                        'class' => 'uk-select',
                        'options' => ['active' => __('Active'), 'inactive' => __('Inactive'), 'suspended' => __('Suspended')],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="uk-width-1-1">
            <div class="uk-margin">
                <label class="uk-form-label"><?= __('Description') ?></label>
                <div class="uk-form-controls">
                    <?= $this->Form->control('description', ['type' => 'textarea', 'label' => false, 'class' => 'uk-textarea', 'rows' => 3]) ?>
                </div>
            </div>
        </div>
        <div class="uk-width-1-1">
            <div class="uk-margin">
                <label class="uk-form-label"><?= __('Settings') ?> <span class="uk-text-muted"><?= __('(JSON)') ?></span></label>
                <div class="uk-form-controls">
                    <?= $this->Form->control('settings', ['type' => 'textarea', 'label' => false, 'class' => 'uk-textarea', 'rows' => 4]) ?>
                </div>
            </div>
        </div>
    </div>

    <?= $this->element('Uikit.crud_buttons', ['type' => 'form', 'entity' => $tenant, 'options' => ['showDelete' => false]]) ?>
<?= $this->Form->end() ?>
