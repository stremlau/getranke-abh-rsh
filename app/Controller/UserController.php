<?php
App::uses('AppController', 'Controller');

class UserController extends AppController {

	public function index() {
        $this->set('title_for_layout', 'Benutzerübersicht');
        $this->set('users', $this->User->find('all'));
	}
	
	public function edit($id = null) {
        $this->set('title_for_layout', 'Benutzer');
        
        if (!empty($this->request->data)) {
            $this->User->id = $id;
            if ($this->User->save($this->request->data)) {
                $this->redirect(array('action' => 'index'));
            }
        }
        
        $this->User->recursive = 0;
        $bill = $this->User->findById($id);
        $this->set('bill', $bill);
        
        if (!$this->request->data) {
            $this->request->data = $bill;
        }
	}
}
