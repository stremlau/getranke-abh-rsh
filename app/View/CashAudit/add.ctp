<h1>Kassenprüfung</h1>

<div class="grid">
    <div class="row">
        <div class="span6">
Bezahlte Rechnungen: <?php echo $debit_bills; ?><br />
Transaktionen: <?php echo $debit_transactions; ?><br />
Anlagenverleih: <?php echo $debit_pa_sureties; ?><br />
(Unbezahlte Rechnungen: <?php echo $unpaid_bills; ?>)<br />       
        </div>
        <div class="span3 money_table">
            <input type="number" data-value="500" value="0" /> x 500€<br />
            <input type="number" data-value="200" value="0" /> x 200€<br />
            <input type="number" data-value="100" autofocus /> x 100€<br />
            <input type="number" data-value="50" /> x 50€<br />
            <input type="number" data-value="20" /> x 20€<br />
            <input type="number" data-value="10" /> x 10€<br />
            <input type="number" data-value="5" /> x 5€
        </div>
        <div class="span3 money_table">
            <input type="number" data-value="2" /> x 2€<br />
            <input type="number" data-value="1" /> x 1€<br />
            <input type="number" data-value="0.5" /> x 0,5€<br />
            <input type="number" data-value="0.2" /> x 0,2€<br />
            <input type="number" data-value="0.1" /> x 0,1€<br />
            <input type="number" data-value="0.05" /> x 0,05€<br />
            <input type="number" data-value="0.02" /> x 0,02€<br />
            <input type="number" data-value="0.01" /> x 0,01€
        </div>
        
    </div>
    <div class="row">
        <div class="span6">
        <strong>SOLL: <span id="debit_total"><?php echo $debit_total; ?></span> &euro;</strong>
        </div>
        <div class="span6">
        <strong>IST: <span style="font-weight: bold;" id="credit_total">0</span> &euro;</strong>
        </div>
    </div>
</div>
<br />
<div id="difference">Differenz: <span id="debit_difference">-<?php echo $debit_total; ?></span> &euro;</div>
<br />
<?php echo $this->Form->create('CashAudit'); ?>
<?php echo $this->Form->hidden('CashAudit.credit', array('id' => 'credit_input', 'default' => 0, 'label' => false, 'div' => false)); ?>
<?php echo $this->Form->end('Speichern'); ?>
<?php echo $this->Html->link('Abbrechen', array('action' => 'index')); ?> 
