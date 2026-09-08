<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\BusinessUsers\Model\Entity\Permission> $permissions
 */

$this->element('Uikit.page_header', [
    'title' => __('Permissions'),
    'actions' => [
        [
            'label' => __('New Permission'),
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
                    <th class="uk-text-nowrap"><?= __('Module') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('name', 'Name') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('code', 'Code') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('is_active', 'Active') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('sort_order', 'Order') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!count($permissions)): ?>
                <tr>
                    <td colspan="7" class="uk-text-center uk-text-muted uk-text-bold">
                        <?= __('No records found') ?>
                    </td>
                </tr>
                <?php endif; ?>
                <?php foreach ($permissions as $permission): ?>
                <tr>
                    <td class="uk-text-center uk-table-shrink uk-text-nowrap">
                        <?= $this->element('Uikit.list_action_buttons', ['entity' => $permission]) ?>
                    </td>
                    <td><?= h($permission->id) ?></td>
                    <td><?= $permission->module ? h($permission->module->name) : '<span class="uk-text-muted">-</span>' ?></td>
                    <td><?= h($permission->name) ?></td>
                    <td><code><?= h($permission->code) ?></code></td>
                    <td>
                        <?php if ($permission->is_active): ?>
                            <span class="uk-label uk-label-success"><?= __('Yes') ?></span>
                        <?php else: ?>
                            <span class="uk-label"><?= __('No') ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?= h($permission->sort_order) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->element('Uikit.table_paginator') ?>
