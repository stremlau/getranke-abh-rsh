<?php
class Bill extends AppModel {
    public $belongsTo = array('Customer', 'User');
    public $hasAndBelongsToMany = array(
        'Article' => array(
            'with' => 'ArticlesBill'
        )
    );
    
    public $order = 'Bill.id';
    
    public function beforeSave($options = array()) {
        $total = 0;
        if (isset($this->data['Article']))
        foreach($this->data['Article'] as $article) {
            $raw_article = $this->Article->findById($article['ArticlesBill']['article_id']);
            $article_sum = $article['ArticlesBill']['amount'] * ($raw_article['Article']['price'] + $raw_article['Deposit']['price']);
            $total += $article_sum;
        }
        $this->data['Bill']['total'] = $total;
        //die($total);
        return true;
    }

    public function dateFormatBeforeSave($dateString) {
        return date('Y-m-d', strtotime($dateString));
    }
}
