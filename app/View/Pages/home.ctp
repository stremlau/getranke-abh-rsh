<script>
if (popup) {
    popup.clearScreen();
}
</script>

<div>&nbsp;</div>

<div class="tile-group three">
<a class="tile double bg-lime" href="<?php echo $this->Html->Url(array('controller' => 'bill')); ?>">
    <div class="tile-content icon">
        <i class="icon-clipboard"></i>
    </div>
    <div class="tile-status">
        <span class="name">Rechnungen</span>
    </div>
    <?php if ($unpaid_bill_count > 0): ?>
    <div class="brand">
        <div class="badge bg-orange"><?php echo $unpaid_bill_count; ?></div>
    </div>
    <?php endif; ?>
</a>

<a class="tile bg-amber" href="<?php echo $this->Html->Url(array('controller' => 'customer')); ?>">
    <div class="tile-content icon">
        <i class="icon-user"></i>
    </div>
    <div class="tile-status">
        <span class="name">Kunden</span>
    </div>
</a>

<a class="tile bg-indigo" href="<?php echo $this->Html->Url(array('controller' => 'transaction')); ?>">
    <div class="tile-content icon">
        <i class="icon-globe"></i>
    </div>
    <div class="tile-status">
        <span class="name">Transaktionen</span>
    </div>
</a>

<a class="tile bg-olive" href="<?php echo $this->Html->Url(array('controller' => 'cash_audit')); ?>">
    <div class="tile-content icon">
        <i class="icon-stats-up"></i>
    </div>
    <div class="tile-status">
        <span class="name">Kassenprüfung</span>
    </div>
</a>

<a class="tile bg-magenta" href="<?php echo $this->Html->Url(array('controller' => 'pa_surety')); ?>">
    <div class="tile-content icon">
        <i class="icon-equalizer"></i>
    </div>
    <div class="tile-status">
        <span class="name">Anlagenverleih</span>
    </div>
</a>



</div>
<div class="tile-group one">
<a class="tile bg-teal" href="<?php echo $this->Html->Url(array('controller' => 'article')); ?>">
    <div class="tile-content icon">
        <i class="icon-list"></i>
    </div>
    <div class="tile-status">
        <span class="name">Artikelliste</span>
    </div>
</a>

<a class="tile bg-cyan" href="<?php echo $this->Html->Url(array('controller' => 'user')); ?>">
    <div class="tile-content icon">
        <i class="icon-user-3"></i>
    </div>
    <div class="tile-status">
        <span class="name">Tutoren</span>
    </div>
</a>
</div>
<div class="tile-group one">
<a class="tile bg-emerald" href="<?php echo $this->Html->Url(array('controller' => 'bill', 'action' => 'customers')); ?>">
    <div class="tile-content icon">
        <i class="icon-arrow-right-3"></i>
    </div>
    <div class="tile-status">
        <span class="name">Wizard</span>
    </div>
</a>
<a class="tile bg-magenta" href="<?php echo $this->Html->Url(array('controller' => 'statistic')); ?>">
    <div class="tile-content icon">
        <i class="icon-stats-up"></i>
    </div>
    <div class="tile-status">
        <span class="name">Statistiken</span>
    </div>
</a>
</div>

