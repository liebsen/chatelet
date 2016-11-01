<?php
class HomeController extends AppController {
	public function beforeFilter() {
    	parent::beforeFilter();
    	 $this->loadModel('Setting');
	     $setting  = $this->Setting->findById('catalog_flap');
	     $catalog_flap = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
	     $this->set('catalog_flap',$catalog_flap);
	     unset($setting);
	}
	
	public function index() {
		$home = $this->Home->find('first');
		$this->set('home', $home['Home']);
	}
}
?>