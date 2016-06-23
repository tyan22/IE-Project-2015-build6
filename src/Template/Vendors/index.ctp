<?php
    $this->assign('title', "ALL VENDORS");
    $this->Html->addCrumb('Vendors', '/vendors');
?>

<script>
        $(document).ready(function(){
            $('#vendTable').DataTable({
                "columnDefs": [ { "targets": 4, "orderable": false } ]
            });
        });
    </script>


<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">

            <li>
                <?= $this->Html->link(
                      $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-plus-sign right-pad-5px')).$this->Html->tag('span', __('Add New Vendor')),
                      ['action' => 'add'],
                      array('escape'=>false)) ?>
            </li>

    </ul>
</div>
<div class="vendors index large-10 medium-9 columns">
    <table id="vendTable" class="table card responsive" cellpadding="0">
    <thead>
        <tr>
            <th><?= h('Vendor Name') ?></th>
            <th class="min-tablet-p"><?= h('Phone') ?></th>
            <th class="min-tablet-l"><?= h('Speciality') ?></th>
            <th class="min-desktop"><?= h('State') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($vendors as $vendor): ?>
        <tr>
            <td><?= h($vendor->vendor_name) ?></td>
            <td><?= h($vendor->phone) ?></td>
            <td><?= h($vendor->speciality) ?></td>
            <td>
                <?= $vendor->has('state') ? $this->Html->link($vendor->state->name, ['controller' => 'States', 'action' => 'view', $vendor->state->id]) : '' ?>
            </td>
            <td class="actions">
                <?php
                 echo $this->Html->link(
                 '<i class="glyphicon glyphicon-search right-pad-0px"></i>',
                   ['action' => 'view', $vendor->id],
                   ['class'=>'btn btn-info','escape'=>false]
                  );
                  ?>
                  &nbsp;&nbsp;
                   <?php
                    echo $this->Html->link(
                       '<i class="glyphicon glyphicon-edit right-pad-0px"></i>',
                       ['action' => 'edit', $vendor->id],
                       ['class'=>'btn btn-warning','escape'=>false]
                      );
                 ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>

</div>
