<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

if (Configure::read('debug')):
    $this->layout = 'default';

    $this->assign('title', $message);
    $this->assign('templateName', 'error500.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?= Debugger::dump($error->params) ?>
<?php endif; ?>
<?php
    echo $this->element('auto_table_warning');

    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
?>
<style>
  .crumbs{display:none !important}
  .errordiv img {width:40% !important;margin-top:20px;margin-bottom:30px}
  .errordiv{text-align:center;}

</style>
<div class="errordiv">
  <?php if (!empty($message) && substr($message,0,10) == 'Record not'){
    echo '<h2>'. __d('cake', 'We looked <em>everywhere</em> but it\'s not here!'). '</h2><br />';
    echo '<h4><strong>Maybe it was deleted? Maybe it... never existed at all...</strong></h4>';
    echo $this->Html->image("404.png", [
    "alt" => "404 image"
   ]);
  }
    else {
    echo '<h2>'. __d('cake', 'Oops, something didn\'t go as planned.'). '</h2><br />';
    echo '<h4><strong>Was it you? Was it... us? Does it even matter?</strong></h4>';
  }?>
  <p>Don't panic! Just make sure the record you entered is correct and refresh the page</p>
  <p>Or you can use the navigation menu above, or just go back to the
    <?php echo $this->Html->link('admin panel',['controller' => 'Pages', 'action' => 'display','start'],['style'=>'color:#DC3300']);?>
    .</p>
</div>
