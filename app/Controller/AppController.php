<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    private $activeUserId;

    public $components = array(
        'Session'
    );

    public function beforeFilter() {
        $this->loadModel('User');
        $this->loadModel('Term');

        $users = $this->User->find('all', array('conditions' => array('active' => 1)));
        $this->set('session_users', $users);
        
        //get active index
        $active_index = 0;
        if (isset($_COOKIE['user'])) {
            $active_id = $_COOKIE['user'];
            
            foreach ($users as $index => $user) {
                if ($user['User']['id'] == $active_id) $active_index = $index;
            }
        }
        
        $this->activeUserId = (isset($_COOKIE['user'])) ? $_COOKIE['user'] : $users[0]['User']['id'];
        
        $this->set('session_user_index', $active_index);
        $this->set('session_user_id', $users[$active_index]['User']['id']);

        $terms = $this->Term->find('all', array('conditions' => array('active' => 1)));
        $this->set('session_terms', $terms);

        //get active index
        if (isset($_COOKIE['term'])) {
            $active_id = $_COOKIE['term'];
            $active_date = '1970-01-01';
        }
        else {
            $active_id = $this->Term->find('first', array('fields' => array('MAX(id) as max', 'start')));
            $active_id = $active_id[0]['max'];
            $active_date = '1970-01-01';
        } 

        foreach ($terms as $index => $term) {
            if ($term['Term']['id'] == $active_id) {
                $active_index = $index;
                $active_date = $term['Term']['start'];
            }
        }

        $active_id2 = $this->Term->find('first', array(
            'fields' => array('start'),
            'conditions' => array(
                'start >' => $active_date
            ),
            'order' => 'start'
        ));

        $sql = " >= '".$active_date."'";
        if (isset($active_id2['Term']['start'])) {
            $sql = " BETWEEN '".$active_date."' AND '".$active_id2['Term']['start']."'";
        }

        $this->set('session_term_index', $active_index);
        $this->activeTermDate = $active_date;
        $this->activeTermDateSQL = $sql;
    }
    
    
    public function getActiveUserId() {
        return $this->activeUserId;
    }
    

}
