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
        'tag' => 'page-search',
        'JSON_EXTRACT(Stat.context, "$.query") IS NOT NULL',
      ),
      'fields' => array('Stat.id, Stat.tag, Stat.context, Stat.created, User.id, User.name, User.surname, User.email, User.birthday'),
      'group' => array('Stat.tag, JSON_EXTRACT(Stat.context, "$.query")'),
      'order' => array('Stat.id DESC'),
      'limit' => 200,
    ));

    foreach($items as $i => $item) {
      $context = json_decode($item['Stat']['context']);
      if(!empty($context)) {
        $items[$i]['Stat']['context'] = (object) $context;
      }
    }

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
        'JSON_EXTRACT(context, "$.cart") IS NOT NULL',
      ),
      'fields' => array('Stat.id, Stat.tag, Stat.context, Stat.created, User.id, User.name, User.surname, User.email, User.birthday'),
      'group' => array('Stat.tag, JSON_EXTRACT(Stat.context, "$.cart")'),
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
