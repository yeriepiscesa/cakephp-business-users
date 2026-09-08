<?php
/**
 * @var \App\View\AppView $this
 * @var \BusinessUsers\Model\Entity\Group $group
 */

$this->element('Uikit.page_header', [
    'title' => h($group->name),
    'actions' => [
        [
            'label' => __('Edit'),
            'url' => ['action' => 'edit', $group->id],
            'class' => 'uk-button uk-button-primary',
        ],
    ],
]);
?>

<table class="uk-table uk-table-divider">
        <tbody>
            <tr>
                <th class="uk-width-small"><?= __('Id') ?></th>
                <td><?= h($group->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Tenant') ?></th>
                <td>
                    <?php if ($group->tenant): ?>
                        <?= $this->Html->link($group->tenant->name, ['controller' => 'Tenants', 'action' => 'view', $group->tenant->id]) ?>
                    <?php else: ?>
                        <span class="uk-text-muted">-</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Name') ?></th>
                <td><?= h($group->name) ?></td>
            </tr>
            <tr>
                <th><?= __('Code') ?></th>
                <td><code><?= h($group->code) ?></code></td>
            </tr>
            <tr>
                <th><?= __('Active') ?></th>
                <td>
                    <?php if ($group->is_active): ?>
                        <span class="uk-label uk-label-success"><?= __('Yes') ?></span>
                    <?php else: ?>
                        <span class="uk-label"><?= __('No') ?></span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Default') ?></th>
                <td><?= $group->is_default ? __('Yes') : __('No') ?></td>
            </tr>
            <tr>
                <th><?= __('Sort Order') ?></th>
                <td><?= h($group->sort_order) ?></td>
            </tr>
            <tr>
                <th><?= __('Description') ?></th>
                <td><?= nl2br(h($group->description)) ?></td>
            </tr>
            <tr>
                <th><?= __('Created') ?></th>
                <td><?= h($group->created) ?></td>
            </tr>
            <tr>
                <th><?= __('Modified') ?></th>
                <td><?= h($group->modified) ?></td>
            </tr>
        </tbody>
    </table>

<?= $this->element('Uikit.crud_buttons', ['type' => 'view', 'entity' => $group, 'options' => ['showList' => true, 'showDelete' => true]]) ?>
