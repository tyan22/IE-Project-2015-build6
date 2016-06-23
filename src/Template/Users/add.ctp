<?php
    $this->assign('title', 'Add New User');
    $this->Html->addCrumb('Users', '/users');
    $this->Html->addCrumb('Add User', ['controller' => 'Users', 'action' => 'add']);
?>

<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">

             <li><?= $this->Html->link(
             $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-list-alt right-pad-5px')).$this->Html->tag('span', __('List Users')),
             ['action' => 'index'],
             array('escape'=>false)) ?>
            </li>
    </ul>
</div>
<div class="customers index large-10 medium-9 columns">
<div class="edit_tables">
  <?php if ($count == 0)
    echo "<p>Step 1 of 2:</p>";
    ?>
    <?= $this->Form->create($user,['novalidate' => true]); ?>
    <fieldset>
        <legend><?php if ($count == 0) { echo 'Add Initial Admin Account'; } else { echo 'Add User';}?></legend>
        <?php
            echo '<div class="row">';
            echo '<div class="columns large-5">';
            echo $this->Form->input('username');
            echo '</div>';
            echo '<div class="columns large-2">';
            //if we have no users, this user must be admin. set to admin and display but disable editing
                        if ($count == 0) {
                            echo $this->Form->input('disabled', ['options' => $groups, 'default' => '1', 'disabled' => TRUE, 'label'=>'Access Level']);
                            echo $this->Form->input('group_id', ['options' => $groups, 'default' => '1', 'hidden' => TRUE, 'label' => FALSE]);
                        }
                        //otherwise if user has admin access level (level 1), allow to edit
                        else if(!empty($loggedInLevel && $loggedInLevel == '1')){
                            echo $this->Form->input('group_id', ['options' => $groups, 'default' => '2']);
                        }
                        //and if user does not have admin access level, display but lock to level 3 (assistant level)
                        else {
                            echo $this->Form->input('disabled', ['options' => $groups, 'default' => '3', 'disabled' => TRUE, 'label'=>'Access Level']);
                            echo $this->Form->input('group_id', ['options' => $groups, 'default' => '3', 'hidden' => TRUE, 'label' => FALSE]);
                        }
                  echo '</div>';
                  echo '<div class="columns large-5">';
                  echo '</div>';
            echo '</div>';
            echo '<div class="row">';
                echo '<div class="columns large-5">';
                    echo $this->Form->input('firstname');
                echo '</div>';
                echo '<div class="columns large-5">';
                    echo $this->Form->input('surname');
                echo '</div>';
                echo '<div class="columns large-2">';
                echo '</div>';
            echo '</div>';
            echo '<div class="row">';
                 echo '<div class="columns large-5">';
                      echo $this->Form->input('password');
                 echo '</div>';
            echo '</div>';
            echo '<div class="row">';
                echo '<div class="columns large-5">';
                     echo $this->Form->input('email');
                echo '</div>';
            echo '</div>';
        ?>
    </fieldset>
    <br />

    <?php if ($count == 0){
      echo "<p>Go to Step 2: Set Initial Settings</p>";
      echo $this->Form->button(__('Next'),['class'=>'btn btn-success']);
    }
    else
     echo $this->Form->button(__('Submit'),['class'=>'btn btn-success']); ?>
    <?= $this->Form->end() ?>
    <span class="required-notice">* required</span>
</div>
</div>
