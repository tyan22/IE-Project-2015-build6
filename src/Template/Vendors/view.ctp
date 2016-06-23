<?php
    $this->assign('title', "Vendor $vendor->vendor_name");
    $this->Html->addCrumb('Vendors', '/vendors');
    $this->Html->addCrumb('View Vendor', ['controller' => 'Vendors', 'action' => 'view',$vendor->id]);
?>
<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">

        <li><?= $this->Html->link(
           $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-pencil right-pad-5px')).$this->Html->tag('span', __('Edit Vendor')),
           ['controller' => 'Vendors', 'action' => 'edit',$vendor->id],
           array('escape'=>false)) ?>
        </li>
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
<div class="vendors view large-10 medium-9 columns">
    <h2 class="bold"><?= h($vendor->vendor_name) ?></h2>


    <div class="row">
        <div class="large-6 columns ">

        <table class="table dataTable  card border-blue-left" cellspacing="0">
                        <tr>
                            <th><?= __('Phone') ?></th>
                            <td><?= h($vendor->phone) ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th><?= __('Email') ?></th>
                            <td colspan ="2"><?= h($vendor->email) ?></td>

                         </tr>
                         <tr>
                            <th><?= __('Address') ?></th>
                            <td colspan ="2"><?= h($vendor->address) ?></td>

                         </tr>
                         <tr>
                             <th><?= __('Suburb') ?></th>
                             <td><?= h($vendor->suburb) ?></td>
                          </tr>
                          <tr>
                            <th><?= __('State') ?></th>
                            <td><?= $vendor->has('state') ? h($vendor['state']['name']) : '' ?></td>
                          </tr>
                          <tr>
                             <th><?= __('Postcode') ?></th>
                             <td><?= h($vendor->postcode) ?></td>
                             <td></td>
                          </tr>
                          <tr>
                             <th><?= __('Speciality') ?></th>
                             <td colspan ="2"><?= h($vendor->speciality) ?></td>

                          </tr>

                          </table>

        </div>
        <div class="large-6 columns ">
        <div class="large-9 columns ">
              <table class="table dataTable  card border-blue-left" cellspacing="0">
                          <tr>
                             <th><?= __('Contact First Name') ?></th>
                             <td><?= h($vendor->contact_fname) ?></td>
                          </tr>
                          <tr>
                             <th><?= __('Contact Surname') ?></th>
                             <td><?= h($vendor->contact_sname) ?></td>
                          </tr>
        </div>
        </div>
    </div>
            <div class="large-7 columns ">

                <table class="table dataTable  card border-blue-left" cellspacing="0">
                                <tr>
                                    <th><?= __('Notes') ?></th>
                                </tr>
                                <tr>
                                <?php
                              if (!empty($vendor->notes))
                                echo "<td>".h($vendor->notes)."</td>";
                              else
                                echo "<td>There are no notes for this vendor</td>";
                              ?>
                                </tr>
                </table>
        </div>
    </div>
</div>
