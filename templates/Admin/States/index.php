<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Cake\Datasource\EntityInterface> $states
 */

$this->element('Uikit.page_header', [
    'title' => __('States'),
    'actions' => [
        [
            'label' => __('New State'),
            'url' => ['action' => 'add'],
            'class' => 'uk-button uk-button-primary'
        ]
    ]
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
                    <th class="uk-text-nowrap"><?= $this->Sort->column('Countries.nicename', 'Country') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('name', 'Name') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('state_code', 'State Code') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('longitude', 'Longitude') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('latitude', 'Latitude') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!$states->count()): ?>
                <tr>
                    <td colspan="7" class="uk-text-center uk-text-muted uk-text-bold">
                        <?= __('No records found') ?>
                    </td>
                </tr>
                <?php endif; ?>
                <?php foreach ($states as $state): ?>
                <tr>
                    <td class="uk-text-center uk-table-shrink uk-text-nowrap">
                        <?= $this->element('Uikit.list_action_buttons', ['entity' => $state]); ?>
                    </td>
                    <td><?= h($state->id) ?></td>
                    <td><?= h($state->country?->nicename) ?></td>
                    <td><?= h($state->name) ?></td>
                    <td><?= h($state->state_code) ?></td>
                    <td><?= h($state->longitude) ?></td>
                    <td><?= h($state->latitude) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->element('Uikit.table_paginator') ?>


