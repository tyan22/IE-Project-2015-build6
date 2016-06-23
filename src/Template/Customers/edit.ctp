<?php
    $this->assign('title', "Edit Customer $customer->fullName");
    $this->Html->addCrumb('Customers', '/customers');
    $this->Html->addCrumb('Edit Customer', ['controller' => 'Customers', 'action' => 'edit',$customer->id]);
?>
<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">
      <li>
    <?php

                    echo $this->Form->postLink(
                       $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove right-pad-5px')). __('Delete Customer'),
                            array('action' => 'delete', $customer->id),
                            array('escape'=>false, 'confirm'=>
                            __('Are you sure you want to delete customer {0} {1}?',
                            $customer->firstname, $customer->surname))
                       );
                    ?></li>
        <li>
         <?= $this->Html->link(
         $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-plus-sign right-pad-5px')).$this->Html->tag('span', __('Add New Anniversary')),
         ['controller' => 'Anniversaries', 'action' => 'add','customer_id' => $customer->id],array('escape'=>false)) ?>
       </li>
       <li>
        <?= $this->Html->link(
            $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-plus-sign right-pad-5px')).$this->Html->tag('span', __('Add New Order')),
                ['controller' => 'Orders', 'action' => 'add',$customer->id],array('escape'=>false)) ?>
         </li>

    </ul>
</div>
<div class="customers index large-10 medium-9 columns">
<div class="edit_tables">
    <?= $this->Form->create($customer,['novalidate' => true]); ?>
    <fieldset>
        <legend><?= __('Edit Customer') ?></legend>
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
                            echo $this->Form->input('bday', array('label'=>'Date of Birth'));
                        echo '</div>';
                        echo '<div class="columns medium-3">';
                            echo $this->Form->input('zodiac_id',['empty' => true]);
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
                    echo '<div class="large-7 columns">';
                    echo $this->Form->input('comments',['rows'=>'3']);
                    echo '</div>';
                    echo '</div>';

                ?>
    </fieldset>
    <br />

    <?= $this->Form->button(__('Submit'),['class'=>'btn btn-success']) ?>
    <?= $this->Form->end() ?>
    <span class="required-notice">* required</span>
</div>
</div>
<script type="text/javascript">
        $(document).ready(function(){
                var d = new Date();
                var n = d.getFullYear() - 15;
                my_range = "1902:"+n;
            $("#bday").datepicker({ dateFormat : 'dd-mm-yy', changeYear: true, yearRange: my_range});
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
