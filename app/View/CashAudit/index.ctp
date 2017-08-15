<h1>
    <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
    Kassenprüfungen<small class="on-right"></small>
</h1>
<table class="table striped bordered hovered">
<tr>
<th>#</th>
<th>Datum</th>
<th>Soll</th>
<th>Haben</th>
<th>Differenz</th>
<th>Tutor</th>
</tr>

<?php foreach($cash_audits as $cash_audit): ?>
    <?php //pr($cash_audit); ?>
    <tr>
    <td><?php echo $cash_audit['CashAudit']['id']; ?></td>
    <td><?php echo $cash_audit['CashAudit']['created']; ?></td>
    <td><?php echo $cash_audit['CashAudit']['debit']; ?></td>
    <td><?php echo $cash_audit['CashAudit']['credit']; ?></td>
    <td><?php echo round($cash_audit['CashAudit']['credit'] - $cash_audit['CashAudit']['debit'], 2); ?></td>
    <td><?php echo $cash_audit['User']['name']; ?></td>
    </tr>
<?php endforeach; ?>
</table>

<?php echo $this->Html->link('Prüfung durchführen', array('action' => 'add')); ?>
