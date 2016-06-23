<?php
    $this->assign('title', 'EDIT INVOICE FOR ORDER #' . $invoice->order_id);
    $this->Html->addCrumb('Orders', '/orders');
    $this->Html->addCrumb('Order', ['controller' => 'Orders', 'action' => 'view', $invoice->order_id]);
    $this->Html->addCrumb('Invoice', ['controller' => 'Invoices', 'action' => 'view', $invoice->id]);
?>

<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
      <li><?= $this->Html->link(
         $this->Html->tag('i', '', ['class' => 'glyphicon glyphicon-pencil right-pad-5px']).$this->Html->tag('span', __('Edit Invoice')),
         ['controller' => 'Invoices', 'action' => 'edit',$invoice->id],
         ['escape'=>false]) ?>
      </li>
        <li>
          <?php echo $this->Form->postLink(
             $this->Html->tag('i', '', ['class' => 'glyphicon glyphicon-remove right-pad-5px']). __('Delete Invoice'),
                  ['action' => 'delete', $invoice->id],
                  ['escape'=>false,'confirm'=>__('Are you sure you want to delete this invoice for order # {0}?',
                  $invoice->order_id)]
             );
          ?>
        </li>
        <li>
          <?= $this->Html->link(
          $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-print right-pad-5px')).$this->Html->tag('span', __('Print Invoice')),
          ['controller' => 'Invoices', 'action' => 'printinvoice',$invoice->id],array('escape'=>false)) ?>
        </li>
    </ul>
</div>
<div class="invoices view large-10 medium-9 columns">
<div class="invoices view large-12 columns">
    <div class="row">
      <h2><?= h('Invoice for Order #'. $invoice->order_id) ?></h2><br />
        <div class="large-5 columns card border-blue-left">
            <h5 class="subheader"><strong><?= __('Grand Total') ?></strong></h5>
            <p><?= $this->Number->currency($invoice->grand_total) .' inc. '. $invoice->gst_rate .'% GST' ?></p>
        </div>
      </div>
      <div class="row">
        <div class="large-5 columns card border-blue-left">
            <h5 class="subheader"><strong><?= __('Date Paid') ?></strong></h5>
            <p><?= h($this->Format->formatDate($invoice->date_paid)) ?></p>
        </div>
      </div>

<div class="related row">
  <div class="large-5 columns card border-blue-left">
    <h4 class="subheader"><strong><?= __('Invoice Items') ?></strong></h4>
    <?php if (!empty($invoice->invoiceitems)): ?>
    <table cellpadding="0" cellspacing="0" class="table">
        <tr>
            <th><?= __('Description') ?></th>
            <th><?= __('Amount ex. GST') ?></th>
        </tr>
        <?php foreach ($invoice->invoiceitems as $invoiceitems): ?>
        <tr>
            <td><?= h($invoiceitems->description) ?></td>
            <td><?= h($this->Number->currency($invoiceitems->amount_ex_gst))?></td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
  </div>
</div>
</div>
