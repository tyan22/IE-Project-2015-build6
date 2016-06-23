<?php
    $this->assign('title', 'CREATE INVOICE FOR ORDER #' . $this->request->pass[0]);
    $this->Html->addCrumb('Orders', '/orders');
    $this->Html->addCrumb('Order', ['controller' => 'Orders', 'action' => 'view', $this->request->pass[0]]);
    $this->Html->addCrumb('Create Invoice', ['controller' => 'Invoices', 'action' => 'add', $this->request->pass[0]]);
?>
<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(
             $this->Html->tag('i', '', ['class' => 'glyphicon glyphicon-list-alt right-pad-5px']).$this->Html->tag('span', __('List All Invoices')),
             ['action' => 'index'],
             ['escape'=>false]) ?>
        </li>
        <li><?= $this->Html->link(
             $this->Html->tag('i', '', ['class' => 'glyphicon glyphicon-list right-pad-5px']).$this->Html->tag('span', __('List Invoices for #'.$this->request->pass[0])),
             ['action' => 'index',$this->request->pass[0]],
             ['escape'=>false]) ?>
        </li>

        <li><?= $this->Html->link(
         $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-ban-circle right-pad-5px')).$this->Html->tag('span', __('Cancel Add Invoice')),
         ['controller' => 'Orders', 'action' => 'view',$this->request->pass[0]],
         array('escape'=>false)) ?>
        </li>
    </ul>
</div>
<div class="customers index large-10 medium-9 columns">
<div class="edit_tables">
    <?= $this->Form->create($invoice,['novalidate' => true]) ?>
    <fieldset>
        <legend><?= __('Create Invoice for Order #'.$this->request->pass[0]) ?></legend>
        <?php
        echo '<div class="row">';
          echo '<div class="columns small-7 medium-5 large-3">';
            echo $this->Form->hidden('order_id', ['value' => $this->request->pass[0]]);
            echo $this->Form->input('datepaid', array('label'=>'Date Paid'));
          echo '</div>';
        echo '</div>';
        ?>
    </fieldset>
    <fieldset>
      <?php
        echo '<h4><strong>Invoice Items</strong></h4>';
        echo '<div class="row">';
          echo '<div class="columns small-8 medium-7 large-8">';
           echo $this->Form->input('invoiceitem[0]', ['label'=>'Description','placeholder'=>'item 1 desc']);
          echo '</div>';
          echo '<div class="columns small-4 medium-4 large-2">';
           echo $this->Form->input('invoiceprice[0]', ['label'=>'Price ex. GST','type' => 'number','placeholder'=>'item 1 price']);
          echo '</div>';
          echo '<div class="columns medium-1 large-2 show-for-medium-up">';
          echo '</div>';
        echo '</div>';
        echo '<div class="row">';
          echo '<div class="columns small-8 medium-7 large-8">';
           echo $this->Form->input('invoiceitem[1]', ['label'=>false,'placeholder'=>'item 2 desc']);
          echo '</div>';
          echo '<div class="columns small-4 medium-4 large-2">';
           echo $this->Form->input('invoiceprice[1]', ['label'=>false,'type' => 'number','placeholder'=>'item 2 price']);
          echo '</div>';
          echo '<div class="columns medium-1 large-2 show-for-medium-up">';
          echo '</div>';
        echo '</div>';
        echo '<div class="row">';
          echo '<div class="columns small-8 medium-7 large-8">';
           echo $this->Form->input('invoiceitem[2]', ['label'=>false,'placeholder'=>'item 3 desc']);
          echo '</div>';
          echo '<div class="columns small-4 medium-4 large-2">';
           echo $this->Form->input('invoiceprice[2]', ['label'=>false,'type' => 'number','placeholder'=>'item 3 price']);
          echo '</div>';
          echo '<div class="columns medium-1 large-2 show-for-medium-up">';
          echo '</div>';
        echo '</div>';
        echo '<div class="row">';
          echo '<div class="columns small-8 medium-7 large-8">';
           echo $this->Form->input('invoiceitem[3]', ['label'=>false,'placeholder'=>'item 4 desc']);
          echo '</div>';
          echo '<div class="columns small-4 medium-4 large-2">';
           echo $this->Form->input('invoiceprice[3]', ['label'=>false,'type' => 'number','placeholder'=>'item 4 price']);
          echo '</div>';
          echo '<div class="columns medium-1 large-2 show-for-medium-up">';
          echo '</div>';
        echo '</div>';
        echo '<div class="row">';
          echo '<div class="columns small-8 medium-7 large-8">';
           echo $this->Form->input('invoiceitem[4]', ['label'=>false,'placeholder'=>'item 5 desc']);
          echo '</div>';
          echo '<div class="columns small-4 medium-4 large-2">';
           echo $this->Form->input('invoiceprice[4]', ['label'=>false,'type' => 'number','placeholder'=>'item 5 price']);
          echo '</div>';
          echo '<div class="columns medium-1 large-2 show-for-medium-up">';
          echo '</div>';
        echo '</div>';      ?>
    </fieldset>
    <?php echo $this->Form->button(__('Submit'),['class'=>'btn btn-success']); ?>
    <?= $this->Form->end() ?>
</div>
</div>
<script type="text/javascript">
        var d = new Date();
        $(document).ready(function(){
            $("#datepaid").datepicker({ dateFormat : 'dd-mm-yy', changeYear: true});
        });
</script>
<script>
window.onload = function () {
var my_var = <?php
    if ($invoice->date_paid != null){
        echo json_encode($invoice->date_paid->i18nFormat('dd-MM-YYYY'));
    }
    else
        echo "null";
   ?>;
   if (my_var == null){
     var today = new Date();
     var dd = today.getDate();
     if (dd < 10)
       dd='0'+dd;
     var mm = today.getMonth()+1;
     if (mm < 10)
       mm='0'+mm;
     my_var = dd + "-" + mm +"-"+today.getFullYear();
   }
 $("#datepaid").datepicker().val(my_var);
}
</script>
