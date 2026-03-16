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
    $NewsletterProduct = ClassRegistry::init('NewsletterProduct');
    $response = array();
    try {
      $newsletters = $Newsletter->find('all', array(
        'fields' => array('Newsletter.id, Newsletter.name, Newsletter.title, Newsletter.created'),
        'conditions' => array( 'Newsletter.created > ' => date("Y-m-d H:i", strtotime("last day of previous month"))),
        'order' => array( 'Newsletter.id DESC' )
      ));

      foreach($newsletters as $i => $newsletter) {
        $products = $NewsletterProduct->find('all', array(
          'joins' => array(
            array(
              'table' => 'products',
              'alias' => 'Product',
              'type' => 'LEFT',
              'conditions' => array( 'Product.id = NewsletterProduct.product_id' )
            ),
          ),
          'fields' => array('NewsletterProduct.*, Product.*'),
          'conditions' => array( 'NewsletterProduct.newsletter_id' => $newsletter['Newsletter']['id']),
          'order' => array( 'NewsletterProduct.id DESC' )
        ));
        $newsletters[$i]['Products'] = $products;
      }

      $this->controller->set('newsletters', $newsletters);
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public function emails_edit($id) {
    $Newsletter = ClassRegistry::init('Newsletter');
    $NewsletterProduct = ClassRegistry::init('NewsletterProduct');
    $response = array();
    try {
      $newsletter = $Newsletter->find('first', array(
        'conditions' => array( 'Newsletter.id' => $id),
        // 'order' => array( 'Newsletter.id DESC' )
      ));

      $newsletter_products = $NewsletterProduct->find('all', array(
        'joins' => array(
          array(
            'table' => 'products',
            'alias' => 'Product',
            'type' => 'LEFT',
            'conditions' => array( 'Product.id = NewsletterProduct.product_id' )
          ),
        ),
        'fields' => array('NewsletterProduct.*, Product.*'),
        'conditions' => array( 'NewsletterProduct.newsletter_id' => $id),
        // 'order' => array( 'Newsletter.id DESC' )
      ));
      
      $this->controller->set('newsletter', $newsletter);
      $this->controller->set('newsletter_products', $newsletter_products);
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public function schedules() {
    $NewsletterProduct = ClassRegistry::init('NewsletterProduct');
    $NewsletterUser = ClassRegistry::init('NewsletterUser');
    $NewsletterSchedule = ClassRegistry::init('NewsletterSchedule');
    $response = array();
    try {
      $schedules = $NewsletterSchedule->find('all', array(
        'joins' => array(
          array(
            'table' => 'newsletters',
            'alias' => 'Newsletter',
            'type' => 'LEFT',
            'conditions' => array( 'Newsletter.id = NewsletterSchedule.newsletter_id' )
          ),
        ),        
        'fields' => array('Newsletter.*, NewsletterSchedule.*'),
        'conditions' => array( 'NewsletterSchedule.created > ' => date("Y-m-d H:i", strtotime("last day of previous month"))),
        'order' => array( 'NewsletterSchedule.id DESC' )
      ));

      foreach($schedules as $i => $schedule) {
        $products = $NewsletterProduct->find('all', array(
          'joins' => array(
            array(
              'table' => 'products',
              'alias' => 'Product',
              'type' => 'LEFT',
              'conditions' => array( 'Product.id = NewsletterProduct.product_id' )
            ),
          ),
          'fields' => array('NewsletterProduct.*, Product.*'),
          'conditions' => array( 'NewsletterProduct.newsletter_id' => $schedule['Newsletter']['id']),
          'order' => array( 'NewsletterProduct.id DESC' )
        ));

        $users = $NewsletterUser->find('all', array(
          'joins' => array(
            array(
              'table' => 'users',
              'alias' => 'User',
              'type' => 'LEFT',
              'conditions' => array( 'User.id = NewsletterUser.user_id' )
            ),
          ),
          'fields' => array('NewsletterUser.*, User.*'),
          'conditions' => array( 'NewsletterUser.newsletter_id' => $schedule['Newsletter']['id']),
          'order' => array( 'NewsletterUser.id DESC' )
        ));


        $schedules[$i]['Users'] = $users;
        $schedules[$i]['Products'] = $products;
      }



      $user_total = 0;
      $prod_total = 0;

      foreach($schedules as $schedule) {
        $prod_total+= count($schedule['NewsletterProduct']);
        $user_total+= count($schedule['NewsletterUser']);
      }

      $response['prod_total'] = $prod_total;
      $response['user_total'] = $user_total;
      $this->controller->set('user_total', $user_total);
      $this->controller->set('prod_total', $prod_total);
      $this->controller->set('schedules', $schedules);
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public function schedules_edit($id) {
    $NewsletterSchedule = ClassRegistry::init('NewsletterSchedule');
    $NewsletterProduct = ClassRegistry::init('NewsletterProduct');
    $NewsletterUser = ClassRegistry::init('NewsletterUser');
    $response = array();
    try {
      $schedule = $NewsletterSchedule->find('first', array(
        'joins' => array(
          array(
            'table' => 'newsletters',
            'alias' => 'Newsletter',
            'type' => 'LEFT',
            'conditions' => array( 'Newsletter.id = NewsletterSchedule.newsletter_id' )
          ),
        ),
        'fields' => array('NewsletterSchedule.*, Newsletter.*'),
        'conditions' => array( 'NewsletterSchedule.id' => $id),
        // 'order' => array( 'Newsletter.id DESC' )
      ));

      $schedule_products = $NewsletterProduct->find('all', array(
        'joins' => array(
          array(
            'table' => 'products',
            'alias' => 'Product',
            'type' => 'LEFT',
            'conditions' => array( 'Product.id = NewsletterProduct.product_id' )
          ),
        ),
        'fields' => array('NewsletterProduct.*, Product.*'),
        'conditions' => array( 'NewsletterProduct.newsletter_id' => $id),
        // 'order' => array( 'Newsletter.id DESC' )
      ));

      $schedule_users = $NewsletterUser->find('all', array(
        'joins' => array(
          array(
            'table' => 'users',
            'alias' => 'User',
            'type' => 'LEFT',
            'conditions' => array( 'User.id = NewsletterUser.user_id' )
          ),
        ),
        'fields' => array('NewsletterUser.*, User.name, User.surname, User.city, User.province, User.birthday, User.created'),
        'conditions' => array( 'NewsletterUser.newsletter_id' => $id),
        // 'order' => array( 'Newsletter.id DESC' )
      ));

      $schedule['NewsletterSchedule']['filter'] =  json_decode($schedule['NewsletterSchedule']['filter'])[0];
      $schedule['NewsletterProduct'] =  array_column($schedule_products, 'NewsletterProduct');
      $schedule['NewsletterUser'] = array_column($schedule_users, 'NewsletterUser');
      
      $this->controller->set('schedule', $schedule);
      $this->controller->set('schedule_products', $schedule_products);
      $this->controller->set('schedule_users', $schedule_users);
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }
}
