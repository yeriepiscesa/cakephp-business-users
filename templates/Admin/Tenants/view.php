<?php
/**
 * @var \App\View\AppView $this
 * @var \BusinessUsers\Model\Entity\Tenant $tenant
 */

$this->element('Uikit.page_header', [
    'title' => h($tenant->name),
    'actions' => [
        [
            'label' => __('Edit'),
            'url' => ['action' => 'edit', $tenant->id],
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
                        <td><?= h($tenant->id) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Name') ?></th>
                        <td><?= h($tenant->name) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Code') ?></th>
                        <td><code><?= h($tenant->code) ?></code></td>
                    </tr>
                    <tr>
                        <th><?= __('Status') ?></th>
                        <td>
                            <span class="uk-label <?= $tenant->status === 'active' ? 'uk-label-success' : 'uk-label-warning' ?>">
                                <?= h(__(ucfirst($tenant->status))) ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Description') ?></th>
                        <td><?= nl2br(h($tenant->description)) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Settings') ?></th>
                        <td><pre class="uk-text-small"><?= h($tenant->settings) ?></pre></td>
                    </tr>
                    <tr>
                        <th><?= __('Created') ?></th>
                        <td><?= h($tenant->created) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modified') ?></th>
                        <td><?= h($tenant->modified) ?></td>
                    </tr>
                </tbody>
            </table>

        <?= $this->element('Uikit.crud_buttons', ['type' => 'view', 'entity' => $tenant, 'options' => ['showList' => true, 'showDelete' => true]]) ?>
    </div>
    <div class="uk-width-1-3@m">
        <?php if (!empty($tenant->groups)): ?>
        <div class="uk-card uk-card-default uk-card-body uk-margin-bottom">
            <h4 class="uk-card-title"><?= __('Groups') ?> <span class="uk-badge"><?= count($tenant->groups) ?></span></h4>
            <ul class="uk-list uk-list-divider">
                <?php foreach ($tenant->groups as $group): ?>
                <li><?= h($group->name) ?> <code class="uk-text-small"><?= h($group->code) ?></code></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <?php if (!empty($tenant->roles)): ?>
        <div class="uk-card uk-card-default uk-card-body uk-margin-bottom">
            <h4 class="uk-card-title"><?= __('Roles') ?> <span class="uk-badge"><?= count($tenant->roles) ?></span></h4>
            <ul class="uk-list uk-list-divider">
                <?php foreach ($tenant->roles as $role): ?>
                <li><?= h($role->name) ?> <code class="uk-text-small"><?= h($role->code) ?></code></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <?php if (!empty($tenant->tenant_users)): ?>
        <div class="uk-card uk-card-default uk-card-body">
            <h4 class="uk-card-title"><?= __('Members') ?> <span class="uk-badge"><?= count($tenant->tenant_users) ?></span></h4>
            <ul class="uk-list uk-list-divider">
                <?php foreach ($tenant->tenant_users as $tu): ?>
                <li><?= h($tu->user_id) ?> &mdash; <?= h(__(ucfirst($tu->status))) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>
