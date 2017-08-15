<h1>Artikel bearbeiten</h1>
<?php echo $this->Form->create('Article'); ?>

<label>Artikelname</label>
<div class="input-control text" data-role="input-control">
    <?php echo $this->Form->input('Article.name', array('placeholder' => 'Name', 'label' => false, 'div' => false)); ?>
</div>
<div class="grid">
    <div class="row">

        <div class="span6">
            <label>Verkaufspreis</label>
            <div class="input-control text" data-role="input-control">

                <?php echo $this->Form->input('Article.price', array('placeholder' => 'Preis', 'label' => false, 'div' => false)); ?>
            </div>
        </div>

        <div class="span6">
            <label>Einkaufspreis</label>
            <div class="input-control text" data-role="input-control">

                <?php echo $this->Form->input('Article.p_price', array('placeholder' => 'Einkaufspreis', 'label' => false, 'div' => false)); ?>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="span6">
            <?php echo $this->Form->input('Article.deposit_id', array(
                'label' => 'Pfand',
                'empty' => 'ist Pfand',
                'div' => array(
                    'class' => 'input-control select',
                )
            )); ?>
        </div>
        <div class="span6">
            <?php echo $this->Form->input('Article.category_id', array(
                'label' => 'Kategorie',
                'empty' => false,
                'div' => array(
                    'class' => 'input-control select',
                )
            )); ?>
        </div>

    </div>
</div>

<div class="element place-right">
    <?php if ($id) echo $this->Form->submit('Rückwirkend speichern', array('div' => false, 'name' => 'overwrite')); ?>
    <?php if ($id) echo $this->Html->link('Löschen', array('action' => 'delete', $id), array('class' => 'button nounloadask'), "Wirklich löschen?"); ?>
</div>

<?php echo $this->Form->end('Speichern'); ?>
<?php echo $this->Html->link('Abbrechen', array('action' => 'index')); ?>
