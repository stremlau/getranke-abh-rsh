<?php
class Article extends AppModel {
    public $belongsTo = array(
        'Deposit' => array(
            'className' => 'Article',
            'foreignKey' => 'deposit_id',
            'conditions' => array('Deposit.deposit_id' => null)
        ),
        'Category');
    
    //public $order = 'Article.name';
}
