<h1>
    <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
    Tutoren<small class="on-right"></small>
</h1>
<div class="tab-control" data-role="tab-control">
    <ul class="tabs">
        <li class="active"><a href="#_active">Aktiv</a></li>
        <li><a href="#_inactive">Inaktiv</a></li>
    </ul>
 
    <div class="frames">
        <div class="frame" id="_active"><?php echo $this->element('usertable', array('active' => 'yes')); ?></div>
        <div class="frame" id="_inactive"><?php echo $this->element('usertable', array('active' => 'no')); ?></div>
    </div>
</div>

<?php echo $this->Html->link('<i class="icon-plus-2"></i> Tutor anlegen', array('action' => 'edit'), array('escape' => false)); ?>
