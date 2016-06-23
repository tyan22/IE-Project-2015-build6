<?php
    $this->assign('title', "ALL INVOICES");
    $this->Html->addCrumb('Invoices', '/invoices');
    if (isset($this->request->params['pass']) && !empty($this->request->params['pass']))
      $this->Html->addCrumb('Filtered by #'. $this->request->params['pass'][0], '/invoices/index/1004');
?>

<script>
    $(document).ready(function(){
        $('#invTable').DataTable({
            "columnDefs": [ { "targets": 3, "orderable": false } ]
        });
    });
</script>

<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
      <li><?= $this->Html->link(
           $this->Html->tag('i', '', ['class' => 'glyphicon glyphicon-list-alt right-pad-5px']).$this->Html->tag('span', __('List All Invoices')),
           ['action' => 'index'],
           ['escape'=>false]) ?>
      </li>
        </ul>
</div>
<div class="invoices index large-10 medium-9 columns">
  <table id="invTable" class="table card responsive" cellpadding="0">
    <thead>
        <tr>
            <th><?= h(__('Order #')) ?></th>
            <th><?= h(__('Date Paid')) ?></th>
            <th class="min-desktop"><?= h(__('Total inc GST')) ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($invoices as $invoice): ?>
        <tr>
            <?php
            echo '<td>'
                . $this->Html->link($invoice->order_id, ['controller' => 'Orders', 'action' => 'view', $invoice->order_id]) .
            '</td>
            <td>' . h($this->Format->formatDate($invoice->date_paid)) . '</td>
            <td>' . h($this->Number->currency($invoice->grand_total)) . '</td>
            <td class="actions">';
            echo $this->Html->link(
            '<i class="glyphicon glyphicon-search" style="padding-right:0px"></i>',
                 ['action' => 'view', $invoice->id],
                 ['class'=>'btn btn-info','escape'=>false]
                );
            ?>&nbsp;&nbsp;
             <?php
               echo $this->Html->link(
                 '<i class="glyphicon glyphicon-edit" style="padding-right:0px"></i>',
                 ['action' => 'edit', $invoice->id],
                 ['class'=>'btn btn-warning','escape'=>false]
                );
             ?>&nbsp;&nbsp;
             <?php
               echo $this->Html->link(
                 '<i class="glyphicon glyphicon-print" style="padding-right:0px"></i>',
                 ['controller' => 'Invoices', 'action' => 'printinvoice',$invoice->id],
                 ['class'=>'btn btn-primary','escape'=>false]
                );
             ?>
            </td>
        </tr>

    <?php endforeach; ?>

    </tbody>
    </table>
</div>
