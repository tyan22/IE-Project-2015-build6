<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'Engage Jewellery Admin';

?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['base','bootstrap']); ?>
    <?= $this->Html->css(['cake','engage','jquery.dataTables.min','dataTables.bootstrap','dataTables.responsive.min','jquery-ui.min','jquery-ui.structure.min','jquery-ui.theme.min','font-awesome.min']) ?>
    <?= $this->Html->css('http://fonts.googleapis.com/css?family=Roboto:400,700') ?>
    <?= $this->Html->script(['jquery-2.1.3.min', 'jquery.dataTables.min','dataTables.responsive.min','jquery-ui.min','bootstrap.min']) ?>



    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <style>i {font-style:normal !important}</style>
</head>
<body  class="bg">
<?=  $this->Flash->render(); ?>
    <?=  $this->Flash->render('auth'); ?>
<!--   <header>-->
        <?php

        //check if user logged in - if yes, make logo link to admin homepage. if no, make it link to customer view order page
        $user = $this->request->session()->read('Auth.User');
                     if(!empty($user)) {
                         //add order modal
                         echo '<div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="addOrder">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Order for existing or new customer?</h4>
                                      </div>
                                      <div class="modal-body" style="text-align=left">
                                        <button type="button" class="btn btn-default">'. $this->Html->link('New Customer',["controller" => "Customers", "action" => "add","o" => "y"]).'</button>
                                      </div>
                                      <div class="modal-body" style="text-align=left">
                                        <input type="text" data-id="order-cust" class="search-cust-order form-control" placeholder="Search existing customer...">
                                      </div>
                                      <div id="cust-order-result"></div>
                                    </div>
                                  </div>
                                </div>';
                                //view cust modal
                                echo '<div class="modal fade" id="viewCustModal" tabindex="-1" role="dialog" aria-labelledby="viewCustomer">
                                         <div class="modal-dialog" role="document">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                               <h4 class="modal-title" id="myModalLabel">Search for a customer</h4>
                                             </div>
                                             <div class="modal-body" style="text-align=left">
                                               <input type="text" data-id="cust" class="search-cust form-control" placeholder="Start typing to search...">
                                             </div>
                                             <div id="cust-result"></div>
                                           </div>
                                         </div>
                                       </div>';
                                       //view order modal
                                       echo '<div class="modal fade" id="viewOrderModal" tabindex="-1" role="dialog" aria-labelledby="viewOrder">
                                                <div class="modal-dialog" role="document">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                      <h4 class="modal-title" id="myModalLabel">Search for an order</h4>
                                                    </div>
                                                    <div class="modal-body" style="text-align=left">
                                                      <input type="text" data-id="order" class="search-order form-control" placeholder="Start typing to search...">
                                                    </div>
                                                    <div id="order-result"></div>
                                                  </div>
                                                </div>
                                              </div>';
                                              //view vendor modal
                                              echo '<div class="modal fade" id="viewVendorModal" tabindex="-1" role="dialog" aria-labelledby="viewVendor">
                                                       <div class="modal-dialog" role="document">
                                                         <div class="modal-content">
                                                           <div class="modal-header">
                                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                             <h4 class="modal-title" id="myModalLabel">Search for a vendor</h4>
                                                           </div>
                                                           <div class="modal-body" style="text-align=left">
                                                             <input type="text" data-id="order" class="search-vendor form-control" placeholder="Start typing to search...">
                                                           </div>
                                                           <div id="vendor-result"></div>
                                                         </div>
                                                       </div>
                                                     </div>';
                         //nav bar
                         echo '<nav class="navbar navbar-inverse">
                                  <div class="container-fluid" style="text-align: center">
                                    <!-- Brand and toggle get grouped for better mobile display -->
                                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                      </button>
                                      <a class="navbar-brand">'. $this->Html->image("Engage_logo_4col1.png", ["alt" => "Engage Jewellery Logo", "url" => ["controller" => "Pages", "action" => "start"]]).'
                                      </a>
                                    </div>

                                    <!-- Collect the nav links, forms, and other content for toggling -->
                                    <div class="collapse navbar-collapse" id="navbar">
                                      <ul class="nav navbar-nav">
                                      <li>'. $this->Html->link(
                                       $this->Html->tag("i", "", array("class" => "glyphicon glyphicon-home right-pad-5px")).$this->Html->tag("span", __('Home')),
                                       ['controller' => 'Pages', 'action' => 'display','start'],
                                       array('escape'=>false)).'
                                      </li>                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>Customer<span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a data-toggle="modal" class="modalLink" data-target="#viewCustModal">Search for a Customer</a></li>
                                                <li>'. $this->Html->link('Add a Customer',["controller" => "Customers", "action" => "add"]).'</li>
                                                <li>'. $this->Html->link('Manage Customers',["controller" => "Customers", "action" => "index"]).'</li>
                                                <li role="separator" class="divider"></li>
                                                <li>'. $this->Html->link('Manage Anniversaries',["controller" => "Anniversarytypes", "action" => "index"]).'</li>
                                            </ul>
                                        </li>
                                        <li class"dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>Order<span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a data-toggle="modal" class="modalLink" data-target="#viewOrderModal">Search for an Order</a></li>
                                                <li><a data-toggle="modal" class="modalLink" data-target="#addOrderModal">Add an Order</a></li>
                                                <li>'. $this->Html->link('Manage Orders',["controller" => "Orders", "action" => "index"]).'</li>
                                                <li role="separator" class="divider"></li>
                                                <li>'. $this->Html->link('Manage Order Payments',["controller" => "Payments", "action" => "index"]).'</li>
                                                <li>'. $this->Html->link('Manage Order Invoices',["controller" => "Invoices", "action" => "index"]).'</li>
                                                <li role="separator" class="divider"></li>
                                                <li>'. $this->Html->link('View Order as Customer',["controller" => "Pages", "action" => "vieworder"]).'</li>
                                            </ul>
                                        </li>
                                        <li class"dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>Vendor<span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a data-toggle="modal" class="modalLink" data-target="#viewVendorModal">Search for a Vendor</a></li>
                                                <li>'. $this->Html->link('Add a Vendor',["controller" => "Vendors", "action" => "add"]).'</li>
                                                <li>'. $this->Html->link('Manage Vendors',["controller" => "Vendors", "action" => "index"]).'</li>
                                            </ul>
                                        </li>
                                        <li class"dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span>Promotion<span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li>'. $this->Html->link('Create a New Promo',["controller" => "Promotions", "action" => "add"]).'</li>
                                                <li>'. $this->Html->link('Manage Promotions',["controller" => "Promotions", "action" => "index"]).'</li>
                                                <li role="separator" class="divider"></li>
                                                <li>'. $this->Html->link('Manage Zodiac Auto Mail',["controller" => "Automail", "action" => "edit",1]).'</li>
                                                <li>'. $this->Html->link('Manage Birthday Auto Mail',["controller" => "Automail", "action" => "edit",2]).'</li>
                                                <li>'. $this->Html->link('Manage Anniv. Auto Mail',["controller" => "Automail", "action" => "edit",3]).'</li>
                                            </ul>
                                        </li>
                                      </ul>

                                      <ul class="nav navbar-nav navbar-right">
                                        <li class="dropdown">
                                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$user['username'].'<span class="caret"></span></a>
                                          <ul class="dropdown-menu">
                                            <li>'. $this->Html->link('App Settings',["controller" => "Settings", "action" => "edit",'1']).'</li>
                                            <li>'.$this->Html->link('View my account',["controller" => "Users", "action" => "view",$user['id']]).'</li>
                                            <li>'. $this->Html->link('Manage Users',["controller" => "Users", "action" => "index"]).'</li>
                                            <li role="separator" class="divider"></li>
                                            <li>'. $this->Html->link(__('Logout'), ['controller' => 'users','action' => 'logout']).'</li>
                                          </ul>
                                        </li>
                                      </ul>
                                    </div><!-- /.navbar-collapse -->
                                  </div><!-- /.container-fluid -->
                                </nav>';
                    }
                    //link logo to cust view order page if not logged in as admin
                    else
                        echo "<header style='text-align: center'>".$this->Html->image("Engage_logo_4col1.png", [
                             "alt" => "Engage Jewellery Logo",
                              "style" => "width:385px",
                              'url' => ['controller' => 'Pages', 'action' => 'vieworder']
                        ])."</header>";
        ?>


    <div id="container">

        <div id="content">
            <?= $this->Flash->render() ?>

            <div class="row">
              <div class="columns large-12">
              <?php  if ($this->fetch('title')!="Admin Panel"
                        && $this->fetch('title')!='Admin System | Login'
                        && substr($this->fetch('title'),0,18)!='Viewing Your Order'
                        && $this->fetch('title')!='Engage Jewellery | Check Your Order'){
              echo '<div class="large-12 hide-for-small-down crumbs">';
              echo $this->Html->getCrumbs(' > ', [
                  'text' => '<i class="glyphicon glyphicon-home" style="font-size:17px;padding-bottom:10px"></i>',
                  'url' => ['controller' => 'Pages', 'action' => 'display', 'start'],
                  'escape' => false
                ]);

              echo '</div>';
            }
              ?>
                <?= $this->fetch('content') ?>
              </div>
            </div>
        </div>
        <footer>
        </footer>
    </div>
<script>
  $(document).ready(function(){
    $('div.message').click(function(){
      $(this).fadeOut('slow');
    });

    var theCustListURL = '<?php echo $this->Url->build([
    "controller" => "/",
    "action" => "customers.json"
    ]);
  ?>';

  var theOrderListURL = '<?php echo $this->Url->build([
  "controller" => "/",
  "action" => "orders.json"
  ]);
?>';

var theVendorListURL = '<?php echo $this->Url->build([
"controller" => "/",
"action" => "vendors.json"
]);
?>';

  var theAddOrdersURL = '<?php echo $this->Url->build([
  "controller" => "Orders",
  "action" => "add"
  ]);
?>';

var theViewCustURL = '<?php echo $this->Url->build([
"controller" => "Customers",
"action" => "view"
]);
?>';

var theViewVendorURL = '<?php echo $this->Url->build([
"controller" => "Vendors",
"action" => "view"
]);
?>';

var theViewOrderURL = '<?php echo $this->Url->build([
"controller" => "Orders",
"action" => "view"
]);
?>';

    $('.search-cust-order, .search-cust').keyup(function(event){
        if ($(event.target).val() != null && $(event.target).val() !== ""){
          var searchField = $(event.target).val();
          var regex = new RegExp(searchField, "i");
          var output = '<div class="row">';
          var count = 1;
          $.getJSON(theCustListURL, function(data) {
            $.each(data.customers, function(key, val){
              if ((val.firstname + ' ' + val.surname).search(regex) != -1 ||
               (val.phone).search(regex) != -1 ||
               (val.email).search(regex) != -1){
                if ($(event.target).data('id') === 'order-cust')
                  output += '<a href="' + theAddOrdersURL + '/' + val.id + '"><div class="col-md-6 searchresults">';
                else
                  output += '<a href="' + theViewCustURL + '/' + val.id + '"><div class="col-md-6 searchresults">';
                output += '<div class="col-md-12">';
                output += '<h5>' + val.firstname + ' ' + val.surname + '</h5>';
                output += '<p>ph: ' + val.phone + '</p>'
                var email = "";
                if (!val.email)
                  email = "&nbsp;";
                else
                  email = val.email;

                output += '<p>' + email + '</p>'
                output += '</div>';
                output += '</div>';
                if(count%2 == 0){
                  output += '</div></a><div class="row">'
                }
                count++;
              }
            });
            output += '</div>';
            if ($(event.target).data('id') === 'order-cust')
              $('#cust-order-result').html(output);
            else
              $('#cust-result').html(output);
          });
        }
        else {
          $('#cust-result, #cust-order-result').html("");
        }
    });

    $('.search-order').keyup(function(event){
        if ($('.search-order').val() != null && $('.search-order').val() !== ""){
          var searchField = $('.search-order').val();
          var regex = new RegExp(searchField, "i");
          var output = '<div class="row">';
          var count = 1;
          $.getJSON(theOrderListURL, function(data) {
            $.each(data.orders, function(key, val){
              if ((val.customer.firstname + ' ' + val.customer.surname).search(regex) != -1 || (val.id + '').search(regex) != -1){
                  output += '<a href="' + theViewOrderURL + '/' + val.id + '"><div class="col-md-6 searchresults">';
                output += '<div class="col-md-12">';
                output += '<h5>#' + val.id + '</h5>'
                output += '<p>' + val.customer.firstname + ' ' + val.customer.surname + '</p>';
                output += '<p style="font-weight:bold;color:rgb(210,70,70)">' + val.orderstatus.name + '</p>';
                output += '</div>';
                output += '</div>';
                if(count%2 == 0){
                  output += '</div></a><div class="row">'
                }
                count++;
              }
            });

            output += '</div>';
            $('#order-result').html(output);
          });
        }
        else {
          $('#order-result').html("");
        }
    });

    $('.search-vendor').keyup(function(event){
        if ($(event.target).val() != null && $(event.target).val() !== ""){
          var searchField = $(event.target).val();
          var regex = new RegExp(searchField, "i");
          var output = '<div class="row">';
          var count = 1;
          $.getJSON(theVendorListURL, function(data) {
            $.each(data.vendors, function(key, val){
              if ((val.vendor_name).search(regex) != -1 ||
                (val.contact_fname + ' ' + val.contact_sname).search(regex) != -1 ||
                (val.phone).search(regex) != -1 ||
                (val.email).search(regex) != -1){
                  output += '<a href="' + theViewVendorURL + '/' + val.id + '"><div class="col-md-6 searchresults">';
                output += '<div class="col-md-12">';
                output += '<h5>' + val.vendor_name + '</h5>'
                output += '<p>ph: ' + val.phone + '</p>';
                var email = "";
                if (!val.email)
                  email = "&nbsp;";
                else
                  email = val.email;
                output += '<p>' + email + '</p>'
                output += '</div>';
                output += '</div>';
                if(count%2 == 0){
                  output += '</div></a><div class="row">'
                }
                count++;
              }
            });

            output += '</div>';
            $('#vendor-result').html(output);
          });
        }
        else {
          $('#vendor-result').html("");
        }
    });

    $('.modalLink').click(function(){
      $('.search-cust-order, .search-cust, .search-order, .search-vendor').val('');
      $('#cust-result, #cust-order-result, #order-result, #vendor-result').html("");
    })

    $('.actions > h3').click(function(){
      $('.side-nav').toggle();
    });
  });

</script>
</body>
</html>
