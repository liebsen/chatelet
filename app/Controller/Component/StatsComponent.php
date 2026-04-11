<?php

App::uses(
  'Model', 
  'Component', 
  'Controller', 
  'Session', 
  'Stat', 
  'Sale',
  'User',
  'Product',
);

class StatsComponent extends Component {
  public $controller; // To store a reference to the Controller
  public function initialize(Controller $controller) {
    $this->controller = $controller;
    parent::initialize($controller);
  }

  public function index(){}

  public function search() {
    $Stat = ClassRegistry::init('Stat');
    $items = $Stat->find('all',array(
      'joins' => array(
        array(
          'table' => 'users',
          'alias' => 'User',
          'type' => 'LEFT',
          'conditions' => array(
              'User.id = Stat.user_id'
          )
        )
      ),
      'conditions' => array(
        'tag' => 'page-search'
      ),
      'fields' => array('User.name, User.surname, User.birthday', 'Stat.*'),
      'order' => array('Stat.id DESC'),
      'limit' => 200,
    ));

    foreach($items as $i => $item) {
      $items[$i]['Stat']['context'] = json_decode($item['Stat']['context']);
    }

    //\d("items",$items);
    $this->controller->set('items', $items);    
  }

  public function cart() {
    $Stat = ClassRegistry::init('Stat');
    $items = $Stat->find('all',array(
      'joins' => array(
        array(
          'table' => 'users',
          'alias' => 'User',
          'type' => 'LEFT',
          'conditions' => array(
            'User.id = Stat.user_id',
          )
        )
      ),
      'conditions' => array(
        'Stat.cart_totals IS NOT NULL',
      ),
      'fields' => array('User.name, User.surname, User.birthday', 'Stat.*'),
      'order' => array('Stat.id DESC'),
      'limit' => 500,
    ));
    $this->controller->set('items', $items);    
  }

  public function products() {
    $Stat = ClassRegistry::init('Stat');
    $items = $Stat->find('all',array(
      'joins' => array(
        array(
          'table' => 'products',
          'alias' => 'Product',
          'type' => 'LEFT',
          'conditions' => array(
            'User.id = Stat.product_id',
          )
        )
      ),
      'conditions' => array(
        'Stat.user_id > 0',
      ),
      'fields' => array('Product.name, Product.desc, Product.article', 'Stat.*'),
      'order' => array('Stat.id DESC'),
      'limit' => 500,
    ));   
    $this->controller->set('items', $items);     
  }

  public function sales() {
    $Stat = ClassRegistry::init('Stat');
    $items = $Stat->find('all',array(
      'joins' => array(
        array(
          'table' => 'users',
          'alias' => 'User',
          'type' => 'LEFT',
          'conditions' => array(
            'User.id = Stat.user_id',
          )
        )
      ),
      'conditions' => array(
        'Stat.user_id > 0',
      ),
      'fields' => array('User.name, User.surname, User.birthday', 'Stat.*'),
      'order' => array('Stat.id DESC'),
      'limit' => 500,
    ));
    $this->controller->set('items', $items);    
  }
}
