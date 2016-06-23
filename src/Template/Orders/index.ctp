<?php
    $this->assign('title', "ALL ORDERS");
    $this->Html->addCrumb('Orders', '/orders');
?>
    <script>
        $(document).ready(function(){
            $('#ordTable').DataTable({
                "columnDefs": [ { "targets": 3, "orderable": false } ]
            });
        });
    </script>



<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">
                    <li><?= $this->Html->link(
                                 $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-list-alt right-pad-5px')).$this->Html->tag('span', __('Go To Customers')),
                                 ['controller'=>'Customers','action' => 'index'],
                                 array('escape'=>false)) ?>
                                </li>



               </ul>
    </ul>
</div>
<div class="customers index large-10 medium-9 columns">
    <table id="ordTable" class="table card responsive nowrap" cellpadding="0">

    <thead>
        <tr>
            <th><?= h('Order #') ?></th>
            <th><?= h('Customer') ?></th>
            <th class="min-desktop"><?= h('Status') ?></th>
            <th class="min-tablet-p"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= h($order->id) ?></td>
            <td>
                <?= $order->has('customer') ? $this->Html->link($order->customer->fullName,
                ['controller' => 'Customers', 'action' => 'view', $order->customer->id],
                ['class'=>'orderLink']) : '' ?>
                <span class="show-for-medium-up">
                <?= $order->has('customer') ? $this->Html->link('+ Order ',
                 ['controller' => 'Orders', 'action' => 'add', $order->customer->id],
                 ['class'=>'btn-xs btn-info']) : '' ?>
               </span>
            </td>
            <td><?= $order->orderstatus->name ?></td>
            <td class="actions">
                <?php
                                echo $this->Html->link(
                                     '<i class="glyphicon glyphicon-search no-padd-right"></i>',
                                     ['action' => 'view', $order->id],
                                     ['class'=>'btn btn-info','escape'=>false]
                                    );
                                ?>&nbsp;
                                 <?php
                                echo $this->Html->link(
                                     '<i class="glyphicon glyphicon-edit no-padd-right"></i>',
                                     ['action' => 'edit', $order->id],
                                     ['class'=>'btn btn-warning','escape'=>false]
                                    );
                                ?>&nbsp;
                                <?php
//                                echo '&nbsp;&nbsp;<button class="btn btn-primary" data-toggle="modal" data-target="#printOrderModal">
//                                        <i class="glyphicon glyphicon-print no-padd-right"></i></button>';
                                echo $this->Html->link(
                                    '<i class="glyphicon glyphicon-print no-padd-right"></i>',
                                    ['action' => 'printorder', $order->id],
                                    ['class'=>'btn btn-primary','escape'=>false]
                                    );

                                ?>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>

</div>
