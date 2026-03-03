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
      'apiKey' => $this->controller->$settings['mailchimp_appkey'] ?? '',
      'server' => $this->controller->$settings['mailchimp_prefix'] ?? ''
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

  public function products($store) {
    try {
      $response = $this->mailchimp->ecommerce->getAllStoreProducts($store);
      return $response;
    } catch (MailchimpMarketing\ApiException $e) {
      echo $e->getMessage();
    }
  }

  public function customers($store) {
    try {
      $response = $this->mailchimp->ecommerce->getAllStoreCustomers($store);
      return $response;
    } catch (MailchimpMarketing\ApiException $e) {
      echo $e->getMessage();
    }
  }

  public function carts($store) {
    try {
      $response = $this->mailchimp->ecommerce->getStoreCarts($store);
      return $response;
    } catch (MailchimpMarketing\ApiException $e) {
      echo $e->getMessage();
    }
  }

  public function store($id) {
    try {
      $response = $this->mailchimp->ecommerce->getStore($id);
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

  public function sync_store($store) {
    try {
      $data = array(
        'domain' => "https://chatelet.com.ar",
        'email_address' => "news@chatelet.com.ar",
        'is_syncing' => false,
        'money_format' => "$",
        'primary_locale' => "es",
        'timezone' => "-3",
        'phone' => "11 2383 3032",
        'address' => array(
          "address1" => "25 De Mayo 202",
          "city" => "Moron",
          "province" => "Buenos Aires",
          "postal_code" => "1017",
          "country" => "Argentina",
          "country_code" => "ar",
        )
      );

      return $this->mailchimp->ecommerce->updateStore($store, $data);
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
  
  public function cart_update($store, $cart=false, $cart_totals=false) {
    if (empty($cart)) {
      $cart = $this->controller->Session->read('cart');
    }

    if (empty($cart_totals)) {
      $cart_totals = $this->controller->Session->read('cart_totals');
    }
    
    $lines = [];
    $user = $this->controller->Auth->user();
    try {
      $j=1;
      foreach($cart as $i => $item) {
        $lines[] = [
          "id" => (string) $j,
          "product_id" => (string) $item['id'],
          "product_variant_id" => (string) $item['id'],
          "quantity" => 1,
          "price" => (float) $item['price'], 
        ];
        $j++;
      }

      $cart_data = [
        "id" => (string) $cart_totals["cart_id"],
        "currency_code" => "ARS",
        "customer" => ["id" => (string) $user['id']],
        "order_total" => (float) $cart_totals['grand_total'],
        "lines" => $lines,
      ];

      //CakeLog::write('debug', 'cart_id:'.$cart_totals['cart_id']);
      //CakeLog::write('debug', 'cart_data:'.json_encode($cart_data));

      $response = $this->mailchimp->ecommerce->getStoreCarts($store);

      //CakeLog::write('debug', 'reponse:'.json_encode($response));

      $this->add_customer($store, $user);

      $cart_exists = false;

      foreach($response->carts as $cart_item) {
        if($cart_item->id == $cart_totals['cart_id']) {
          $cart_exists = true;
          break;
        }
      }

      if($cart_exists) {
        CakeLog::write('debug', 'updateStore:'.json_encode($cart_data));
        return $this->mailchimp->ecommerce->updateStoreCart($store, $cart_totals['cart_id'], $cart_data);
      } else {
        CakeLog::write('debug', 'addStore:'.json_encode($cart_data));
        return $this->mailchimp->ecommerce->addStoreCart($store, $cart_data);  
      }

    } catch (MailchimpMarketing\ApiException $e) {
      echo $e->getMessage();
    }
  }

  public function add_customer($store,$customer) {
    try {
      return $this->mailchimp->ecommerce->setStoreCustomer($store, $customer['id'], [
        "id" => $customer['id'],
        "opt_in_status" => true,
        "email_address" => $customer['email'],
        "first_name" => $customer['name'],
        "last_name" => $customer['surname'],
      ]);    
    } catch (MailchimpMarketing\ApiException $e) {
      echo $e->getMessage();
    }  
  }

  public function add_product($store,$item) {
    try {
      return $this->mailchimp->ecommerce->addStoreProduct($store, [
        "id" => $item['id'],
        "title" => $item['name'],
        "variants" => [["id" => $item['id'], "title" => $item['name']]],
      ]);
    } catch (MailchimpMarketing\ApiException $e) {
      echo $e->getMessage();
    }    
  }

  public function order($store, $order_id, $total, $sale_items) {
    // $response = $client->ecommerce->setOrder("d168ae47ee", "order_id", [
    $lines = [];
    $user = $this->controller->Auth->user();
    $j = 1;
    foreach($sale_items as $i => $item) {
      $lines[] = [
        "id" => (string) $j,
        "product_id" => (string) $item['id'],
        "product_variant_id" => (string) $item['id'],
        "quantity" => 1,
        "price" => (float) $item['precio_vendido'], 
      ];
      $j++;
    }

    CakeLog::write('debug', 'lines:'.json_encode($lines));
    try {
      return $this->mailchimp->ecommerce->addStoreOrder($store, [
        "id" => $order_id,
        "customer" => ["id" => $user['id']],
        "currency_code" => "ARS",
        "order_total" => $total,
        "lines" => $lines,
      ]);
    } catch (MailchimpMarketing\ApiException $e) {
      echo $e->getMessage();
    }
  }

  public function delete_cart($store, $cart_id) {
    try {
      $response = $this->mailchimp->ecommerce->getStoreCarts($store);

      //CakeLog::write('debug', 'reponse:'.json_encode($response));
      $cart_exists = false;

      foreach($response->carts as $cart_item) {
        if($cart_item->id == $cart_id) {
          $cart_exists = true;
          break;
        }
      }

      if($cart_exists) {
        return $this->mailchimp->ecommerce->deleteStoreCart($store, $cart_id);
      }
    } catch (MailchimpMarketing\ApiException $e) {
      echo $e->getMessage();
    }
  }
}
