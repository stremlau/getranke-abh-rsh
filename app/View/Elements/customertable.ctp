<table class="table striped bordered hovered">
<tr>
<th>#</th>
<th>Name</th>
<th>Kategorie</th>
</tr>

<?php foreach($customers as $customer): ?>
    <?php if ($active == 'yes' && !$customer['Customer']['active'] || $active == 'no' && $customer['Customer']['active']) continue; ?>
    
    <tr>
    <td><?php echo $this->Html->link($customer['Customer']['id'], array('action' => 'edit', $customer['Customer']['id'])); ?></td>
    <td><?php echo $customer['Customer']['name']; ?></td>
    <td><?php echo $customer['Customer']['category']; ?></td>
    </tr>
<?php endforeach; ?>
</table>
