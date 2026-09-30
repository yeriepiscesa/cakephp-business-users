<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\BusinessUsers\Model\Entity\TenantUser> $tenantUsers
 */

$this->element('Uikit.page_header', [
    'title' => __('Tenant Users'),
    'actions' => [
        [
            'label' => __('Add Member'),
            'url' => ['action' => 'add'],
            'class' => 'uk-button uk-button-primary',
        ],
    ],
]);
?>

<?= $this->element('Uikit.table_controls') ?>

<div class="datalist-table datalist-freeze-3">
    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-small uk-table-striped">
            <thead>
                <tr>
                    <th class="uk-text-center">&nbsp;</th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('id', 'Id') ?></th>
                    <th class="uk-text-nowrap"><?= __('Tenant') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('user_id', 'User') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('status', 'Status') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('is_owner', 'Owner') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('joined', 'Joined') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!count($tenantUsers)): ?>
                <tr>
                    <td colspan="7" class="uk-text-center uk-text-muted uk-text-bold">
                        <?= __('No records found') ?>
                    </td>
                </tr>
                <?php endif; ?>
                <?php foreach ($tenantUsers as $tenantUser): ?>
                <tr>
                    <td class="uk-text-center uk-table-shrink uk-text-nowrap">
                        <?= $this->element('Uikit.list_action_buttons', ['entity' => $tenantUser]) ?>
                    </td>
                    <td><?= h($tenantUser->id) ?></td>
                    <td><?= $tenantUser->tenant ? h($tenantUser->tenant->name) : '<span class="uk-text-muted">-</span>' ?></td>
                    <td class="uk-text-truncate" style="max-width:180px"><?= h($tenantUser->user_id) ?></td>
                    <td>
                        <span class="uk-label <?= $tenantUser->status === 'active' ? 'uk-label-success' : 'uk-label-warning' ?>">
                            <?= h(__(ucfirst($tenantUser->status))) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($tenantUser->is_owner): ?>
                            <span class="uk-label uk-label-warning"><?= __('Owner') ?></span>
                        <?php else: ?>
                            <span class="uk-text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $tenantUser->joined ? h($tenantUser->joined) : '<span class="uk-text-muted">-</span>' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->element('Uikit.table_paginator') ?>
