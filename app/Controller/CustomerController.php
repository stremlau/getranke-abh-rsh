<?php
App::uses('AppController', 'Controller');

class CustomerController extends AppController {

	public function index() {
        $this->set('title_for_layout', 'Kundenübersicht');
        $this->set('customers', $this->Customer->find('all'));
	}
	
	public function edit($id = null) {
        $this->set('title_for_layout', 'Kunde');
        
        if (!empty($this->request->data)) {
            $this->Customer->id = $id;
            if ($this->Customer->save($this->request->data)) {
                $this->redirect(array('action' => 'index'));
            }
        }
        
        $this->Customer->recursive = 0;
        $bill = $this->Customer->findById($id);
        $this->set('bill', $bill);
        
        if (!$this->request->data) {
            $this->request->data = $bill;
        }
	}
}
