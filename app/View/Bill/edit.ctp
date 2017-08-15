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
<script>
if (popup) {
	popup.setCustomer('<?php echo $customer['Customer']['name']; ?>');
    popup.newBill();
}
</script>

<a class="button" id="in_out" data-state="in">Rückgabe</a>

<!-- Rechnung ist gezahlt <?php //echo $this->Form->checkbox('Bill.paid'); ?> -->
<?php //echo $this->Form->text('paid_date', array('type' => 'date')); ?>

<?php //echo $this->Form->hidden('Bill.customer_id', array('label' => 'Kunde')); ?>
<?php echo $this->Form->hidden('Bill.user_id', array('label' => 'Verkäufer', 'default' => $session_user_id)); ?>

<?php /*echo $this->Form->input('created', array(
    'label' => 'Erstellt',
    'dateFormat' => 'DMY',
    'minYear' => date('Y') - 2,
    'maxYear' => date('Y') +2,
));*/ ?>

<div class="grid">
    <div class="row">
        <div class="span9">
        
        <div class="tab-control" data-role="tab-control">
            <ul class="tabs">
                <?php
                $first = true;
                foreach($categories as $category): ?>
                <li<?php if ($first == true && !($first = false)) echo ' class="active"'; ?>><a href="#_cat_<?php echo $category['Category']['id']; ?>"><?php echo $category['Category']['name']; ?></a></li>
                <?php endforeach;  ?>
            </ul>
         
            <div class="frames">
                <?php
                $category = 'first';
                foreach($articles as $article) {
                    if ($article['Category']['id'] != $category) {
                        if ($category != 'first') echo '</div>';
                        $category = $article['Category']['id'];
                        echo '<div class="frame" id="_cat_'.$category.'">';
                    }
                    
                    echo '<div class="tile bg-darkPink article" data-id="'.$article['Article']['id'].'" data-price="'.$article['Article']['price'].'" data-deposit="'.$article['Deposit']['price'].'"><div class="tile-status"><span class="name">'.$article['Article']['name'].'</span></div></div>';
                }  echo '</div>'; ?>    
            </div>
        </div>
        
        </div>
        <div class="span3">
            <div class="listview-outlook" data-role="listview" id="article_list">
<?php echo $this->Form->create('Bill'); ?>
<?php for($i = 0; $i < 2; $i++): ?>
                <div class="list-group">
                    <a href="" class="group-title"><?php echo ($i == 0) ? 'Rückgabe' : 'Einkauf'; ?></a>
                    <div class="group-content" id="articles_<?php echo ($i == 0) ? 'in' : 'out'; ?>">

    <?php
    $total = 0;

    if (isset($bill['Article']))
    foreach($bill['Article'] as $index => $article) {
        if (($i == 0) == ($article['ArticlesBill']['amount'] > 0)) continue;
        $deposit = (isset($article['Deposit']['price'])) ? $article['Deposit']['price'] : 0.00;
        
        $sum = ($article['price']+$deposit)*$article['ArticlesBill']['amount'];
        $total += $sum;

     ?>
     <div class="list" data-article-id="<?php echo $article['id']; ?>" data-singleprice="<?php echo $article['price']+$deposit; ?>">
         <div class="list-content">
             <span class="list-title"><span class="amount"><?php echo $article['ArticlesBill']['amount']; ?></span>x <?php echo $article['name']; ?><span class="place-right fg-crimson"><span class="total"><?php echo sprintf("%.2f", $sum).'</span> &euro;'; ?></span></span>
             <span class="list-subtitle">Einzelpreis <span class="place-right"><?php echo sprintf("%.2f", $article['price']).' &euro;'; ?> <span class="fg-gray">+ <?php echo sprintf("%.2f", $deposit).'&euro;'; ?></span></span>

     <?php
        
        //pr($article);

        echo $this->Form->input('Article.'.$index.'.ArticlesBill.article_id', array(
            'type' => 'hidden',
            'value' => $article['id']
        ));
        
        echo $this->Form->input('Article.'.$index.'.ArticlesBill.amount', array(
            'type' => 'hidden',
            'value' => $article['ArticlesBill']['amount'],
            'class' => 'amount_hidden'
        ));
    ?>
             </div>
     </div>
    <?php
    }
    ?>
       </div>
    </div>
<?php endfor; ?>
            </div>
        </div>
    </div>
</div>

<?php echo $this->Form->end(array('label' => 'Speichern', 'div' => false, 'class' => 'nounloadask', 'style' => 'margin-right: 20px;')); ?> 
<?php echo $this->Html->link('Abbrechen', array('action' => 'customers'), array('class' => 'button nounloadask')); ?>
<?php if ($id) echo $this->Html->link('Löschen', array('action' => 'delete', $id), array('class' => 'button place-right nounloadask'), "Wirklich löschen?"); ?>

<div id="select_article_amount" class="clearfix" style="display: none;">
<div class="tile half bg-violet num_select"><div class="tile-content number">7</div></div>
<div class="tile half bg-violet num_select"><div class="tile-content number">8</div></div>
<div class="tile half bg-violet num_select"><div class="tile-content number">9</div></div>

<div class="tile half bg-violet num_select"><div class="tile-content number">4</div></div>
<div class="tile half bg-violet num_select"><div class="tile-content number">5</div></div>
<div class="tile half bg-violet num_select"><div class="tile-content number">6</div></div>

<div class="tile half bg-violet num_select"><div class="tile-content number">1</div></div>
<div class="tile half bg-violet num_select"><div class="tile-content number">2</div></div>
<div class="tile half bg-violet num_select"><div class="tile-content number">3</div></div>

<div class="tile half bg-pink" id="sub_ten"><div class="tile-content number">-10</div></div>
<div class="tile half bg-violet num_select"><div class="tile-content number">0</div></div>
<div class="tile half bg-pink" id="add_ten"><div class="tile-content number">+10</div></div>
</div>
<?php echo $this->Html->script('touch'); ?>
<?php echo $this->Html->css('touch'); ?>
