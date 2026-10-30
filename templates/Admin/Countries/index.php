<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Cake\Datasource\EntityInterface> $countries
 */

$this->element('Uikit.page_header', [
    'title' => __('Countries'),
    'actions' => [
        [
            'label' => __('New Country'),
            'url' => ['action' => 'add'],
            'class' => 'uk-button uk-button-primary'
        ]
    ]
]);
?>

<?= $this->element('Uikit.table_controls', ['defaultLimit' => 25]) ?>

<div class="datalist-table datalist-freeze-3">
    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-small uk-table-striped">
            <thead>
                <tr>
                    <th class="uk-text-center">&nbsp;</th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('id', __('Id')) ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('iso', __('ISO')) ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('nicename', __('Name')) ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('iso3', __('ISO3')) ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('phonecode', __('Phone Code')) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!$countries->count()): ?>
                <tr>
                    <td colspan="6" class="uk-text-center uk-text-muted uk-text-bold">
                        <?= __('No records found') ?>
                    </td>
                </tr>
                <?php endif; ?>
                <?php foreach ($countries as $country): ?>
                <tr>
                    <td class="uk-text-center uk-table-shrink uk-text-nowrap">
                        <?= $this->element('Uikit.list_action_buttons', ['entity' => $country]); ?>
                    </td>
                    <td><?= h($country->id) ?></td>
                    <td><?= h($country->iso) ?></td>
                    <td><?= $this->Html->link($country->nicename, ['controller' => 'States', 'action' => 'index', '?' => ['country_id' => $country->id]]) ?></td>
                    <td><?= h($country->iso3) ?></td>
                    <td><?= h($country->phonecode) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->element('Uikit.table_paginator') ?>


