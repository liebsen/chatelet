<?php

App::uses('CakeEmail', 'Network/Email');

error_reporting(E_ALL);
ini_set("display_errors", 1);
header('Content-Type: text/html; charset=utf-8');

require __DIR__ . '/../../functions.php';
require __DIR__ . '/../../Vendor/web-push/vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class MinuteShell extends AppShell {
  public $uses = array(
    'Setting', 
    'User', 
    'Product', 
    'Sale', 
    'SaleProduct'
  );

  // searches for unfinished purchases and send reminder
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
      $sale['Sale']['items'] = $this->SaleProduct->find('all',array(
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

      $response[$i] = $this->sendEmail($sale);
    }

    return json_encode(array(
      'reponse' => $response,
      'count' => count($sales)
    ));
  }

  public function sendPush($sale) {

    $push = [
        'subscription' => Subscription::create([
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/djRg_IDPtSs:APA91bFwYCC73F4X3cXELK...',
            'keys' => [
                'auth' => 'SPB_NNfRw...',
                'p256dh' => 'BP-WMuJdP7buopSb_HrNX...'
            ]
        ]),
        'payload' => json_encode([
            'title' => "Hello",
            'body' => "How are you?",
            'icon' => "https://cdn-icons-png.flaticon.com/512/3884/3884851.png",
            'data' => [
                'vibrate' => [100, 200],
                'additionalData' => [],
                'url' => "https://google.com",
            ],
        ]),
    ];

    $auth = [
        'VAPID' => [
            'subject' => 'support@gmail.com', // can be a mailto: or your website address
            'publicKey' => 'BFrp-TvkuqCeNsytRt...', // (recommended) uncompressed public key P-256 encoded in Base64-URL
            'privateKey' => '9BvI1aN1CR4w4iceMS...', // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL
        ],
    ];

    $webPush = new WebPush($auth);

    try {
      $webPush->queueNotification(
        $push['subscription'],
        $push['payload']
      );
      $report = $webPush->flush()->current();
      $is_success = $report->isSuccess();
      $response = $report->getResponseContent();
    } catch (\Throwable $th) {
      $is_success = false;
      $response = $th->getMessage();
    }

    if ($is_success) {
      echo "Push was sent";
    } else {
      echo "Push was not sent. Error message: " . $response;
    }    
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
