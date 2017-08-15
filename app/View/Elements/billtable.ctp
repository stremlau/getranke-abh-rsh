<table class="table striped bordered hovered">
<tr>
<th>#</th>
<th>Kunde</th>
<th>Summe</th>
<th>Erstellt</th>
<th>Bezahlt</th>
<th>Tutor</th>
</tr>
<?php foreach($bills as $bill): ?>
    <?php if ($filter == 'paid' && !$bill['Bill']['paid'] || $filter == 'unpaid' && $bill['Bill']['paid']) continue; ?>
    
    <tr<?php if (!$bill['Bill']['paid'] && $filter == '') echo ' class="text-warning'; ?>">
    <td><?php echo $this->Html->link($bill['Bill']['id'], array('action' => 'view', $bill['Bill']['id'])); ?></td>
    <td><?php echo $bill['Customer']['name']; ?></td>
    <td><?php echo $bill['Bill']['total']; ?></td>
    <td><?php echo $bill['Bill']['created']; ?></td>
    <td><?php echo ($bill['Bill']['paid']) ? $bill['Bill']['paid_date'] : 'nein'; ?></td>
    <td><?php echo $bill['User']['name']; ?></td>
    </tr>
<?php endforeach; ?>
</table>
