<?php
    $this->assign('title', "Group $group->name");
?>

<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">

        <li><?= $this->Html->link(
           $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-pencil right-pad-5px')).$this->Html->tag('span', __('Edit Group')),
           ['controller' => 'Groups', 'action' => 'edit',$group->id],
           array('escape'=>false)) ?>
        </li>
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
<div class="groups view large-10 medium-9 columns">
    <h2 class="bold move-right-5px"><?= h($group->name) ?></h2>
    <div class="row">
            <div class="large-9 columns">
              <h4 class="subheader"><?= __('Current users in the {0} group',$group->name) ?></h4>
            <?php if (!empty($group->users)): ?>
            <table class="table dataTable card border-blue-left" cellspacing="0">
                <tr>
                    <th><?= __('Username') ?></th>
                    <th><?= __('Name') ?></th>
                    <th><?= __('Email') ?></th>


                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($group->users as $users): ?>
                <tr>
                    <td><?= h($users->username) ?></td>
                    <td><?= h($users->firstname) ?>
                    <?= h($users->surname) ?></td>
                    <td><?= h($users->email) ?></td>



                    <td class="actions">
                <?php
                echo $this->Html->link(
                     '<i class="glyphicon glyphicon-eye-open right-pad-5px"></i>View',
                     ['controller'=>'Users','action' => 'view', $users->id],
                     ['class'=>'btn btn-info','escape'=>false]
                    );
                ?>&nbsp;&nbsp;
                 <?php
                echo $this->Html->link(
                     '<i class="glyphicon glyphicon-edit right-pad-5px"></i>Edit',
                     ['controller'=>'Users','action' => 'edit', $users->id],
                     ['class'=>'btn btn-warning','escape'=>false]
                    );
 ?>

                    </td>
                </tr>

                <?php endforeach; ?>
            </table>
            <?php endif; ?>
            </div>
    </div>
</div>
