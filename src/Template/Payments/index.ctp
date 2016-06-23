<?php
    $this->assign('title', "All Payments");
    $this->Html->addCrumb('Payments', '/payments');
?>

    <script>
        $(document).ready(function(){
            $('#paymentsTable').DataTable({
                "columnDefs": [ { "targets": 5, "orderable": false } ]
            });
        });
    </script>



<div class="actions columns large-2 medium-3">

    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">
            <li>
                <?= $this->Html->link(
                      $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-plus-sign right-pad-5px')).$this->Html->tag('span', __('List All Payments')),
                      ['action' => 'index'],
                      array('escape'=>false)) ?>
            </li>
    </ul>
</div>
<div class="customers index large-10 medium-9 columns">
    <table id="paymentsTable" class="table card responsive" cellpadding="0">
    <thead>
        <tr>
            <th>Trans #</th>
            <th>Order #</th>
            <th class="min-desktop">Date</th>
            <th class="min-tablet-l">Type</th>
            <th class="min-desktop">Amount</th>
            <th class="actions tab-col-actions "><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($payments as $pmnt): ?>
        <tr <?php (($pmnt->trans_status == "OK" || $pmnt->trans_status == "MANUAL - OK" || $pmnt->trans_status == "MANUAL - Deposit") ? $bg = 'style="background-color:#BFEFBF"' : $bg = 'style="background-color:#FDB4B4"'); echo $bg;?>>
            <td><?= '<span style="font-size:11px">'.h(strtoupper($pmnt->txnid)) .'</span>'?></td>
            <td><?= h($pmnt->order_id) ?></td>
            <td><?= h($this->Format->formatDate($pmnt->createdtime)) ?></td>
            <td><?= h(ucfirst($pmnt->paymenttype->name)) ?></td>
            <td><?= h($this->Number->currency($pmnt->payment_amount)) ?></td>

            <td class="actions tab-col-actions">

                <?php
                echo $this->Html->link(
                '<i class="glyphicon glyphicon-search" style="padding-right:0px"></i>',
                     ['action' => 'view', $pmnt->id],
                     ['class'=>'btn btn-info','escape'=>false]
                    );
                ?>&nbsp;&nbsp;
                 <?php
                 if ($pmnt->payment_type != 4){
                   echo $this->Html->link(
                     '<i class="glyphicon glyphicon-edit" style="padding-right:0px"></i>',
                     ['action' => 'editmanpayment', $pmnt->id],
                     ['class'=>'btn btn-warning','escape'=>false]
                    );
                  }
                 ?>
            </td>
        </tr>

    <?php endforeach; ?>

    </tbody>
    </table>
    <table class="card ">
    <tr style="background-color:none !important">
      <td style="background-color:white !important" colspan="2"><span style="background-color:#BFEFBF">&nbsp;&nbsp;&nbsp;&nbsp;</span> Payment OK/Successful</td>
    </tr>
    <tr style="background-color:none !important">
      <td style="background-color:white !important" colspan="2"><span style="background-color:#FDB4B4">&nbsp;&nbsp;&nbsp;&nbsp;</span> Payment Cancelled/Failed/Refunded</td>
    </tr>
  </table>

</div>
