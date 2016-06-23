<?php
    $this->assign('title', "All Anniversary Types");
    $this->Html->addCrumb('Anniversary Types', ['controller' => 'Anniversarytypes', 'action' => 'index']);
?>
<script>
        $(document).ready(function(){
            $('#anTypeTable').DataTable({
                 "bSort" : false,
                "bPaginate": false,
                "bFilter": false
            });
        });
    </script>
<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">


             <li>
                 <?= $this->Html->link(
                       $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-plus-sign right-pad-5px')).$this->Html->tag('span', __('Add Anniversary Type')),
                       ['action' => 'add'],
                       array('escape'=>false)) ?>
             </li>
    </ul>
</div>
<div class="users index large-10 medium-9 columns">
    <table id="anTypeTable" class="table card dataTable no-footer" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('type') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($anniversarytypes as $anniversarytype): ?>
        <tr>
            <td><?= h($anniversarytype->type) ?></td>

            <td class="actions tab-col-actions">

                <?php
                echo $this->Html->link(
                '<i class="glyphicon glyphicon-edit right-pad-5px"></i>Edit',
                 ['action' => 'edit', $anniversarytype->id],
                  ['class'=>'btn btn-warning','escape'=>false]
                 );
                 ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>

</div>
