<h1>
    <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
    Rechnungen<small class="on-right"></small>
</h1>
<div class="tab-control" data-role="tab-control">
    <ul class="tabs">
        <li class="active"><a href="#_page_1">Unbezahlt</a></li>
        <li><a href="#_page_2">Bezahlt</a></li>
        <li><a href="#_page_3">Alle</a></li>
    </ul>
 
    <div class="frames">
        <div class="frame" id="_page_1"><?php echo $this->element('billtable', array('filter' => 'unpaid')); ?></div>
        <div class="frame" id="_page_2"><?php echo $this->element('billtable', array('filter' => 'paid')); ?></div>
        <div class="frame" id="_page_3"><?php echo $this->element('billtable', array('filter' => '')); ?></div>
    </div>
</div>
<br />
<?php echo $this->Html->link('<i class="icon-plus-2"></i> Rechnung erstellen', array('action' => 'edit'), array('escape' => false)); ?>
