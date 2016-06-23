<?php
    $this->assign('title', "Edit User $user->username");
    $this->Html->addCrumb('Users', '/users');
    $this->Html->addCrumb('Edit User', ['controller' => 'Users', 'action' => 'edit',$user->id]);
?>

<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">

            <li>
        <?php
        echo $this->Form->postLink(
           $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove right-pad-5px')). __('Delete User'),
                array('action' => 'delete', $user->id),
                array('escape'=>false, 'confirm'=>__('Are you sure you want to delete user {0}?', $user->username))

           );
        ?>
        </li>

    </ul>
</div>
<div class="customers index large-10 medium-9 columns">
<div class="edit_tables">
    <?= $this->Form->create($user,['novalidate' => true]); ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo '<div class="row">';
                echo '<div class="columns large-5">';
                    echo $this->Form->input('username');
                echo '</div>';
                echo '<div class="columns large-2">';
                //only allow editing of access level if admin group (level 1). otherwise, display value but disable editing
                if(!empty($loggedInLevel && $loggedInLevel == '1')){
                    echo $this->Form->input('group_id', ['options' => $groups, 'label'=>'Access Level']);
                }
                else {
                    echo $this->Form->input('disabled', ['options' => $groups, 'default'=> $loggedInLevel, 'disabled' => TRUE, 'label'=>'Access Level']);
                }echo '</div>';
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

    <?= $this->Form->button(__('Submit'),['class'=>'btn btn-success']) ?>
    <?= $this->Form->end() ?>
    <span class="required-notice">* required</span>
</div>
</div>
