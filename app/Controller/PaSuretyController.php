<?php
App::uses('AppController', 'Controller');

class PaSuretyController extends AppController {

	public function index() {
        $this->set('title_for_layout', 'Anlagenverleih');
        $this->set('pa_sureties', $this->PaSurety->find('all'));
	}
	
	public function edit($id = null) {
        $this->set('title_for_layout', 'Rechnung');
        
        if (!empty($this->request->data)) {
            $this->PaSurety->id = $id;
            $this->request->data['PaSurety']['user_id'] = $this->getActiveUserId();
            if ($this->PaSurety->save($this->request->data)) {
                $this->redirect(array('action' => 'index'));
            }
        }
        
        $this->set('id', $id);
        
        $this->set('customers', $this->PaSurety->Customer->find('list', array('conditions' => array('category !=' => 'private'))));
        
        $pa_surety = $this->PaSurety->findById($id);
        
        if (!$this->request->data) {
            $this->request->data = $pa_surety;
        }
	}
	
	public function edit_fancy($id = null) {
        $this->edit($id);
	}
	
	private function calculateDebit() {
	    $this->loadModel('Bill');
        $res = $this->Bill->find('first', array('fields' => 'SUM(total) as total', 'conditions' => array('paid' => 1)));
        $bills = $res[0]['total'];
        
        $this->loadModel('Transaction');
        $res = $this->Transaction->find('first', array('fields' => 'SUM(amount) as total'));
        $transactions = $res[0]['total'];
        
        return $bills - $transactions;
	}
	
	public function delete($id = null) {
        $this->PaSurety->delete($id);
        $this->redirect(array('action' => 'index'));
	}

}
