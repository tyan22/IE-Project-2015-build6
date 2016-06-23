<style>
  .crumbs{display:none !important}
  .errordiv{text-align:center;}
  .errordiv img{width:40% !important;margin-top:20px;margin-bottom:30px}
</style>
<div class="errordiv">
<h1>Oops, something went wrong there!</h1><br />
<h4><strong>Looks like you tried to load a page that doesn't exist</strong></h4>
  <?php echo $this->Html->image("404.png", [
  "alt" => "404 image"]);
  ?>
  <p>No big deal, just make sure the URL you entered is correct and refresh the page</p>
  <p>Or you can use the navigation menu above, or just go back to the
    <?php echo $this->Html->link('admin panel',['controller' => 'Pages', 'action' => 'display','start'],['style'=>'color:#DC3300']);
    echo '.</p>';
    ?>
</div>
