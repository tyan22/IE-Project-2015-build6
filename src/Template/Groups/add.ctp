<?php
    $this->assign('title', "ADD NEW GROUP");
        $this->Html->addCrumb('Groups', '/groups');
        $this->Html->addCrumb('Add Group', ['controller' => 'Groups', 'action' => 'add']);
?>
<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">

            <li><?= $this->Html->link(
             $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-list-alt right-pad-5px')).$this->Html->tag('span', __('List Groups')),
             ['action' => 'index'],
             array('escape'=>false)) ?>
            </li>
    </ul>
</div>
<div class="customers index large-10 medium-9 columns">
<div class="edit_tables">
    <?= $this->Form->create($group,['novalidate' => true]); ?>
    <fieldset>
        <legend><?= __('Add Group') ?></legend>
        <?php
            echo $this->Form->input('name');
        ?>
    </fieldset>
    <br />

    <?= $this->Form->button(__('Submit'),['class'=>'btn btn-success']) ?>
    <?= $this->Form->end() ?>
    <span class="required-notice">* required</span>
</div>
</div>
