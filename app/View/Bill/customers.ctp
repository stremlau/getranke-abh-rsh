<script>
if (popup) {
    popup.clearScreen();
}
</script>
<h1>
    <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
    Kunde auswählen<small class="on-right"></small>
</h1>
<?php
$category_name = array('floor' => 'Stockwerk', 'tutorage' => 'Tutorat', 'private' => 'Privat');
$category = 'first';
foreach($customers as $customer): 
if ($customer['Customer']['category'] != $category) {
    if ($category != 'first') echo '</div>';
    $category = $customer['Customer']['category'];
    echo '<div class="tile-group seven customer"><div class="tile-group-title fg-red">'.$category_name[$category].'</div>';
}
?>
<a href="<?php echo $this->Html->Url(array('action' => 'customer', $customer['Customer']['id'])); ?>" class="tile bg-amber">
    <div class="tile-status">
        <span class="name"><?php echo $customer['Customer']['name']; ?></span>
    </div><?php if ($customer['unpaid_bills'] > 0): ?>
    <div class="brand">
        <div class="badge bg-orange"><?php echo $customer['unpaid_bills']; ?></div>
    </div><?php endif; ?>
</a>
<?php endforeach; ?>
</div>
