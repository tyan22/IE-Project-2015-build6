<?php
    $this->assign('title', "Forgot Password");
    $this->Html->addCrumb('Login', ['controller' => 'Users', 'action' => 'login']);
    $this->Html->addCrumb('Forgot Password', ['controller' => 'Users', 'action' => 'forgot']);
?>

<div class="users form large-offset-3 large-6 medium-6 columns">
    <p><strong>Please enter the email address associated with your account. Your password will be reset and an email will be sent to this address with your temporary password.</strong></p>
    <?php echo $this->Form->create('User', array('controller'=>'Users', 'action' => 'forgot')); ?>
    <fieldset>
        <?php echo $this->Form->input('email');?>
    </fieldset>
    <br />

    <?= $this->Form->button(__('Reset Password'),['class'=>'btn btn-success']) ?>
    <?php echo $this->Form->end();?>
</div>
