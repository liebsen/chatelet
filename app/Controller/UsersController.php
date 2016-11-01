<?php
class UsersController extends AppController {
    public $uses = array('User');
    public $components = array("RequestHandler");

	public function beforeFilter() {
    	parent::beforeFilter();
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
}
?>