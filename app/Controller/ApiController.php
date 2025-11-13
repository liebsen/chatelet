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
  public function subscriptions(){
    $this->loadModel('Subscriptions'); 
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
}
?>
