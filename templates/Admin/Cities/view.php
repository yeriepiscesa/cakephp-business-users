<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $city
 */

$this->assign('title', __('City'));
?>

<div class="uk-overflow-auto">
    <table class="uk-table uk-table-striped uk-table-divider">
        <tbody>
            <tr>
                <th><?= __('State') ?></th>
                <td><?= h($city->state?->name) ?></td>
            </tr>
            <tr>
                <th><?= __('Country') ?></th>
                <td><?= h($city->state?->country?->nicename) ?></td>
            </tr>
            <tr>
                <th><?= __('Name') ?></th>
                <td><?= h($city->name) ?></td>
            </tr>
                    <tr>
                <th><?= __('Latitude') ?></th>
                <td><?= h($city->latitude) ?></td>
            </tr>
                    <tr>
                <th><?= __('Longitude') ?></th>
                <td><?= h($city->longitude) ?></td>
            </tr>
            </tbody>
    </table>
</div>

<?= $this->element('crud_buttons', [
    'type' => 'view',
    'entity' => $city,
    'options' => [
        'showDelete' => true,
        'showList' => true,
        'showNew' => true
    ]
]) ?>
