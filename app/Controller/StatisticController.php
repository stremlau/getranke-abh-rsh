<?php
App::uses('AppController', 'Controller');

class StatisticController extends AppController {

	public function index() {
        $this->set('title_for_layout', 'Statistik');

        //$this->set('bills', $this->Bill->find('all', array('conditions' => 'created'.$this->activeTermDateSQL)));
		$this->loadModel('ArticlesBill');

		$this->ArticlesBill->virtualFields['total'] = 'SUM(amount)';

		$articles = $this->ArticlesBill->find('all', array(
			'fields' => array('Article.id', 'Article.name', 'Article.price', 'Article.p_price', 'ArticlesBill.total'),
			'group' => 'Article.id',
			'order' => 'Article.name',
			'conditions' => 'Bill.created'.$this->activeTermDateSQL
		));

		$this->set('articles', $articles);
	}
}
?>
