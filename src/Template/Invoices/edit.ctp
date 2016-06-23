<?php
    $this->assign('title', 'EDIT INVOICE FOR ORDER #' . $invoice->order_id);
    $this->Html->addCrumb('Orders', '/orders');
    $this->Html->addCrumb('Order', ['controller' => 'Orders', 'action' => 'view', $invoice->order_id]);
    $this->Html->addCrumb('Edit Invoice', ['controller' => 'Invoices', 'action' => 'edit', $invoice->id]);
?>
<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
      <li>
        <?php echo $this->Form->postLink(
           $this->Html->tag('i', '', ['class' => 'glyphicon glyphicon-remove right-pad-5px']). __('Delete Invoice'),
                ['action' => 'delete', $invoice->id],
                ['escape'=>false,'confirm'=>__('Are you sure you want to delete this invoice for order # {0}?',
                $invoice->order_id)]
           );
        ?>
      </li>
        <li><?= $this->Html->link(
             $this->Html->tag('i', '', ['class' => 'glyphicon glyphicon-list-alt right-pad-5px']).$this->Html->tag('span', __('List All Invoices')),
             ['action' => 'index'],
             ['escape'=>false]) ?>
        </li>
        <li><?= $this->Html->link(
             $this->Html->tag('i', '', ['class' => 'glyphicon glyphicon-list right-pad-5px']).$this->Html->tag('span', __('List Invoices for #'.$invoice->order_id)),
             ['action' => 'index',$invoice->order_id],
             ['escape'=>false]) ?>
        </li>

    </ul>
</div>
<div class="customers index large-10 medium-9 columns">
<div class="edit_tables">
    <?= $this->Form->create($invoice) ?>
    <fieldset>
        <legend><?= __('Edit Invoice for Order #'.$invoice->order_id) ?></legend>
        <?php
        echo '<div class="row">';
          echo '<div class="columns small-7 medium-5 large-3">';
            echo $this->Form->hidden('order_id', ['value' => $invoice->order_id]);
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
          if (isset($invoice->invoiceitems[0]) && !empty($invoice->invoiceitems[0]))
           echo $this->Form->input('invoiceitem[0]', ['label'=>'Description','placeholder'=>'item 1 desc','value'=>$invoice->invoiceitems[0]['description']]);
          else {
            echo $this->Form->input('invoiceitem[0]', ['label'=>'Description','placeholder'=>'item 1 desc']);
          }
          echo '</div>';
          echo '<div class="columns small-4 medium-4 large-2">';
          if (isset($invoice->invoiceitems[0]) && !empty($invoice->invoiceitems[0]))
           echo $this->Form->input('invoiceprice[0]', ['label'=>'Price ex. GST','type' => 'number','placeholder'=>'item 1 price','value'=>$invoice->invoiceitems[0]['amount_ex_gst']]);
          else
            echo $this->Form->input('invoiceprice[0]', ['label'=>'Price ex. GST','type' => 'number','placeholder'=>'item 1 price']);

          echo '</div>';
          echo '<div class="columns medium-1 large-2 show-for-medium-up">';
          echo '</div>';
        echo '</div>';

        echo '<div class="row">';
          echo '<div class="columns small-8 medium-7 large-8">';
          if (isset($invoice->invoiceitems[1]) && !empty($invoice->invoiceitems[1]))
           echo $this->Form->input('invoiceitem[1]', ['label'=>false,'placeholder'=>'item 2 desc','value'=>$invoice->invoiceitems[1]['description']]);
          else {
            echo $this->Form->input('invoiceitem[1]', ['label'=>false,'placeholder'=>'item 2 desc']);
          }
          echo '</div>';
          echo '<div class="columns small-4 medium-4 large-2">';
          if (isset($invoice->invoiceitems[1]) && !empty($invoice->invoiceitems[1]))
           echo $this->Form->input('invoiceprice[1]', ['label'=>false,'type' => 'number','placeholder'=>'item 2 price','value'=>$invoice->invoiceitems[1]['amount_ex_gst']]);
          else {
            echo $this->Form->input('invoiceprice[1]', ['label'=>false,'type' => 'number','placeholder'=>'item 2 price']);
          }
          echo '</div>';
          echo '<div class="columns medium-1 large-2 show-for-medium-up">';
          echo '</div>';
        echo '</div>';

        echo '<div class="row">';
          echo '<div class="columns small-8 medium-7 large-8">';
          if (isset($invoice->invoiceitems[2]) && !empty($invoice->invoiceitems[2]))
           echo $this->Form->input('invoiceitem[2]', ['label'=>false,'placeholder'=>'item 3 desc','value'=>$invoice->invoiceitems[2]['description']]);
          else
            echo $this->Form->input('invoiceitem[2]', ['label'=>false,'placeholder'=>'item 3 desc']);

          echo '</div>';
          echo '<div class="columns small-4 medium-4 large-2">';
          if (isset($invoice->invoiceitems[2]) && !empty($invoice->invoiceitems[2]))
           echo $this->Form->input('invoiceprice[2]', ['label'=>false,'type' => 'number','placeholder'=>'item 3 price','value'=>$invoice->invoiceitems[2]['amount_ex_gst']]);
          else
            echo $this->Form->input('invoiceprice[2]', ['label'=>false,'type' => 'number','placeholder'=>'item 3 price']);

          echo '</div>';
          echo '<div class="columns medium-1 large-2 show-for-medium-up">';
          echo '</div>';
        echo '</div>';

        echo '<div class="row">';
          echo '<div class="columns small-8 medium-7 large-8">';
          if (isset($invoice->invoiceitems[3]) && !empty($invoice->invoiceitems[3]))
           echo $this->Form->input('invoiceitem[3]', ['label'=>false,'placeholder'=>'item 4 desc','value'=>$invoice->invoiceitems[3]['description']]);
          else
            echo $this->Form->input('invoiceitem[3]', ['label'=>false,'placeholder'=>'item 4 desc']);

          echo '</div>';
          echo '<div class="columns small-4 medium-4 large-2">';
          if (isset($invoice->invoiceitems[3]) && !empty($invoice->invoiceitems[0]))
           echo $this->Form->input('invoiceprice[3]', ['label'=>false,'type' => 'number','placeholder'=>'item 4 price','value'=>$invoice->invoiceitems[3]['amount_ex_gst']]);
          else
            echo $this->Form->input('invoiceprice[3]', ['label'=>false,'type' => 'number','placeholder'=>'item 4 price']);
          echo '</div>';
          echo '<div class="columns medium-1 large-2 show-for-medium-up">';
          echo '</div>';
        echo '</div>';

        echo '<div class="row">';
          echo '<div class="columns small-8 medium-7 large-8">';
          if (isset($invoice->invoiceitems[4]) && !empty($invoice->invoiceitems[4]))
           echo $this->Form->input('invoiceitem[4]', ['label'=>false,'placeholder'=>'item 5 desc','value'=>$invoice->invoiceitems[4]['description']]);
          else
            echo $this->Form->input('invoiceitem[4]', ['label'=>false,'placeholder'=>'item 5 desc']);

         echo '</div>';
          echo '<div class="columns small-4 medium-4 large-2">';
          if (isset($invoice->invoiceitems[4]) && !empty($invoice->invoiceitems[4]))
           echo $this->Form->input('invoiceprice[4]', ['label'=>false,'type' => 'number','placeholder'=>'item 5 price','value'=>$invoice->invoiceitems[4]['amount_ex_gst']]);
          else
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
   if (my_var == null) {
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
