<?php
    $this->assign('title', "ADD NEW ORDER");
    $this->Html->addCrumb('Orders', '/orders');
    $this->Html->addCrumb('Customer', ['controller' => 'Customers', 'action' => 'view', $this->request->pass[0]]);
    $this->Html->addCrumb('Add Order', ['controller' => 'Orders', 'action' => 'add', $this->request->pass[0]]);

?>
<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">

        <li><?= $this->Html->link(
             $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-list-alt right-pad-5px')).$this->Html->tag('span', __('List Orders')),
             ['action' => 'index'],
             array('escape'=>false)) ?>
            </li>
            <li><?= $this->Html->link(
             $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-ban-circle right-pad-5px')).$this->Html->tag('span', __('Cancel Add Order')),
             ['controller' => 'Customers', 'action' => 'view',$this->request->pass[0]],
             array('escape'=>false)) ?>
            </li>
        </li>
            </ul>
</div>
<div class="orders form large-10 medium-9 columns">
<div class="edit_tables">
    <?= $this->Form->create($order,['novalidate' => true]); ?>
    <fieldset>
        <legend><?= __('Add Order') ?></legend>
        <?php
        echo "<div class='row'>";
        echo "<div class='medium-6 columns'>";
            echo $this->Form->input('customer_id', ['options' => $customers,'hidden'=>true,'value'=>$this->request->pass[0]]);
            echo $this->Form->input('customer_id_hidden', ['options' => $customers,'disabled','label'=>false,'value'=>$this->request->pass[0]]);
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
                echo $this->Form->hidden('orderstatus_id', ['value'=>'0']);
              echo "</div>";
              echo "<div class='medium-6 columns'>";
                echo $this->Form->hidden('paymentstatus_id', ['value'=>'0']);
              echo "</div>";
             echo "<div class='row'>";
                         echo "<div class='medium-12 columns'>";
                           echo "<div class='medium-12 columns'>";

                             echo "<div class='medium-9 columns'>";
                    echo $this->Form->input('description', ['label'=>'Order Description']);
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
