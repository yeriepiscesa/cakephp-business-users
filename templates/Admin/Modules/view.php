<?php
/**
 * @var \App\View\AppView $this
 * @var \BusinessUsers\Model\Entity\Module $module
 */

$this->element('Uikit.page_header', [
    'title' => h($module->name),
    'actions' => [
        [
            'label' => __('Edit'),
            'url' => ['action' => 'edit', $module->id],
            'class' => 'uk-button uk-button-primary',
        ],
    ],
]);
?>

<div class="uk-grid-small" uk-grid>
    <div class="uk-width-2-3@m">
        <table class="uk-table uk-table-divider">
                <tbody>
                    <tr>
                        <th class="uk-width-small"><?= __('Id') ?></th>
                        <td><?= h($module->id) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Name') ?></th>
                        <td><?= h($module->name) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Code') ?></th>
                        <td><code><?= h($module->code) ?></code></td>
                    </tr>
                    <tr>
                        <th><?= __('Active') ?></th>
                        <td>
                            <?php if ($module->is_active): ?>
                                <span class="uk-label uk-label-success"><?= __('Yes') ?></span>
                            <?php else: ?>
                                <span class="uk-label"><?= __('No') ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Sort Order') ?></th>
                        <td><?= h($module->sort_order) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Description') ?></th>
                        <td><?= nl2br(h($module->description)) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Settings') ?></th>
                        <td><pre class="uk-text-small"><?= h($module->settings) ?></pre></td>
                    </tr>
                    <tr>
                        <th><?= __('Created') ?></th>
                        <td><?= h($module->created) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modified') ?></th>
                        <td><?= h($module->modified) ?></td>
                    </tr>
                </tbody>
            </table>

        <?= $this->element('Uikit.crud_buttons', ['type' => 'view', 'entity' => $module, 'options' => ['showList' => true, 'showDelete' => true]]) ?>
    </div>
    <div class="uk-width-1-3@m">
        <?php if (!empty($module->permissions)): ?>
        <div class="uk-card uk-card-default uk-card-body">
            <h4 class="uk-card-title"><?= __('Permissions') ?> <span class="uk-badge"><?= count($module->permissions) ?></span></h4>
            <ul class="uk-list uk-list-divider">
                <?php foreach ($module->permissions as $permission): ?>
                <li>
                    <?= h($permission->name) ?>
                    <div class="uk-text-small uk-text-muted"><code><?= h($permission->code) ?></code></div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>
