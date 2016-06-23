<?php
  $this->Html->addCrumb('Customers', '/customers');
  $this->Html->addCrumb('Customer', ['controller' => 'Customers', 'action' => 'view',$cust_id]);
  $this->Html->addCrumb('Add Anniversary', ['controller' => 'Anniversaries', 'action' => 'add', 'customer_id'=>$cust_id]);
?>
<?= $this->Html->script(['jquery-ui.min']) ?>
<style>
    .ui-datepicker-year{display:none !important;}
    #anniyear{margin:0 0 0 0;}
</style>
<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">


        <li><?= $this->Html->link(
             $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-ban-circle right-pad-5px')).$this->Html->tag('span', __('Cancel Add Anniv.')),
             ['controller' => 'Customers', 'action' => 'view',$cust_id],
             array('escape'=>false)) ?>
            </li>
        </li>
    </ul>
</div>
<div class="anniversaries form large-7 medium-8 columns">
<div class="edit_tables">
    <?= $this->Form->create($anniversary,['novalidate' => true]); ?>
    <fieldset>
        <legend><?= __('Add Anniversary') ?></legend>
        <?php
            echo $this->Form->input('anniversarytype_id', ['label'=>'Anniversary Type','options' => $anniversarytypes]);
            echo $this->Form->input('customer_id', ['label'=>false,'hidden'=>true,'value' => $cust_id]);
            echo '<div class="row">';
                echo '<div class="small-3 columns">';
                    echo $this->Form->input('annidate',['required'=>'true','label'=>'Anniversary Date']);
                echo '</div>';
                echo '<div class="small-3 columns" style="text-align:right;">';
                echo '<br /><span style="padding-top:10px;">Include year? </span>' . $this->Form->checkbox('yearknown');
                echo '</div>';
                echo '<div class="small-3 columns" id="anniHolder">';
                echo $this->Form->input('anniyear',['label'=>'Year']);
                echo '</div>';
                echo '<div class="small-3 columns" id="anniPlaceHolder">';
                echo '</div>';
                echo '<div class="small-3 columns">';
                echo '</div>';
            echo '</div>';
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),['class'=>'btn btn-success']) ?>
    <?= $this->Form->end() ?>
    <span class="required-notice">* required</span>
</div>
</div>
<div class="anniversaries form large-5 medium-4 columns">
</div>
<script type="text/javascript">
        $(document).ready(function(){
            $("#annidate").datepicker( { changeYear: false, dateFormat: 'dd-M' });
            $("#anniyear" ).spinner();


            //set initial values and visibilities
            $("#anniyear").spinner().val(null);
            $('#anniyear').hide();
            $('#anniHolder').hide();
            $('#anniPlaceHolder').show();
            var d = new Date();
            var n = d.getFullYear() - 20;

            $('input:checkbox').change(
                 function(){
                    if ($(this).is(':checked')) {
                       $("#anniPlaceHolder").hide();
                       $("#anniyear").spinner().val(n);
                       $('#anniHolder').show();
                       $('#anniyear').show();
                    }
                    else {
                        $("#anniyear").spinner().val(null);
                        $('#anniyear').hide();
                        $('#anniHolder').hide();
                        $('#anniPlaceHolder').show();
                    }
                 });

        });
</script>
