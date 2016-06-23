<?php
    $this->assign('title', "User $user->username");
    $this->Html->addCrumb('Users', '/users');
    $this->Html->addCrumb('View User', ['controller' => 'Users', 'action' => 'view',$user->id]);
?>
<div class="actions columns large-2 medium-3">
    <h3><span class="hide-for-medium-up glyphicon glyphicon-menu-hamburger right-pad-5px"></span><?= __('Actions') ?></h3>
    <ul class="side-nav">

        <li><?= $this->Html->link(
           $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-pencil right-pad-5px')).$this->Html->tag('span', __('Edit User')),
           ['controller' => 'Users', 'action' => 'edit',$user->id],
           array('escape'=>false)) ?>
        </li>

        <li>
        <?php
        echo $this->Form->postLink(
           $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove right-pad-5px')). __('Delete User'),
                array('action' => 'delete', $user->id),
                array('escape'=>false, 'confirm'=>__('Are you sure you want to delete user {0}?', $user->username))
           );
        ?>
       </li>


    </ul>
</div>
    <div class="users view large-10 medium-9 columns">
        <h2 class="bold move-right-5px"><?= h($user->fullName) ?></h2>
        <div class="row">
            <div class="large-7 columns">

                    <table class='table dataTable card border-blue-left'>
                        <tr>
                            <th><?= __('Username') ?></th>
                            <td><?= h($user->username) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Access Level Group') ?></th>
                            <td><?= $user->has('group') ? $this->Html->link($user->group->name, ['controller' => 'Groups', 'action' => 'view', $user->group->id]) : '' ?></td>
                         </tr>
                         <tr>
                            <th><?= __('Email') ?></th>
                            <td><?= h($user->email) ?></td>
                         </tr>

</table>
            </div>
          </div>
          <div class="row">
            <div class="large-7 columns end">
                                 <table class='table dataTable card border-blue-left'>
                                     <tr>
                                       <th> <?= __('Created') ?> </th>
                                       <th> <?= __('Modified') ?> </th>
                                    </tr>

                                    <tr><td><?= $user->created->i18nFormat('dd-MM-YYYY h:mm a') ?></td>

                                     <?php
                                          if (!empty($user->modified))
                                          {
                                              echo "<td>". $user->modified->i18nFormat('dd-MM-YYYY h:mm a')."</td>";
                                          }
                                          else
                                          {
                                              echo '<td>'. $user->created->i18nFormat('dd-MM-YYYY h:mm a'). '</td>';
                                          }
                                          ?>
                                          </tr>
                                      </table>

                               </div>
          </div>
</div>
