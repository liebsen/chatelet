<?php
class SucursalesController extends AppController {
	public $uses = array('Store','Catalogo','Category');
	
	public function beforeFilter() {
    	parent::beforeFilter();
    	$this->loadModel('Setting');
		$categories = $this->Category->find('all');
		$this->set('categories', $categories);

	}
	
	public function index() {
		$stores = $this->Store->find('all');
		$this->set('stores', $stores);

		$this->loadModel('Setting');
		$setting 			 = $this->Setting->findById('catalog_flap');
		$catalog_flap = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_flap',$catalog_flap);
		unset($setting);
	}
}
?>