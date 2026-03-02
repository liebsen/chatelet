<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class UsersController extends AppController {
  public $uses = array('User','Category','LookBook');
  public $components = array("Mailchimp", "RequestHandler");
  //public $components = array("RequestHandler");

	public function beforeFilter() {
  	parent::beforeFilter();
    $this->Auth->allow('register');
    $this->loadModel('Setting');

    $lookbook = $this->LookBook->find('all');
    $this->set('lookBook', $lookbook); 
    
    $setting            = $this->Setting->findById('catalog_first_line');
    $catalog_first_line = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
    $this->set('catalog_first_line',$catalog_first_line);
    unset($setting);
	}

  public function login() {
    $redirect = $this->request->data['redirect'];
    $ajax = $this->request->data['ajax'];
    $email_user = trim($this->request->data['User']['email']) ?? '';
    CakeLog::write('debug', 'login:'.json_encode($this->request->data));

    if(!empty($ajax)) {
      $this->RequestHandler->respondAs('application/json');
      $this->autoRender = false;        
    }

    $user_data = $this->User->find('first', array(
      'recursive' => -1, 
      'conditions' => array('User.email' => $email_user)
    ));

    if(empty($user_data)){
      return json_encode(array(
        'success' => false, 
        'errors' => 'Tu email no está registrado en nuestra tienda'
      ));
    }

    if ($this->request->is('post')) {
      if ($this->Auth->login()) {
        $this->Session->setFlash(
          "Hola {$this->Auth->user('name')}, qué bueno tenerte de nuevo en Châtelet", 
          'default',
          array( 'class' => 'hidden notice' )
        );

        if(!empty($ajax)) {
          die(json_encode(array(
            'success' => true, 
            'message' => "Bienvenida {$this->Auth->user('name')} a Châtelet"
          )));
        }

        return $this->redirect($redirect ?? $this->referer());
        // return $this->redirect(array('controller' => 'shop', 'action' => 'cuenta'));
      }

      if(!empty($ajax)) {
        return json_encode(array(
          'success' => false, 
          'errors' => 'Por favor verifica tu contraseña'
        ));
      }

      $this->Session->setFlash(
        'Por favor verifique su email y contraseña e intente nuevamente',
        'default',
        array('class' => 'hidden error')
      );
      return $this->redirect($this->referer());
    }
    return $this->redirect(array('controller' => 'home', 'action' => 'index'));
  }

  public function logout() {
    $this->Session->destroy();
    $this->Session->setFlash(
      'Tu sesión ha terminado. Gracias por comprar con Châtelet', 
      'default', 
      array('class' => 'hidden notice')
    );        
    return $this->redirect($this->Auth->logout());
  }

  public function fix_user_ids(){
    $this->autoRender = false;
    $this->loadModel('Sale');    
    $this->loadModel('User');    

    $sales = $this->Sale->find('all',[
      'conditions' => [
          'user_id' => null,
      ],
      'order' => ['Sale.id DESC'],
      'limit' => 1000,
    ]);

    //$this->set('sales', $sales);

    $result = [];
    $ok = 0;
    $fail = 0;
    foreach($sales as $sale) {
      //$query = "select id, name from users where surname = 'Ziehl' and name like '%Cristina%'"
      $user = $this->User->find('first',[
          'conditions' => [
              'User.email' => $sale['Sale']['email'],
          ]
      ]);

      /*if(!$user) {
          $user = $this->User->find('first',[
              'conditions' => [
                  'User.name like' => '%'.$sale['Sale']['nombre'].'%',
                  'User.surname like' => '%'.$sale['Sale']['apellido'].'%',
              ]
          ]);
      }*/

      CakeLog::write('debug','check: '.$sale['Sale']['nombre'].' '.$sale['Sale']['apellido']);

      if($user) {
        $ok++;
        $sale['Sale']['user_id'] = $user['User']['id'];
        $this->User->save($sale['Sale']);
        //CakeLog::write('debug','user[OK]: '.$user['User']['id']);
      } else {
        $fail++;
        //CakeLog::write('debug','user[FAIL]');
      }
    }

    CakeLog::write('debug','ok: '.$ok);
    CakeLog::write('debug','fail: '.$fail);
  }

  public function test_mc(){
    $response = $this->Mailchimp->test();
    print_r($response);
    die();
  }

  public function lists_mc(){
    $response = $this->Mailchimp->lists();
    print_r($response);
    die();
  }

  public function stores(){
    $response = $this->Mailchimp->stores();
    print_r($response);
    die();
  }

  public function subscribe(){
    $this->loadModel('Subscription');
    if ($this->request->is('post')) {
      $data = $this->request->data;
      $ajax = $data['ajax'] ?? 0;
      $subscriber_email = trim($data['Subscription']['email']) ?? 0;
      if (!empty($subscriber_email)) {
        $exists = $this->Subscription->findByEmail($subscriber_email);
        if ($exists) {
          if(!empty($ajax)) {
            die(json_encode(array(
              'success' => true,
              'is_already_subscribed' => true, 
              'message' => 'Este email ya existe en nuestra base de datos. Ingresa otro.'
            )));
          }

          $this->Session->setFlash(
            'El email ya está registrado', 
            'default', 
            array('class' => 'hidden notice')
          );            
        }

        $toSave = array(
          'email' => $data['Subscription']['email'],
          'full_name' => $data['Subscription']['full_name'],
        );

        $saved = $this->Subscription->save($toSave);

        if($this->settings['mailchimp_on'] == 'on' && $this->settings['mc_subscription_on'] == 'on') {
          $this->Mailchimp->subscribe($data['Subscription'], $this->settings['mc_subscription']);
        }

        if(!empty($saved)){
          if(!empty($ajax)) {
            die(json_encode(array(
              'success' => true, 
              'message' => 'Bienvenida a Châtelet'
            )));
          }

          $this->Session->setFlash(
            'Bien!,email registrado', 
            'default', 
            array('class' => 'hidden notice')
          );  
        }
      } else {
        $this->Session->setFlash(
           'Por favor intente nuevamente',
           'default',
           array('class' => 'hidden error')
        );
      }
    }    
  }

  public function register(){
    $this->autoRender = false;

    if ($logged || !$this->request->is('post')) {
      //return json_encode(array('success' => false));
      return $this->redirect(array('controller' => 'home', 'action' => 'index'));
    }

    $data = $this->request->data;

    if($this->Auth->user('id')) {
      $data['User']['id'] = $this->Auth->user('id');
      $this->request->data['User']['id'] = $this->Auth->user('id');
    }
    
    $invite = $data['invite'];
    $ajax = $data['ajax'];
    $validate = empty($invite);

    if(!empty($ajax)) {
      $this->RequestHandler->respondAs('application/json');
      $this->autoRender = false;
    }

    if(empty($data['User']['email'])) {
      if(!empty($ajax)) {
        return json_encode(array(
          'success' => false,
          'message' => 'No se recibió el email'
        ));
      }
      
      return $this->redirect($this->referer());
    }
    
    if(!empty($invite) && empty($data['User']['password'])) {
      $random_password = $this->random_password();
      
      $data['User']['password'] = $random_password;
      $this->request->data['User']['password'] = $random_password;
    }

    // CakeLog::write('debug', 'User:'.json_encode($data['User']));
    CakeLog::write('debug', 'register:'.json_encode($data));

    // CakeLog::write('debug', 'validate:'.$validate);
    // CakeLog::write('debug', 'new user data:'.json_encode($data));
    try {
      $saved = $this->User->save(
        $data, 
        array('validate' => $validate)
      );
    } catch (Exception $e) {
      return json_encode(array(
        'success' => false,
        'errors' => $e->getMessage()
      ));      
    }

    if (!empty($saved)) {
      CakeLog::write('debug', 'saved:'.json_encode($saved));

      $logged = $this->Auth->login();     

      if(!$logged) {
        CakeLog::write('debug', 'could not login :'.json_encode($logged));
        return $this->redirect($this->referer());
      }

      $email_data = array(
        'id_user' => $data['User']['id'] ,
        'receiver_email' => $data['User']['email'],
        'name' =>  $data['User']['name'],
        'password' => $data['User']['password']
      );

      $sent = $this->sendEmail($email_data, 'Bienvenida a Châtelet', 'welcome_email');

      $this->Session->setFlash(
        'Bienvenida a Châtelet', 
        'default', 
        array('class' => 'hidden notice')
      );

      if(!empty($ajax)) {
        return json_encode(array(
          'success' => true,
          'message' => 'Tus datos fueron actualizados'
        ));
      }

      if($this->settings['mailchimp_on'] == 'on' && $this->settings['mc_subscription_on'] == 'on') {
        $this->Mailchimp->subscribe($data['User'], $this->settings['mc_subscription']);
      }

      return $this->redirect($this->referer());
    } else {
      $errors = $this->User->validationErrors;
      $texterr = "<br><br>";
      foreach($errors as $source => $error) {
        $texterr.= "$error[0] <br>";
      }

      // CakeLog::write('debug', 'errors:'.json_encode($errors));
      $this->Session->setFlash(
        'Hubo en error al intentar crear la cuenta. ' . $texterr,
        'default',
        array('class' => 'hidden error')
      );

      if(!empty($ajax)) {
        return json_encode(array(
          'success' => false,
          'errors' => $errors,
          'message' => 'Hubo en error al intentar crear la cuenta. ' . $texterr,
        ));
      }

      return $this->redirect(array('controller' => 'home', 'action' => 'index'));
    }
  }

  public function forgot_password(){
    if ($this->request->is('post')) {
      $email_user = trim($this->request->data['User']['email']) ?? '';
      $ajax = $this->request->data['ajax'];

      if(!empty($ajax)) {
        $this->RequestHandler->respondAs('application/json');
        $this->autoRender = false;        
      }

      if(!empty($email_user)){
        $user_data = $this->User->find('first', array(
          'recursive' => -1, 
          'conditions' => array('User.email' => $email_user)
        ));

        if(!empty($user_data)){
          $pass1 = $this->random_password();
          // $passwordHasher = new SimplePasswordHasher();
          // $pass = $passwordHasher->hash($pass1);
          CakeLog::write('debug', 'hash:'.$pass1);

          $this->User->save(array(
            'id' => $user_data['User']['id'],
            'password' => $pass1
          ), false);

          $email_data = array(
            'id_user' => $user_data['User']['id'] ,
            'receiver_email' => $user_data['User']['email'],
            'name' =>  $user_data['User']['name'],
            'password' => $pass1
          );

          $sent = $this->sendEmail($email_data,'Recuperar contraseña Châtelet', 'confirm_email');

          if(!empty($ajax)) {            
            return json_encode(array(
              'success' => true, 
              'message' => "Acabamos de enviarle un mensaje de correo electrónico",
              'errors' => "Hubo un error al intentar recuperar tu cuenta"
            ));
          }

          $this->Session->setFlash(
            'BIEN!' , 
            'Verifique su casilla de correo', 
            array('class' => 'hidden notice')
          );

          return $this->redirect($this->referer());
        } else {
          
          if(!empty($ajax)) {
            return json_encode(array(
              'success' => false, 
              'errors' => "La cuenta <b>{$email_user}</b> no existe"
            ));
          }

          $this->Session->setFlash(
            'La cuenta no existe',
            'default',
            array('class' => 'hidden error')
          );

          return $this->redirect($this->referer());
        }

        return $this->redirect(array('controller' => 'home', 'action' => 'index'));
      }
    }
  }
}
