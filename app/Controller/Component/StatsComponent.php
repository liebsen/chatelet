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
      'limit' => 500,
    ));

    foreach($items as $i => $item) {
      $context = json_decode($item['Stat']['context']);
      if(!empty($context)) {
        $items[$i]['Stat']['context'] = (object) $context;
      }
    }

    $words = $Stat->find('all',array(
      'conditions' => array(
        'tag' => 'page-search',
        'JSON_EXTRACT(Stat.context, "$.query") IS NOT NULL',
      ),
      'fields' => array('COUNT(JSON_EXTRACT(LOWER(Stat.context), "$.query")) AS count, JSON_UNQUOTE(JSON_EXTRACT(LOWER(Stat.context), "$.query")) AS query'),
      'group' => array('JSON_EXTRACT(LOWER(Stat.context), "$.query")'),
      'order' => array('count DESC'),
      'limit' => 500,
    ));

    $this->controller->set('items', $items);    
    $this->controller->set('words', $words);    
  }

  public function cart() {
    $Stat = ClassRegistry::init('Stat');
    $this->controller->set('items', $Stat->find('all',
      array(
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
          'tag' => array(
            'page-exit', 
            'card-add', 
            'cart-remove'
          ),
          'JSON_EXTRACT(context, "$.cart") IS NOT NULL'
        ),
        'fields' => array('Stat.id, Stat.tag, Stat.context, Stat.created, User.id, User.email, User.name, User.surname, User.birthday'),
        'group' => array('Stat.id, Stat.tag, Stat.context, Stat.created, User.id, User.email, User.name, User.surname, User.birthday'),
        'order' => array('Stat.id DESC'),
        'limit' => 1000,
      )
    ));
  }

  public function items() {
    $Stat = ClassRegistry::init('Stat');
    $this->controller->set('items', $Stat->find('all',
      array(
        'joins' => array(
          array(
            'table' => 'products',
            'alias' => 'Product',
            'type' => 'LEFT',
            'conditions' => array(
              'Product.id IS NOT NULL'
            )
          )
        ),
        'conditions' => array(
          'Stat.user_id > 1',
          'Stat.product_id > 1',
        ),
        'fields' => array('Product.name, Product.desc, Product.article', 'Stat.*'),
        'order' => array('Stat.id DESC'),
        'limit' => 500,
      )
    ));
  }

  public function sales() {
    $Stat = ClassRegistry::init('Stat');
    $this->controller->set('items', $Stat->find('all',
      array(
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
      )
    ));
  }

  public function session() {
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
        'tag LIKE ' => 'session-%'
      ),
      'fields' => array('Stat.id, Stat.tag, Stat.created, User.id, User.name, User.surname, User.email, User.birthday'),
      'group' => array('Stat.id'),
      'order' => array('Stat.id DESC'),
      'limit' => 500,
    ));

    $this->controller->set('items', $items);
  }
}
