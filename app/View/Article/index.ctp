<h1>
    <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
    Artikelliste<small class="on-right"></small>
</h1>
<table class="table striped bordered hovered">
<tr>
    <th>#</th>
    <th>Artikel</th>
    <th>Einzelpreis</th>
    <th>EK-Preis</th>
    <th>Pfand</th>
    <th>Kategorie</th>
</tr>

<?php foreach($articles as $article): ?>
    <?php //pr($article); ?>
    <tr>
        <td><?php echo $article['Article']['id']; ?></td>
        <td><?php echo $this->Html->link($article['Article']['name'], array('action' => 'edit', $article['Article']['id'])); ?></td>
        <td><?php echo $article['Article']['price']; ?></td>
        <td><?php echo $article['Article']['p_price']; ?></td>
        <td><?php echo $article['Deposit']['name']; ?></td>
        <td><?php echo $article['Category']['name']; ?></td>
    </tr>
<?php endforeach; ?>
</table>

<?php echo $this->Html->link('Artikel hinzufügen', array('action' => 'edit')); ?>
