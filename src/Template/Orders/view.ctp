<?php
    $this->assign('title', "Order #$order->id");
    $this->Html->addCrumb('Orders', '/orders');
    $this->Html->addCrumb('View Order', ['controller' => 'Orders', 'action' => 'view',$order->id]);
?>

<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">

        <li><?= $this->Html->link(
           $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-pencil right-pad-5px')).$this->Html->tag('span', __('Edit Order')),
           ['controller' => 'Orders', 'action' => 'edit',$order->id],
           array('escape'=>false)) ?>
        </li>

        <li>
        <?php
        echo $this->Form->postLink(
           $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove right-pad-5px')). __('Delete Order'),
                array('action' => 'delete', $order->id),
                array('escape'=>false,'confirm'=>
                __('Are you sure you want to delete order #{0} belonging to customer {1}?',
                $order->id, $order->customer->fullName))
           );
        ?>
       </li>

       <li>
         <?= $this->Html->link(
         $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-plus-sign right-pad-5px')).$this->Html->tag('span', __('Add File to Stash')),
         ['controller' => 'Stashes', 'action' => 'add',$order->id],array('escape'=>false)) ?>
       </li>
       <li>
         <?= $this->Html->link(
         $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-usd right-pad-5px')).$this->Html->tag('span', __('Add Manual Payment')),
         ['controller' => 'Payments', 'action' => 'manualpayment',$order->id],array('escape'=>false)) ?>
       </li>
       <li>
         <?= $this->Html->link(
         $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-print right-pad-5px')).$this->Html->tag('span', __('View Order Invoices')),
         ['controller' => 'Invoices', 'action' => 'index',$order->id],array('escape'=>false)) ?>
       </li>
       <li>
         <?= $this->Html->link(
         $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-print right-pad-5px')).$this->Html->tag('span', __('Print Order')),
         ['controller' => 'Orders', 'action' => 'printorder',$order->id],array('escape'=>false)) ?>
       </li>
   </ul>
</div>
<div class="orders view large-10 medium-9 columns">
    <h2 class="bold"><?= h('Order #'.$order->id) ?></h2>

    <div class="row">
            <div class="large-6 columns ">
                <table class="table dataTable card border-blue-left" cellspacing="0">
                    <tr>
                        <th><?= __('Customer') ?></th>
                        <td><?= $order->has('customer') ? $this->Html->link($order['customer']['fullName'],
                                         ['controller' => 'Customers', 'action' => 'view', $order->customer->id], ['class'=>'orderLink'])
                                          : 'Error!' ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Vendor') ?></th>
                        <td><?= $order->vendor_id != 0 && $order->vendor_id != null ? $this->Html->link($order['vendor']['vendor_name'],
                                        ['controller' => 'Vendors', 'action' => 'view', $order->vendor->id]) : 'No vendor' ?></td>
                     </tr>
                     <tr>
                        <th><?= __('Order Type') ?></th>
                        <td><?=$this->Format->orderType($order->order_type) ?></td>
                     </tr>

                      </table>
                      <table class='table dataTable card border-blue-left'>
                          <tr>
                            <th> <?= __('Date Created') ?> </th>
                            <td><?= $this->Format->formatDateTime($order->created) ?></td>
                          </tr>
                          <tr>
                            <th> <?= __('Date Modified') ?> </th>

                          <?php
                               if ($order->modified != null)
                               {
                                   echo "<td>". $this->Format->formatDateTime($order->modified)."</td>";
                               }
                               else
                               {
                                   echo '<td>'. $this->Format->formatDateTime($order->created). '</td>';
                               }
                               ?>
                               </tr>
                           </table>

                      <table class="table dataTable card border-blue-left">
                            <tr>
                              <th><?= __('Order Description') ?></th>
                            </tr>
                            <tr>
                            <?php
                              if (!empty($order->description))
                                echo "<td>".h($order->description)."</td>";
                              else
                                echo "<td>There are no notes for this order</td>";
                              ?>
                            </tr>
                      </table>
                      </div>
                        <div class="medium-3 large-3 small-5 columns statuses end">

                               <h6 class='subheader'>Order Status</h6>
                               <p class="subheader bold"><?= $order->orderStatusName ?></p>

                               <h6 class='subheader'>Payment Status</h6>
                               <p class="subheader bold"><?= $order->paymentStatusName ?></p>
                              </div>


                      <div class="medium-3 large-2 small-5 columns quotes end">
                                  <?php if ($order->quote == null)
                                     {
                                       echo "<h6 class='subheader'>Quote for order</h6>";
                                       echo "<p class='opportunity' style='font-size:18px;;font-weight:bold'><i class='glyphicon glyphicon-exclamation-sign right-pad-5px'></i>Quote not set</p>
";
                                     }
                                     else {
                                         echo "<h6 class='subheader'>Quote for order</h6>";
                                         echo "<p class='subheader bold'>".$this->Number->currency($order->quote)."</p>";
                                         if ($order->orderstatus_id >= 2){
                                            echo "<h6 class='subheader'>Balance remaining</h6>";
                                            echo "<p id='balance' class='subheader bold'>".$this->Number->currency($order->balance)."</p>";
                                          }
                                    }
                                  ?>
                              </div>


                      </div>
                      <div class="row">

        <div class="column large-12 ">
            <table class="table dataTable card border-blue-left"  cellspacing="0">
              <tr><th colspan="3"><h4 class="subheader"><?= __('Payment History') ?></h4></th></tr>
              <?php if (!empty($order->payments))
              {
                echo "
             <tr>
                  <th colspan='2'>". __('Ref No.') ."</th>
                  <th>". __('Amount')."</th>
                  <th class='hide-for-medium-down'>". __('Status')."</th>
                  <th class='hide-for-medium-down'>". __('Description')."</th>
                  <th>". __('Date/Time') ."</th>
              </tr>";
                foreach ($order->payments as $p) {
                echo "
              <tr>
                  <td colspan='2'>".
                  $this->Html->link(h(strtoupper($p->txnid)),['controller'=>'payments','action'=>'view',$p->id],['class'=>'orderLink'])
                  ."</td>
                  <td class='paymentamount'>".$this->Number->currency($p->payment_amount) ."</td>
                  <td class='hide-for-medium-down'>".$p->trans_status ."</td>
                  <td class='hide-for-medium-down'>".$p->item_name ."</td>
                  <td>".$this->Format->formatDateTime($p->createdtime) ."</td>
              </tr>";
             }
            }
            else {
              echo "<tr><td colspan='2'>There are no payments for this order</td></tr>";
            }
            ?>
            </table>
          </div>
        </div>

          <table class="table dataTable card border-blue-left" cellspacing="0">
            <tr><th colspan="3"><h4 class="subheader"><?= __('Files in Stash') ?></h4></th></tr>
        <?php if (!empty($order->stashes)): ?>

            <tr>
                <th><?= __('Filename') ?></th>
                <th class="hide-for-medium-down"><?= __('Type') ?></th>
                <th class="hide-for-small-down"><?= __('Uploaded') ?></th>
                <th class="hide-for-medium-down"><?= __('Visibility') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($order->stashes as $stashes): ?>
            <tr style="white-space: nowrap;">
                <td style="vertical-align:middle;"><?= h($stashes->filename) ?></td>
                <td style="vertical-align:middle;" class="hide-for-medium-down"><?= h($stashes->filetype) ?></td>
                <td style="vertical-align:middle;" class="hide-for-small-down"><?= $this->Format->formatDateTime($stashes->uploaded) ?></td>
                <td style="vertical-align:middle;" class="hide-for-medium-down"><?= $this->Format->stashVis($stashes->visible) ?>
                </td>
                <td style="vertical-align:middle;display:inline-block;" class="actions">

                                <?= $stashes->visible == 'Y' ? $this->Html->link($this->Html->tag('i', '', array('style'=>'padding-right: 0px !important;','class' => 'glyphicon glyphicon-eye-close padding-right-0px')),
                                                       ['controller' => 'Stashes', 'action' => 'toggleVis', $stashes->id,$order->id],
                                                       ['class'=>'btn btn-primary btn-symbol','escape'=>false]) : $this->Html->link($this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-eye-open')),
                                                       ['controller' => 'Stashes', 'action' => 'toggleVis', $stashes->id,$order->id],
                                                       ['class'=>'btn btn-primary btn-symbol','escape'=>false]) ?>
                                 <?php
                                echo $this->Html->link(
                                     $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-download ', 'style'=>'padding-right: 0px;')),
                                     ['controller' => 'Stashes', 'action' => 'sendfile', $order->id,$stashes->filename],
                                     ['class'=>'btn btn-success btn-symbol','escape'=>false]
                                    );
                                ?>
                                 <?php
                                echo $this->Html->link(
                                     $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove', 'style'=>'padding-right: 0px;')),
                                     ['controller'=>'Stashes','action' => 'delete',$stashes->id,$order->id],
                                     ['class'=>'btn btn-danger btn-symbol','escape'=>false,'confirm' => __('Are you sure you want to delete the stashed file {0}?', $stashes->filename)]
                                    );
                 ?>
                </td>
            </tr>




            <?php endforeach; ?>
        <?php else : ?>
          <tr><td colspan='2'>There are no files in this order's stash</td></tr>
        <?php endif; ?>
      </table>

    <div class="row">
      <div class="large-8 columns">
      <table class="table dataTable card border-blue-left">
           <tr>
              <th><?= __('Messages') ?></th>
           </tr>

               <?php
                    if (!empty($order->messages)) {
                        foreach($order->messages as $message){
                            echo "<tr><td><span style='";
                            if ($message->from_cust)
                                echo "float:left; margin-right: 55px;";
                            else
                                echo "float:right; margin-left: 55px;";
                            echo "' class='alert ";
                             if ($message->from_cust)
                                 echo "alert-success";
                             else
                                 echo "alert-info";
                            echo " cust-alert'><p style='font-weight:bold;font-size:12px;'>".h($message->name);
                            echo "</p><br />";
                            echo "<p>".h($message->message)."</p><br />";
                            echo "<p style='font-weight:bold;font-size:12px;'>".h($this->Format->formatDateTime($message->msg_date))."</span></td></tr>";
                        }
                    }
                    else
                        echo "<tr id='no-msg'><td>There are no messages regarding this order</td></tr>";
                    echo '<tr id="new-msg"></tr>';

                    ?>
                      <tr><td>

                                <?php
                                    echo "<div class='row'>";
                                        echo "<div class='small-9 columns'>";
                                            echo $this->Form->input('message', ['placeholder'=>'New message...','style'=>'margin:4%;padding:10px;','label'=>false, 'value'=>'']);
                                        echo "</div>";
                                        echo $this->Form->hidden('order_id', ['value'=>$order->id]);
                                    if(empty($this->request->session()->read('Auth.User'))){
                                        echo $this->Form->hidden('name', ['value'=>$order->customer->firstname]);
                                    }
                                    else
                                        echo $this->Form->hidden('name', ['value'=>$this->request->session()->read('Auth.User')['firstname']]);
                                    if(!empty($this->request->session()->read('Auth.User')))
                                        echo $this->Form->hidden('from_cust', ['value'=>0]);
                                    else
                                        echo $this->Form->hidden('from_cust', ['value'=>1]);
                                ?>
                                <?= "<div style='margin:15px 10px 15px 0px' class='small-2 columns'>" ?>
                                <?= $this->Form->button(__('Send'),['onclick'=>'messageAdd()','class'=>'btn btn-success','style'=>'margin-top: 5px;']) ?>
                                <?= $this->Form->end() ?>
                                <?= "</div>" ?>
                                <?= "</div>" ?>

                    </td></tr>
       </table>
    </div>
 </div>
 </div>
<script>
var messageAdd = function() {
        var name=$("input[name=name]").val();
        var from_cust=$("input[name=from_cust]").val();
        var order_id=$("input[name=order_id]").val();
        var message=$("#message").val();
        var msg_date=$("input[name=msg_date]").val();
        $.get("../../messages/add?name="+name+"&from_cust="+from_cust+"&order_id="+order_id+"&message="+message, function(d) {})
        .done(function ( data ) {
            $('#no-msg').hide();
            $('#new-msg').append(data);
            $("input[name=message]").val('');
          });
    }
</script>
