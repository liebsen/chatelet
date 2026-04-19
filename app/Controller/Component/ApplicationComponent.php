<?php

App::uses(
  'Model', 
  'Component', 
  'Controller', 
  'Session', 
  'Setting',
);

class ApplicationComponent extends Component {
  public $controller; // To store a reference to the Controller
  public function initialize(Controller $controller) {
    $this->controller = $controller;
    parent::initialize($controller);
  }

  public function index(){}  

  public function share() {
    if($this->controller->request->is('post')){
      return $this->update_settings();
    }    
  }

  public function email() {
    if($this->controller->request->is('post')){
      return $this->update_settings();
    }    
  }

  public function fonts() {
    if($this->controller->request->is('post')){
      return $this->update_settings();
    }        
  }

  public function payments() {
    if($this->controller->request->is('post')){
      return $this->update_settings();
    }
  }

  public function notifications() {
    if($this->controller->request->is('post')){
      return $this->update_settings();
    }

    $notification_register_templates = array(
      'id_user' => 'Nro. Clienta',
      'receiver_email' => 'email',
      'name' =>  'Nombre',
      'surname' =>  'Apellido',
      'password' => 'Contraseña'
    );

    $notification_tags = array(
      'notification_sale_success' => "Compra con pago exitoso",
      'notification_sale_pending' => "Compra con pago pendiente",
      'notification_register_welcome' => "Registro en la tienda",
    );

    foreach($notification_tags as $id => $tag) {
      $notification_settings["{$id}_title"] = $this->controller->settings["{$id}_title"] ?? '';
      $notification_settings["{$id}_text"] = $this->controller->settings["{$id}_text"] ?? '';
    }

    $this->controller->set('notification_settings', $notification_settings);
    $this->controller->set('notification_tags', $notification_tags);
    $this->controller->set('notification_sale_templates', $notification_sale_templates);
    $this->controller->set('notification_register_templates', $notification_register_templates);
  }

  public function update_settings(){
    $this->controller->RequestHandler->respondAs('application/json');
    $this->controller->autoRender = false;
    $Setting = ClassRegistry::init('Setting');
    $data = $this->controller->request->data;
    $saves = array();

    foreach($data as $id => $value) {
      if(is_array($value) && ($id == 'opengraph_image')) {
        $value = $this->controller->save_file( $value ); 
        $value = $this->controller->settings['upload_url'] . $value; 
      }

      array_push($saves, 
        array(
          'id' => $id, 
          'value' => $value
        )
      );
    }

    CakeLog::write('debug', 'data:'. json_encode($data));
    CakeLog::write('debug', 'saves:'. json_encode($saves));

    $Setting->saveAll($saves);

    $response = array(
      'success' => true,
      'message' => 'La nueva configuración se actualizó exitosamente'
    );

    return json_encode($response);    
  }
}
