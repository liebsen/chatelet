<?php

class MailchimpController extends AppController {
  public $uses = array('User','Setting', 'Product');
  public $components = array("Mailchimp", "RequestHandler");

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

    return json_encode($response->lists);
  }

  public function stores(){
    $this->RequestHandler->respondAs('application/json');
    $this->autoRender = false;

    $response = $this->Mailchimp->stores();

    return json_encode($response->stores);
  }

  public function sync_products(){
    $this->RequestHandler->respondAs('application/json');
    $this->autoRender = false;

    $products = $this->Product->find('all');

    $response = [];
    foreach($products as $item) {
      $response[] = $this->Mailchimp->add_product($item['Product']);
    }

    return json_encode($response);
  }
}
