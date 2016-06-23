<?php
    $this->assign('title', "Edit Order #$order->id");
    $this->Html->addCrumb('Orders', '/orders');
    $this->Html->addCrumb('Edit Order', ['controller' => 'Orders', 'action' => 'edit',$order->id]);
?>
<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">


        <li>
        <?php
        echo $this->Form->postLink(
           $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove right-pad-5px')). __('Delete Order'),
                array('action' => 'delete', $order->id),
                array('escape'=>false,'confirm'=>__('Are you sure you want to delete order #{0} belonging to customer {1}?',
                $order->id, $customer->fullName))
           );
        ?>
       </li>

       <li>
         <?= $this->Html->link(
         $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-plus-sign right-pad-5px')).$this->Html->tag('span', __('Add File to Stash')),
         ['controller' => 'Stashes', 'action' => 'add',$order->id],array('escape'=>false)) ?>
       </li>

    </ul>
</div>
<div class="orders form large-10 medium-9 columns">
<div class="edit_tables">

    <?= $this->Form->create($order,['novalidate' => true]); ?>
    <fieldset>
        <legend><?= __('Edit Order') ?></legend>
        <?php
        echo "<div class='row'>";
        echo "<div class='medium-6 columns'>";
            echo $this->Form->input('customer_id', ['options' => $customers,'hidden'=>true,'value'=>$customer->id]);
            echo $this->Form->input('customer_id_hidden', ['options' => $customers,'disabled','label'=>false,'value'=>$order->customer_id]);
        echo '</div>';
        echo '<div class="medium-6 columns">';
        $stateName = "";
        if (!empty($customer->state->name))
          $stateName = " ". $customer->state->name;
          echo '<p><strong>Address:</strong> '.$customer->address. ' '. $customer->suburb . $stateName . ' '. $customer->postcode .'<br />';
          echo '<strong>Phone:</strong> '.$customer->phone.'<br />';
          echo '<strong>Email:</strong> '.$customer->email.'</p>';
        echo "</div>";
        echo "</div>";
        echo "<div class='row'>";
        echo "<div class='medium-4 columns'>";
            echo $this->Form->input('quote');
        echo "</div>";
        echo '<div class="medium-6 columns">';
            echo $this->Form->input('vendor_id', ['options' => $vendors,'label'=>'Vendor','empty'=>true]);
        echo "</div>";
        echo '<div class="hidden-sm medium-2 columns">';
        echo "</div>";
        echo "</div>";
        echo "<div class='row'>";
        echo '<div class="medium-6 columns acceptquote">';
          echo "<strong>Customer has accepted quote </strong>" . $this->Form->checkbox('acceptedquote');
        echo "</div>";
        echo "</div>";
            echo $this->Form->input('order_type', ['type'=>'radio','options'=>$orderTypes, 'label'=>'Order Type']);
            echo "<div class='row'>";
              echo "<div class='medium-6 columns'>";
                echo $this->Form->input('orderstatus_id', ['label'=>'Order Status','options' => $orderstatuses]);
              echo "</div>";
              echo "<div class='medium-6 columns'>";
                echo $this->Form->input('paymentstatus_id', ['label'=>'Payment Status','options' => $paymentstatuses]);
              echo "</div>";
            echo "<div class='row'>";
            echo "<div class='medium-12 columns'>";
            echo "<div class='medium-12 columns'>";

                echo "<div class='medium-9 columns'>";
                    echo $this->Form->input('description', ['label'=>'Order Notes']);
                echo "</div>";
              echo "</div>";
             echo "</div>";
           echo "</div>";
              ?>
    </fieldset>

    <br />
    <?= $this->Form->button(__('Submit'),['class'=>'btn btn-success']) ?>
    <?= $this->Form->end() ?>
    <span class="required-notice">* required</span>
    </div>
</div>
<script>
    $(document).ready(function(){
      $('.acceptquote').hide();
      $('input[name=quote]').change(function(){
          if ($('input[name=quote]').val() != 0)
            $('.acceptquote').show();
          else {
            $('.acceptquote').hide();
          }
      });
      $('input[name=quote]').keyup(function(){
          if ($('input[name=quote]').val() != 0)
            $('.acceptquote').show();
          else {
            $('.acceptquote').hide();
          }
      });
    });
</script>
