<?php
class UsersController extends AppController {
    public $uses = array('User','Category','LookBook');
    public $components = array("RequestHandler");


	public function beforeFilter() {
    	parent::beforeFilter();
        $this->loadModel('Setting');
        $categories = $this->Category->find('all');
        $this->set('categories', $categories);

        $lookbook = $this->LookBook->find('all');
        $this->set('lookBook', $lookbook); 
        
        $setting            = $this->Setting->findById('catalog_first_line');
        $catalog_first_line = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
        $this->set('catalog_first_line',$catalog_first_line);
        unset($setting);

	}

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->Session->setFlash(
                    'Bienvenido a Chatelet', 
                    'default', 
                    array('class' => 'hidden notice')
                );
                return $this->redirect($this->referer());
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
        return $this->redirect($this->Auth->logout());
    }

    public function register() {
        $this->autoRender = false;
        $this->RequestHandler->respondAs('application/json');
        if (!$this->request->is('post')) {
            return json_encode(array('success' => false));
        }

        if ($this->User->save($this->request->data)) {
            return json_encode(array('success' => true));

        } else {
            $errors = $this->User->validationErrors;
            return json_encode(array('success' => false, 'errors' => $errors));
        }
        
    }

    public function forgot_password(){
       
        if ($this->request->is('post')) {
            $email_user = $this->request->data['User']['email'];
           
            if(!empty($email_user)){
                $user_data = $this->User->find('first', array('recursive' => -1, 
                            'conditions' => array('User.email' => $email_user)));
               
                if(!empty($user_data)){   
             
                    /*$new_data = array(
                    'id' => $user_data['User']['id'],
                    'password' => substr($user_data['User']['password'], -6),
                    );
                    $save = $this->User->save($new_data);
                    pr($save);die;
                    if ($save) {
                       */
                        $email_data = array('id_user' => $user_data['User']['id'] ,
                                            'receiver_email' => $user_data['User']['email'],
                                            'name' =>  $user_data['User']['name'],
                                            'password' => $user_data['User']['password']);
                         
                        $this->sendEmail($email_data,'Recuperar contraseña Chatelet', 'confirm_email');

                        $this->Session->setFlash(
                            'BIEN! Verifique su casilla de correo' , 
                            'default', 
                            array('class' => 'hidden notice')
                         );
                        return $this->redirect($this->referer());
                  /*  }*/
                }else{
                $this->Session->setFlash(
                    'Por favor verifique email e intente nuevamente',
                    'default',
                    array('class' => 'hidden error')
                );
                return $this->redirect($this->referer());
               }
            }else{
                $this->Session->setFlash(
                    'Error',
                    'default',
                    array('class' => 'hidden error')
                );
                return $this->redirect($this->referer());
            }

            return $this->redirect(array('controller' => 'home', 'action' => 'index'));
        
        }  

    }
}  
?>