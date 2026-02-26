<?php

require_once(APP . 'Vendor' . DS . 'mailchimp' . DS . 'mailchimp.php');

App::uses('Component', 'Controller', 'Session');

class MailchimpComponent extends Component {
  public $controller; // To store a reference to the Controller
  private $mailchimp;

  private static $store = [
    "list_id" => "307ffec4aa",
    "name" => "CHATELET",
    "currency_code" => "ARS",
  ];    

  private static $campaign_defaults = [
    "from_name" => "CHATELET",
    "from_email" => "news@chatelet.com.ar",
    "subject" => "🌸 CHATELET - NO RESPONDER",
    "language" => "es",
  ];

  private static $contact = [
    "company" => "CHATELET",
    "address1" => "25 De Mayo 202",
    "city" => "Moron",
    "state" => "Buenos Aires",
    "country" => "Argentina",
  ];

  public function initialize(Controller $controller) {
    $this->controller = $controller;
    $mailchimp = new \MailchimpMarketing\ApiClient();
    $mailchimp->setConfig([
      'apiKey' => getenv('MAILCHIMP_API_KEY'),
      'server' => getenv('MAILCHIMP_SERVER_PREFIX')
    ]);
    $this->mailchimp = $mailchimp;
    parent::initialize($controller);
  }

  public function lists() {
    try {
      $response = $this->mailchimp->lists->getAllLists();
      return $response;
    } catch (MailchimpMarketing\ApiException $e) {
      echo $e->getMessage();
    }
  }

  public function stores() {
    try {
      $response = $this->mailchimp->ecommerce->stores();
      return $response;
    } catch (MailchimpMarketing\ApiException $e) {
      echo $e->getMessage();
    }
  }

  public function test() {
    try {
      $response = $this->mailchimp->ecommerce->stores();
/*$response = $this->mailchimp->ecommerce->addStore([
    "id" => "d168ae47ee",
    "list_id" => "d168ae47ee",
    "name" => "CHATELET",
    "currency_code" => "ARS",
]);*/      
      return $response;
    } catch (MailchimpMarketing\ApiException $e) {
      echo $e->getMessage();
    }
  }

  public function subscribe($user, $audience) {
    // CakeLog::write('debug', 'user:'.json_encode($user));
    if(
      empty($user['surname']) && 
      (!empty($user['name']) || !empty($user['full_name']))
    ) {
      $nameparts = \nameparts($user['name'] ?? $user['full_name']);
      $user['name'] = $nameparts['name'];
      $user['surname'] = $nameparts['surname'];
    }

    try {
      $contact = [
        "email_address" => $user['email'],
        "status" => "subscribed",
        "merge_fields" => [
          "FNAME" => $user['name'],
          "LNAME" => $user['surname']
        ]
      ];
      // CakeLog::write('debug', 'contact:'.json_encode($contact));
      return $this->mailchimp->lists->setListMember($audience, $contact);
    } catch (MailchimpMarketing\ApiException $e) {
      echo $e->getMessage();
    }
  }
  
  public function update($cart=false, $cart_totals=false) {

    if (empty($cart)) {
      $cart = $this->controller->Session->read('cart');
    }

    if (empty($cart_totals)) {
      $cart_totals = $this->controller->Session->read('cart_totals');
    }
    
    $lines = [];

    try {
      foreach($cart as $i => $item) {
        $lines[] = [
          "id" => $i+1,
          "product_id" => $item['id'],
          "product_variant_id" => $item['id'],
          "quantity" => 1,
          "price" => $item['price'], 
        ];
      }

      $cart = [
        "id" => $cart_totals["cart_id"],
        "currency_code" => "ARS",
        "customer" => ["id" => $this->controller->Auth->user('id')],
        "order_total" => $cart_totals['grand_total'],
        "lines" => $lines,
      ];

      CakeLog::write('debug', 'cart:'.json_encode($cart));

      return $this->mailchimp->ecommerce->addStoreCart("d168ae47ee", $cart);

    } catch (MailchimpMarketing\ApiException $e) {
      echo $e->getMessage();
    }
// chatelet
  }

  public function order($order_id, $customer_id, $total, $items) {
    // $response = $client->ecommerce->setOrder("d168ae47ee", "order_id", [
    $lines = [];
    foreach($items as $i => $item) {
      $lines[] = [
        "id" => $i+1,
        "product_id" => $item['id'],
        "product_variant_id" => $item['id'],
        "quantity" => 1,
        "price" => $item['unit_price'], 
      ];
    }

    try {
      $response = $this->mailchimp->ecommerce->addStoreOrder("d168ae47ee", [
          "id" => $order_id,
          "customer" => ["id" => $customer_id,],
          "currency_code" => "ARS",
          "order_total" => $total,
          "lines" => [
              [
                  "id" => "id",
                  "product_id" => "product_id",
                  "product_variant_id" => "product_variant_id",
                  "quantity" => 23739,
                  "price" => 78420,
              ],
          ],
      ]);
    } catch (MailchimpMarketing\ApiException $e) {
      echo $e->getMessage();
    }
  }

  public function delete_cart($cart_id) {
    try {
      $response = $this->mailchimp->ecommerce->deleteStoreCart("d168ae47ee", $cart_id);
    } catch (MailchimpMarketing\ApiException $e) {
      echo $e->getMessage();
    }
  }
}
