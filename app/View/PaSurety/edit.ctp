<h1>Anlagenverleih bearbeiten</h1>
<?php echo $this->Form->create('PaSurety'); ?>
<div class="input-control text" data-role="input-control">
    <?php echo $this->Form->input('PaSurety.value_paid', array('placeholder' => 'Kaution bezahlt', 'label' => false, 'div' => false, 'default' => 50)); ?>
</div>
<div class="input-control text" data-role="input-control">
    <?php echo $this->Form->input('PaSurety.value_regained', array('placeholder' => 'Kaution zurückbekommen', 'label' => false, 'div' => false)); ?>
</div>
<?php echo $this->Form->input('PaSurety.customer_id', array(
    'label' => 'Kunde'
)); ?><br />
<?php echo $this->Form->end(array('label' => 'Speichern', 'div' => false)); ?>
<?php echo $this->Html->link('Abbrechen', array('action' => 'index'), array('class' => 'button')); ?> 
<?php if ($id) echo $this->Html->link('Löschen', array('action' => 'delete', $id), array('class' => 'button place-right'), "Wirklich löschen?"); ?>
