<?php
App::uses('AppController', 'Controller');

class BillController extends AppController {

	public function index() {
        $this->set('title_for_layout', 'Rechnungsübersicht');
        $this->set('bills', $this->Bill->find('all', array('conditions' => 'created'.$this->activeTermDateSQL)));
	}
	
	public function edit($id = null) {
        $this->set('title_for_layout', 'Rechnung');
        
        if (!empty($this->request->data)) {
            $this->Bill->id = $id;
            if (isset($this->request->params['named']['customer']))
                $this->request->data['Bill']['customer_id'] = $this->request->params['named']['customer'];
            $this->request->data['Bill']['user_id'] = $this->getActiveUserId();
            
            if ($this->Bill->save($this->request->data)) {
                $this->redirect(array('action' => 'view', $this->Bill->id));
            }
        }
        
        $this->set('users', $this->Bill->User->find('list', array('conditions' => array('active' => 1))));
        $this->set('customer', $this->Bill->Customer->findById($this->request->params['named']['customer']));
        $this->set('articles', $this->Bill->Article->find('all', array('order' => array('Article.category_id', 'Article.name'), 'conditions' => array('Article.child' => '0', 'Article.active' => 1))));
        $this->set('categories', $this->Bill->Article->Category->find('all', array('order' => array('Category.deposit DESC'))));
        
        $this->Bill->recursive = 2;
        $bill = $this->Bill->findById($id);
        $this->set('bill', $bill);
        $this->set('id', $id);
        
        if (!$this->request->data) {
            $this->request->data = $bill;
        }
	}
	
	public function customers() {
	    $customers = $this->Bill->Customer->find('all', array('recursive' => 0, 'conditions' => array('active' => 1), 'order' => "FIELD(category, 'floor', 'tutorage', 'private'), id"));
        $customers_unpaid_count = array();
        foreach ($customers as &$customer) {
            $unpaid_count = $this->Bill->find('count', array('conditions' => array('customer_id' => $customer['Customer']['id'], 'paid' => 0, 'created'.$this->activeTermDateSQL)));
            $customer['unpaid_bills'] = $unpaid_count;
        }
        
        $this->set('customers', $customers);
	}
	
	public function view($ids) {
	    $ids = explode('-', $ids);
        $this->set('bill_ids', $ids);

        if (isset($this->params['named']['pay']) && $this->params['named']['pay'] == 1) {
            $this->Bill->updateAll(
                array('Bill.paid' => 1, 'Bill.paid_date' => "'".date('Y-m-d')."'"),
                array('Bill.id' => $ids)
            );
        }

        if (isset($this->params['named']['unpay']) && $this->params['named']['unpay'] == 1) {
            $this->Bill->updateAll(
                array('Bill.paid' => 0, 'Bill.paid_date' => null),
                array('Bill.id' => $ids)
            );
        }

        $this->set('print', (isset($this->params['named']['print']) && ($this->params['named']['print'] == 1 || $this->params['named']['print'] == 2)) ? $this->params['named']['print'] : false);

        $this->Bill->unbindModel(array('hasAndBelongsToMany' => array('Article')));
        $this->set('bills', $this->Bill->find('all', array('conditions' => array('Bill.id' => $ids))));

        $this->Bill->ArticlesBill->unbindModel(array('belongsTo' => array('Bill')));
	    $this->set('articles_bills_in', $this->Bill->ArticlesBill->find('all', array(
		'conditions' => array('bill_id' => $ids, 'ArticlesBill.amount <' => 0), 
                'order' => array('Article.category_id', 'Article.name'),
		'recursive' => 2
            )));

            $this->set('articles_bills_out', $this->Bill->ArticlesBill->find('all', array(
		'conditions' => array('bill_id' => $ids, 'ArticlesBill.amount >' => 0), 
                'order' => array('Article.category_id', 'Article.name'),
		'recursive' => 2
            )));
	}
	
	public function customer($id = null) {
	    $unpaid_bills = $this->Bill->find('all', array('conditions' => array('customer_id' => $id, 'paid' => 0, 'created'.$this->activeTermDateSQL), 'order' => 'created'));
        if (count($unpaid_bills) == 0) return $this->redirect(array('action' => 'edit', 'customer' => $id));
        $this->set('unpaid_bills', $unpaid_bills);
        $customer = $this->Bill->Customer->find('first', array('conditions' => array('id' => $id)));
        
        $this->set('customer_id', $id);
        $this->set('customer_name', $customer['Customer']['name']);
	}
	
	public function delete($id = null) {
        $this->Bill->delete($id);
        $this->redirect(array('action' => 'index'));
	}
	
	public function edit_fancy($id = null) {
        $this->edit($id);
	}
}
