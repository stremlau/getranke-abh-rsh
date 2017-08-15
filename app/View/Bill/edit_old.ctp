<?php
App::uses('String', 'Utility');

$article_names = array();
$article_ids = array();
$article_prices = array();
$article_basics = array();
$article_deposits = array();
foreach($articles as $article) {
    $article_names[] = $article['Article']['name'];
    $article_ids[] = $article['Article']['id'];
    $article_prices[] = $article['Article']['price'];
    $article_basics[] = $article['Article']['basic'];
    $article_deposits[] = $article['Deposit']['price'];
}

echo $this->Html->scriptBlock(
    'var articles = ["'.implode('","', $article_names).'"];'. 
    'var articles_id = ['.implode(',', $article_ids).']; '.
    'var articles_basic = ['.implode(',', $article_basics).']; '.
    'var articles_deposit = ['.implode(',', $article_deposits).']; '.
    'var articles_price = ['.implode(',', $article_prices).'];'. 
    'var next_article_id = '.((isset($bill['Article'])) ? count($bill['Article']) : 0).';',
    array('inline' => false)
);
?>




Artikel hinzufügen:<br />
<span id="add_article_direction">&#8680;</span> <span id="add_article_amount">0</span> x  
<input type="text" autofocus id="add_article" size="3" /><span id="add_article_ac"></span>
<br />
<input type="checkbox" id="basic" checked="checked" /> Nur Grundstock
<br />
<br />
<?php echo $this->Form->create('Bill'); ?>
<?php for($i = 0; $i < 2; $i++): ?>
<div class="article_box">
    <h2><?php echo ($i == 0) ? 'Rückgabe' : 'Einkauf'; ?></h2>
    <table id="articles_<?php echo ($i == 0) ? 'in' : 'out'; ?>">
    <tbody>
    <tr>
        <th>Anzahl</th>
        <th>Artikel</th>
        <th>Pfand</th>
        <th>Einzelpreis</th>
        <th>Gesamtpreis</th>
    </tr>

    <?php
    $total = 0;

    if (isset($bill['Article']))
    foreach($bill['Article'] as $index => $article) {
        if (($i == 0) == ($article['ArticlesBill']['amount'] > 0)) continue;
        $deposit = (isset($article['Deposit']['price'])) ? $article['Deposit']['price'] : 0.00;
        
        $sum = ($article['price']+$deposit)*$article['ArticlesBill']['amount'];
        $total += $sum;

        echo '<tr>';
        
        //pr($article);

        echo $this->Form->input('Article.'.$index.'.ArticlesBill.article_id', array(
            'type' => 'hidden',
            'value' => $article['id']
        ));
        
        echo '<td>'.$this->Form->input('Article.'.$index.'.ArticlesBill.amount', array(
            'type' => 'number',
            'value' => $article['ArticlesBill']['amount'],
            'div' => false,
            'label' => false,
            'class' => 'amounts'
        )).'</td>';
        
        echo '<td>'.$article['name'].'</td>';
        echo '<td style="text-align: right;">'.sprintf("%.2f", $deposit).' &euro;</td>';
        echo '<td style="text-align: right;">'.sprintf("%.2f", $article['price']).' &euro;</td>';
        echo '<td style="text-align: right;" class="sum">'.sprintf("%.2f", $sum).' &euro;</td>';
        echo '</tr>';
    }
    ?>
    </tbody>
    </table>
    <div class="total">Gesamt: <?php echo $total; ?> &euro;</div>
</div>
<?php endfor; ?>
Rechnung ist gezahlt <?php echo $this->Form->checkbox('Bill.paid'); ?>
<?php echo $this->Form->text('paid_date', array('type' => 'date')); ?>

<?php echo $this->Form->input('Bill.customer_id', array('label' => 'Kunde')); ?>
<?php echo $this->Form->input('Bill.user_id', array('label' => 'Verkäufer')); ?>

<?php echo $this->Form->input('created', array(
    'label' => 'Erstellt',
    'dateFormat' => 'DMY',
    'minYear' => date('Y') - 2,
    'maxYear' => date('Y') +2,
)); ?>

<?php echo $this->Form->end('Speichern'); ?>
<?php echo $this->Html->link('Abbrechen', array('action' => 'index')); ?>
<?php echo $this->Html->script('bill'); ?>
