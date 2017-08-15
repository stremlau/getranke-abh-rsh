<h1>
    <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
    Transaktionen<small class="on-right"></small>
</h1>
<table class="table striped bordered hovered">
<tr>
<th>#</th>
<th>Datum</th>
<th>Wert in &euro;</th>
<th>Tutor</th>
</tr>

<?php foreach($transactions as $transaction): ?>
    <?php //pr($transaction); ?>
    <tr>
    <td><?php echo $this->Html->link($transaction['Transaction']['id'], array('action' => 'edit', $transaction['Transaction']['id'])); ?></td>
    <td><?php echo $transaction['Transaction']['created']; ?></td>
    <td><?php echo $transaction['Transaction']['amount']; ?></td>
    <td><?php echo $transaction['User']['name']; ?></td>
    </tr>
<?php endforeach; ?>
</table>

<?php echo $this->Html->link('Transaktion tätigen', array('action' => 'edit')); ?>
