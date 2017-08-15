<?php
App::uses('AppController', 'Controller');

class ArticleController extends AppController {

	public function index() {
        $this->set('title_for_layout', 'Artikelsübersicht');
        $this->set('articles', $this->Article->find('all', array('order' => 'Article.name', 'conditions' => array('Article.child' => '0', 'Article.active' => 1))));
	}
	
	public function edit($id = null) {
        $this->set('title_for_layout', 'Artikel');
		$this->set('id', $id);

        if (!empty($this->request->data)) {
            if (isset($this->request->data['overwrite'])) {
                $this->Article->id = $id;
                if ($this->Article->save($this->request->data)) {
                    $this->redirect(array('action' => 'index'));
                }
            }
            else {
                $this->Article->create($this->request->data);
                if ($this->Article->save()) {
                    $new_id = $this->Article->id;
                    if ($id != null) {
                        $this->Article->id = $id; //modify old article
                        $this->Article->saveField('child', $new_id);
                    }
                    $this->redirect(array('action' => 'index'));
                }
            }
        }
        
        $this->set('deposits', $this->Article->Deposit->find('list', array('conditions' => array('deposit_id' => null, 'child' => '0', 'active' => 1))));
        $this->set('categories', $this->Article->Category->find('list'));
        
        $article = $this->Article->findById($id);
        $this->set('article', $article);
        
        if (!$this->request->data) {
            $this->request->data = $article;
        }
	}

	public function delete($id = null) {
        $this->Article->id = $id;
		$this->Article->saveField('active', 0);
        $this->redirect(array('action' => 'index'));
	}
}
