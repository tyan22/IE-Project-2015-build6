<?php
$this->assign('title', "Adjust Settings");
$this->Html->addCrumb('Settings', '/settings/edit/1');
?>
<style>
  .smslink{
    color:#CC5151;text-decoration:underline !important;
  }
  .smslink:hover{
    color:#634d4d;text-decoration:underline !important;
  }
</style>
<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
      <li><?= $this->Html->link(
           $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-ban-circle right-pad-5px')).$this->Html->tag('span', __('Cancel Edit')),
           ['controller' => 'pages', 'action' => 'start'],
           array('escape'=>false))
           ?>
      </li>
    </ul>
</div>
<div class="customers index large-10 medium-9 columns">
<div class="edit_tables">
  <?php if (isset($this->request->query['init']) && $this->request->query['init'] == 'y')
    echo "<p>Step 2 of 2:</p>";
    ?>
    <?= $this->Form->create($setting) ?>
    <fieldset>
        <legend><?= __('Set Initial Settings') ?></legend>
        <?php
        echo '<div class="row">';
            echo '<div class="columns medium-9">';
               echo '<br /><p style="color:#CC5151;font-size:14px">NOTE: If you do not have an account with <a class="smslink" href="https://www.smsbroadcast.com.au/">SMS Broadcast Australia</a> and enter your username and password here, the SMS functionality of this application will be disabled. You must also ensure there is sufficient credit on your account. To receive test SMSs, you must also enter your mobile number into the SMS Test Mobile field.</p>';
           echo '</div>';
        echo '</div>';
        echo '<div class="row">';
            echo '<div class="columns medium-6">';
               echo $this->Form->input('sms_username',['label'=>'SMS Broadcast Aus. Username']);
           echo '</div>';
        echo '</div>';
        echo '<div class="row">';
            echo '<div class="columns medium-6">';
               echo $this->Form->input('sms_password',['label'=>'SMS Broadcast Aus. Password']);
           echo '</div>';
        echo '</div>';
        echo '<div class="row">';
            echo '<div class="columns medium-6">';
               echo $this->Form->input('test_sms_mobile',['label'=>'SMS Test Mobile']);
           echo '</div>';
        echo '</div>';
        echo '<div class="row">';
            echo '<div class="columns medium-6">';
               echo $this->Form->input('paypal_username',['label'=>'Paypal Username']);
           echo '</div>';
        echo '</div>';
        echo '<div class="row">';
            echo '<div class="columns medium-6">';
               echo $this->Form->input('paypal_password',['label'=>'Paypal Password']);
           echo '</div>';
        echo '</div>';
        echo '<div class="row">';
            echo '<div class="columns medium-6">';
               echo $this->Form->input('paypal_signature',['label'=>'Paypal Signature']);
           echo '</div>';
        echo '</div>';
        echo '<div class="row">';
            echo '<div class="columns medium-7">';
               echo $this->Form->input('business_name');
           echo '</div>';
        echo '</div>';
        echo '<div class="row">';
            echo '<div class="columns medium-7">';
               echo $this->Form->input('business_name');
           echo '</div>';
        echo '</div>';
        echo '<div class="row">';
            echo '<div class="columns medium-11">';
               echo $this->Form->input('address');
           echo '</div>';
        echo '</div>';
        echo '<div class="row">';
            echo '<div class="columns medium-6">';
               echo $this->Form->input('phone');
           echo '</div>';
        echo '</div>';
            echo '<div class="row">';
                echo '<div class="columns medium-6">';
                echo $this->Form->input('admin_email');
                echo '</div>';
                echo '<div class="columns medium-6">';
                echo $this->Form->input('enquiry_email');
                echo '</div>';
            echo '</div>';
            echo '<div class="row">';
                echo '<div class="columns medium-8">';
                   echo $this->Form->input('website');
               echo '</div>';
            echo '</div>';
            echo '<div class="row">';
                echo '<div class="columns large-5 medium-4">';
                echo $this->Form->input('abn', ['label'=>'ABN']);
                echo '</div>';
                echo '<div class="columns large-2 medium-4">';
                echo $this->Form->input('gst_rate',['label'=>'GST Rate %']);
                echo '</div>';
                echo '<div class="columns show-for-medium-up large-5 medium-4">';
                echo '</div>';
            echo '</div>';
        ?>
    </fieldset>
    <br />

    <?php
     echo $this->Form->button(__('Submit'),['class'=>'btn btn-success']); ?>
    <?= $this->Form->end() ?>
    <span class="required-notice">* required</span>
</div>
</div>
