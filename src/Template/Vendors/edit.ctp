<?php
    $this->assign('title', "Edit Vendor $vendor->vendor_name");
    $this->Html->addCrumb('Vendors', '/vendors');
    $this->Html->addCrumb('Edit Vendor', ['controller' => 'Vendors', 'action' => 'edit',$vendor->id]);
?>
<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">

        <li>
        <?php
        echo $this->Form->postLink(
           $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove right-pad-5px')). __('Delete Vendor'),
                array('action' => 'delete', $vendor->id),
                array('escape'=>false,'confirm'=>__('Are you sure you want to delete vendor #{0}?',
                $vendor->vendor_name))
           );
        ?>
       </li>
    </ul>
</div>
<div class="vendors form large-10 medium-9 columns">
<div class="edit_tables">

    <?= $this->Form->create($vendor,['novalidate' => true]); ?>
    <fieldset>
        <legend><?= __('Edit Vendor') ?></legend>
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
