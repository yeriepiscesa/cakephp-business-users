<?php
/**
 * @var \App\View\AppView $this
 * @var \BusinessUsers\Model\Entity\TenantUser $tenantUser
 * @var array $tenants List options for Tenant select
 */

$this->element('Uikit.page_header', ['title' => __('Edit Tenant User')]);
?>

<?= $this->Form->create($tenantUser, ['class' => 'uk-form-stacked']) ?>
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
                <label class="uk-form-label"><?= __('User ID') ?> <span class="uk-text-muted"><?= __('(UUID)') ?></span></label>
                <div class="uk-form-controls">
                    <?= $this->Form->control('user_id', ['label' => false, 'class' => 'uk-input', 'required' => true]) ?>
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
        <div class="uk-width-1-2@m">
            <div class="uk-margin">
                <label class="uk-form-label"><?= __('Joined') ?></label>
                <div class="uk-form-controls">
                    <?= $this->Form->control('joined', ['type' => 'datetime-local', 'label' => false, 'class' => 'uk-input']) ?>
                </div>
            </div>
        </div>
        <div class="uk-width-1-1">
            <div class="uk-margin">
                <?= $this->Form->control('is_owner', ['type' => 'checkbox', 'label' => __('Tenant owner')]) ?>
            </div>
        </div>
        <div class="uk-width-1-1">
            <div class="uk-margin">
                <label class="uk-form-label"><?= __('Metadata') ?> <span class="uk-text-muted"><?= __('(JSON)') ?></span></label>
                <div class="uk-form-controls">
                    <?= $this->Form->control('metadata', ['type' => 'textarea', 'label' => false, 'class' => 'uk-textarea', 'rows' => 3]) ?>
                </div>
            </div>
        </div>
    </div>

    <?= $this->element('Uikit.crud_buttons', ['type' => 'form', 'entity' => $tenantUser, 'options' => ['showDelete' => true]]) ?>
<?= $this->Form->end() ?>
