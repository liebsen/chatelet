<?php

App::uses(
  'Model', 
  'Component', 
  'Controller', 
  'Session', 
  'Analytics', 
  'Sale',
  'Product',
);

class AnalyticsComponent extends Component {
  public $controller; // To store a reference to the Controller
  public function initialize(Controller $controller) {
    $this->controller = $controller;
    parent::initialize($controller);
  }

  public function index($value=''){
  }

  public function search() {
    $this->loadModel('Search');
    $Search = ClassRegistry::init('Search');
    $items = $Search->find('all',array(
      'joins' => array(
        array(
          'table' => 'users',
          'alias' => 'UserJoin',
          'type' => 'LEFT',
          'conditions' => array(
              'UserJoin.id = Search.user_id'
          )
        )
      ),
      'fields' => array('UserJoin.name, UserJoin.surname, UserJoin.birthday', 'Search.*'),
      'order' => array('Search.id DESC'),
      'limit' => 20,
    ));
    $this->set('view', "searches");    
  }

  public function cart() {
    $this->loadModel('Analytic');
    $items = $this->Analytic->find('all',array(
      'joins' => array(
        array(
          'table' => 'users',
          'alias' => 'UserJoin',
          'type' => 'LEFT',
          'conditions' => array(
            'UserJoin.id = Analytic.user_id',
          )
        )
      ),
      'conditions' => array(
        'Analytic.user_id > 0',
      ),
      'fields' => array('UserJoin.name, UserJoin.surname, UserJoin.birthday', 'Analytic.*'),
      'order' => array('Analytic.id DESC'),
      'limit' => 500,
    ));    
  }

  public function products() {
    $this->loadModel('Analytic');
    $items = $this->Analytic->find('all',array(
      'joins' => array(
        array(
          'table' => 'users',
          'alias' => 'UserJoin',
          'type' => 'LEFT',
          'conditions' => array(
            'UserJoin.id = Analytic.user_id',
          )
        )
      ),
      'conditions' => array(
        'Analytic.user_id > 0',
      ),
      'fields' => array('UserJoin.name, UserJoin.surname, UserJoin.birthday', 'Analytic.*'),
      'order' => array('Analytic.id DESC'),
      'limit' => 500,
    ));    
  }

  public function sales() {
    $this->loadModel('Analytic');
    $items = $this->Analytic->find('all',array(
      'joins' => array(
        array(
          'table' => 'users',
          'alias' => 'UserJoin',
          'type' => 'LEFT',
          'conditions' => array(
            'UserJoin.id = Analytic.user_id',
          )
        )
      ),
      'conditions' => array(
        'Analytic.user_id > 0',
      ),
      'fields' => array('UserJoin.name, UserJoin.surname, UserJoin.birthday', 'Analytic.*'),
      'order' => array('Analytic.id DESC'),
      'limit' => 500,
    ));    
  }
}
