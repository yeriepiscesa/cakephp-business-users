<?php
/**
 * @var \App\View\AppView $this
 * @var \BusinessUsers\Model\Entity\Role $role
 */

$this->element('Uikit.page_header', [
    'title' => h($role->name),
    'actions' => [
        [
            'label' => __('Edit'),
            'url' => ['action' => 'edit', $role->id],
            'class' => 'uk-button uk-button-primary',
        ],
    ],
]);
?>

<table class="uk-table uk-table-divider">
        <tbody>
            <tr>
                <th class="uk-width-small"><?= __('Id') ?></th>
                <td><?= h($role->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Tenant') ?></th>
                <td>
                    <?php if ($role->tenant): ?>
                        <?= $this->Html->link($role->tenant->name, ['controller' => 'Tenants', 'action' => 'view', $role->tenant->id]) ?>
                    <?php else: ?>
                        <span class="uk-text-muted">-</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Name') ?></th>
                <td><?= h($role->name) ?></td>
            </tr>
            <tr>
                <th><?= __('Code') ?></th>
                <td><code><?= h($role->code) ?></code></td>
            </tr>
            <tr>
                <th><?= __('Level') ?></th>
                <td><?= h($role->level) ?></td>
            </tr>
            <tr>
                <th><?= __('Active') ?></th>
                <td>
                    <?php if ($role->is_active): ?>
                        <span class="uk-label uk-label-success"><?= __('Yes') ?></span>
                    <?php else: ?>
                        <span class="uk-label"><?= __('No') ?></span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Default') ?></th>
                <td><?= $role->is_default ? __('Yes') : __('No') ?></td>
            </tr>
            <tr>
                <th><?= __('Sort Order') ?></th>
                <td><?= h($role->sort_order) ?></td>
            </tr>
            <tr>
                <th><?= __('Description') ?></th>
                <td><?= nl2br(h($role->description)) ?></td>
            </tr>
            <tr>
                <th><?= __('Created') ?></th>
                <td><?= h($role->created) ?></td>
            </tr>
            <tr>
                <th><?= __('Modified') ?></th>
                <td><?= h($role->modified) ?></td>
            </tr>
        </tbody>
    </table>

<?= $this->element('Uikit.crud_buttons', ['type' => 'view', 'entity' => $role, 'options' => ['showList' => true, 'showDelete' => true]]) ?>
