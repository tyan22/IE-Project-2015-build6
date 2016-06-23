<?php
    $this->assign('title', "Payment #$payment->txnid");
    $this->Html->addCrumb('Payments', '/payments');
    $this->Html->addCrumb('View Payment', ['controller' => 'Payments', 'action' => 'view',$payment->id]);
?>

<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">

        <?php if ($payment->payment_type != 4)
        {
          echo "
        <li>".$this->Html->link(
           $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-pencil right-pad-5px')).$this->Html->tag('span', __('Edit Payment')),
           ['action' => 'editmanpayment',$payment->id],
           array('escape'=>false)) ."
        </li>";
      };
      ?>
        <li><?= $this->Html->link(
           $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-credit-card right-pad-5px')).$this->Html->tag('span', __('Go To Order')),
           ['controller'=>'orders','action' => 'view',$payment->order_id],
           array('escape'=>false)) ?>
        </li>
    </ul>
</div>
<div class="payments view large-10 medium-9 columns">
    <h3 style="font-style:normal;font-weight:bold" class="bold move-right-5px">Payment #<?= h($payment->txnid) ?></h3>
    <div class="row">
            <div class="large-6 columns">
            <table class="table dataTable card border-blue-left" cellspacing="0">
                    <tr><th><?= __('Transaction #') ?></th><td><?= h($payment->txnid) ?></td></tr>
                    <tr><th><?= __('Type') ?></th><td><?= h(ucfirst($payment->paymenttype->name)) ?></td></tr>
                    <tr><th><?= __('Date') ?></th><td><?= h($this->Format->formatDateTime($payment->createdtime))  ?></td></tr>
                    <tr><th><?= __('Amount') ?></th><td><?= h($this->Number->currency($payment->payment_amount)) ?></td></tr>
                    <tr><th><?= __('Description') ?></th><td><?= h($payment->item_name) ?></td></tr>
            </table>
            </div>
            <div class="large-6 columns">
            <table class="table dataTable card border-blue-left" cellspacing="0">
                    <tr><th><?= __('Order #') ?></th><td><?= h($payment->order_id) ?></td></tr>
                    <tr><th><?= __('Order Type') ?></th><td><?= h($this->Format->orderType($payment->order->order_type)) ?></td></tr>
                    <tr><th><?= __('Customer Name') ?></th><td><?= h($cust->fullName) ?></td></tr>
                    <tr><th><?= __('Customer Email') ?></th><td><?php if (empty($cust->email) || $cust->email == null){
                      echo "N/A";
                    }else {
                        echo $cust->email;
                      }
                    ?></td></tr>
                    <tr><th><?= __('Customer Phone') ?></th><td><?php if (empty($cust->phone) || $cust->phone == null){
                      echo "N/A";
                    }else {
                        echo $cust->phone;
                      }
                    ?></td></tr>
            </table>
            </div>
          </div>
          <div class="row">
            <div class="medium-6 columns">
            <table class="table dataTable card border-blue-left" cellspacing="0">
                    <tr><th style="font-size:20px"><?= __('Transaction Status') ?></th><td style="font-size:20px;font-weight:bold;<?php
                    if ($payment->trans_status == "OK" || $payment->trans_status == "MANUAL - OK" || $pmnt->trans_status == "MANUAL - Deposit")
                    {
                      echo 'color:#00bb00';
                    }
                    else
                    {
                      echo 'color:#bb0000';
                    }
                    ?>"><?= h($payment->trans_status) ?></td></tr>
            </table>
          </div>
            <div class="hide-for-medium-down medium-6 columns">
            </div>
          </div>
    </div>
</div>
