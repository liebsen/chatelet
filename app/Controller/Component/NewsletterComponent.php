<?php

App::uses(
  'Model', 
  'Component', 
  'Controller', 
  'Session', 
  'Stat', 
  'Newsletter', 
  'NewsletterUser',
);

#App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
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
      $this->controller->autoRender = false;
      $this->controller->RequestHandler->respondAs('application/json');      
      $Setting = ClassRegistry::init('Setting');
      $data = $this->controller->request->data;
      $redirect = array( 'action' => 'newsletters');
      
      foreach($data as $id => $value) {
        if(is_array($value) && ($id == 'newsletter_icon' || $id == 'newsletter_badge')) {
          $value = $this->controller->save_file( $value );  
          #CakeLog::write('debug', 'file:'. json_encode(['id' => $id, 'value' => $value]));
        }
        #CakeLog::write('debug', 'save:'. json_encode(['id' => $id, 'value' => $value]));
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

      $response = array(
        'success' => true,
        'message' => 'La nueva configuración se actualizó exitosamente',
        'redirect' => Router::reverse($redirect)
      );

      return json_encode($response);
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

    if(empty($this->controller->request->query['extended'])) {
      $conditions['Newsletter.enabled'] = 1;
      $conditions['Newsletter.user_id'] = $this->controller->Auth->user('id');
    }

    try {
      $newsletters = $Newsletter->find('all', 
        array(
          'joins' => array(
            array(
              'table' => 'users',
              'alias' => 'User',
              'type' => 'LEFT',
              'conditions' => array( 'User.id = Newsletter.user_id' )
            ),
          ),          
          'fields' => array('Newsletter.id, Newsletter.title,Newsletter.body,Newsletter.send_email, Newsletter.send_push, Newsletter.created, Newsletter.modified, Newsletter.enabled, User.id, User.email, User.name, User.surname'),
          'conditions' => $conditions,
          'order' => array( 'Newsletter.modified DESC' )
        )
      );

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
    $NewsletterProduct = ClassRegistry::init('NewsletterProduct');
    $NewsletterSchedule = ClassRegistry::init('NewsletterSchedule');
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
        #\d("ok",$id);
        $this->controller->autoRender = false;
        $this->controller->RequestHandler->respondAs('application/json');
        $data = $this->controller->request->data;
        $data['id'] = $id ?? null;
        $redirect = array( 'action' => 'newsletters', 'templates');

        if(empty($data['id'])) {
          $data['user_id'] = $this->controller->Auth->user('id');
        }

        #\d("data", $data);

        $Newsletter->save($data);

        if(isset($data['x_coord']) && $data['x_coord'] == '1') {
          $redirect = array( 'action' => 'newsletters', 'templates', 'edit', $Newsletter->id);
        }

        $response = array(
          'success' => true,
          'message' => 'Tu Plantilla se actualizó correctamente',
          'redirect' => Router::reverse($redirect)
        );

        return json_encode($response);
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
      \d("error",$e->getMessage());
      echo $e->getMessage();
    }
  }

  public function schedules() {
    $NewsletterProduct = ClassRegistry::init('NewsletterProduct');
    $NewsletterSchedule = ClassRegistry::init('NewsletterSchedule');
    $NewsletterScheduleItem = ClassRegistry::init('NewsletterScheduleItem');
    $response = array();
    $schedules = array();
    $conditions = array(); // array('NewsletterSchedule.created > ' => date("Y-m-d H:i", strtotime("last day of previous month")));

    if(empty($this->controller->request->query['extended'])) {
      $conditions['NewsletterSchedule.enabled'] = 1;
      $conditions['NewsletterSchedule.user_id'] = $this->controller->Auth->user('id');
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
          array(
            'table' => 'users',
            'alias' => 'User',
            'type' => 'LEFT',
            'conditions' => array('NewsletterSchedule.user_id = User.id'),
          ),
        ),        
        'fields' => array(
          'NewsletterSchedule.id, Newsletter.id,Newsletter.title,Newsletter.body,NewsletterList.id,NewsletterList.name,NewsletterSchedule.schedule_date, NewsletterSchedule.schedule_hour, NewsletterSchedule.created,NewsletterSchedule.modified, NewsletterSchedule.enabled, Newsletter.send_push, Newsletter.send_email, COUNT(distinct NewsletterProduct.id) as prod_total, User.id, User.email, User.name, User.surname'
        ),
        'conditions' => $conditions,
        'group' => array(
          'NewsletterSchedule.id, Newsletter.id,Newsletter.title,Newsletter.body,NewsletterList.id,NewsletterList.name, NewsletterSchedule.schedule_date,NewsletterSchedule.schedule_hour,NewsletterSchedule.created,NewsletterSchedule.modified, NewsletterSchedule.enabled, Newsletter.send_push, Newsletter.send_email'
        ),
        'order' => array( 
          'NewsletterSchedule.modified DESC' 
        )
      ));

      #\d("schedules",$schedules);
      foreach($schedules as $i => $schedule) {
        $push_total = 0;
        $email_total = 0;
        $push_sent = 0;
        $email_sent = 0;
        $clicks = 0;

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
          $clicks+= $user['NewsletterScheduleItem']['clicks'];
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

        /*if(empty($schedule['NewsletterSchedule']['enabled'])) {
          $rowclass = 'light';
        }*/
        
        if(
          empty($schedule['Newsletter']['send_email']) && 
          empty($schedule['Newsletter']['send_push'])
        ) {
          $rowclass = 'danger';
          $status = 'Sin método asignado';
        }

        $schedules[$i]['stats'] = array(
          'email_sent' => $email_sent,
          'push_sent' => $push_sent,
          'email_total' => $email_total,
          'push_total' => $push_total,
          'clicks' => $clicks,
        );

        $schedules[$i]['status'] = $status;
        $schedules[$i]['rowclass'] = $rowclass;
        $schedules[$i]['list_total'] = count($users);
        $schedules[$i]['prod_total'] = $schedule[0]['prod_total'];
        // $schedules[$i]['Users'] = $users;
        // $schedules[$i]['Products'] = $products;
      }

      $this->controller->set('schedules', $schedules);

    } catch (\Exception $e) {
      echo $e->getMessage();
    }
    return $schedules;
  }

  public function schedules_delete() {
    $NewsletterSchedule = ClassRegistry::init('NewsletterSchedule');
    $NewsletterScheduleItem = ClassRegistry::init('NewsletterScheduleItem');
    try {
      if($this->controller->request->is('post')){
        $data = $this->controller->request->data;
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
    $NewsletterScheduleItem = ClassRegistry::init('NewsletterScheduleItem');
    $schedule = array();
    try {
      if($this->controller->request->is('post')){
        $this->controller->autoRender = false;
        $this->controller->RequestHandler->respondAs('application/json');      

        $data = $this->controller->request->data;
        $data['id'] = $id ?? null;

        if(empty($data['id'])) {
          $data['user_id'] = $this->controller->Auth->user('id');
        }

        $redirect = array( 'action' => 'newsletters', 'schedules' );
        $NewsletterSchedule->save($data);
        $users = array();

        if(empty($id)) {
          $users = $NewsletterUser->find('all', 
            array(
              'conditions' => array(
                'list_id' => $data['list_id']
              )
            )
          );

          $saves = array();

          foreach($users as $i => $user) {
            $save = $user['NewsletterUser'];
            $save['id'] = null;
            $save['schedule_id'] = $NewsletterSchedule->id;
            array_push($saves, $save);
          }

          $NewsletterScheduleItem->saveAll(
            $saves, 
            array(
              'validate' => false, 
              'callbacks' => false
            )
          );
        }

        /* // reset
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
        */

        if(isset($data['x_coord']) && $data['x_coord'] == '1') {
          $redirect = array( 'action' => 'newsletters', 'schedules', 'edit', $NewsletterSchedule->id);
        }

        $response = array(
          'success' => true,
          'message' => 'Tu Campaña se actualizó correctamente',
          'redirect' => Router::reverse($redirect)
        );

        return json_encode($response);
      }

      if(!empty($id)) {
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
      } 

      $this->controller->set('newsletters', $Newsletter->find('all', array(
        'joins' => array(
          array(
            'table' => 'newsletter_products',
            'alias' => 'NewsletterProduct',
            'type' => 'LEFT',
            'conditions' => array( 'Newsletter.id = NewsletterProduct.newsletter_id' )
          ),
          array(
            'table' => 'users',
            'alias' => 'User',
            'type' => 'LEFT',
            'conditions' => array( 'User.id = Newsletter.user_id' )
          ),
        ),
        'fields' => array('Newsletter.id, Newsletter.title, Newsletter.created, User.name, User.email, COUNT(NewsletterProduct.id) AS total'),
        'conditions' => array(
          // 'Newsletter.created > ' => date("Y-m-d H:i", strtotime("last day of previous month")),
          'Newsletter.enabled' => '1',
          //'NewsletterProduct.id IS NOT NULL',
        ),
        'group' => array('Newsletter.id, Newsletter.title, Newsletter.created, User.name, User.email'),
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
          array(
            'table' => 'users',
            'alias' => 'User',
            'type' => 'LEFT',
            'conditions' => array( 'User.id = NewsletterList.user_id' )
          ),
        ),
        'fields' => array('NewsletterList.id, NewsletterList.name, NewsletterList.text, NewsletterList.created, User.name, User.email,  COUNT(NewsletterUser.id) AS total'),
        'conditions' => array( 
          'NewsletterList.enabled' => 1,
          'NewsletterUser.id IS NOT NULL',
        ),
        'group' => array('NewsletterList.id, NewsletterList.name, NewsletterList.text, NewsletterList.created, User.name, User.email'),
        'order' => array( 'NewsletterList.modified DESC' )
      )));
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public function lists() {
    $NewsletterList = ClassRegistry::init('NewsletterList');
    $NewsletterUser = ClassRegistry::init('NewsletterUser');
    $response = array();
    $conditions = array('NewsletterList.id IS NOT NULL',); // array('NewsletterSchedule.created > ' => date("Y-m-d H:i", strtotime("last day of previous month")));
    if(empty($this->controller->request->query['extended'])) {
      $conditions['NewsletterList.enabled'] = 1;
      $conditions['NewsletterList.user_id'] = $this->controller->Auth->user('id');
    }

    try {
      $lists = $NewsletterList->find('all', array(
        'joins' => array(
          array(
            'table' => 'newsletter_users',
            'alias' => 'NewsletterUser',
            'type' => 'LEFT',
            'conditions' => array('NewsletterList.id = NewsletterUser.list_id'),
          ),
          array(
            'table' => 'users',
            'alias' => 'User',
            'type' => 'LEFT',
            'conditions' => array('User.id = NewsletterList.user_id'),
          ),
        ),  
        'fields' => array('NewsletterList.id, NewsletterList.name, NewsletterList.text,NewsletterList.modified, NewsletterList.enabled, NewsletterList.modified, COUNT(NewsletterUser.id) as total, User.id, User.email, User.name, User.surname'),
        'conditions' => $conditions,
        'group' => array('NewsletterList.id, NewsletterList.name, NewsletterList.text,NewsletterList.modified, NewsletterList.enabled, NewsletterList.created, NewsletterList.modified'),
        'order' => array( 'NewsletterList.modified DESC' )
      ));

      $this->controller->set('lists', $lists);
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public function lists_delete() {
    $NewsletterUser = ClassRegistry::init('NewsletterUser');
    $NewsletterList = ClassRegistry::init('NewsletterList');
    try {
      if($this->controller->request->is('post')){
        $data = $this->controller->request->data;
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
        $this->controller->autoRender = false;
        $this->controller->RequestHandler->respondAs('application/json');            
        $data = $this->controller->request->data;
        $data['filter'] = !empty($data['filter']) ? 
          json_encode($data) : 
          null;
        $data['id'] = $id ?? null;

        if(empty($data['id'])) {
          $data['user_id'] = $this->controller->Auth->user('id');
        }

        $redirect = array( 'action' => 'newsletters', 'lists' );

        $NewsletterList->save($data);

        if(empty($data['id']) || isset($data['x_coord']) && $data['x_coord'] == '1') {
          $redirect = array( 'action' => 'newsletters', 'lists', 'edit', $NewsletterList->id);
        }

        $response = array(
          'success' => true,
          'message' => 'Tu Lista se actualizó correctamente',
          'redirect' => Router::reverse($redirect),
          'lastid' => $NewsletterList->id,
        );

        return json_encode($response);
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
          'order' => array( 'NewsletterUser.user_id DESC' ),
          'limit' => 100 
        )));
      }
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }  
}
