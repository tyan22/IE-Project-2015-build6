<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $stash->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $stash->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Stashes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="stashes form large-10 medium-9 columns">
    <?= $this->Form->create($stash); ?>
    <fieldset>
        <legend><?= __('Edit Stash') ?></legend>
        <?php
            echo $this->Form->input('order_id', ['options' => $orders]);
            echo $this->Form->input('filename');
            echo $this->Form->input('uploaded');
            echo $this->Form->input('visible');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
