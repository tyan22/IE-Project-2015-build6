<?php
    $this->assign('title', "ALL USERS");
    $this->Html->addCrumb('Users', '/users');
?>

    <script>
        $(document).ready(function(){
            $('#userTable').DataTable({
                "columnDefs": [ { "targets": 4, "orderable": false } ]
            });
        });
    </script>

<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">

            <li>
                <?= $this->Html->link(
                      $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-plus-sign right-pad-5px')).$this->Html->tag('span', __('Add User')),
                      ['action' => 'add'],
                      array('escape'=>false)) ?>
            </li>
       </ul>
</div>
<div class="users index large-10 medium-9 columns">
    <table id="userTable" class="table card dataTable no-footer responsive" cellspacing="0">
    <thead>
        <tr>
            <th>Username</th>
            <th class="min-desktop">First Name</th>
            <th class="min-tablet-l">Surname</th>
            <th class="min-tablet">Access Level</th>
            <th class="actions tab-col-actions "><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= h($user->username) ?></td>
            <td><?= h($user->firstname) ?></td>
            <td><?= h($user->surname) ?></td>
            <td>
                <?= $user->has('group') ? $this->Html->link($user->group->name, ['controller' => 'Groups', 'action' => 'view', $user->group->id]) : '' ?>
            </td>
            <td class="actions tab-col-actions">
              <?php
                              echo $this->Html->link(
                              '<i class="glyphicon glyphicon-search right-pad-5px"></i>',
                                   ['action' => 'view', $user->id],
                                   ['class'=>'btn btn-info','escape'=>false]
                                  );
                              ?>&nbsp;&nbsp;
                               <?php
                              echo $this->Html->link(
                                   '<i class="glyphicon glyphicon-edit right-pad-5px"></i>',
                                   ['action' => 'edit', $user->id],
                                   ['class'=>'btn btn-warning','escape'=>false]
                                  );
               ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>

</div>
