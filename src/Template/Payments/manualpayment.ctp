<?php
    $this->assign('title', "Add Manual Payment | Order #".$this->request->params['pass'][0]);
    $this->Html->addCrumb('Orders', '/orders');
    $this->Html->addCrumb('View Order', ['controller' => 'Orders', 'action' => 'view',$this->request->params['pass'][0]]);
    $this->Html->addCrumb('Add Manual Payment', ['controller' => 'Payments', 'action' => 'manualpayment',$this->request->params['pass'][0]]);

?>
<style>
  .radio label {
    padding-left:20px;
  }
  div.input.radio {
    margin-top:0px;
  }
</style>
<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">


        <li><?= $this->Html->link(
             $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-ban-circle right-pad-5px')).$this->Html->tag('span', __('Cancel Add Payment')),
             ['controller' => 'Orders', 'action' => 'view',$this->request->params['pass'][0]],
             array('escape'=>false)) ?>
            </li>
        </li>
    </ul>
</div>
<div class="stashes form large-10 medium-9 columns">
<div class="edit_tables">
    <?= $this->Form->create($payment,['novalidate' => true]); ?>
    <fieldset>
        <legend><?= __('Add Manual Payment | Order #' . $this->request->params['pass'][0]) ?></legend>
        <?php
            echo $this->Form->hidden('order_id', ['value' =>  $this->request->params['pass'][0]]);
            echo "<h6><strong>Note:</strong> If cheque is selected, enter cheque number as reference</h6>";
            echo "<br /><h6 style='margin-bottom:0px;'><strong>Payment Method</strong></h6>";
            echo $this->Form->input('paymentOpts', ['default'=>'1','type'=>'radio','options'=>$paymentOpts, 'label'=>false]);
            echo "<br /><h6 style='margin-bottom:0px;display:inline'><strong>Payment Type</strong> - select if appropriate</h6>&nbsp;&nbsp;";
            echo '<button id="clearMiscOpts" class="btn btn-xs btn-info">clear</button>';
            echo $this->Form->input('miscOpts', ['type'=>'radio','options'=>$miscOpts, 'label'=>false]);
            echo "<div class='medium-2 small-4'>";
            echo "<br /><h6><strong>Balance Remaining</strong></h6>" . $this->Number->currency($order->balance);
            echo $this->Form->input('amount',['label'=>'Payment Amount $','type'=>'number', 'min' => '0']);
            echo "</div>";
            echo "<div id='refnumber' style='display:none;' class='large-5'>";
            echo $this->Form->input('reference',['label'=>'Reference']);
            echo "</div>";

        ?>
    </fieldset>
    <br />
    <?= $this->Form->button(__('Submit'),['class'=>'btn btn-success']) ?>
    <?= $this->Form->end() ?>
  </div>
</div>

<script>
    $(document).ready(function(){
      $('#paymentopts-5').click(function(){
          $('#refnumber').show();
      });
      $('#paymentopts-1, #paymentopts-2, #paymentopts-3').click(function(){
          $('input[name=reference]').val('');
          $('#refnumber').hide();
      });
      $('#clearMiscOpts').click(function(evt){
        evt.preventDefault();
        $('#miscopts-deposit').removeAttr('checked');
        $('#miscopts-refund').removeAttr('checked');
      });
    });
</script>
