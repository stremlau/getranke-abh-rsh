<?php
App::uses('AppController', 'Controller');

class ApiController extends AppController {

    private $customerId;

    public function beforeFilter() {
        parent::beforeFilter();

        //handle authentication and authorization on our own
        $this->Auth->allow();

        //do not use views
        $this->autoRender = false;
        $this->layout = false;

        $this->response->type('json');

        if (!isset($this->request->query['secret']) || strlen($this->request->query['secret']) != 32) {
            throw new ForbiddenException('No valid secret.');
        }

        $this->loadModel('Customer');
        $customer = $this->Customer->findBySecret($this->request->query['secret']);

        if (!$customer) {
            throw new ForbiddenException('Secret unknown.');
        }

        $this->customerId = $customer['Customer']['id'];
    }

    public function bill() {
        $this->loadModel('Bill');
        $this->Bill->unbindModel(array('belongsTo' => array('Customer', 'User')));
        $bills = $this->Bill->find('all', array(
            'conditions' => array(
                'customer_id' => $this->customerId,

            ),
            'fields' => array(
                'Bill.id', 'Bill.total', 'Bill.created', 'Bill.paid_date', 'Bill.paid'
            ),
            'recursive' => -1,
        ));

        return json_encode($bills);
    }
}
