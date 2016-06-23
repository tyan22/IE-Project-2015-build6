<?php
    $this->assign('title', "Edit $anniversarytype->type");
    $this->Html->addCrumb('Anniversary Types', ['controller' => 'Anniversarytypes', 'action' => 'index']);

    $this->Html->addCrumb('Edit Anniversary Type', ['controller' => 'Anniversarytypes', 'action' => 'edit',$anniversarytype->id]);

?>
<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">


              <li>
              <?php
                 echo $this->Form->postLink(
                     $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove right-pad-5px')). __('Delete Type'),
                          array('action' => 'delete', $anniversarytype->id),
                          array('escape'=>false, 'confirm'=>__('Are you sure you want to delete the {0} anniversary type?', $anniversarytype->type))
                  );
         ?>
         </li>
    </ul>
</div>
<div class="customers index large-10 medium-9 columns">
<div class="edit_tables">
    <?= $this->Form->create($anniversarytype,['novalidate' => true]); ?>
    <fieldset>
        <legend><?= __('Edit Anniversary Type') ?></legend>
        <?php
            echo $this->Form->input('type');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
    <span class="required-notice">* required</span>
</div>
</div>
