<?php
$sum_out = 0;
$articles_out = array();
foreach($articles_bills_out as $articles_bill) {
    $sum_article = $articles_bill['Article']['price'] + ((isset($articles_bill['Article']['Deposit']['price'])) ? $articles_bill['Article']['Deposit']['price'] : 0);
    $sum_out += $articles_bill['ArticlesBill']['amount'] * $sum_article;

    if (isset($articles_out[$articles_bill['Article']['id']])) {
        $articles_out[$articles_bill['Article']['id']]['amount_'.$articles_bill['ArticlesBill']['bill_id']] = $articles_bill['ArticlesBill']['amount'];
        $articles_out[$articles_bill['Article']['id']]['sum'] += $sum_article * $articles_bill['ArticlesBill']['amount'];
    }
    else {
        $articles_out[$articles_bill['Article']['id']] = array(
            'name' => $articles_bill['Article']['name'],
            'price' => $articles_bill['Article']['price'],
            'deposit' => ((isset($articles_bill['Article']['Deposit']['price'])) ? $articles_bill['Article']['Deposit']['price'] : 0),
            'sum' => $sum_article * $articles_bill['ArticlesBill']['amount'],
            'amount_'.$articles_bill['ArticlesBill']['bill_id'] => $articles_bill['ArticlesBill']['amount']
        );
    }
}

$sum_in = 0;
$articles_in = array();
foreach($articles_bills_in as $articles_bill) {
    $sum_article = $articles_bill['Article']['price'] + ((isset($articles_bill['Article']['Deposit']['price'])) ? $articles_bill['Article']['Deposit']['price'] : 0);
    $sum_in += $articles_bill['ArticlesBill']['amount'] * $sum_article;

    if (isset($articles_in[$articles_bill['Article']['id']])) {
        $articles_in[$articles_bill['Article']['id']]['amount_'.$articles_bill['ArticlesBill']['bill_id']] = $articles_bill['ArticlesBill']['amount'] * -1;
        $articles_in[$articles_bill['Article']['id']]['sum'] += $sum_article * $articles_bill['ArticlesBill']['amount'];
    }
    else {
        $articles_in[$articles_bill['Article']['id']] = array(
            'name' => $articles_bill['Article']['name'],
            'price' => $articles_bill['Article']['price'],
            'deposit' => ((isset($articles_bill['Article']['Deposit']['price'])) ? $articles_bill['Article']['Deposit']['price'] : 0),
            'sum' => $sum_article * $articles_bill['ArticlesBill']['amount'],
            'amount_'.$articles_bill['ArticlesBill']['bill_id'] => $articles_bill['ArticlesBill']['amount'] * -1
        );
    }
}

//pr($bills);
if ($print) echo '<script>printPage('.$print.');</script>';

?>

<?php
if ($bills[0]['Bill']['paid'] == 1) {
    echo $this->Form->postLink(
        'Unbezahlen',
        array(implode('-', $bill_ids), 'unpay' => true),
        array('class' => 'button large')
    ).' ';
    echo $this->Form->postLink(
        'Drucken',
        array(implode('-', $bill_ids), 'print' => true),
        array('class' => 'button large')
    );
}
else {
    echo $this->Form->postLink(
        'Bezahlen',
        array(implode('-', $bill_ids), 'pay' => true),
        array('class' => 'button large')
    ).' ';
    echo $this->Form->postLink(
        'Bezahlen und 2x drucken',
        array(implode('-', $bill_ids), 'pay' => true, 'print' => 2),
        array('class' => 'button large')
    );
}
?> 
<a class="button large" id="print_offer">Als Angebot drucken</a>

<h1 class="noprint">Rechnung(en)</h1>

<?php echo $this->Html->image('beabar.png', array('alt' => 'BeaBar', 'class' => 'print')); ?>

<h1 class="print bill_offer_s">Getränkerechnung</h1>

<?php foreach($bills as $id => $bill) {
    echo '<p><span class="bill_offer">Rechnung</span> <strong>'.chr(65 + $id).'</strong> ('.$bill['Bill']['id'].') vom '.$this->Time->format($bill['Bill']['created'], '%d.%m.%Y').': <strong>'.sprintf("%.2f", $bill['Bill']['total']).'</strong> &euro;</p>';
}
?>
<p>&nbsp;</p>
<h2>Rückgabe:</h2>
<table class="table striped bordered hovered">
    <tr>
        <?php foreach($bills as $id => $bill) echo '<th>'.chr(65 + $id).'</th>'; ?>
        <th>Artikelname</th>
        <th class="text-right">Preis</th>
        <th class="text-right">Pfand</th>
        <th class="text-right">Gesamt</th>
<?php foreach($articles_in as $article): ?>
    <tr>
        <?php foreach ($bills as $id => $bill) echo '<td>'.((isset($article['amount_'.$bill['Bill']['id']])) ? $article['amount_'.$bill['Bill']['id']] : 0).'</td>'; ?>
        <td><?php echo $article['name']; ?></td>
        <td class="text-right"><?php echo sprintf("%.2f", $article['price']); ?> &euro;</td>
        <td class="text-right"><?php echo sprintf("%.2f", $article['deposit']); ?> &euro;</td>
        <td class="text-right"><?php echo sprintf("%.2f", $article['sum']); ?> &euro;</td>
    </tr>
<?php endforeach; ?>
</table>
<p class="sum"><?php echo sprintf("%.2f", $sum_in); ?> &euro;</p>

<h2>Einkauf:</h2>
<table class="table striped bordered hovered">
    <tr>
        <?php foreach($bills as $id => $bill) echo '<th>'.chr(65 + $id).'</th>'; ?>
        <th>Artikelname</th>
        <th class="text-right">Preis</th>
        <th class="text-right">Pfand</th>
        <th class="text-right">Gesamt</th>
<?php foreach($articles_out as $article): ?>
    <tr>
        <?php foreach ($bills as $id => $bill) echo '<td>'.((isset($article['amount_'.$bill['Bill']['id']])) ? $article['amount_'.$bill['Bill']['id']] : 0).'</td>'; ?>
        <td><?php echo $article['name']; ?></td>
        <td class="text-right"><?php echo sprintf("%.2f", $article['price']); ?> &euro;</td>
        <td class="text-right"><?php echo sprintf("%.2f", $article['deposit']); ?> &euro;</td>
        <td class="text-right"><?php echo sprintf("%.2f", $article['sum']); ?> &euro;</td>
    </tr>
<?php endforeach; ?>
</table>
<p class="sum"><?php echo sprintf("%.2f", $sum_out); ?> &euro;</p>
<p class="sumsum"><?php echo sprintf("%.2f", $sum_out + $sum_in); ?> &euro;</p>
<p class="print">&nbsp;</p>
<p class="print bill_offer_payed">Der Rechnungsbetrag wurde am <?php echo $this->Time->format(time(), '%d.%m.%Y'); ?> vollständig bezahlt.</p>

<div class="signature print"><p><?php echo $bills[0]['Customer']['name']; ?></p></div>
<div class="signature print"><p>Getränketutor</p></div>
