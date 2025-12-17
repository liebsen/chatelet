<?php

App::uses('CakeEmail', 'Network/Email');

require __DIR__ . '/../../functions.php';

class SalesShell extends AppShell {
  public $uses = array(
    'Setting', 
    'User', 
    'Sale', 
    'SaleProduct'
  );

  public function main() {
    $sales = $this->Sale->find('all', array(
      'conditions' => array( 
        'Sale.completed' => 0,
        'Sale.def_reminder_sent' => 0,
        'DATE(Sale.created)' => date('Y-m-d')
      )
    ));

    $response = array();

    foreach($sales as $i => $sale) {
      $sale['Sale']['items'] = $this->SaleProduct->find('all', array('conditions' => array(
        'sale_id' => $sale['Sale']['id']
      )));
      $response[$i] = $this->sendEmail($sale);
    }

    CakeLog::write('debug', 'unfinished sales:'.count($sales));

    return json_encode(array(
      'reponse' => $response,
      'count' => count($sales)
    ));
  }

  public function sendEmail($sale) {
    $email = new CakeEmail();
    // $email->transport('Debug');
    $email->from(array(
      'info@chatelet.com' => 'Châtelet'
    ));

    $settings = $this->load_settings();
    $sale['Sale']['checkout_link'] = Router::url('/checkout', true);

    $email->to($sale['Sale']['email']);
    $email->subject('Completá tu compra');
    $email->template('purchase_unfinished', 'default');
    $email->emailFormat('html');
    $email->config('default');
    $email->viewVars(array(
      'data' => $sale['Sale'],
      'socials' => \parsed_socials($settings)
    ));

    if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' || empty($sale['Sale']['email'])){
      CakeLog::write('debug', 'unfinished error: empty email or localhost');
      $this->Sale->save(array(
        'id' => $sale['Sale']['id'],
        'def_reminder_sent' => 1
      ));      
      return true;
    }

    $sent = $email->send();

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
