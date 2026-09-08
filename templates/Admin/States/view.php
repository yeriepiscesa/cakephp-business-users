<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $state
 */

$this->assign('title', __('State'));
?>

<div class="uk-overflow-auto">
    <table class="uk-table uk-table-striped uk-table-divider">
        <tbody>
            <tr>
                <th><?= __('Country') ?></th>
                <td><?= h($state->country?->nicename) ?></td>
            </tr>
            <tr>
                <th><?= __('Name') ?></th>
                <td><?= h($state->name) ?></td>
            </tr>
                    <tr>
                <th><?= __('State Code') ?></th>
                <td><?= h($state->state_code) ?></td>
            </tr>
                    <tr>
                <th><?= __('Longitude') ?></th>
                <td><?= h($state->longitude) ?></td>
            </tr>
                    <tr>
                <th><?= __('Latitude') ?></th>
                <td><?= h($state->latitude) ?></td>
            </tr>
            </tbody>
    </table>
</div>

<?= $this->element('crud_buttons', [
    'type' => 'view',
    'entity' => $state,
    'options' => [
        'showDelete' => true,
        'showList' => true,
        'showNew' => true
    ]
]) ?>
