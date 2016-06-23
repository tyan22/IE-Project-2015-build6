<?php
  $this->assign('title', "Edit Auto Mail Msg");
  $param = 0;
  if ($this->request->query['type'] == 'zodiac'){
    $this->Html->addCrumb('Edit Zodiac Auto Mailout', ['controller' => 'automail', 'action' => 'edit',1]);
    $param = 1;
  }
  else if ($this->request->query['type'] == 'monthly') {
    $this->Html->addCrumb('Edit Birthday Auto Mailout', ['controller' => 'automail', 'action' => 'edit',2]);
    $param = 2;
  }
  else {
    $this->Html->addCrumb('Edit Anniv. Auto Mailout', ['controller' => 'automail', 'action' => 'edit',3]);
    $param = 3;
  }
  $this->Html->addCrumb('Edit '. ucfirst($this->request->query['type']) .' Msgs', ['controller' => 'automail_msgs', 'action' => 'edit','type'=>$this->request->query['type']]);
 ?><div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
      <li><?= $this->Html->link(
          $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-ban-circle right-pad-5px')).$this->Html->tag('span', __('Cancel Edit')),
          ['controller'=>'Automail','action' => 'view',$param],
          array('escape'=>false)) ?>
     </li>
   </ul>
</div>
<div class="automailMsgs view large-10 medium-9 columns">
  <div class="edit_tables">

    <h2><?= h('Edit '. ucfirst($this->request->query['type']) . '  Message Descriptions') ?></h2>
    <?= $this->Form->create(null) ?>
    <?php foreach($msgs as $msg){
    echo '<div class="row">';
        echo '<div class="columns medium-10">';
          echo $this->Form->input('message',['type'=>'textarea','label'=>$msg->name,'value'=>$msg->msg]);
        echo '</div>';
      echo '</div>';
  }?>
  <br />
  <?= $this->Form->button(__('Submit'),['class'=>'btn btn-success']) ?>
  <?= $this->Form->end ?>
<span class="required-notice">* required</span>
</div>
</div>
