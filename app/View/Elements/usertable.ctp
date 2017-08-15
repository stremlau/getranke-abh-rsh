<table class="table striped bordered hovered">
<tr>
<th>#</th>
<th>Name</th>
<th>Zimmer</th>
</tr>

<?php foreach($users as $user): ?>
    <?php if ($active == 'yes' && !$user['User']['active'] || $active == 'no' && $user['User']['active']) continue; ?>
    
    <tr>
    <td><?php echo $this->Html->link($user['User']['id'], array('action' => 'edit', $user['User']['id'])); ?></td>
    <td><?php echo $user['User']['name']; ?></td>
    <td><?php echo $user['User']['room']; ?></td>
    </tr>
<?php endforeach; ?>
</table>
