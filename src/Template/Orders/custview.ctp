<?php

    $this->assign('title', "Viewing Your Order #$order->id");
    $depositrequired = $order->quote >= 200;
?>


<div class="orders view large-10 columns">
    <h2 class="bold"><?= h('Your Order - #'.$order->id) ?></h2>
    <h3 class="bold">
    <?php
    // 24-hour format of an hour without leading zeros
    $hour = date('G');

    if ( $hour >= 5 && $hour <= 11 )
        echo "Good morning, ";
    else if ( $hour >= 12 && $hour <= 18 )
        echo "Good afternoon, ";
    else if ( $hour >= 19 || $hour <= 4 )
        echo "Good evening, ";

    ?>
    <?= $order->customer->firstname ?>
    </h3>
    <div class="row">
            <div class="large-6 columns ">
                <table class="table dataTable card border-blue-left" cellspacing="0">
                     <tr>
                        <th><?= __('Order Type') ?></th>
                        <td><?=$this->Format->orderType($order->order_type) ?></td>
                     </tr>

                      </table>
                    <table class="table dataTable card border-blue-left" cellspacing="0">
                     <tr>
                        <th><?= __('Order Date') ?></th>
                                <td><?= $this->Format->formatDate($order->created) ?></td>
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
                                                    $now = new DateTime();
                                                    if(!empty($this->request->session()->read('Auth.User')))
                                                        echo $this->Form->hidden('from_cust', ['value'=>0]);
                                                    else
                                                        echo $this->Form->hidden('from_cust', ['value'=>1]);
                                                ?>
                                                <?= "<div style='margin:15px 10px 15px 0px' class='small-2 columns'>" ?>
                                                <?= $this->Form->button(__('Send'),['onclick'=>'messageAdd()','class'=>'btn btn-success']) ?>
                                                <?= "</div>" ?>
                                                <?= "</div>" ?>

                                    </td></tr>
                       </table>
                      </div>
                      <!--end of first column-->
                      <!--start of second column-->
                      <div class="medium-6 columns">
                        <div class="row">
                        <div class="small-5 columns quotes end">

                            <span id="orderstatus-span">
                               <h6 class='subheader'>Order Status</h6>
                               <p id="orderstatus"><?= $order->orderStatusName ?></p>

                               <h6 class='subheader'>Payment Status</h6>
                               <p id="paymentstatus"><?= $order->paymentStatusName ?></p>
                            </span>

                              <?php
                                //calculate payment amount
                                $itemamount = 0;
                                $is_deposit = false;
                                if ($depositrequired && !$order->deposit_paid)
                                {
                                  $itemamount = 50;
                                  $is_deposit = true;
                                }
                                else if (!$depositrequired || ($depositrequired && $order->deposit_paid))
                                {
                                  $itemamount = $order->balance;
                                }


                              ?>

                              <?= $this->Form->create(null,['novalidate' => true,
                                      'url' => ['controller' => 'Payments', 'action' => 'paypalpayment'],
                                      'type' => 'post']);
                              ?>

                                <?= $this->Form->hidden('is_deposit',['value'=>$is_deposit]) ?>
                                <?= $this->Form->hidden('cmd',['value'=>'_xclick']) ?>
                                <?= $this->Form->hidden('no_note', ['value'=>'1']) ?>
                                <?= $this->Form->hidden('lc', ['value'=>'AU']) ?>
                                <?= $this->Form->hidden('currency_code', ['value'=>'AUD']) ?>
                                <?= $this->Form->hidden('bn', ['value'=>'PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest']) ?>
                                <?= $this->Form->hidden('first_name',['value'=>$order->customer->firstname]) ?>
                                <?= $this->Form->hidden('surname',['value'=>$order->customer->surname]) ?>
                                <?= $this->Form->hidden('payer_email',['value'=>$order->customer->email]) ?>
                                <?= $this->Form->hidden('item_amount',['value'=>$itemamount]) ?>
                                <?php
                                      if ($is_deposit)
                                        $ordertype = "DEPOSIT for ";
                                      else
                                        $ordertype = "";
                                ?>
                                <?= $this->Form->hidden('item_name',['value'=>$ordertype.$order->description]) ?>
                                <?= $this->Form->hidden('order_number',['value'=>$order->id]) ?>
                                <span style='text-align:center;display:block;margin:2px 5px 10px 5px'>
                                  <button id='payment-btn' class='btn btn-primary' type="submit">
                                  <?php
                                    if ($depositrequired && !$order->deposit_paid)
                                       $btntext = "Pay Deposit";
                                    else
                                       $btntext = "Pay Balance";
                                    echo $btntext;
                                  ?>
                                  </button>
                                </span>
                            <?= $this->Form->end(); ?>

                        </div>

                      <div class="small-5 columns quotes end">
                                  <?php if ($order->quote == null)
                                     {
                                       echo "<h6 class='subheader'>Quote for order</h6>";
                                       echo "<p class='opportunity' style='font-size:18px;font-weight:bold'><i class='glyphicon glyphicon-exclamation-sign right-pad-5px'></i>Quote not set</p>
";
                                     }
                                     else {
                                         echo "<h6 class='subheader'>Quote for order</h6>";
                                         echo "<p class='subheader bold'>".$this->Number->currency($order->quote)."</p>";
                                         if ($order->orderstatus_id >= 2){
                                            echo "<h6 class='subheader'>Balance remaining</h6>";
                                            echo "<p id='balance' class='subheader bold'>".$this->Number->currency($order->balance)."</p>";
                                          }
                                         if ($order->orderstatus_id < 2)
                                            echo "<span style='text-align:center;display:block;margin:2px 5px 10px 5px'><button id='accept-quote' onclick='acceptQuote()' class='btn btn-primary'>Accept Quote</button></span>";
                                  }
                                  ?>
                              </div>
                          </div>
                          <div class="row">
                            <div class="small-12 columns">
                              <table class="table dataTable card border-blue-left" cellspacing="0">
                                <tr><th colspan='2'><h4>Payment History</h4></th></tr>
                                <?php if (!empty($order->payments))
                                {
                                  echo "
                               <tr>
                                    <th colspan='2'>". __('Ref No.') ."</th>
                                    <th>". __('Amount')."</th>
                                    <th>". __('Status')."</th>
                                    <th>". __('Date') ."</th>
                                </tr>";
                                  foreach ($order->payments as $p) {
                                  echo "
                                <tr>
                                    <td colspan='2'>".$p->txnid ."</td>
                                    <td class='paymentamount'>".$this->Number->currency($p->payment_amount) ."</td>
                                    <td>".$p->trans_status ."</td>
                                    <td>".$this->Format->formatPickerDate($p->createdtime) ."</td>
                                </tr>";
                               }
                              }
                              else {
                                echo "<tr><td colspan='2'>There are no payments for this order</td></tr>";
                              }
                              ?>
                              </table>
                              <table id="contact-details-view" class="table dataTable card border-blue-left" cellspacing="0">
                                <tr><th><h4>My Contact Details</h4></th>
                                <?php
                                echo "<td style='text-align:right;padding-right:10px;padding-top:10px'><button id='show-edit' class='btn btn-success'>Edit</button></td>";
                                ?>
                                </tr>
                                <tr>
                                    <th><?= __('Email') ?></th>
                                    <td><?=$order->customer->email ?></td>
                                </tr>
                                                                <tr>
                                    <th><?= __('Phone') ?></th>
                                    <td><?=$order->customer->phone ?></td>
                                </tr>

                              </table>
                             <table id="contact-details-edit" class="table dataTable card border-blue-left" cellspacing="0">

                                 <tr><th><h4>My Contact Details</h4></th></tr>

                                <?php
                                      echo "<tr><th>Email</th><td>".$this->Form->input('email', ['label'=>false, 'value'=>$order->customer->email])."</td></tr>";
                                      echo "<tr><th>Phone</th><td>".$this->Form->input('phone', ['label'=>false, 'value'=>$order->customer->phone])."</td></tr>";
                                      echo "<tr><th><div id='new-contact'></div></th><td style='text-align:right'>".$this->Form->button(__('Update'),['onclick'=>'contactEdit()','class'=>'btn btn-success'])."</td></tr>";

                                    ?>
                              </table>

                          </div>
                        </div>
                      </div>
    </div>
    <div class="row">



        <div class="column large-12 ">
                <div class="column large-12 card border-blue-left">

  <?php
            echo "<table class='table dataTable no-footer card' cellspacing='0'>";
            echo "<tr><th><h4>Attached Files</h4></th></tr>";
          if (!empty($publicstashes))
            {
            echo "<tr>";
                echo "<th>" . __('Filename') . "</th>";
                echo "<th>" . __('Type') . "</th>";
                echo "<th>" . __('Uploaded') . "</th>";
                echo "<th>" . __('Actions') . "</th>";
            echo "</tr>";
            for ($i = 0;$i < sizeOf($publicstashes); $i++) {
            echo "<tr>";
                echo "<td>" . h($publicstashes[$i]->filename) . "</td>";
                echo "<td>" . h($publicstashes[$i]->filetype) . "</td>";
                echo "<td>" . $this->Format->formatDateTime($publicstashes[$i]->uploaded) . "</td>";
                echo "<td class='actions' style='padding-top:0px;'>";
                     echo $this->Html->link(
                          'Download',
                          ['controller' => 'Stashes', 'action' => 'sendfile', $order->id,$publicstashes[$i]->filename],
                          ['class'=>'btn btn-success','escape'=>false]
                     );
            echo "</td></tr>";
          }
        }
        else
              echo "<tr><td>No shared files exist for this order</td></tr>";

        echo "</table>";

        ?>
    </div>
        </div>
</div>
<script>

    var cust_id = <?php echo $order->customer_id; ?>;
    var order_id = <?php echo $order->id; ?>;
    var order_quote = <?php echo $order->quote; ?>;
    var order_bal = <?php if ($order->balance != 0) echo $order->balance; else echo '0'; ?>;
    var paypal_enabled = <?php echo $paypal_enabled; ?>;
    var paymentstatus_id = <?php echo $order->paymentstatus_id; ?>;
    var orderstatus_id = <?php echo $order->orderstatus_id; ?>;
    $(document).ready(function () {
        $('#payment-btn').hide();
        $("#new-msg").hide();
        $("#contact-details-edit").hide();
        $("#show-edit").on("click", function(){
            $("#contact-details-edit").show();
            $("#contact-details-view").hide();
        });
        setPaymentButtons();
    });

    var setPaymentButtons = function(){
      if ((paymentstatus_id === 1 || paymentstatus_id === 3) && paypal_enabled)
        $('#payment-btn').show();
    };

    var acceptQuote = function(){
      $.get("../orders/acceptquote?order_id="+order_id, function(d) {})
      .done(function ( data ) {
        $('#orderstatus-span').html(data);
        if (data)
        {
         if (paypal_enabled) {
          if (order_quote >= 200){
            $('#payment-btn').show();
            $('#payment-btn').html('Pay Deposit');
          }
          else {
            $('#payment-btn').show();
            $('#payment-btn').html('Pay Balance');
          }
        }
        $("#accept-quote").hide();
       }
      });
    };

    var contactEdit = function() {
        var phone=$("input[name=phone]").val();
        var email=$("input[name=email]").val();
        var regex = /^\d{10}$/;
        var emailregex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!phone) {
            data = '<p class="alert alert-danger">Phone is required<p>';
            $('#new-contact').html(data);
            $("#new-contact").show();
        }
        else if (phone.length > 10 || phone.length < 10){
             data= '<p class="alert alert-danger">Phone must be 10 digits</p>';
             $('#new-contact').html(data);
             $("#new-contact").show();
        }
        else if (!regex.test(phone)){
            data= '<p class="alert alert-danger">Numbers only in phone</p>';
            $('#new-contact').html(data);
            $("#new-contact").show();
        }
        if (email && !emailregex.test(email)){
            data= '<p class="alert alert-danger">Email must be valid</p>';
            $('#new-contact').html(data);
            $("#new-contact").show();
        }
        else {
            $.get("../customers/custedit?phone="+phone+"&email="+email+"&cust_id="+cust_id, function(d) {})
        .done(function ( data ) {
            $('#new-contact').html(data);
            $("#new-contact").show();
          });
        }
    };

    var messageAdd = function() {
        var name=$("input[name=name]").val();
        var from_cust=$("input[name=from_cust]").val();
        var order_id=$("input[name=order_id]").val();
        var message=$("#message").val();
        var msg_date=$("input[name=msg_date]").val();
        $.get("../messages/add?name="+name+"&from_cust="+from_cust+"&order_id="+order_id+"&message="+message, function(d) {})
        .done(function ( data ) {
            $('#no-msg').hide();
            $('#new-msg').show();
            $('#new-msg').append(data);
            $("input[name=message]").val('');
          });
    };
</script>
