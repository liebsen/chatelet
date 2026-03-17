<?php
App::import('Controller', 'Facebook');
App::uses('CakeText', 'Utility');
App::uses('Security', 'Utility');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class ApiController extends AppController {
	public $helpers = array('Text');
	public $components = array("RequestHandler");

	public function beforeFilter() {
  	parent::beforeFilter();
  	$this->autoRender = false;

  	header("Content-Type: application/json");
    $this->Auth->allow('subscriptions');
	}
	
	public function sucursales() {
    $this->RequestHandler->respondAs('application/json');
		$this->loadModel('Store');
		$stores = $this->Store->find('all',array('order'=>array('Store.name ASC')));
		return json_encode($stores);
	}

	//get , http://www.chatelet.com.ar/api/subscriptions
  public function subscribe(){
    $this->loadModel('Webpush'); 

    if($this->Auth->user('id') && $this->request->is('post')){
      CakeLog::write('debug', 'webpush(user_id):'.json_encode($this->Auth->user('id')));
      CakeLog::write('debug', 'webpush(data):'.json_encode($this->request->data));
      $this->Webpush->save(array(
        'user_id' => $this->Auth->user('id'),
        'payload' => $this->request->data,
      ));

      return json_encode(
        array(
          'success' => true, 
          'message', 'Gracias por suscribirte'
        )
      );
    }

    return json_encode(
      array(
        'success' => false, 
        'message', 'No se pudo suscribir al usuario'
      )
    );
  }

  public function ckupload(){
    $func_number = $_GET['CKEditorFuncNum'] ;
    $folder = 'newsletters';
    $url = '';
    $message = '';
    if (isset($_FILES['upload']) && $_FILES['upload']['size']) {
      $url = $this->saveFile($_FILES['upload'], false, 0, $folder);
    }
    $full = $this->settings['site_url'] . $this->settings['upload_url'] . $folder . '/' . $url;
    echo "<script type='text/javascript'> window.parent.CKEDITOR.tools.callFunction($func_number, '$full', '$message')</script>";
  }

  public function subscriptions(){
    $this->loadModel('Subscription'); 
    $result = array();
    if (!empty($this->request->is('get'))) {
      $Subscriptions = $this->Subscriptions->find('all',array('order'=>array('Subscriptions.id DESC')));

      if(!empty($Subscriptions)){  
        foreach($Subscriptions as &$item){
          $result[] = $item['Subscriptions'];
        }

        header('200, SUBSCRIPTIONS_UNSUCCESSFUL');
        return(json_encode($result));   
      } else {
        header('409, SUBSCRIPTIONS_UNSUCCESSFUL');
        die(json_encode(array(
          "detail"=>"Subscriptions queried unsuccessfully",
          "code"=>"SUBSCRIPTIONS_UNSUCCESSFUL"
        )));  
      }
    }
  }

  public function emails(){
    if(empty($this->Auth->user('id'))) {
      return json_encode(
        array(
          'status' => "error", 
          'errors' => "El usuario está sin autentificar"
        )
      );
    }

    if(empty($this->Auth->user->isAdmin())) {
      return json_encode(
        array(
          'status' => "error", 
          'errors' => "El usuario no es administrador"
        )
      );
    }

    $this->loadModel('Email'); 
    $result = array();
    // if (!empty($this->request->is('get'))) {
    $Emails = $this->Email->find('all',array('order'=>array('Email.id DESC')));
    if(!empty($Emails)){  
      foreach($Emails as &$item){
        $result[] = $item['Subscriptions'];
      }
    }
    return(json_encode($result));
  }

  public function stats(){
    $this->autoRender = false;
    $this->loadModel('Analytic');
    $data = $this->request->data;
    $cart = $this->Session->read('cart') ?? 0;
    $cart_totals = $this->Session->read('cart_totals') ?? 0;
    $page = $data['page'] ?? '/';
    $tag = $data['tag'] ?? 'page-exit';
    $user_id = $this->Auth->user('id') ?? 0;
    $product_id = $data['product_id'] ?? 0;

    // save entry
    $entry = array(
      'tag' => $tag,
      'user_id' => $user_id,
      'product_id' => $product_id,
      'page' => $page
    );

    // $analytic['created'] = date('Y-m-d H:i:s');
    if(!empty($cart)){
      $entry['cart'] = json_encode($cart);
    }

    if(!empty($cart_totals)){
      $entry['cart_totals'] = json_encode($cart_totals);
    }

    CakeLog::write('debug', "analytics:".json_encode($data));

    $this->Analytic->save($entry);   
    exit(); 
  }
}
