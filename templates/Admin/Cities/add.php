<?php
/**
 * @var \App\View\AppView $this
 * @var \BusinessUsers\Model\Entity\City $city
 */

$this->set('devScripts', ['resources/js/admin/lookup-select.js']);
$this->set('prodScripts', ['admin/lookup-select.js']);

$this->assign('title', __('Add City'));
?>

<?= $this->Form->create($city, ['class' => 'uk-form-stacked']) ?>
    <div class="uk-margin">
        <label class="uk-form-label" for="state-id-select"><?= __('State') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->select('state_id', [], [
                'label' => false,
                'id' => 'state-id-select',
                'placeholder' => __('Select a state'),
                'data-lookup-url' => $this->Url->build([
                    'plugin' => 'BusinessUsers',
                    'prefix' => 'Admin',
                    'controller' => 'States',
                    'action' => 'lookup',
                ]),
                'data-label-fields' => 'name,country.nicename,country.iso',
                'data-search-field' => 'name',
            ]) ?>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="name"><?= __('Name') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->control('name', ['label' => false, 'class' => 'uk-input']) ?>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="latitude"><?= __('Latitude') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->control('latitude', ['label' => false, 'class' => 'uk-input']) ?>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="longitude"><?= __('Longitude') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->control('longitude', ['label' => false, 'class' => 'uk-input']) ?>
        </div>
    </div>

    <?= $this->element('crud_buttons', [
        'type' => 'form',
        'entity' => $city,
        'options' => [
            'showDelete' => false,
        ],
    ]) ?>
<?= $this->Form->end() ?>
