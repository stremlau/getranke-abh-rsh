<h1>Tutor bearbeiten</h1>

<?php echo $this->Form->create('User'); ?>

<div class="input-control text" data-role="input-control">
    <?php echo $this->Form->input('name', array('placeholder' => 'Name', 'label' => false, 'div' => false)); ?>
</div>
<div class="input-control text" data-role="input-control">
    <?php echo $this->Form->input('room', array('placeholder' => 'Zimmer', 'label' => false, 'div' => false)); ?>
</div>
<div class="input-control switch" data-role="input-control">
    <label>
        Aktiv
        <?php echo $this->Form->checkbox('active', array('label' => 'aktiv')); ?>&nbsp;
        <span class="check"></span>
    </label>
</div>

<?php echo $this->Form->end('Speichern'); ?>
<?php echo $this->Html->link('Abbrechen', array('action' => 'index')); ?>
