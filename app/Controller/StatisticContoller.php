<?php
App::uses('AppController', 'Controller');

class StatisticController extends AppController {

	public function index() {
        $this->set('title_for_layout', 'Statistik');
		
		print_r($this);

        //$this->set('bills', $this->Bill->find('all', array('conditions' => 'created'.$this->activeTermDateSQL)));
	}
}
?>
