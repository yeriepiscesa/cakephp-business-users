<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $country
 */

$this->assign('title', __('Country'));
?>

<div class="uk-overflow-auto">
    <table class="uk-table uk-table-striped uk-table-divider">
        <tbody>
                    <tr>
                <th><?= __('Iso') ?></th>
                <td><?= h($country->iso) ?></td>
            </tr>
                    <tr>
                <th><?= __('Name') ?></th>
                <td><?= h($country->name) ?></td>
            </tr>
                    <tr>
                <th><?= __('Nicename') ?></th>
                <td><?= h($country->nicename) ?></td>
            </tr>
                    <tr>
                <th><?= __('Iso3') ?></th>
                <td><?= h($country->iso3) ?></td>
            </tr>
                    <tr>
                <th><?= __('Numcode') ?></th>
                <td><?= h($country->numcode) ?></td>
            </tr>
                    <tr>
                <th><?= __('Phonecode') ?></th>
                <td><?= h($country->phonecode) ?></td>
            </tr>
            </tbody>
    </table>
</div>

<?= $this->element('crud_buttons', [
    'type' => 'view',
    'entity' => $country,
    'options' => [
        'showDelete' => true,
        'showList' => true,
        'showNew' => true
    ]
]) ?>
