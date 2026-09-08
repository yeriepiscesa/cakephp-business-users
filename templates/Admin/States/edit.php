<?php
/**
 * @var \App\View\AppView $this
 * @var \BusinessUsers\Model\Entity\State $state
 */

$this->set('devScripts', ['resources/js/admin/lookup-select.js']);
$this->set('prodScripts', ['admin/lookup-select.js']);

$this->assign('title', __('Edit State'));

$countryLabel = $state->country
    ? implode(', ', array_filter([$state->country->nicename, $state->country->iso]))
    : '';
?>

<?= $this->Form->create($state, ['class' => 'uk-form-stacked']) ?>
    <div class="uk-margin">
        <label class="uk-form-label" for="country-id-select"><?= __('Country') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->select('country_id', [
                $state->country_id => $countryLabel,
            ], [
                'label' => false,
                'id' => 'country-id-select',
                'placeholder' => __('Select a country'),
                'data-lookup-url' => $this->Url->build([
                    'plugin' => 'BusinessUsers',
                    'prefix' => 'Admin',
                    'controller' => 'Countries',
                    'action' => 'lookup',
                ]),
                'data-label-fields' => 'nicename,iso',
                'data-search-field' => 'nicename',
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
        <label class="uk-form-label" for="state_code"><?= __('State Code') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->control('state_code', ['label' => false, 'class' => 'uk-input']) ?>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="longitude"><?= __('Longitude') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->control('longitude', ['label' => false, 'class' => 'uk-input']) ?>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="latitude"><?= __('Latitude') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->control('latitude', ['label' => false, 'class' => 'uk-input']) ?>
        </div>
    </div>

    <?= $this->element('crud_buttons', [
        'type' => 'form',
        'entity' => $state,
        'options' => [
            'returnUrl' => $returnUrl,
            'showDelete' => true,
            'showNew' => true,
        ],
    ]) ?>
<?= $this->Form->end() ?>
