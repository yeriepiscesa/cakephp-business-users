<?php
/**
 * @var \App\View\AppView $this
 * @var \BusinessUsers\Model\Entity\Permission $permission
 */

$this->element('Uikit.page_header', [
    'title' => h($permission->name),
    'actions' => [
        [
            'label' => __('Edit'),
            'url' => ['action' => 'edit', $permission->id],
            'class' => 'uk-button uk-button-primary',
        ],
    ],
]);
?>

<table class="uk-table uk-table-divider">
        <tbody>
            <tr>
                <th class="uk-width-small"><?= __('Id') ?></th>
                <td><?= h($permission->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Module') ?></th>
                <td>
                    <?php if ($permission->module): ?>
                        <?= $this->Html->link($permission->module->name, ['controller' => 'Modules', 'action' => 'view', $permission->module->id]) ?>
                    <?php else: ?>
                        <span class="uk-text-muted">-</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Name') ?></th>
                <td><?= h($permission->name) ?></td>
            </tr>
            <tr>
                <th><?= __('Code') ?></th>
                <td><code><?= h($permission->code) ?></code></td>
            </tr>
            <tr>
                <th><?= __('Active') ?></th>
                <td>
                    <?php if ($permission->is_active): ?>
                        <span class="uk-label uk-label-success"><?= __('Yes') ?></span>
                    <?php else: ?>
                        <span class="uk-label"><?= __('No') ?></span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Sort Order') ?></th>
                <td><?= h($permission->sort_order) ?></td>
            </tr>
            <tr>
                <th><?= __('Description') ?></th>
                <td><?= nl2br(h($permission->description)) ?></td>
            </tr>
            <tr>
                <th><?= __('Created') ?></th>
                <td><?= h($permission->created) ?></td>
            </tr>
            <tr>
                <th><?= __('Modified') ?></th>
                <td><?= h($permission->modified) ?></td>
            </tr>
        </tbody>
    </table>

<?= $this->element('Uikit.crud_buttons', ['type' => 'view', 'entity' => $permission, 'options' => ['showList' => true, 'showDelete' => true]]) ?>
