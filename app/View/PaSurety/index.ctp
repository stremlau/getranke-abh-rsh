<h1>
    <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
    Anlagenverleih<small class="on-right"></small>
</h1>
<table class="table striped bordered hovered">
<tr>
<th>#</th>
<th>Kunde</th>
<th>Datum</th>
<th>Bezahlt</th>
<th>Zurückbekommen</th>
<th>Tutor</th>
</tr>

<?php foreach($pa_sureties as $pa_surety): ?>
    <?php //pr($pa_surety); ?>
    <tr>
    <td><?php echo $this->Html->link($pa_surety['PaSurety']['id'], array('action' => 'edit', $pa_surety['PaSurety']['id'])); ?></td>
    <td><?php echo $pa_surety['Customer']['name']; ?></td>
    <td><?php echo $pa_surety['PaSurety']['created']; ?></td>
    <td><?php echo $pa_surety['PaSurety']['value_paid']; ?></td>
    <td><?php echo $pa_surety['PaSurety']['value_regained']; ?></td>
    <td><?php echo $pa_surety['User']['name']; ?></td>
    </tr>
<?php endforeach; ?>
</table>

<?php echo $this->Html->link('Anlage verleihen', array('action' => 'edit')); ?>
