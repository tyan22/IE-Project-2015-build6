
<?php
    echo $this->Html->css('isotope-docs');
    echo $this->Html->script('isotope.pkgd.min');
    $this->assign('title', 'Admin Panel');
?>
<script>
$( function() {
    //quick search regex
    var qsRegex;
    // use value of search field to filter
  var $quicksearch = $('.search-bar').keyup( debounce( function() {
    qsRegex = new RegExp( $quicksearch.val(), 'gi' );
    $grid.isotope();
  }, 200 ) );

  $('.grid').isotope({
      layoutMode: 'fitRows',
      itemSelector: '.recent-item'
    });

  // init Isotope
  var $grid = $('.isotope').isotope({
      itemSelector: '.recent-item',
      fitRows: {
    },
      filter: function() {
      return qsRegex ? $(this).text().match( qsRegex ) : true;
    }
    });
  // filter functions
  var filterFns = {
    // show if number is greater than 50
    numberGreaterThan50: function() {
      var number = $(this).find('.number').text();
      return parseInt( number, 10 ) > 50;
    },
    // show if name ends with -ium
    ium: function() {
      var name = $(this).find('.name').text();
      return name.match( /ium$/ );
    }
  };


    //shuffle & reset
     $('.functions-button-group').on( 'click', 'button',function() {
       var functionName = $(this).attr('function-name');
        if(functionName =="reset"){
           //sort by original order
           }

     });
  // bind filter button click
  $('.filters-button-group').on( 'click', 'button', function() {
    var filterValue = $( this ).attr('data-filter');
    // use filterFn if matches value
    filterValue = filterFns[ filterValue ] || filterValue;
    $grid.isotope({ filter: filterValue });
  });
  // change is-checked class on buttons
  $('.button-group').each( function( i, buttonGroup ) {
    var $buttonGroup = $( buttonGroup );
    $buttonGroup.on( 'click', 'button', function() {
      $buttonGroup.find('.is-checked').removeClass('is-checked');
      $( this ).addClass('is-checked');
    });
  });



});
    // debounce so filtering doesn't happen every millisecond
function debounce( fn, threshold ) {
  var timeout;
  return function debounced() {
    if ( timeout ) {
      clearTimeout( timeout );
    }
    function delayed() {
      fn();
      timeout = null;
    }
    timeout = setTimeout( delayed, threshold || 100 );
  }
}

</script>
  <div class="row">
    <div class="small-12 columns">
    <div class="containerIsotope">
    <h2 style="font-size:25px">Recently accessed</h2>
        <div class="button-group filters-button-group" style="display:block">
            <button class="btn btn-info is-checked" data-filter="*">show all</button>
            <button class="btn btn-info" data-filter=".customer">customers</button>
            <button class="btn btn-info" data-filter=".order">orders</button>
            <button class="btn btn-info" data-filter=".vendor">vendors</button>
        </div>

    <div class="isotope">
        <?php
            //repeat for each recently accessed customer
            foreach ($custs as $key=>$cust) {
                echo "<a href='../customers/view/".$cust->id."'><div class='recent-item customer' data-category='customer'>
                       <i class='fa fa-user'><p class='type'>Customer</p></i>
                       <p class='details'>".$cust->fullName."</p>
                       <p class='phone'>ph. ".$cust->phone."</p>
                      </div></a>";
            }

            //repeat for each recently accessed order
            foreach ($orders as $key=>$order) {
                echo "<a href='../orders/view/".$order->id."'><div class='recent-item order' data-category='order'>
                       <i class='fa fa-credit-card'><p class='type'>Order</p></i>
                       <p class='details'>#".$order->id."</p>
                       <p class='status'>".$order->customer['fullName']."</p>
                      </div></a>";
            }

            //repeat for each recently accessed vendor
            foreach ($vendors as $key=>$vendor) {
                echo "<a href='../vendors/view/".$vendor->id."'><div class='recent-item vendor' data-category='vendor'>
                       <i class='fa fa-cogs'><p class='type'>Vendor</p></i>
                       <p class='details'>".$vendor->vendor_name."</p>
                       <p class='phone'>ph. ".$vendor->phone."</p>
                      </div></a>";
            }
        ?>
    </div>
</div>
</div>
<!--
<div class="row state-overview">
    <div class="small-12">
                  <div class="large-3 small-6 columns">
                      <section class="panel start">
                          <div class="symbol red">
                              <i class="fa fa-users"><h1>Customers</h1></i>
                          </div>
                          <div class="value">
                              <ul>
                                <li class="red-li"><p><?= $this->Html->link(__('Manage Customers'),['controller' => 'customers','action' => 'index'], array('class' => 'start-link')) ?></p></li>
                              </ul>
                          </div>
                      </section>
                  </div>
                  <div class="large-3 small-6 columns">
                      <section class="panel start">
                          <div class="symbol yellow">
                              <i class="fa fa-credit-card"><h1>Orders</h1></i>
                          </div>
                          <div class="value">
                              <ul>
                                <li class="yellow-li"><p><?= $this->Html->link(__('Manage Orders'), ['controller' => 'orders','action' => 'index'], array('class' => 'start-link')) ?></p></li>
                                <li class="yellow-li"><p><?= $this->Html->link(__('View Order as Customer'), ['controller' => 'pages','action' => 'vieworder'], array('class' => 'start-link')) ?></p></li>
                              </ul>
                          </div>
                      </section>
                  </div>
                  <div class="large-3 small-6 columns">
                      <section class="panel start">
                          <div class="symbol green">
                              <i class="fa fa-tags"><h1>Users</h1></i>
                          </div>
                          <div class="value">
                              <ul>
                                <li class="green-li"><p><?= $this->Html->link(__('Manage Users'), ['controller' => 'users','action' => 'index'], array('class' => 'start-link')) ?></p></li>
                                <li class="green-li"><p><?= $this->Html->link(__('Manage Access Levels'), ['controller' => 'groups','action' => 'index'], array('class' => 'start-link')) ?></p></li>
                              </ul>
                          </div>
                      </section>
                  </div>
                  <div class="large-3 small-6 columns">
                      <section class="panel start">
                          <div class="symbol blue">
                              <i class="fa fa-cogs"><h1>Other</h1></i>
                          </div>
                          <div class="value">
                              <ul>
                                <li class="blue-li"><p><?= $this->Html->link(__('Manage Vendors'), ['controller' => 'vendors','action' => 'index'], array('class' => 'start-link')) ?></p></li>
                                <li class="blue-li"><p><?= $this->Html->link(__('Manage Anniv. Types'), ['controller' => 'anniversarytypes','action' => 'index'], array('class' => 'start-link')) ?></p></li>
                                <li class="blue-li"><p><?= $this->Html->link(__('Log Out'), ['controller' => 'users','action' => 'logout'], array('class' => 'start-link')) ?></p></li>
                              </ul>
                          </div>
                      </section>
                  </div>
              </div>
</div>

-->
