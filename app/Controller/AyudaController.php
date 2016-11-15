<?php
class AyudaController extends AppController {
	public $uses = array('Category');
	public $components = array("OCA");

	public function beforeFilter() {
    	parent::beforeFilter();
    	$this->loadModel('Setting');
    	$categories = $this->Category->find('all');
		$this->set('categories', $categories);
		$setting 			 = $this->Setting->findById('catalog_flap');
		$catalog_flap = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_flap',$catalog_flap);
		unset($setting);
	}
	

	public function como_comprar($step = 0) {
		switch ($step) {
			case 1:
				$this->render('como_comprar/step1');
				break;
			case 2:
				$this->render('como_comprar/step2');
				break;
			case 3:
				$this->render('como_comprar/step3');
				break;
		}
	}

	public function envios() {
		if ($this->request->is('post')) {
			$data = $this->request->data;

			$tracking = $this->OCA->tracking(array(
				//'NroDocumentoCliente' => $data['dni'],
				//'CUIT' => $data['cuit'],
				'Pieza' => $data['guia']
			));
			$this->set('tracking', $tracking);
		}

	}

	public function metodos_de_pago() {
		
	}

	public function faq() {
		
	}
}
?>