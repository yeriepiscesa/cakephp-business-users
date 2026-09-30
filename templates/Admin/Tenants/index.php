<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\BusinessUsers\Model\Entity\Tenant> $tenants
 */

$this->element('Uikit.page_header', [
    'title' => __('Tenants'),
    'actions' => [
        [
            'label' => __('New Tenant'),
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
                    <th class="uk-text-nowrap"><?= $this->Sort->column('name', 'Name') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('code', 'Code') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('status', 'Status') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('created', 'Created') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!count($tenants)): ?>
                <tr>
                    <td colspan="6" class="uk-text-center uk-text-muted uk-text-bold">
                        <?= __('No records found') ?>
                    </td>
                </tr>
                <?php endif; ?>
                <?php foreach ($tenants as $tenant): ?>
                <tr>
                    <td class="uk-text-center uk-table-shrink uk-text-nowrap">
                        <?= $this->element('Uikit.list_action_buttons', ['entity' => $tenant]) ?>
                    </td>
                    <td><?= h($tenant->id) ?></td>
                    <td><?= h($tenant->name) ?></td>
                    <td><code><?= h($tenant->code) ?></code></td>
                    <td>
                        <span class="uk-label <?= $tenant->status === 'active' ? 'uk-label-success' : 'uk-label-warning' ?>">
                            <?= h(__(ucfirst($tenant->status))) ?>
                        </span>
                    </td>
                    <td><?= h($tenant->created) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->element('Uikit.table_paginator') ?>
