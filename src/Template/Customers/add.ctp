<?= $this->Html->script(['jquery-ui.min']) ?>

<?php
    $this->assign('title', "Add New Customer");
    $this->Html->addCrumb('Customers', '/customers');
    $this->Html->addCrumb('Add Customer', ['controller' => 'Customers', 'action' => 'add']);
?>
<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">

            <li><?= $this->Html->link(
             $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-list-alt right-pad-5px')).$this->Html->tag('span', __('List Customers')),
             ['action' => 'index'],
             array('escape'=>false)) ?>
            </li>
          </ul>
</div>
<div class="customers index large-10 medium-9 columns">
<div class="edit_tables">
  <?php if (isset($this->request->query['o']) && $this->request->query['o'] == 'y')
    echo "<p>Step 1 of 2:</p>";
    ?>
    <?= $this->Form->create($customer,['novalidate' => true]); ?>
    <fieldset>

        <legend><?= __('Add Customer') ?></legend>
        <?php
            echo '<div class="row">';
                echo '<div class="columns large-2">';
                    echo $this->Form->input('title_id',['empty' => true,'options'=>$titles]);
                echo '</div>';
                echo '<div class="columns large-5">';
                    echo $this->Form->input('firstname');
                echo '</div>';
                echo '<div class="columns large-5">';
                    echo $this->Form->input('surname');
                echo '</div>';
            echo '</div>';
                    echo '<div class="row">';
                      echo '<div class="columns medium-4">';
                        echo $this->Form->input('bday', ['label'=>'Date of Birth']);
                      echo '</div>';
                    echo '<div class="columns medium-3">';
                     echo $this->Form->input('zodiac_id',['empty' => true]);
                     echo '</div>';
                     echo '<div class="columns medium-5">';
                     echo '</div>';
                 echo '<div class="columns medium-5">';
                    echo '</div>';
                   echo '</div>';
            echo '<div class="row">';
                echo '<div class="columns large-5">';
                    echo $this->Form->input('phone',['label'=>'Phone (pref. mobile)']);
                echo '</div>';
                echo '<div class="columns large-7">';
                     echo $this->Form->input('email');
                echo '</div>';
            echo '</div>';
            echo $this->Form->input('address');
            echo '<div class="row">';
                echo '<div class="columns large-5">';
                    echo $this->Form->input('suburb');
                echo '</div>';
                echo '<div class="columns large-3">';
                    echo $this->Form->input('state_id',['empty' => true,'options'=>$states]);
                echo '</div>';
                echo '<div class="columns large-4">';
                     echo $this->Form->input('postcode');
                echo '</div>';
            echo '</div>';
            echo '<div class="row">';
              echo '<div class="columns large-7">';
                 echo $this->Form->input('notes',['rows'=>3]);
               echo '</div>';
            echo '</div>';

        ?>
    </fieldset>
    <br />

    <?php if (isset($this->request->query['o']) && $this->request->query['o'] == 'y'){
      echo "<p>Go to Step 2: Create Order</p>";
      echo $this->Form->button(__('Next'),['class'=>'btn btn-success']);
    }
    else
     echo $this->Form->button(__('Submit'),['class'=>'btn btn-success']); ?>
    <?= $this->Form->end() ?>
    <span class="required-notice">* required</span>
</div>
</div>
<script type="text/javascript">
        var d = new Date();
        var n = d.getFullYear() - 15;
        $(document).ready(function(){
            $("#bday").datepicker({ dateFormat : 'dd-mm-yy', changeYear: true, minDate: new Date(1902,0,1), maxDate: new Date(n,0,1)});
        });
</script>
<script>
window.onload = function () {
var my_var = <?php
    if ($customer->dob != null){
        echo json_encode($customer->dob->i18nFormat('dd-MM-YYYY'));
    }
    else
        echo "null";
   ?>;
 $("#bday").datepicker().val(my_var);
}
</script>
