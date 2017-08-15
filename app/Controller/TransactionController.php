<?php
class TransactionController extends AppController {
	public function index() {
        $this->set('title_for_layout', 'Transaktionen');
        $this->set('transactions', $this->Transaction->find('all', array('order' => 'created')));
	}
	
	public function edit($id = null) {
        $this->set('title_for_layout', 'Transaktion');
        
        if (!empty($this->request->data)) {
            $this->Transaction->id = $id;
            $this->request->data['Transaction']['user_id'] = $this->getActiveUserId();
            if ($this->Transaction->save($this->request->data)) {
                $this->redirect(array('action' => 'index'));
            }
        }
        
        $transaction = $this->Transaction->findById($id);
        $this->set('transaction', $transaction);
        $this->set('id', $id);
        
        if (!$this->request->data) {
            $this->request->data = $transaction;
        }
	}
	
	public function delete($id = null) {
        $this->Transaction->delete($id);
        $this->redirect(array('action' => 'index'));
	}
}
