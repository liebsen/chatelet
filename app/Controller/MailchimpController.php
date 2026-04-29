<?php

class MailchimpController extends AppController {
  public $uses = array(
    'User',
    'Setting', 
    'Product'
  );
  
  public $components = array(
    // "Mailchimp", 
    "RequestHandler"
  );
  
  public function beforeFilter() {
    parent::beforeFilter();
  }

  public function test(){
    $this->RequestHandler->respondAs('application/json');
    $this->autoRender = false;
    
    $response = $this->Mailchimp->test();

    return json_encode($response->test);
  }

  public function lists(){
    $this->RequestHandler->respondAs('application/json');
    $this->autoRender = false;

    $response = $this->Mailchimp->lists();

    return json_encode($response);
  }

  public function stores(){
    $this->RequestHandler->respondAs('application/json');
    $this->autoRender = false;

    $response = $this->Mailchimp->stores();

    return json_encode($response);
  }

  public function store($id){
    $this->RequestHandler->respondAs('application/json');
    $this->autoRender = false;

    $response = $this->Mailchimp->store($id);

    return json_encode($response);
  }

  public function carts($store){
    $this->RequestHandler->respondAs('application/json');
    $this->autoRender = false;

    $response = $this->Mailchimp->carts($store);

    return json_encode($response);
  }

  public function products($store){
    $this->RequestHandler->respondAs('application/json');
    $this->autoRender = false;

    $response = $this->Mailchimp->products($store);

    return json_encode($response);
  }

  public function customers($store){
    $this->RequestHandler->respondAs('application/json');
    $this->autoRender = false;

    $response = $this->Mailchimp->customers($store);

    return json_encode($response);
  }

  public function sync_store($store){
    $this->RequestHandler->respondAs('application/json');
    $this->autoRender = false;

    $response = $this->Mailchimp->sync_store($store);

    return json_encode($response);
  }

  public function sync_products($store){
    $this->RequestHandler->respondAs('application/json');
    $this->autoRender = false;

    $products = $this->Product->find('all');

    $response = [];
    foreach($products as $item) {
      $response[] = $this->Mailchimp->add_product($store,$item['Product']);
    }

    return json_encode($response);
  }
}
