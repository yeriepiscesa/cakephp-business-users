<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\BusinessUsers\Model\Entity\Group> $groups
 */

$this->element('Uikit.page_header', [
    'title' => __('Groups'),
    'actions' => [
        [
            'label' => __('New Group'),
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
                    <th class="uk-text-nowrap"><?= $this->Sort->column('name', 'Name') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('code', 'Code') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('is_active', 'Active') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('sort_order', 'Order') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!count($groups)): ?>
                <tr>
                    <td colspan="7" class="uk-text-center uk-text-muted uk-text-bold">
                        <?= __('No records found') ?>
                    </td>
                </tr>
                <?php endif; ?>
                <?php foreach ($groups as $group): ?>
                <tr>
                    <td class="uk-text-center uk-table-shrink uk-text-nowrap">
                        <?= $this->element('Uikit.list_action_buttons', ['entity' => $group]) ?>
                    </td>
                    <td><?= h($group->id) ?></td>
                    <td><?= $group->tenant ? h($group->tenant->name) : '<span class="uk-text-muted">-</span>' ?></td>
                    <td><?= h($group->name) ?></td>
                    <td><code><?= h($group->code) ?></code></td>
                    <td>
                        <?php if ($group->is_active): ?>
                            <span class="uk-label uk-label-success"><?= __('Yes') ?></span>
                        <?php else: ?>
                            <span class="uk-label"><?= __('No') ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?= h($group->sort_order) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->element('Uikit.table_paginator') ?>
