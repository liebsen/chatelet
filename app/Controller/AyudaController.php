<?php
class AyudaController extends AppController {
	public $uses = array('Category','LookBook','Sale');
	public $components = array("OCA");

	public function beforeFilter() {
    	parent::beforeFilter();
    	$this->loadModel('Setting');
		$setting 			 = $this->Setting->findById('catalog_flap');
		$catalog_flap = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_flap',$catalog_flap);
		unset($setting);

	  	
    	$setting 			= $this->Setting->findById('catalog_first_line');
		$catalog_first_line = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_first_line',$catalog_first_line);
		unset($setting);

		$lookbook = $this->LookBook->find('all');
		$this->set('lookBook', $lookbook);
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
		    case 4:
				$this->render('como_comprar/step4');
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

	public function onlinebanking($id) {
		$sale = $this->Sale->findById($id);
		$price = $sale['Sale']['value'];

		/*if (isset($sale['Sale']['deliver_cost']) && empty($sale['Sale']['free_shipping'])) {
			$price+= $sale['Sale']['deliver_cost'];
		}*/

		$this->set('price', $price);
		$this->set('invoice_id', $id);
		// return $this->render('onlinebanking');
	}

	public function metodos_de_pago() {

	}

	public function politicas_de_cambio() {
		
	}

	public function faq() {
		
	}
}
?>