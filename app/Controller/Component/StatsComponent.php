<?php

App::uses(
  'Model', 
  'Component', 
  'Controller', 
  'Session', 
  'Stat', 
  'Sale',
  'SaleProduct',
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

  public function items($query) {
  	$date_min = $query['date_min'] ?? date("Y-m-d", strtotime("last day of previous month"));
  	$date_max = $query['date_max'] ?? date("Y-m-d", strtotime("today"));
    $this->controller->set('date_min', $date_min);
    $this->controller->set('date_max', $date_max);
    $Stat = ClassRegistry::init('Stat');
    $this->controller->set('items', $Stat->find('all',
      array(
        'joins' => array(
          array(
            'table' => 'products',
            'alias' => 'Product',
            'type' => 'LEFT',
            'conditions' => array(
              'Product.id = Stat.product_id'
            )
          )
        ),
        'conditions' => array(
        	"Stat.tag" => "page-view",
        	"Stat.created > '{$date_min}'",
        	"Stat.created <= '{$date_max}'",
          'Product.id IS NOT NULL',
          'Product.id > 1',
        ),
        'fields' => array('Product.id,Product.name, Product.desc, Product.article,Stat.user_id,COUNT(*) AS ProdCount'),
        'order' => array('ProdCount DESC'),
        'group' => array('Stat.product_id'),
        'limit' => 50,
      )
    ));
  }

  public function sales($query) {
  	$date_min = $query['date_min'] ?? date("Y-m-d", strtotime("last day of previous month"));
  	$date_max = $query['date_max'] ?? date("Y-m-d", strtotime("today"));
    $SaleProduct = ClassRegistry::init('SaleProduct');
    $this->controller->set('date_min', $date_min);
    $this->controller->set('date_max', $date_max);
    $this->controller->set('query', $query);
    $this->controller->set('items', $SaleProduct->find('all',
      array(
        'joins' => array(
          array(
            'table' => 'sales',
            'alias' => 'Sale',
            'type' => 'LEFT',
            'conditions' => array(
              'SaleProduct.sale_id = Sale.id'
            )
          ),
          array(
            'table' => 'products',
            'alias' => 'Product',
            'type' => 'LEFT',
            'conditions' => array(
              'SaleProduct.product_id = Product.id'
            )
          )
        ),
        'conditions' => array(
        	"Sale.created > '{$date_min}'",
        	"Sale.created <= '{$date_max}'",
          'Product.id IS NOT NULL',
          'Product.id > 1',
          #'SaleProduct.product_id IS NOT NULL',
          #'SaleProduct.product_id > 1',
        ),
        'fields' => array('Product.id, Product.name, SaleProduct.product_id, SaleProduct.description, COUNT(*) AS ProdCount'),
        'order' => array('ProdCount DESC'),
        'group' => array('SaleProduct.product_id'),
        'limit' => 50,
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
      'fields' => array('Stat.id, Stat.tag, Stat.created, User.id, User.name, User.surname, User.email, User.role, User.birthday'),
      'group' => array('Stat.id'),
      'order' => array('Stat.id DESC'),
      'limit' => 500,
    ));

    $this->controller->set('items', $items);
  }
}
