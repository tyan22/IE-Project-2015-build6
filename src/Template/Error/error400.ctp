<?php
use Cake\Core\Configure;

echo "<h1>Oops, something went wrong!</h1>";

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');

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
<?= $this->element('auto_table_warning') ?>
<?php
    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
?>
<!--catchall error message template -->
<style>
  .crumbs{display:none !important}
  .errordiv img {width:40% !important;margin-top:20px;margin-bottom:30px}
  .errordiv{text-align:center;}

</style>
<div class="errordiv">
  <?php
    echo '<h2>'. __d('cake', 'Oops, something weird happened!'). '</h2><br />';
    echo '<h4><strong>Maybe the gremlins escaped from their cages?</strong></h4>';
  ?>
  <p>Don't panic! Just make sure the URL you entered is correct and refresh the page</p>
  <p>Or you can use the navigation menu above, or just go back to the
    <?php echo $this->Html->link('admin panel',['controller' => 'Pages', 'action' => 'display','start'],['style'=>'color:#DC3300']);?>
    .</p>
</div>
