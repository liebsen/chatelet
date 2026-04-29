<?php

App::uses('CakeEmail', 'Network/Email');

require __DIR__ . '/../../functions.php';

class ReportShell extends AppShell {
  public $uses = array(
    'Setting', 
    'User', 
    'Product', 
    'Sale', 
    'SaleProduct'
  );

  private $response = array();
  private $total = 0;
  private $items = array();    

  public function main() {

    $collection = array();

    $sales = $this->Sale->find('all', array(
      'conditions' => array(
        'and' => array(
          'DATE(Sale.created)' => date('Y-m-d'),
          // 'Sale.completed' => 1,
        ),
      )
    ));
    
    echo "sales today:".count($sales)."\n";

    foreach($sales as $i => $sale) {
      // print_r($sale);
      $items = $this->SaleProduct->find('all',array(
        'joins' => array(
          array(
            'table' => 'products',
            'alias' => 'Product',
            'type' => 'LEFT',
            'conditions' => array( 'Product.id = SaleProduct.product_id' )
          )
        ),
        'fields' => array('Product.id, Product.category_id, Product.article, Product.name, Product.desc, Product.img_url, Product.price, Product.article, Product.discount, Product.stock_total'),
        'conditions' => array( 
          'SaleProduct.sale_id' => $sale['Sale']['id'],
          'Product.visible' => "1" 
        )
      ));

      echo "sales prods:".count($items)."\n";

      foreach($items as $item) {
        echo $item['Product']['name'] . "\n";

        $pid = $item['SaleProduct']['product_id'];
        if(empty($collection[$pid])) {
          $collection[$pid] = array(
            'name' => $item['Product']['name'],
            'price' => $item['Product']['price'],
            'count' => 1
          );
        } else {
          $collection[$pid]['count']++;  
        }
      }

      print_r($collection);
      $this->items = $collection;
      $this->total+= (float) $sale['Sale']['value'];
      $sale['Sale']['items'] = $items;
    }

    $admins = $this->User->find('all', array('conditions' => array(
      'role in' => array('admin', 'sadmin')
    )));

    foreach($admins as $admin) {
      $this->response[$admin['User']['id']] = $this->sendEmail($admin);
    }

    var_dump($this->response);
    return true;
  }

  public function sendEmail($user) {
    $email = new CakeEmail();
    // $email->transport('Debug');
    $email->from(array(
      'info@chatelet.com' => 'Châtelet'
    ));

    $settings = $this->load_settings();

    echo "sending email to: " . $user['User']['email'];

    $email->to($user['User']['email']);
    $email->subject('Reporte de venta diario');
    $email->template('report_daily', 'default');
    $email->emailFormat('html');
    $email->config('default');
    $email->viewVars(array(
      'user' => $user['User'],
      'total' => $this->total,
      'items' => $this->items,
      'reports_link' => Router::url('/admin/reportes', true),
      'socials' => \parsed_socials($settings)
    ));

    if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' || empty($sale['Sale']['email'])){
      CakeLog::write('debug', 'unfinished error: empty email or localhost');
      return true;
    }

    $sent = false;
    // $sent = $email->send();

    if($sent) {
      $this->Sale->save(array(
        'id' => $sale['Sale']['id'],
        'def_reminder_sent' => 1
      ));
    }

    return $sent;
  }

  public function load_settings(){
    $tags = [];        
    $settings = $this->Setting->find('all');
    $path = Router::url(null, false);
    foreach($settings as $setting) {
      $id = $setting['Setting']['id'];
      $value = $setting['Setting']['value'];
      $data[$id] = $value;
    }
    return $data;
  }
}
