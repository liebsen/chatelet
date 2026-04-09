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
    $User = ClassRegistry::init('User');

    $club_total = $User->find('count', 
      array(
        'conditions' => array(
          'User.role' => 'club',
        )
      )
    );

    $users_total = $User->find('count', 
      array(
        'conditions' => array(
          'or' => array(
            'User.role <>' => 'admin',
            'User.role is null'
          )
        )
      )
    );
    
    $this->controller->set('club_total', $club_total);
    $this->controller->set('users_total', $users_total);

    parent::initialize($controller);
  }

  public function index($value=''){
    $Newsletter = ClassRegistry::init('Newsletter');
    $NewsletterSchedule = ClassRegistry::init('NewsletterSchedule');
    $NewsletterList = ClassRegistry::init('NewsletterList');
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

    $lists_count = $NewsletterList->find('count', array(
      'conditions' => array(
        'enabled' => 1
      ),
    ));

    $this->controller->set('counts', 
      array(
        'templates' => $templates_count,
        'schedules' => $schedules_count,
        'lists' => $lists_count,
      )
    );
  }

  public function config() {
    if($this->controller->request->is('post')){
      $Setting = ClassRegistry::init('Setting');
      $data = $this->controller->request->data;
      $redirect = array( 'action' => 'newsletters');

      foreach($data as $id => $value) {
        if(is_array($value) && ($id == 'newsletter_logo' || $id == 'newsletter_badge')) {
          $value = $this->controller->save_file( $value );  
          CakeLog::write('debug', 'file:'. json_encode(['id' => $id, 'value' => $value]));
        }
        CakeLog::write('debug', 'save:'. json_encode(['id' => $id, 'value' => $value]));
        $Setting->save(
          array(
            'id' => $id, 
            'value' => $value
          )
        );
      }

      if(isset($data['x_coord']) && $data['x_coord'] == '1') {
        $redirect = array('action' => 'newsletters', 'config');
      }

      return $this->controller->redirect($redirect);
    }
  }

  public function templates() {
    $Newsletter = ClassRegistry::init('Newsletter');
    $NewsletterProduct = ClassRegistry::init('NewsletterProduct');
    $NewsletterSchedule = ClassRegistry::init('NewsletterSchedule');
    $response = array();
    $conditions = array(
      //'Newsletter.created > ' => date("Y-m-d H:i", strtotime("last day of previous month"))
    );

    if(empty($_GET['extended'])) {
      $conditions['Newsletter.enabled'] = 1;
    }

    try {
      $newsletters = $Newsletter->find('all', array(
        'fields' => array('Newsletter.id, Newsletter.title, Newsletter.created'),
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
            'Product.id IS NOT NULL',
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

  public function templates_delete() {
    $Newsletter = ClassRegistry::init('Newsletter');
    try {
      if($this->controller->request->is('post')){
        $data = $this->controller->request->data;
        $Newsletter->delete($data['id']);
      }
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
        $redirect = array( 'action' => 'newsletters', 'templates');

        if(empty($data['id'])) {
          $data['user_id'] = $this->controller->Auth->user('id');
        }

        //\d("Newsletter(data)", $data);
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
          'conditions' => array( 
            'NewsletterProduct.newsletter_id' => $id,
            'Product.id IS NOT NULL',
          ),
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
    $NewsletterSchedule = ClassRegistry::init('NewsletterSchedule');
    $NewsletterScheduleItem = ClassRegistry::init('NewsletterScheduleItem');
    $response = array();
    $conditions = array(); // array('NewsletterSchedule.created > ' => date("Y-m-d H:i", strtotime("last day of previous month")));
    if(empty($_GET['extended'])) {
      $conditions['NewsletterSchedule.enabled'] = 1;
    }

    try {
      $schedules = $NewsletterSchedule->find('all', array(
        'joins' => array(
          array(
            'table' => 'newsletter_lists',
            'alias' => 'NewsletterList',
            'type' => 'LEFT',
            'conditions' => array('NewsletterList.id = NewsletterSchedule.list_id')
          ),
          /*array(
            'table' => 'newsletter_users',
            'alias' => 'NewsletterUser',
            'type' => 'LEFT',
            'conditions' => array(
              'NewsletterUser.list_id = NewsletterList.id',
            )
          ),*/
          array(
            'table' => 'newsletters',
            'alias' => 'Newsletter',
            'type' => 'LEFT',
            'conditions' => array('Newsletter.id = NewsletterSchedule.newsletter_id')
          ),          
          array(
            'table' => 'newsletter_products',
            'alias' => 'NewsletterProduct',
            'type' => 'LEFT',
            'conditions' => array(
              'NewsletterProduct.newsletter_id = Newsletter.id',
            )
          ),
        ),        
        'fields' => array(
          'NewsletterSchedule.id, Newsletter.id, NewsletterList.id, Newsletter.title, NewsletterList.name, NewsletterSchedule.schedule_date, NewsletterSchedule.schedule_hour, NewsletterSchedule.enabled, NewsletterSchedule.send_push, NewsletterSchedule.send_email, COUNT(distinct NewsletterProduct.id) as prod_total'
        ),
        'conditions' => $conditions,
        'group' => array(
          'NewsletterSchedule.id, Newsletter.id, NewsletterList.id, Newsletter.title, NewsletterList.name, NewsletterSchedule.schedule_date, NewsletterSchedule.schedule_hour, NewsletterSchedule.enabled, NewsletterSchedule.send_push, NewsletterSchedule.send_email'
        ),
        'order' => array( 
          'NewsletterSchedule.schedule_date DESC, NewsletterSchedule.schedule_hour DESC' 
        )
      ));

      // \d("schedules",$schedules);
      foreach($schedules as $i => $schedule) {
        $push_total = 0;
        $email_total = 0;
        $push_sent = 0;
        $email_sent = 0;
        /*$products = $NewsletterProduct->find('all', array(
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
            'NewsletterProduct.newsletter_id' => $schedule['Newsletter']['id'],
            'Product.id IS NOT NULL',
          ),
          'order' => array( 'NewsletterProduct.id DESC' )
        ));*/

        $users = $NewsletterScheduleItem->find('all', array(
          'joins' => array(
            array(
              'table' => 'users',
              'alias' => 'User',
              'type' => 'LEFT',
              'conditions' => array( 'User.id = NewsletterScheduleItem.user_id' )
            ),
          ),
          'fields' => array('NewsletterScheduleItem.*, User.*'),
          'conditions' => array( 
            'NewsletterScheduleItem.schedule_id' => $schedule['NewsletterSchedule']['id'],
            'User.id IS NOT NULL',
          ),
          'order' => array( 'NewsletterScheduleItem.created DESC' )
        ));

        foreach($users as $user) {
          $email_total+= 1;
          $push_total+= 1;
          if($user['NewsletterScheduleItem']['status'] === 'sent') {
            $email_sent+= $user['NewsletterScheduleItem']['email_sent'];
            $push_sent+= $user['NewsletterScheduleItem']['push_sent'];
          }
        }

        $timestamp1 = strtotime($schedule['NewsletterSchedule']['schedule_date'].' '.$schedule['NewsletterSchedule']['schedule_hour'].':00');
        $timestamp2 = strtotime("now");
        $difference_seconds = $timestamp2 - $timestamp1; // Use abs() for absolute difference
        $difference_hours = $difference_seconds / 3600;
        $rowclass = 'neutral';
        $status = 'Inactivo';

        //\d("difference_hours",$difference_hours);
        if ($difference_hours > 0) {
          $rowclass = 'warning';
          $status = 'Procesando';
          if($push_sent >= $push_total || $email_sent >= $email_total) {
            $rowclass = 'success';
            $status = 'Procesado';
          } 
        } else {
          if($schedule['NewsletterSchedule']['enabled']) {
            $rowclass = 'success';
            $status = 'Activo';
          }
        }

        if(empty($schedule['NewsletterSchedule']['enabled'])) {
          // $rowclass = 'danger';
        }
        
        if(
          empty($schedule['NewsletterSchedule']['send_email']) && 
          empty($schedule['NewsletterSchedule']['send_push'])
        ) {
          $rowclass = 'danger';
          $status = 'Sin método asignado';
        }

        $schedules[$i]['stats'] = array(
          'email_sent' => $email_sent,
          'push_sent' => $push_sent,
          'email_total' => $email_total,
          'push_total' => $push_total,
          // 'total' => count($users),
        );

        $schedules[$i]['status'] = $status;
        $schedules[$i]['rowclass'] = $rowclass;
        $schedules[$i][0]['list_total'] = count($users);
        // $schedules[$i]['Users'] = $users;
        // $schedules[$i]['Products'] = $products;
      }

      //$this->controller->set('user_total', $user_total);
      //$this->controller->set('prod_total', $prod_total);
      $this->controller->set('schedules', $schedules);
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public function schedules_delete() {
    $NewsletterSchedule = ClassRegistry::init('NewsletterSchedule');
    //$NewsletterUser = ClassRegistry::init('NewsletterUser');
    try {
      if($this->controller->request->is('post')){
        $data = $this->controller->request->data;
        /*$schedule = $NewsletterSchedule->find('first', array(
          'conditions' => array(
            'NewsletterSchedule.id' => $data['id']
          )
        ));*/
        //$NewsletterUser->deleteAll(array('User.list_id' => $schedule['NewsletterSchedule']['list_id']), false);
        $NewsletterSchedule->delete($data['id']);
      }
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public function schedules_edit($id) {
    $Newsletter = ClassRegistry::init('Newsletter');
    $NewsletterSchedule = ClassRegistry::init('NewsletterSchedule');
    $NewsletterList = ClassRegistry::init('NewsletterList');
    $NewsletterUser = ClassRegistry::init('NewsletterUser');
    #$NewsletterProduct = ClassRegistry::init('NewsletterProduct');
    $NewsletterScheduleItem = ClassRegistry::init('NewsletterScheduleItem');
    $schedule = array();
    try {
      if($this->controller->request->is('post')){
        $data = $this->controller->request->data;
        $resend_all = !empty($data['resend_all']) ? 1 : 0;
        $data['id'] = $data['id'] ?? NULL;
        $data['enabled'] = !empty($data['enabled']) ? 1 : 0;
        $data['send_email'] = !empty($data['send_email']) ? 1 : 0;
        $data['send_push'] = !empty($data['send_push']) ? 1 : 0;
        $redirect = array( 'action' => 'newsletters', 'schedules' );
        $create = empty($id);
        $NewsletterSchedule->save($data);

        // reset recipients
        if(
          !empty($data['reset']) && 
          !empty($data['reset_all'])
        ) {
          $NewsletterScheduleItem->updateAll(
            array(
              'NewsletterScheduleItem.status' => "'pending'",
              'NewsletterScheduleItem.push_sent' => 0,
              'NewsletterScheduleItem.email_sent' => 0,
            ),
            array(
              'NewsletterScheduleItem.schedule_id' => $id,
            )
          );
        }

        // update schedule reference
        $users = array();

        if($create) {
          $users = $NewsletterUser->find('all', array(
            'conditions' => array(
              'list_id' => $data['list_id']
            )
          ));
        } else {
          $users = $NewsletterScheduleItem->find('all', array(
            'conditions' => array(
              'schedule_id' => $id
            )
          ));          
        }

        $saves = array();

        foreach($users as $i => $user) {
          $save = $create ? $user['NewsletterUser'] : $user['NewsletterScheduleItem'];
          $save['id'] = $create ? null : $save['id'];
          $save['schedule_id'] = $NewsletterSchedule->id;
          if(!$create){
            if(
              !empty($data['reset']) && 
              empty($data['reset_all'])
            ) {
              $save['push_sent'] = 0;
              $save['email_sent'] = 0;
              $save['status'] = 'pending';
            }
          }
          //\d("save",$save);
          array_push($saves, $save);
        }

        $NewsletterScheduleItem->saveAll($saves, 
          array(
            'validate' => false, 
            'callbacks' => false
          )
        );

        if(isset($data['x_coord']) && $data['x_coord'] == '1') {
          $redirect = array( 'action' => 'newsletters', 'schedules', 'edit', $NewsletterSchedule->id);
        }

        return $this->controller->redirect($redirect);
      }

      if(!$create) {
        $this->controller->set('schedule', $NewsletterSchedule->find('first', array(
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
        )));

        /*$schedule_products = $NewsletterProduct->find('all', array(
          'joins' => array(
            array(
              'table' => 'products',
              'alias' => 'Product',
              'type' => 'LEFT',
              'conditions' => array( 'Product.id = NewsletterProduct.product_id' )
            ),
          ),
          'fields' => array('Product.*'),
          'conditions' => array( 
            'NewsletterProduct.newsletter_id' => $schedule['Newsletter']['id'],
            'Product.id IS NOT NULL',
          ),
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
          'conditions' => array( 
            'NewsletterUser.list_id' => $schedule['NewsletterSchedule']['list_id'],
            'User.id IS NOT NULL',
          ),
          // 'order' => array( 'Newsletter.id DESC' )
        ));*/
        #$schedule['NewsletterSchedule']['filter'] = json_decode($schedule['NewsletterSchedule']['filter']);
        #$schedule['NewsletterProduct'] =  array_column($schedule_products, 'NewsletterProduct');
        #$schedule['NewsletterUser'] = array_column($schedule_users, 'NewsletterUser');
      } 

      $this->controller->set('newsletters', $Newsletter->find('all', array(
        'joins' => array(
          array(
            'table' => 'newsletter_products',
            'alias' => 'NewsletterProduct',
            'type' => 'LEFT',
            'conditions' => array( 'Newsletter.id = NewsletterProduct.newsletter_id' )
          ),
        ),
        'fields' => array('Newsletter.id, Newsletter.title, Newsletter.created, COUNT(NewsletterProduct.id) AS total'),
        'conditions' => array(
          // 'Newsletter.created > ' => date("Y-m-d H:i", strtotime("last day of previous month")),
          'Newsletter.enabled' => '1',
          //'NewsletterProduct.id IS NOT NULL',
        ),
        'group' => array('Newsletter.id, Newsletter.title, Newsletter.created'),
        'order' => array( 'Newsletter.modified DESC' )
      )));

      $this->controller->set('lists', $NewsletterList->find('all', array(

        'joins' => array(
          array(
            'table' => 'newsletter_users',
            'alias' => 'NewsletterUser',
            'type' => 'LEFT',
            'conditions' => array( 'NewsletterList.id = NewsletterUser.list_id' )
          ),
        ),
        'fields' => array('NewsletterList.id, NewsletterList.name, NewsletterList.text, NewsletterList.created, COUNT(NewsletterUser.id) AS total'),
        'conditions' => array( 
          'NewsletterList.enabled' => 1,
          'NewsletterUser.id IS NOT NULL',
        ),
        'group' => array('NewsletterList.id, NewsletterList.name, NewsletterList.text, NewsletterList.created'),
        'order' => array( 'NewsletterList.modified DESC' )
      )));

      #$this->controller->set('schedule', $schedule);
      #$this->controller->set('schedule_products', $schedule_products);
      #$this->controller->set('schedule_users', $schedule_users);
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public function lists() {
    $NewsletterList = ClassRegistry::init('NewsletterList');
    $NewsletterUser = ClassRegistry::init('NewsletterUser');
    $response = array();
    $conditions = array('NewsletterList.id IS NOT NULL',); // array('NewsletterSchedule.created > ' => date("Y-m-d H:i", strtotime("last day of previous month")));
    if(empty($_GET['extended'])) {
      $conditions['NewsletterList.enabled'] = 1;
    }

    try {
      $lists = $NewsletterList->find('all', array(
        'joins' => array(
          array(
            'table' => 'newsletter_users',
            'alias' => 'NewsletterUser',
            'type' => 'LEFT',
            'conditions' => array('NewsletterList.id = NewsletterUser.list_id'),
            //'fields' => array('NewsletterUser.id'),
          ),
        ),        
        'fields' => array('NewsletterList.id, NewsletterList.name, NewsletterList.text, NewsletterList.modified, COUNT(NewsletterUser.id) as total'),
        'conditions' => $conditions,
        'group' => array('NewsletterList.id, NewsletterList.name, NewsletterList.text, NewsletterList.modified'),
        'order' => array( 'NewsletterList.modified DESC' )
      ));

      $this->controller->set('lists', $lists);
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public function lists_delete() {
    $NewsletterSchedule = ClassRegistry::init('NewsletterSchedule');
    $NewsletterList = ClassRegistry::init('NewsletterList');
    try {
      if($this->controller->request->is('post')){
        $data = $this->controller->request->data;

        /*$NewsletterSchedule->updateAll(array(
          'list_id' => null,
        ), array(
          'list_id' => $data['id']
        ));*/

        $NewsletterUser->deleteAll(array(
          'list_id' => $data['id']
        ));
        $NewsletterList->delete($data['id']);
      }
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public function lists_edit($id) {
    $NewsletterList = ClassRegistry::init('NewsletterList');
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

        $redirect = array( 'action' => 'newsletters', 'lists' );

        $NewsletterList->save($data);

        if(empty($data['id']) || isset($data['x_coord']) && $data['x_coord'] == '1') {
          $redirect = array( 'action' => 'newsletters', 'lists', 'edit', $NewsletterList->id);
        }

        return $this->controller->redirect($redirect);
      }

      if(!empty($id)) {
        $list = $NewsletterList->find('first', array(
          'conditions' => array( 'NewsletterList.id' => $id),
          'order' => array( 'NewsletterList.modified DESC' )
        ));

        $list['NewsletterList']['filter'] = json_decode($list['NewsletterList']['filter']);

        $this->controller->set('list', $list);
        $this->controller->set('list_users', $NewsletterUser->find('all', array(
          'joins' => array(
            array(
              'table' => 'users',
              'alias' => 'User',
              'type' => 'LEFT',
              'conditions' => array( 
                'User.id = NewsletterUser.user_id' 
              )
            ),
          ),
          'fields' => array('User.id, User.email, User.name, User.surname, User.city, User.province, User.birthday, User.created'),
          'conditions' => array( 
            'NewsletterUser.list_id' => $id,
            'User.id IS NOT NULL',
          ),
          // 'order' => array( 'Newsletter.id DESC' )
        )));
      }
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }  
}
