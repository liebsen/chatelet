<?php

App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class UsersController extends AppController {
  public $uses = array('User','Category','LookBook');
  public $components = array("RequestHandler");

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
            'message' => "Bienvenido {$this->Auth->user('name')} a Châtelet"
          )));
        }

        return $this->redirect($redirect ?? $this->referer());
        // return $this->redirect(array('controller' => 'shop', 'action' => 'cuenta'));
      }

      if(!empty($ajax)) {
        die(json_encode(array(
          'success' => false, 
          'errors' => 'Por favor verifique su email y contraseña e intente nuevamente'
        )));
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

  public function register(){
    $this->autoRender = false;

    if (!$this->request->is('post')) {
      //return json_encode(array('success' => false));
      return $this->redirect(array('controller' => 'home', 'action' => 'index'));
    }

    $data = $this->request->data;

    if(empty($data['email'])) {
      if(!empty($ajax)) {
        die(json_encode(array(
          'success' => false,
          'message' => 'No se recibió el email'
        )));
      }
      
      return $this->redirect($this->referer());
    }
    
    $invite = $this->request->data['invite'];
    $ajax = $this->request->data['ajax'];
    $validate = empty($invite);

    if(!empty($invite) && empty($data['User']['password'])) {
      CakeLog::write('debug', 'New password generated');
      $data['User']['password'] = $this->random_password();
    }

    // CakeLog::write('debug', 'validate:'.$validate);
    // CakeLog::write('debug', 'new user data:'.json_encode($data));
    
    $saved = $this->User->save(
      $data, 
      array(
        'validate' => $validate
      )
    );

    //CakeLog::write('debug', 'saved:'. json_encode($saved));
    if (!empty($saved)) {
      $this->Auth->login();     
      $this->Session->setFlash(
        'Bienvenida a Châtelet', 
        'default', 
        array('class' => 'hidden notice')
      );
      if(!empty($ajax)) {
        die(json_encode(array(
          'success' => true,
          'message' => 'Tu nueva cuenta ha sido creada'
        )));
      }
      return $this->redirect($this->referer());
    } else {
      $errors = $this->User->validationErrors;

      CakeLog::write('debug', 'errors:'.json_encode($errors));
      $this->Session->setFlash(
        'Hubo en error al intentar crear la cuenta. Por favor intente nuevamente en unos instantes.',
        'default',
        array('class' => 'hidden error')
      );            
      if(!empty($ajax)) {
        die(json_encode(array(
          'success' => false,
          'errors' => 'Hubo en error al intentar crear la cuenta. Por favor intente nuevamente en unos instantes'
        )));
      }
      return $this->redirect(array('controller' => 'home', 'action' => 'index'));
    }
  }

  public function forgot_password(){
    if ($this->request->is('post')) {
      $email_user = trim($this->request->data['User']['email']) ?? '';
      $ajax = $this->request->data['ajax'] ?? '';
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
            'User'=>array(
              'id' => $user_data['User']['id'],
              'password' => $pass1
            )
          ), false);

          $email_data = array(
            'id_user' => $user_data['User']['id'] ,
            'receiver_email' => $user_data['User']['email'],
            'name' =>  $user_data['User']['name'],
            'password' => $pass1
          );

          $sent = $this->sendEmail($email_data,'Recuperar contraseña Châtelet', 'confirm_email');

          if(!empty($ajax)) {
            die(json_encode(array(
              'success' => $sent, 
              'message' => "Revisa tu correo <b>{$email_user}</b> para continuar con el proceso",
              'errors' => "Hubo un error al intentar recuperar tu cuenta"
            )));
          }
          $this->Session->setFlash(
            'BIEN!' , 
            'Verifique su casilla de correo', 
            array('class' => 'hidden notice')
          );
          return $this->redirect($this->referer());
        } else {
          
          if(!empty($ajax)) {
            die(json_encode(array(
              'success' => false, 
              'errors' => "La cuenta <b>{$email_user}</b> no existe"
            )));
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
