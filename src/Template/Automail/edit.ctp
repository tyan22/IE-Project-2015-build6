<?php
    $this->assign('title', "Edit Automatic Mailout");
?>
<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
      <?php
      if ($automail->id == 1) {
        echo "<li>" . $this->Html->link(
        $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-edit right-pad-5px')).$this->Html->tag('span', __('Edit Zodiac Messages')),
        ['controller'=>'automail_msgs','action' => 'edit','type'=>'zodiac'],
        array('escape'=>false)) .
       "</li>";
     }
     else if ($automail->id == 2){
       echo "<li>" . $this->Html->link(
       $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-edit right-pad-5px')).$this->Html->tag('span', __('Edit Month Messages')),
       ['controller'=>'automail_msgs','action' => 'edit','type'=>'monthly'],
       array('escape'=>false)) .
      "</li>";
     }
       ?>
      <li><?= $this->Html->link(
      $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-list-alt right-pad-5px')).$this->Html->tag('span', __('Preview This Auto Mail')),
      ['action' => 'view',$automail->id],
      array('escape'=>false)) ?>
     </li>
     <li><?= $this->Html->link(
         $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-ban-circle right-pad-5px')).$this->Html->tag('span', __('Cancel Edit')),
         ['controller'=>'Pages','action' => 'start'],
         array('escape'=>false)) ?>
    </li>
      </ul>
</div>
<div class="customers index large-10 medium-9 columns">
<div class="edit_tables">
      <?= $this->Form->create($automail,['enctype' => 'multipart/form-data','novalidate' => true]); ?>
    <fieldset>
        <legend><?php
        if ($automail->id == 1){
           echo __('Edit Zodiac Auto Mailout');
           $this->assign('title', "Edit Zodiac Auto Mailout");
           $this->Html->addCrumb('Edit Zodiac Auto Mailout', ['controller' => 'automail', 'action' => 'edit',$automail->id]);
         }
        else if ($automail->id == 2){
           echo __('Edit Birthday Auto Mailout');
           $this->assign('title', "Edit Birthday Auto Mailout");
           $this->Html->addCrumb('Edit Birthday Auto Mailout', ['controller' => 'automail', 'action' => 'edit',$automail->id]);
         }
        else if ($automail->id == 3){
           echo __('Edit Anniv. Auto Mailout');
           $this->assign('title', "Edit Anniv. Auto Mailout");
           $this->Html->addCrumb('Edit Anniv. Auto Mailout', ['controller' => 'automail', 'action' => 'edit',$automail->id]);
         }
         if ($automail->active){
           echo " -<span style='color:green'> ACTIVE</span>";
         }
         else {
           echo " -<span style='color:red'> INACTIVE</span>";
         }
        ?></legend>
        <?php
           echo '<br /><div class="row">';
            echo '<div class="columns medium-7">';
                    echo "<strong>Activate Mailout&nbsp;&nbsp;</strong>" . $this->Form->checkbox('active',['label'=>false]);
                  echo '</div>';
                echo '</div>';
                  echo '<div class="row">';
                      echo '<div class="columns medium-10">';
                        echo $this->Form->input('title',['label'=>'Title (Email Subject)']);
                      echo '</div>';
                    echo '</div>';
                    echo '<div class="row">';
                        echo '<div class="columns large-3 medium-4">';
                          echo $this->Form->input('cust_group', ['type'=>'select','label'=>'Customer Group','options'=>['All'=>'All','Jewellery'=>'Jewellery','Diamonds'=>'Diamonds']]);
                        echo '</div>';
                        echo '<div class="columns large-3 medium-4">';
                        echo '</div>';
                    echo '</div>';
                    echo '<div class="row">';
                        echo '<div class="columns medium-10">';
                          echo $this->Form->input('headline');
                        echo '</div>';
                    echo '</div>';
                    echo '<div class="row">';
                        echo '<div class="columns medium-8">';
                          echo $this->Form->input('description',['style'=>'margin-bottom:12px']);
                        echo '</div>';
                         echo '<div class="columns medium-4">';
                         echo '</div>';
                    echo '</div>';
                    echo '<div class="row">';
                        echo '<div class="columns medium-8">';
                          echo $this->Form->input('aboutengage',['label'=>'About Engage','style'=>'min-height:120px;margin-bottom:12px']);
                        echo '</div>';
                         echo '<div class="columns medium-4">';
                         echo '</div>';
                    echo '</div>';
                    echo '<div class="row">';
                        echo '<div class="columns medium-4">';
                        echo '<p style="margin-top: 10px;margin-bottom: 5px;font-size:0.875rem;color:#4d4d4d"><strong>Upload Image</strong></p>';
                          echo $this->Form->file('image', ['onchange'=>'PreviewImage()','id'=>'promoimg','style'=>'margin-top:20px', 'size'=>'60']);
                          echo "<br /><img id='preview' width='200'/>";
                        echo '</div>';
                        echo '<div class="columns medium-6">';
                          echo '<p style="margin-top: 10px;margin-bottom: 5px;font-size:0.875rem;color:#4d4d4d"><strong>Current Image&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Remove ' . $this->Form->checkbox('remove_image'). '</strong></p>';
                          if (!empty($automail->image) && $automail->image != null){
                          echo $this->Html->image('../'.$automail->image, [
                               "alt" => "Promotional image",
                                "style" => "width:50%"]);
                        }
                        else {
                          echo '<h2 style="color:#aa3344">No Image!</h2>';
                        }
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

<script>

function PreviewImage() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("promoimg").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("preview").src = oFREvent.target.result;
    };
};

</script>

<?php
$default_title = "";
if ($automail->id == 1){
  $default_title = "Embrace your $starsign style! Find that perfect piece from Engage Jewellery to celebrate your $starsign nature";
}
else if($automail->id == 2){
  $default_title = "It\'s your birthday soon! Treat yourself or a loved one to a special piece from Engage Jewellery";
}
else if ($automail->id == 3){
  $default_title = "Special day coming up? Get something beautiful from Engage Jewellery!";
}
?>

<script>
    $(document).ready(function(){
      $('input[name=active]').change(function(){
          if ($('input[name=active]').is(':checked'))
            alert("Checking this option will activate this automatic mail out! Make sure everything is correct before you submit this form.");
          else {
            alert("Unchecking this option will de-activate this automatic mail out when you submit this form.");
          }
      });
      if (!$('input[name=title]').val())
        $('input[name=title]').val('<?= $default_title ?>');
      if (!$('#aboutengage').val())
        $('#aboutengage').val("At Engage Jewellery we carry over a dozen local and international jewellery and watch brands yet our intimate boutique atmosphere and personalised customer service will make your shopping experience a most enjoyable one. We specialise in crafting some of the most beautiful and high-quality gold and platinum wedding bands and ideal-cut diamond engagement rings Australia has to offer.");
    });
</script>
