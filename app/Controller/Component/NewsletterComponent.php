<?php

App::uses(
  'Model', 
  'Component', 
  'Controller', 
  'Session', 
  'Sale', 
  'SaleProduct'
);

class NewsletterComponent extends Component {
  public $controller; // To store a reference to the Controller
  public function initialize(Controller $controller) {
    $this->controller = $controller;
    parent::initialize($controller);
  }

  public function products() {
    $Sale = ClassRegistry::init('Sale');
    $response = array();
    try {
      $sales = $Sale->find('all', array(
        'joins' => array(
          array(
            'table' => 'sale_products',
            'alias' => 'SaleProduct',
            'type' => 'LEFT',
            'conditions' => array( 'Sale.id = SaleProduct.sale_id' )
          )
        ),
        'fields' => array('Sale.*, SaleProduct.size, SaleProduct.color, SaleProduct.precio_vendido'),
        'conditions' => array( 'Sale.created > ' => date("Y-m-d H:i", strtotime("last day of previous month"))),
        //'order' => array( 'Product.price ASC' )
      ));

      $sales_total = 0;
      $prod_total = 0;

      foreach($sales as $sale) {
        $sales_total+= (float) $sale['Sale']['value'];
        $prod_total+= (int) count($sale['SaleProduct']);
      }

      $response['sales_total'] = $sales_total;
      $response['prod_total'] = $prod_total;
      $this->controller->set('sales_total', $sales_total);
      $this->controller->set('prod_total', $prod_total);
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public function sales() {
    $Sale = ClassRegistry::init('Sale');
    $response = array();
    try {
      $sales = $Sale->find('all', 
        array(
          'conditions' => array(
            'created > ' => date("Y-m-d H:i", strtotime("last day of previous month"))
          )
        )
      );

      $sales_total = 0;
      foreach($sales as $sale) {
        $sales_total+= (float) $sale['Sale']['value'];
      }

      $response['sales_total'] = $sales_total;

      return json_encode($response);
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }
}
