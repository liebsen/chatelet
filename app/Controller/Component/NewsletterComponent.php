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

  public function index($value=''){
    $Newsletter = ClassRegistry::init('Newsletter');
    $NewsletterSchedule = ClassRegistry::init('NewsletterSchedule');
    $templates_count = $Newsletter->find('count', array(
      'conditions' => array(
        'enabled' => 1
      ),
    ));

    $schedules_count = $NewsletterSchedule->find('count', array(
      'conditions' => array(
        'enabled' => 1
      ),
    ));

    $this->controller->set('counts', 
      array(
        'templates' => $templates_count,
        'schedules' => $schedules_count
      )
    );
  }

  public function templates() {
    $Newsletter = ClassRegistry::init('Newsletter');
    $NewsletterProduct = ClassRegistry::init('NewsletterProduct');
    $NewsletterSchedule = ClassRegistry::init('NewsletterSchedule');
    $response = array();
    $conditions = array(
      'Newsletter.created > ' => date("Y-m-d H:i", strtotime("last day of previous month"))
    );

    if(empty($_GET['extended'])) {
      $conditions['Newsletter.enabled'] = 1;
    }

    try {
      $newsletters = $Newsletter->find('all', array(
        'fields' => array('Newsletter.id, Newsletter.name, Newsletter.title, Newsletter.created'),
        'conditions' => $conditions,
        'order' => array( 'Newsletter.modified DESC' )
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
          'conditions' => array( 
            'NewsletterProduct.newsletter_id' => $newsletter['Newsletter']['id'],
          ),
          'order' => array( 'NewsletterProduct.id DESC' )
        ));

        $schedules = $NewsletterSchedule->find('all', array(
          'fields' => array('NewsletterSchedule.*'),
          'conditions' => array( 'NewsletterSchedule.newsletter_id' => $newsletter['Newsletter']['id']),
          'order' => array( 'NewsletterSchedule.id DESC' )
        ));
        /*$start = new \DateTime($newsletter['Newsletter']['modified']);
        $end = new \DateTime("now");
        $interval = $end->diff($start);
        $days = $interval->d;
        \d("days", $days);
        if ($days < 1) {
          $newsletters[$i]['Newsletter']['recent'] = 1;
        }*/

        $newsletters[$i]['NewsletterProduct'] = $products;
        $newsletters[$i]['NewsletterSchedule'] = $schedules;
      }

      $this->controller->set('newsletters', $newsletters);
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public function templates_edit($id) {
    $Newsletter = ClassRegistry::init('Newsletter');
    $NewsletterProduct = ClassRegistry::init('NewsletterProduct');
    $newsletter = array();
    $newsletter_products = array();
    try {
      if($this->controller->request->is('post')){
        $data = $this->controller->request->data;
        $data['id'] = $data['id'] ?? NULL;
        $data['enabled'] = !empty($data['enabled']) ? 1 : 0;
        $redirect = array( 'action' => 'newsletters');

        if(empty($data['id'])) {
          $data['user_id'] = $this->controller->Auth->user('id');
        }

        //\d("data", $data);
        //\d("redirect", $redirect);

        $Newsletter->save($data);

        if(isset($data['x_coord']) && $data['x_coord'] == '1') {
          $redirect = array( 'action' => 'newsletters', 'templates', 'edit', $Newsletter->id);
        }

        // $this->response->statusCode(200);
        return $this->controller->redirect($redirect);
      }

      if(!empty($id)) {
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
      }
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
    $conditions = array('NewsletterSchedule.created > ' => date("Y-m-d H:i", strtotime("last day of previous month")));
    if(empty($_GET['extended'])) {
      $conditions['NewsletterSchedule.enabled'] = 1;
    }

    try {
      $schedules = $NewsletterSchedule->find('all', array(
        'joins' => array(
          array(
            'table' => 'newsletters',
            'alias' => 'Newsletter',
            'type' => 'LEFT',
            'conditions' => array('Newsletter.id = NewsletterSchedule.newsletter_id')
          ),
        ),        
        'fields' => array('Newsletter.*, NewsletterSchedule.*'),
        'conditions' => $conditions,
        'order' => array( 'NewsletterSchedule.schedule_date DESC, NewsletterSchedule.schedule_hour DESC' )
      ));

      foreach($schedules as $i => $schedule) {
        $push_sent = 0;
        $email_sent = 0;

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
          'conditions' => array( 'NewsletterUser.schedule_id' => $schedule['NewsletterSchedule']['id']),
          'order' => array( 'NewsletterUser.created DESC' )
        ));

        foreach($users as $user) {
          $email_sent+= $user['NewsletterUser']['email_sent'];
          $push_sent+= $user['NewsletterUser']['push_sent'];
        }

        $rowclass = '';
        $timestamp1 = strtotime($schedule['NewsletterSchedule']['schedule_date'].' '.$schedule['NewsletterSchedule']['schedule_hour'].':00');
        $timestamp2 = strtotime("now");
        $difference_seconds = $timestamp2 - $timestamp1; // Use abs() for absolute difference
        $difference_hours = $difference_seconds / 3600;
        $status = 'Inactivo';

        if ($difference_hours > 0) {
          $rowclass = 'bg-light';
          $status = 'Procesado';          
        } else {
          if($schedule['NewsletterSchedule']['enabled']) {
            $rowclass = 'bg-success';
            $status = 'Activo';
          }
        }

        if(empty($schedule['NewsletterSchedule']['enabled'])) {
          // $rowclass = 'bg-danger';
        }
        
        if(
          empty($schedule['NewsletterSchedule']['send_email']) && 
          empty($schedule['NewsletterSchedule']['send_push'])
        ) {
          $rowclass = 'bg-danger';
          $status = 'Sin método asignado';
        }

        $schedules[$i]['stats'] = array(
          'email_sent' => $email_sent,
          'push_sent' => $push_sent,
          'total' => count($users),
        );

        $schedules[$i]['status'] = $status;
        $schedules[$i]['rowclass'] = $rowclass;
        $schedules[$i]['Users'] = $users;
        $schedules[$i]['Products'] = $products;
      }

      $this->controller->set('user_total', $user_total);
      $this->controller->set('prod_total', $prod_total);
      $this->controller->set('schedules', $schedules);
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public function schedules_edit($id) {
    $Newsletter = ClassRegistry::init('Newsletter');
    $NewsletterSchedule = ClassRegistry::init('NewsletterSchedule');
    $NewsletterProduct = ClassRegistry::init('NewsletterProduct');
    $NewsletterUser = ClassRegistry::init('NewsletterUser');
    $schedule = array();
    $schedule_users = array();
    $schedule_products = array();
    
    try {
      if($this->controller->request->is('post')){
        $data = $this->controller->request->data;
        $data['id'] = $data['id'] ?? NULL;
        $data['filter'] = json_encode($data['filter']);
        $data['enabled'] = !empty($data['enabled']) ? 1 : 0;
        $data['send_email'] = !empty($data['send_email']) ? 1 : 0;
        $data['send_push'] = !empty($data['send_push']) ? 1 : 0;
        $redirect = array( 'action' => 'newsletters', 'schedules' );

        // reset recipients
        $NewsletterUser->updateAll(
          array(
            'NewsletterUser.status' => "'pending'"
          ),
          array(
            'NewsletterUser.schedule_id' => $id,
          )
        );

        $NewsletterSchedule->save($data);

        if(isset($data['x_coord']) && $data['x_coord'] == '1') {
          $redirect = array( 'action' => 'newsletters', 'schedules', 'edit', $NewsletterSchedule->id);
        }

        return $this->controller->redirect($redirect);
      }


      if(!empty($id)) {
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
          'fields' => array('Product.*'),
          'conditions' => array( 'NewsletterProduct.newsletter_id' => $schedule['Newsletter']['id']),
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
          'fields' => array('User.id, User.email, User.name, User.surname, User.city, User.province, User.birthday, User.created'),
          'conditions' => array( 'NewsletterUser.schedule_id' => $schedule['NewsletterSchedule']['id']),
          // 'order' => array( 'Newsletter.id DESC' )
        ));
        $schedule['NewsletterSchedule']['filter'] = json_decode($schedule['NewsletterSchedule']['filter']);
        $schedule['NewsletterProduct'] =  array_column($schedule_products, 'NewsletterProduct');
        $schedule['NewsletterUser'] = array_column($schedule_users, 'NewsletterUser');
      } else {
        $this->controller->set('newsletters', $Newsletter->find('all', array(
          'joins' => array(
            array(
              'table' => 'users',
              'alias' => 'User',
              'type' => 'LEFT',
              'conditions' => array( 'User.id = Newsletter.user_id' )
            ),
          ),
          'fields' => array('Newsletter.id, Newsletter.name, Newsletter.title, Newsletter.created, User.name, User.surname'),
          'conditions' => array(
            'Newsletter.created > ' => date("Y-m-d H:i", strtotime("last day of previous month")),
            'Newsletter.enabled' => '1'
          ),
          'order' => array( 'Newsletter.modified DESC' )
        )));
      }
      $this->controller->set('schedule', $schedule);
      $this->controller->set('schedule_products', $schedule_products);
      $this->controller->set('schedule_users', $schedule_users);
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }
}
