<?php
class SucursalesController extends AppController {
	public $uses = array('Store','Catalogo');
	
	public function beforeFilter() {
    	parent::beforeFilter();
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