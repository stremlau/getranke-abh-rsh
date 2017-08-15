<h1>Transaktion</h1>
<?php echo $this->Form->create('Transaction'); ?>
<div class="input-control text" data-role="input-control">
    <?php echo $this->Form->input('Transaction.amount', array('placeholder' => 'Wert', 'label' => false, 'div' => false)); ?>
</div>
<?php echo $this->Form->end('Speichern'); ?>
<?php echo $this->Html->link('Abbrechen', array('action' => 'index')); ?> 
<?php if ($id) echo $this->Html->link('Löschen', array('action' => 'delete', $id), null, "Wirklich löschen?"); ?>
