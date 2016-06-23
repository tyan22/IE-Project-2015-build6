<?php
    $this->assign('title', "ALL GROUPS");
    $this->Html->addCrumb('Groups', '/groups');

?>
    <script>
        $(document).ready(function(){
            $('#groupTable').DataTable({
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
                      $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-plus-sign right-pad-5px')).$this->Html->tag('span', __('Add Group')),
                      ['action' => 'add'],
                      array('escape'=>false)) ?>
            </li>
    </ul>
</div>
<div class="users index large-10 medium-9 columns">
    <table id="groupTable" class="table card dataTable no-footer" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('name') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($groups as $group): ?>
        <tr>
            <td><?= h($group->name) ?></td>

            <td class="actions tab-col-actions">
<?php
                echo $this->Html->link(
                     '<i class="glyphicon glyphicon-search right-pad-5px"></i>View',
                     ['action' => 'view', $group->id],
                     ['class'=>'btn btn-info','escape'=>false]
                    );
                ?>&nbsp;&nbsp;
                 <?php
                echo $this->Html->link(
                     '<i class="glyphicon glyphicon-edit right-pad-5px"></i>Edit',
                     ['action' => 'edit', $group->id],
                     ['class'=>'btn btn-warning','escape'=>false]
                    );
 ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>

</div>
