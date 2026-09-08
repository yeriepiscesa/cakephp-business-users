<?php
/**
 * @var \App\View\AppView $this
 * @var \BusinessUsers\Model\Entity\TenantUser $tenantUser
 */

$this->element('Uikit.page_header', [
    'title' => h($tenantUser->user_id),
    'actions' => [
        [
            'label' => __('Edit'),
            'url' => ['action' => 'edit', $tenantUser->id],
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
                        <td><?= h($tenantUser->id) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Tenant') ?></th>
                        <td>
                            <?php if ($tenantUser->tenant): ?>
                                <?= $this->Html->link($tenantUser->tenant->name, ['controller' => 'Tenants', 'action' => 'view', $tenantUser->tenant->id]) ?>
                            <?php else: ?>
                                <span class="uk-text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('User ID') ?></th>
                        <td><code><?= h($tenantUser->user_id) ?></code></td>
                    </tr>
                    <tr>
                        <th><?= __('Status') ?></th>
                        <td>
                            <span class="uk-label <?= $tenantUser->status === 'active' ? 'uk-label-success' : 'uk-label-warning' ?>">
                                <?= h($tenantUser->status) ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Owner') ?></th>
                        <td><?= $tenantUser->is_owner ? '<span class="uk-label uk-label-warning">' . __('Yes') . '</span>' : __('No') ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Joined') ?></th>
                        <td><?= $tenantUser->joined ? h($tenantUser->joined) : '<span class="uk-text-muted">-</span>' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Metadata') ?></th>
                        <td><pre class="uk-text-small"><?= h($tenantUser->metadata) ?></pre></td>
                    </tr>
                    <tr>
                        <th><?= __('Created') ?></th>
                        <td><?= h($tenantUser->created) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modified') ?></th>
                        <td><?= h($tenantUser->modified) ?></td>
                    </tr>
                </tbody>
            </table>

        <?= $this->element('Uikit.crud_buttons', ['type' => 'view', 'entity' => $tenantUser, 'options' => ['showList' => true, 'showDelete' => true]]) ?>
    </div>
    <div class="uk-width-1-3@m">
        <?php if (!empty($tenantUser->tenant_user_roles)): ?>
        <div class="uk-card uk-card-default uk-card-body uk-margin-bottom">
            <h4 class="uk-card-title"><?= __('Roles') ?> <span class="uk-badge"><?= count($tenantUser->tenant_user_roles) ?></span></h4>
            <ul class="uk-list uk-list-divider">
                <?php foreach ($tenantUser->tenant_user_roles as $tur): ?>
                <li><?= h($tur->business_users_role_id) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <?php if (!empty($tenantUser->group_members)): ?>
        <div class="uk-card uk-card-default uk-card-body">
            <h4 class="uk-card-title"><?= __('Groups') ?> <span class="uk-badge"><?= count($tenantUser->group_members) ?></span></h4>
            <ul class="uk-list uk-list-divider">
                <?php foreach ($tenantUser->group_members as $gm): ?>
                <li><?= h($gm->business_users_group_id) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>
