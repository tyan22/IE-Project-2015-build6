<?php
    $this->assign('title', "ALL PROMOTIONS");
    $this->Html->addCrumb('Promotions', '/promotions');
?>
<script>
    $(document).ready(function(){
        $('#promoTable').DataTable({
          "columnDefs": [ { "targets": 4, "orderable": false } ]
        });
    });
</script>
<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
      <li>
          <?= $this->Html->link(
                $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-plus-sign right-pad-5px')).$this->Html->tag('span', __('New Promotion')),
                ['action' => 'add'],
                array('escape'=>false)) ?>
      </li>    </ul>
</div>
<div class="promotions index large-10 medium-9 columns">
    <table id="promoTable" class="table card responsive nowrap" cellpadding="0">
    <thead>
        <tr>
            <th><?= h(__('Start Date')) ?></th>
            <th class="min-desktop"><?= h(__('End Date')) ?></th>
            <th class="min-desktop"><?= h(__('Customer Group')) ?></th>
            <th class="min-tablet"><?= h(__('Mailed Out')) ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($promotions as $promotion): ?>
        <tr>
            <td><?= $this->Format->formatDate($promotion->start_date) ?></td>
            <td><?= $this->Format->formatDate($promotion->end_date) ?></td>
            <td><?= h($promotion->cust_group) ?></td>


            <td><?php if (!$promotion->mail_out_completed){
              echo $this->Html->tag('i', '', ['class' => 'glyphicon glyphicon-remove','style'=>'color:#dd5555;font-size:40px']);
            }
            else {
              echo $this->Html->tag('i', '', ['class' => 'glyphicon glyphicon-ok','style'=>'color:#119911;font-size:40px']);
            }
           ?></td>
            <td class="actions">
              &nbsp;&nbsp;
               <?php
              echo $this->Html->link(
                   '<i class="glyphicon glyphicon-search right-pad-0px"></i>',
                   ['action' => 'mailout', $promotion->id],
                   ['class'=>'btn btn-info','escape'=>false]
                 );
                 echo "&nbsp;&nbsp;";
                  echo $this->Html->link(
                       '<i class="glyphicon glyphicon-edit right-pad-0px"></i>',
                       ['action' => 'edit', $promotion->id],
                       ['class'=>'btn btn-warning','escape'=>false]
                      );
                ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>

</div>
