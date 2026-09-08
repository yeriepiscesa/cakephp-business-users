<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $country
 */

$this->assign('title', __('Add Country'));
?>

<?= $this->Form->create($country, ['class' => 'uk-form-stacked']) ?>
            <div class="uk-margin">
        <label class="uk-form-label" for="iso"><?= __('Iso') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->control('iso', ['label' => false, 'class' => 'uk-input']) ?>
        </div>
    </div>
            <div class="uk-margin">
        <label class="uk-form-label" for="name"><?= __('Name') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->control('name', ['label' => false, 'class' => 'uk-input']) ?>
        </div>
    </div>
            <div class="uk-margin">
        <label class="uk-form-label" for="nicename"><?= __('Nicename') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->control('nicename', ['label' => false, 'class' => 'uk-input']) ?>
        </div>
    </div>
            <div class="uk-margin">
        <label class="uk-form-label" for="iso3"><?= __('Iso3') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->control('iso3', ['label' => false, 'class' => 'uk-input']) ?>
        </div>
    </div>
            <div class="uk-margin">
        <label class="uk-form-label" for="numcode"><?= __('Numcode') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->control('numcode', ['label' => false, 'class' => 'uk-input']) ?>
        </div>
    </div>
            <div class="uk-margin">
        <label class="uk-form-label" for="phonecode"><?= __('Phonecode') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->control('phonecode', ['label' => false, 'class' => 'uk-input']) ?>
        </div>
    </div>
    
    <?= $this->element('crud_buttons', [
        'type' => 'form',
        'entity' => $country,
        'options' => [
            'showDelete' => false
        ]
    ]) ?>
<?= $this->Form->end() ?>
