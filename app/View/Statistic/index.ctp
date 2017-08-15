<h1>
    <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
    Verkaufsstatistik<small class="on-right"></small>
</h1>
<table class="table striped bordered hovered">
    <tbody>
    <tr>
        <th>Artikelname</th>
        <th>Einzelpreis</th>
        <th>EK-Preis</th>
        <th>Anzahl verkauft</th>
        <th>Umsatz</th>
        <th>Gewinn</th>
    </tr>
    <?php foreach($articles as $article): ?>
    <tr>
        <td><?php echo $article['Article']['name']; ?></td>
        <td><?php echo $article['Article']['price']; ?> &euro;</td>
        <td><?php echo $article['Article']['p_price']; ?> &euro;</td>
        <td><?php echo $article['ArticlesBill']['total']; ?></td>
        <td><?php echo $article['ArticlesBill']['total'] * $article['Article']['price']; ?> &euro;</td>
        <td><?php echo $article['ArticlesBill']['total'] * ($article['Article']['price'] - $article['Article']['p_price']); ?> &euro;</td>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>