<?php
class ApiController extends AppController {
	public $components = array("RequestHandler");

	public function beforeFilter() {
    	parent::beforeFilter();
    	$this->autoRender = false;
	}
	
	public function sucursales() {
    	$this->RequestHandler->respondAs('application/json');
		$this->loadModel('Store');
		$stores = $this->Store->find('all',array('order'=>array('Store.name ASC')));
		return json_encode($stores);
	}
}
?>