<?php
    $this->assign('title', "Edit Group $group->name");
?>
<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">


             <li>
             <?php
                echo $this->Form->postLink(
                    $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove right-pad-5px')). __('Delete Group'),
                         array('action' => 'delete', $group->id),
                         array('escape'=>false, 'confirm'=>__('Are you sure you want to delete the {0} group?', $group->name))
                 );
        ?></li>
    </ul>
</div>
<div class="groups form large-6 medium-8 columns">
    <div class="edit_tables">
    <?= $this->Form->create($group,['novalidate' => true]); ?>
    <fieldset>
        <legend><?= __('Edit Group') ?></legend>
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
<div class="groups form large-6 medium-4 columns">
</div>
