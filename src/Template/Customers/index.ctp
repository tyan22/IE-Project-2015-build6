<?php
    $this->assign('title', "All Customers");
    $this->Html->addCrumb('Customers', '/customers');
?>

    <script>
        $(document).ready(function(){
            $('#custTable').DataTable({
                responsive:true,
                "columnDefs": [ { "targets": 3, "orderable": false } ]
            });
        });
    </script>



<div class="actions columns large-2 medium-3">

    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">


            <li>
                <?= $this->Html->link(
                      $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-plus-sign right-pad-5px')).$this->Html->tag('span', __('Add Customer')),
                      ['action' => 'add'],
                      array('escape'=>false)) ?>
            </li>
    </ul>
</div>
<div class="customers index large-10 medium-9 columns">
    <table id="custTable" class="table card responsive" cellpadding="0">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Surname</th>
            <th class="min-desktop">Phone</th>
            <th class="min-desktop">Email</th>
            <th class="actions tab-col-actions "><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($customers as $customer): ?>
        <tr>
            <td><?= h($customer->firstname) ?></td>
            <td><?= h($customer->surname) ?></td>
            <td><?= h($customer->phone) ?></td>
            <td><?= h($customer->email) ?></td>
            <td class="actions tab-col-actions">

                <?php
                echo $this->Html->link(
                '<i class="glyphicon glyphicon-search right-pad-0px"></i>',
                     ['action' => 'view', $customer->id],
                     ['class'=>'btn btn-info','escape'=>false]
                    );
                ?>&nbsp;&nbsp;
                 <?php
                echo $this->Html->link(
                     '<i class="glyphicon glyphicon-edit right-pad-0px"></i>',
                     ['action' => 'edit', $customer->id],
                     ['class'=>'btn btn-warning','escape'=>false]
                    );
 ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>

</div>
