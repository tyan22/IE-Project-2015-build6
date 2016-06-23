<?php
    $this->assign('title', "Add New Anniversary Type");
    $this->Html->addCrumb('Anniversary Types', ['controller' => 'Anniversarytypes', 'action' => 'index']);
    $this->Html->addCrumb('Add Anniversary Type', ['controller' => 'Anniversarytypes', 'action' => 'add']);
?>

<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">

        <li><?= $this->Html->link(
             $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-list-alt right-pad-5px')).$this->Html->tag('span', __('List Anniversary Types')),
             ['action' => 'index'],
             array('escape'=>false)) ?>
            </li>
    </ul>
</div>
<div class="customers index large-7 medium-9 columns">
<div class="edit_tables">
    <?= $this->Form->create($anniversarytype,['novalidate' => true]); ?>
    <fieldset>
        <legend><?= __('Add Anniversary Type') ?></legend>
        <?php
            echo '<div class="large-4 medium-6">';
            echo $this->Form->input('type');
            echo '</div>';
        ?>
    </fieldset>
    <br />

    <?= $this->Form->button(__('Submit'),['class'=>'btn btn-success']) ?>
    <?= $this->Form->end() ?>
    <span class="required-notice">* required</span>
</div>
</div>
<div class="hidden-sm large-5 medium-3 columns">
</div>
