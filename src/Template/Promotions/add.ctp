<?php
    $this->assign('title', "Create Promotion");
    $this->Html->addCrumb('Promotions', '/promotions');
    $this->Html->addCrumb('Create Promotion', ['controller' => 'Promotions', 'action' => 'add']);
?>
<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
      <li><?= $this->Html->link(
      $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-list-alt right-pad-5px')).$this->Html->tag('span', __('List Promotions')),
      ['action' => 'index'],
      array('escape'=>false)) ?>
     </li>
     <li><?= $this->Html->link(
         $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-ban-circle right-pad-5px')).$this->Html->tag('span', __('Cancel Create Promo')),
         ['controller' => 'Pages', 'action' => 'start'],
         array('escape'=>false)) ?>
    </li>
  </ul>
</div>
<div class="customers index large-10 medium-9 columns">
<div class="edit_tables">
      <?= $this->Form->create($promotion,['enctype' => 'multipart/form-data']); ?>
    <fieldset>
        <legend><?= __('Create Promotion') ?></legend>
        <?php
                    echo '<div class="row">';
                       echo '<div class="columns medium-7">';
                          echo $this->Form->input('title');
                       echo '</div>';
                    echo '</div>';
                    echo '<div class="row">';
                        echo '<div class="columns large-3">';
                          echo $this->Form->input('start', ['label'=>'Start Date','required'=>true]);
                        echo '</div>';
                        echo '<div class="columns large-3">';
                          echo $this->Form->input('end', ['label'=>'End Date','required'=>true]);
                        echo '</div>';
                        echo '<div class="columns large-3">';

                          echo $this->Form->input('cust_group', ['type'=>'select','label'=>'Customer Group','options'=>['All'=>'All','Jewellery'=>'Jewellery','Diamonds'=>'Diamonds']]);
                        echo '</div>';
                        echo '<div class="columns large-3">';
                        echo '</div>';
                    echo '</div>';
                    echo '<div class="row">';
                        echo '<div class="columns medium-10">';
                          echo $this->Form->input('headline');
                        echo '</div>';
                    echo '</div>';
                    echo '<div class="row">';
                        echo '<div class="columns medium-8">';
                          echo $this->Form->input('description',['style'=>'margin-bottom:1rem']);
                        echo '</div>';
                         echo '<div class="columns medium-4">';
                         echo '</div>';
                    echo '</div>';
                    echo '<div class="row">';
                        echo '<div class="columns medium-8">';
                          echo $this->Form->input('aboutengage',['label'=>'About Engage','style'=>'min-height:100px;margin-bottom:1rem']);
                        echo '</div>';
                         echo '<div class="columns medium-4">';
                         echo '</div>';
                    echo '</div>';
                    echo '<div class="row">';
                        echo '<div class="columns medium-8">';
                        echo $this->Form->input('sms_message',['type'=>'textarea','label'=>'SMS Message - leave blank to exclude SMS for this promo','style'=>'min-height:60px;margin-bottom:1rem']);
                          echo "<strong><span style='color:#CC5151;float:right' id='remainingC'></span></strong>";
                        echo '</div>';
                         echo '<div class="columns medium-4">';
                         echo '</div>';
                    echo '</div>';
                    echo '<div class="row">';
                        echo '<div class="columns medium-4">';
                        echo '<p style="margin-top: 10px;margin-bottom: 5px;font-size:0.875rem;color:#4d4d4d"><strong>Upload Promo Image</strong></p>';
                          echo $this->Form->file('promo_image', ['onchange'=>'PreviewImage()','id'=>'promoimg','style'=>'margin-top:20px', 'size'=>'60']);
                          echo "<br /><img id='preview' width='200'/>";
                        echo '</div>';
                        echo '<div class="columns medium-8">';
                        echo '</div>';
                    echo '</div>';

                    echo $this->Form->hidden('test_mail_sent',['value'=>0]);
                    echo $this->Form->hidden('mail_out_completed',['value'=>0]);

                ?>
    </fieldset>
    <br />

    <?= $this->Form->button(__('Submit'),['class'=>'btn btn-success']) ?>
    <?= $this->Form->end() ?>
    <span class="required-notice">* required</span>
  </div>

</div>
</div>

<script>
  $(document).ready(function(){
    $('#sms-message').keyup(function(){
        if(this.value.length > 160){
            return false;
        }
        $('#remainingC').html('Remaining characters : ' + (160 - this.value.length));
    })
  });
</script>

<script>

function PreviewImage() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("promoimg").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("preview").src = oFREvent.target.result;
    };
};

window.onload = function () {
  $("#start").datepicker({ dateFormat : 'dd-mm-yy'});
  $("#end").datepicker({ dateFormat : 'dd-mm-yy'});
  $("#start").datepicker();
  $("#end").datepicker();
  $('#aboutengage').val("At Engage Jewellery we carry over a dozen local and international jewellery and watch brands yet our intimate boutique atmosphere and personalised customer service will make your shopping experience a most enjoyable one. We specialise in crafting some of the most beautiful and high-quality gold and platinum wedding bands and ideal-cut diamond engagement rings Australia has to offer.");
}
</script>
