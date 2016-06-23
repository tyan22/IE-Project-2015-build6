<?php
    $this->assign('title', "ADD NEW VENDOR");
    $this->Html->addCrumb('Vendors', '/vendors');
    $this->Html->addCrumb('Add Vendor', ['controller' => 'Vendors', 'action' => 'add']);
?>
<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">

        <li><?= $this->Html->link(
             $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-list-alt right-pad-5px')).$this->Html->tag('span', __('List Vendors')),
             ['action' => 'index'],
             array('escape'=>false)) ?>
            </li>        </ul>
</div>
<div class="vendors form large-10 medium-9 columns">
<div class="edit_tables">

    <?= $this->Form->create($vendor,['novalidate' => true]); ?>
    <fieldset>
        <legend><?= __('Add Vendor') ?></legend>
        <?php
         echo '<div class="row">';
           echo '<div class="columns medium-8">';
            echo $this->Form->input('vendor_name');
           echo '</div>';
         echo '</div>';
            echo '<div class="row">';
                echo '<div class="columns large-5">';
                    echo $this->Form->input('phone');
                echo '</div>';
                echo '<div class="columns large-7">';
                     echo $this->Form->input('email');
                echo '</div>';
            echo '</div>';
            echo '<div class="row">';
                echo '<div class="columns large-10">';
                    echo $this->Form->input('address');
                echo '</div>';
            echo '</div>';
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
                      echo $this->Form->input('speciality');
                 echo '</div>';
            echo '</div>';
            echo '<div class="row">';
               echo '<div class="columns large-6">';
                  echo $this->Form->input('contact_fname',['label'=>'Contact First Name']);
               echo '</div>';
               echo '<div class="columns large-6">';
                  echo $this->Form->input('contact_sname',['label'=>'Contact Surname']);
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

    <?= $this->Form->button(__('Submit'),['class'=>'btn btn-success']) ?>
    <?= $this->Form->end() ?>
    <span class="required-notice">* required</span>
</div>
</div>
