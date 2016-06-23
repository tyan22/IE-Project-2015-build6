<?php
    $this->assign('title', "Add to Stash | Order #".$this->request->params['pass'][0]);
    $this->Html->addCrumb('Orders', '/orders');
    $this->Html->addCrumb('View Order', ['controller' => 'Orders', 'action' => 'view',$this->request->params['pass'][0]]);
    $this->Html->addCrumb('Add File to Stash', ['controller' => 'Stashes', 'action' => 'add',$this->request->params['pass'][0]]);

?>
<style>
  .radio label {
    padding-left:20px;
  }
</style>
<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">


        <li><?= $this->Html->link(
             $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-ban-circle right-pad-5px')).$this->Html->tag('span', __('Cancel Add to Stash')),
             ['controller' => 'Orders', 'action' => 'view',$this->request->params['pass'][0]],
             array('escape'=>false)) ?>
            </li>
        </li>
    </ul>
</div>
<div class="stashes form large-10 medium-9 columns">
<div class="edit_tables">
    <?= $this->Form->create($stash,['enctype' => 'multipart/form-data']); ?>
    <fieldset>
        <legend><?= __('Add to Stash | Order #' . $this->request->params['pass'][0]) ?></legend>
        <?php
            echo $this->Form->hidden('order_id', ['options' => $orders]);
            echo "<h6><strong>Public:</strong> customer can see this file<br /><strong>Private:</strong> only admin can see this file</h6>";
            echo $this->Form->input('visible', ['type'=>'radio','options'=>$stashVis, 'label'=>false]);
            echo $this->Form->file('uploadfile', ['label' =>'', 'size'=>'60']);
        ?>
    </fieldset>
    <br />
    <?= $this->Form->button(__('Submit'),['class'=>'btn btn-success']) ?>
    <?= $this->Form->end() ?>
  </div>
</div>
