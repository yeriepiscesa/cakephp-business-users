<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Cake\Datasource\EntityInterface> $cities
 */

$this->element('Uikit.page_header', [
    'title' => __('Cities'),
    'actions' => [
        [
            'label' => __('New City'),
            'url' => ['action' => 'add'],
            'class' => 'uk-button uk-button-primary'
        ]
    ]
]);
?>

<?php
$this->set('devScripts', ['resources/js/admin/lookup-select.js']);
$this->set('prodScripts', ['admin/lookup-select.js']);
$selectedCountries = $selectedCountries ?? [];
$selectedStates = $selectedStates ?? [];
echo $this->element('Uikit.table_controls', ['defaultLimit' => 25, 'filters' => [
    'country_id' => [
        'type' => 'select', 'label' => __('Country'), 'multiple' => true, 'class' => 'uk-select',
        'options' => $selectedCountries, 'value' => array_keys($selectedCountries), 'data-placeholder' => __('Search countries'),
        'data-lookup-url' => $this->Url->build(['plugin' => 'BusinessUsers', 'prefix' => 'Admin', 'controller' => 'Countries', 'action' => 'lookup']),
        'data-label-fields' => 'nicename,iso', 'data-search-field' => 'nicename', 'data-clearable' => 'true',
    ],
    'state_id' => [
        'type' => 'select', 'label' => __('State'), 'multiple' => true, 'class' => 'uk-select',
        'options' => $selectedStates, 'value' => array_keys($selectedStates), 'data-placeholder' => __('Search states'),
        'data-lookup-url' => $this->Url->build(['plugin' => 'BusinessUsers', 'prefix' => 'Admin', 'controller' => 'States', 'action' => 'lookup']),
        'data-label-fields' => 'name,country.nicename,country.iso', 'data-search-field' => 'name', 'data-clearable' => 'true',
    ],
]]);
?>

<div class="datalist-table datalist-freeze-3">
    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-small uk-table-striped">
            <thead>
                <tr>
                    <th class="uk-text-center">&nbsp;</th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('id', __('Id')) ?></th>
                    <th class="uk-text-nowrap"><?= __('State') ?></th>
                    <th class="uk-text-nowrap"><?= __('Country') ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('name', __('Name')) ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('latitude', __('Latitude')) ?></th>
                    <th class="uk-text-nowrap"><?= $this->Sort->column('longitude', __('Longitude')) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!$cities->count()): ?>
                <tr>
                    <td colspan="7" class="uk-text-center uk-text-muted uk-text-bold">
                        <?= __('No records found') ?>
                    </td>
                </tr>
                <?php endif; ?>
                <?php foreach ($cities as $city): ?>
                <tr>
                    <td class="uk-text-center uk-table-shrink uk-text-nowrap">
                        <?= $this->element('Uikit.list_action_buttons', ['entity' => $city]); ?>
                    </td>
                    <td><?= h($city->id) ?></td>
                    <td><?= h($city->state?->name) ?></td>
                    <td><?= h($city->state?->country?->iso) ?></td>
                    <td><?= h($city->name) ?></td>
                    <td><?= h($city->latitude) ?></td>
                    <td><?= h($city->longitude) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->element('Uikit.table_paginator') ?>


