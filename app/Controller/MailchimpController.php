<?php

class MailchimpController extends AppController {
  public $uses = array('User','Setting');
  public $components = array("Mailchimp", "RequestHandler");

  public function beforeFilter() {
    parent::beforeFilter();
  }

  public function test(){
    $response = $this->Mailchimp->test();
    echo '<pre>';
    var_dump($response);
    die();
  }

  public function lists(){
    $response = $this->Mailchimp->lists();
    echo '<pre>';
    var_dump($response);
    die();
  }

  public function stores(){
    $response = $this->Mailchimp->stores();
    echo '<pre>';
    print_r($response);
    die();
  }
}
