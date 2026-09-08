<?php
/**
 * @var \App\View\AppView $this
 * @var \BusinessUsers\Model\Entity\Role $role
 * @var array $tenants List options for Tenant select
 */

$this->element('Uikit.page_header', ['title' => __('Add Role')]);
?>

<?= $this->Form->create($role, ['class' => 'uk-form-stacked']) ?>
<div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-2@m">
            <div class="uk-margin">
                <label class="uk-form-label"><?= __('Tenant') ?></label>
                <div class="uk-form-controls">
                    <?= $this->Form->control('business_users_tenant_id', [
                        'type' => 'select',
                        'label' => false,
                        'class' => 'uk-select',
                        'options' => $tenants,
                        'empty' => __('-- Select Tenant --'),
                        'required' => true,
                    ]) ?>
                </div>
            </div>
        </div>
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
        <div class="uk-width-1-4@m">
            <div class="uk-margin">
                <label class="uk-form-label"><?= __('Level') ?></label>
                <div class="uk-form-controls">
                    <?= $this->Form->control('level', ['type' => 'number', 'label' => false, 'class' => 'uk-input', 'value' => 10]) ?>
                </div>
            </div>
        </div>
        <div class="uk-width-1-4@m">
            <div class="uk-margin">
                <label class="uk-form-label"><?= __('Sort Order') ?></label>
                <div class="uk-form-controls">
                    <?= $this->Form->control('sort_order', ['type' => 'number', 'label' => false, 'class' => 'uk-input', 'value' => 0]) ?>
                </div>
            </div>
        </div>
        <div class="uk-width-1-1">
            <div class="uk-margin">
                <?= $this->Form->control('is_active', ['type' => 'checkbox', 'label' => __('Active'), 'checked' => true]) ?>
                <?= $this->Form->control('is_default', ['type' => 'checkbox', 'label' => __('Default role')]) ?>
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
    </div>

    <?= $this->element('Uikit.crud_buttons', ['type' => 'form', 'entity' => $role, 'options' => ['showDelete' => false]]) ?>
<?= $this->Form->end() ?>
