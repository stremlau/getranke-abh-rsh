<?php
App::uses('AppController', 'Controller');

class CashAuditController extends AppController {

	public function index() {
        $this->set('title_for_layout', 'Rechnungsübersicht');
        $this->set('cash_audits', $this->CashAudit->find('all', array(
            'conditions' => 'created'.$this->activeTermDateSQL
        )));
        
	}
	
	public function add($id = null) {
        $this->set('title_for_layout', 'Kassenprüfung durchführen');
        
        $debit_bills = $this->calculateDebitBills();
        $this->set('debit_bills', $debit_bills);
        $debit_transactions = $this->calculateDebitTransactions();
        $this->set('debit_transactions', $debit_transactions);
        $debit_pa_sureties = $this->calculateDebitPaSureties();
        $this->set('debit_pa_sureties', $debit_pa_sureties);
        $debit_total = $this->calculateDebit();
        $this->set('debit_total', $debit_total);
        
        $unpaid_bills = $this->calculateUnpaidBills();
        $this->set('unpaid_bills', $unpaid_bills);
        
        
        if (!empty($this->request->data)) {
            $this->request->data['CashAudit']['debit'] = $debit_total;
            $this->request->data['CashAudit']['user_id'] = $this->getActiveUserId();
            
            if ($this->CashAudit->save($this->request->data)) {
                $this->redirect(array('action' => 'index'));
            }
        }
	}
	
	private function calculateDebit() {
	    return $this->calculateDebitBills() - $this->calculateDebitTransactions() + $this->calculateDebitPaSureties();
	}
	
	private function calculateDebitBills() {
	    $this->loadModel('Bill');
        $res = $this->Bill->find('first', array('fields' => 'SUM(total) as total', 'conditions' => array(
            'paid' => 1,
            'created'.$this->activeTermDateSQL
        )));
        return $res[0]['total'];
	}
	
	private function calculateUnpaidBills() {
	    $this->loadModel('Bill');
        $res = $this->Bill->find('first', array('fields' => 'SUM(total) as total', 'conditions' => array(
            'paid' => 0,
            'created'.$this->activeTermDateSQL
        )));
        return $res[0]['total'];
	}
	
	private function calculateDebitTransactions() {
	    $this->loadModel('Transaction');
        $res = $this->Transaction->find('first', array('fields' => 'SUM(amount) as total', 'conditions' => array(
            'created'.$this->activeTermDateSQL        
        )));
        return $res[0]['total'];
	}
	
	private function calculateDebitPaSureties() {
	    $this->loadModel('PaSurety');
        $res = $this->PaSurety->find('first', array('fields' => '(SUM(value_paid)-SUM(value_regained)) as total', 'conditions' => array(
            'created'.$this->activeTermDateSQL        
        )));
        return $res[0]['total'];
	}

}
