<script>
if (popup) {
    popup.setCustomer('<?php echo $customer_name; ?>');
    popup.setUnpaidBills([<?php 
        foreach($unpaid_bills as $bill)
            echo '{id: '.$bill['Bill']['id'].', total: \''.sprintf("%.2f", $bill['Bill']['total']).'\', date: \''.$this->Time->format($bill['Bill']['created'], '%d.%m.%Y').'\', user: \''.$bill['User']['name'].'\'}, '; 
    ?>null]);
}
</script>
<h1>
    <a href="<?php echo $this->Html->Url(array('action' => 'customers')); ?>"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
    Offene Rechnungen<small class="place-right"><a href="<?php echo $this->Html->Url(array('action' => 'edit', 'customer' => $customer_id)); ?>">neue Rechnung <i class="icon-arrow-right-3 fg-darker"></i></a></small>
</h1>
<br />
<div class="balloon bottom">
    <div class="padding10 text-warning">Für den gewählten Kunden existier<?php echo (count($unpaid_bills) == 1) ? 't noch eine' : 'en noch '.count($unpaid_bills); ?> unbezahlte Rechnung<?php echo (count($unpaid_bills) != 1) ? 'en' : ''; ?>.</div>
</div>

<div class="listview fluent">
<?php foreach($unpaid_bills as $bill): ?>
    <a href="#" class="list unpaid-bill" data-id="<?php echo $bill['Bill']['id']; ?>" data-total="<?php echo $bill['Bill']['total']; ?>">
        <div class="list-content">
            <i class="icon-clipboard-2 fg-olive icon"></i>
            <div class="data">
                <span class="list-title"><?php echo $this->Time->format($bill['Bill']['created'], '%d.%m.%Y'); ?></span>
                <span class="list-subtitle fg-cobalt"><?php echo sprintf("%.2f", $bill['Bill']['total']); ?> &euro;</span>
                <span class="list-remark"><?php echo $bill['User']['name']; ?></span>
            </div>
        </div>
    </a>
<?php endforeach; ?>
<span class="clearfix"></span>
</div>
<br />
<button disabled class="button large" id="view_unpaid_bills">Ansehen</button>
<button disabled class="button large" id="edit_unpaid_bills">Bearbeiten</button>
<br />
<small id="unpaid_bills_total"></small>
