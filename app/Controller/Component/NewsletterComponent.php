<?php

App::uses(
  'Model', 
  'Component', 
  'Controller', 
  'Session', 
  'Newsletter', 
  'NewsletterUser',
);

class NewsletterComponent extends Component {
  public $controller; // To store a reference to the Controller
  public function initialize(Controller $controller) {
    $this->controller = $controller;
    parent::initialize($controller);
  }

  public function emails() {
    $Newsletter = ClassRegistry::init('Newsletter');
    $response = array();
    try {
      $newsletters = $Newsletter->find('all', array(
        'joins' => array(
          array(
            'table' => 'newsletter_users',
            'alias' => 'NewsletterUser',
            'type' => 'LEFT',
            'conditions' => array( 'Newsletter.id = NewsletterUser.newsletter_id' )
          ),
          array(
            'table' => 'newsletter_products',
            'alias' => 'NewsletterProduct',
            'type' => 'LEFT',
            'conditions' => array( 'Newsletter.id = NewsletterProduct.newsletter_id' )
          ),
          array(
            'table' => 'newsletter_schedule',
            'alias' => 'NewsletterSchedule',
            'type' => 'LEFT',
            'conditions' => array( 'Newsletter.id = NewsletterSchedule.newsletter_id' )
          ),
        ),
        'fields' => array('Newsletter.*, NewsletterProduct.*, NewsletterSchedule.*,NewsletterUser.*'),
        'conditions' => array( 'Newsletter.created > ' => date("Y-m-d H:i", strtotime("last day of previous month"))),
        'order' => array( 'Newsletter.id DESC' )
      ));

      $user_total = 0;
      $prod_total = 0;

      foreach($newsletters as $newsletter) {
        $prod_total+= count($newsletter['NewsletterProduct']);
        $user_total+= count($newsletter['NewsletterUser']);
      }

      $response['prod_total'] = $prod_total;
      $response['user_total'] = $user_total;
      $this->controller->set('user_total', $user_total);
      $this->controller->set('prod_total', $prod_total);
      $this->controller->set('newsletters', $newsletters);
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public function schedule() {

    $Newsletter = ClassRegistry::init('Newsletter');
    $response = array();
    try {
      $newsletters = $Newsletter->find('all', array(
        'joins' => array(
          array(
            'table' => 'newsletter_users',
            'alias' => 'NewsletterUser',
            'type' => 'LEFT',
            'conditions' => array( 'Newsletter.id = NewsletterUser.newsletter_id' )
          ),
          array(
            'table' => 'newsletter_products',
            'alias' => 'NewsletterProduct',
            'type' => 'LEFT',
            'conditions' => array( 'Newsletter.id = NewsletterProduct.newsletter_id' )
          ),
          array(
            'table' => 'newsletter_schedule',
            'alias' => 'NewsletterSchedule',
            'type' => 'LEFT',
            'conditions' => array( 'Newsletter.id = NewsletterSchedule.newsletter_id' )
          ),
        ),
        'fields' => array('Newsletter.*, NewsletterProduct.*, NewsletterSchedule.*,NewsletterUser.*'),
        'conditions' => array( 'Newsletter.created > ' => date("Y-m-d H:i", strtotime("last day of previous month"))),
        'order' => array( 'Newsletter.id DESC' )
      ));

      $user_total = 0;
      $prod_total = 0;

      foreach($newsletters as $newsletter) {
        $prod_total+= count($newsletter['NewsletterProduct']);
        $user_total+= count($newsletter['NewsletterUser']);
      }

      $response['prod_total'] = $prod_total;
      $response['user_total'] = $user_total;
      $this->controller->set('user_total', $user_total);
      $this->controller->set('prod_total', $prod_total);
      $this->controller->set('newsletters', $newsletters);
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }
}
