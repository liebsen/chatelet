<?php

require_once(APP . 'Vendor' . DS . 'oca.php');
require_once(APP . 'Vendor' . DS . 'curl.php');
require __DIR__ . '/../Vendor/andreani/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../Vendor/andreani/');
$dotenv->load();


// use Cake\Routing\Router;
use AlejoASotelo\Andreani;

class CheckoutController extends AppController
{
	public $uses = array(
		'Product', 
		'ProductProperty', 
		'Store', 
		'Sale',
		'Package',
		'User',
		'SaleProduct',
		'Catalogo',
		'Category',
		'LookBook',
		'Coupon',
		'Logistic',
		'Setting',
		'Legend',
		'Router'
	);
	
	public $checkout_steps = array(
		array(
			'url' => '/checkout',
			'label' => 'Registro'
		),
		array(
			'url' => '/checkout/envio',
			'label' => 'Envío'
		),
		array(
			'url' => '/checkout/pago',
			'label' => 'Pago'
		),
		array(
			'url' => '/checkout/confirma',
			'label' => 'Confirma'
		),
	);

	public $components = array('Cart', 'RequestHandler');

	public function beforeFilter()
	{
  	parent::beforeFilter();
  	$this->set('sorted', $this->Cart->sort());
		$index = array_search($this->request->here, array_column($this->checkout_steps, 'url'));
		$this->set('checkout_index', $index);
		$this->set('checkout_steps', $this->checkout_steps);
		$freeShipping = $this->Cart->isFreeShipping($total_price);
		$this->set('freeShipping', $freeShipping);		
	}

	public function index()
	{ }

	private function parseTemplate ($str, $data) {
		$html = $str;
    foreach ($data as $key => $value) {
      $html = str_replace(["{{" . $key . "}}", "{{ " . $key . " }}"], $value, $html);
    }		
		return $html;
	}

	public function envio() {
		if(empty($this->Session->read('cart_totals'))) {
			$this->redirect(array( 'controller' => 'carrito', 'action' => 'index' ));
		}

		if ($this->request->is('post')) {
			$this->RequestHandler->respondAs('application/json');
			$this->autoRender = false;

			$data = $this->request->data;
			$cart_totals = $this->Session->read('cart_totals');

			if(empty($data)) {
	      return json_encode(array(
	        'success' => false, 
	        'errors' => 'No se recibió datos de envío'
	      ));
			}

			$customer = $data['customer'];

			if($data['cargo'] == 'shipment' && empty($data['customer'])) {
	      return json_encode(array(
	        'success' => false, 
	        'errors' => 'No se recibió datos de persona'
	      ));
			}
      
      $response = array(
        'success' => true, 
        'message' => 'OK, pasemos a pago'
      );

			$delivery_cost = 0;
			// CakeLog::write('debug', 'envio(data):'.json_encode($data));	
			// CakeLog::write('debug', 'envio(cart_totals):'.json_encode($cart_totals));	

			if($data['cargo'] == 'shipment' && empty($cart_totals['free_shipping'])) {
				$delivery_data = json_decode($this->deliveryCost(
					$data['postal_address'], 
					$data['shipping'],
					$cart_totals
				));
				
				// CakeLog::write('debug', 'envio(json):'.json_encode($delivery_data));	
				// CakeLog::write('debug', 'envio(price)(1):'.$delivery_data->rates[0]->price);
				$delivery_cost = (float) $delivery_data->rates[0]->price;
				// CakeLog::write('debug', 'envio(deliverycost)(1):'.$delivery_cost);
				if(!empty($delivery_cost)) {
					$cart_totals['delivery_cost'] = $delivery_cost;
				} else {
					// CakeLog::write('debug', 'envio(err) No se obtuvo cotizacion de envio. delivery_data:'.json_encode($delivery_data, JSON_PRETTY_PRINT));
				}
			}

			// CakeLog::write('debug', 'envio(deliverycost):'.$delivery_cost);

			$cart_totals['delivery_cost'] = $delivery_cost;

			$partials = array(
				'shipping', 
				'cargo',
				'store', 
				'postal_address', 
				'store_address', 
				'customer'
			);

			foreach($partials as $part) {
				$cart_totals[$part] = $data[$part];
			}

			CakeLog::write('debug', 'envio(cart_totals)'.json_encode($cart_totals));
			$this->Cart->update(null, $cart_totals);

      return json_encode($response);
		}

		$stores = $this->Store->find('all', [
			'conditions' => ['takeaway' => 1]
		]);

		$oca = new Oca();
		$provincias = $oca->getProvincias();
		$user = $this->User->find('first',array('recursive' => -1,'conditions'=>array('User.id' => $this->Auth->user('id'))));
		$this->set('userData',$user);		
		$this->set('provincias',$provincias);		
		$this->set('stores', $stores);
	}

	public function pago() {
		
		if ($this->request->is('post')) {
			$this->RequestHandler->respondAs('application/json');
			$this->autoRender = false;

			$pago = $this->request->data;
			$response = array(
				'success' => true,
				'message' => 'OK, pasemos a pago'
			);

			if(empty($pago)) {
				return json_encode(array(
					'success' => false,
					'errors' => 'Datos de pago no recibidos'
				));
			}

			if(empty($pago['payment_method'])) {
				return json_encode(array(
					'success' => false,
					'errors' => 'Método de pago no recibido'
				));
			}

			$partials = array(
				'payment_method', 
				'payment_dues',
			);

			$cart_totals = $this->Session->read('cart_totals');

			foreach($partials as $part) {
				$cart_totals[$part] = $pago[$part];
			}

			// CakeLog::write('debug', 'updateTotals(2)'.json_encode($cart_totals));
			$this->Cart->update(null, $cart_totals);

			return json_encode($response);
		}
				
    $legends = $this->Legend->find('all', [
      'conditions' => ['enabled' => 1],
      'order' => ['Legend.ordernum ASC']
    ]);

    $this->set('legends', $legends);

		// $user = $this->User->find('first',array('recursive' => -1,'conditions'=>array('User.id' => $this->Auth->user('id'))));
		// $this->set('userData',$user);
	}

	public function confirma() {
		$cart_totals = $this->Session->read('cart_totals');
		if(empty($this->Session->read('cart'))) {
			$this->redirect(array( 'controller' => 'carrito', 'action' => 'index' ));
		}
		
		if ($this->request->is('post')) {
			$this->RequestHandler->respondAs('application/json');
			$this->autoRender = false;

			$response = array(
				'success' => false,
				'errors' => 'No se puedo procesar tu compra'
			);

			// check integrity
			if(empty($cart_totals['payment_method'])) {
				return json_encode(array(
					'success' => false,
					'errors' => 'No se recibió método de pago'
				));
			}

			if($cart_totals['cargo'] == 'shipment' && empty($cart_totals['customer'])) {
	      return json_encode(array(
	        'success' => false, 
	        'errors' => 'No se recibió datos de persona de entrega'
	      ));
			}

			$data = $this->request->data;
	    // $settings = $this->load_settings();

			if(empty($data['confirm'])) {
	      return json_encode(array(
	        'success' => false, 
	        'errors' => 'No se recibieron datos de confirmacion'
	      ));
			}

			// CakeLog::write('debug', '-.-.-.-.-.-.-.-.-.-.- sale -.-.-.-.-.-.-.-.-.-');
			$sale = $this->sale();
			// here we start the sale
			CakeLog::write('debug', 'confirma(sale):'. json_encode($sale));
			return json_encode($sale);
		}
	}

	public function getLocalidadProvincia($id)
	{
		$this->RequestHandler->respondAs('application/json');
		$this->autoRender = false;

		$response = array();
		if ($id) {
			$oca = new Oca();
			$response = $oca->getLocalidadesByProvincia($id);
		}

		return json_encode($response);
	}


	private function getItemsData()
	{
		$data = array('count' => 0, 'price' => 0);
		$items = $this->Session->read('cart');
		//CakeLog::write('debug', 'getItemsData:'. json_encode($items));
		if ($items) {
			foreach ($items as $key => $item) {
				$data['count']++;
				$data['price']+= $item['price'];
			}
			$package = $this->Package->find('first',array('conditions' => array( 'Package.amount_min <=' => $data['count'] , 'Package.amount_max >=' => $data['count'] )));
			if(!empty($package)){
				$data['package']= $package['Package'];
				$data['weight'] = $package['Package']['weight']/1000;
				$data['volume'] = ($package['Package']['width']/100)*($package['Package']['height']/100)*($package['Package']['depth']/100);
				return $data;
			}
		}
		return false;
	}

	private function checkOcaCP($cp){
		$oca = new Oca();
		$centers = $oca->getCentrosImposicionPorCP( $cp );
		if( !empty($centers) ){
			return $centers;
		}else{
			return 0;
		}
	}

	/*public function getCartData($id)
	{
		$this->RequestHandler->respondAs('application/json');
		$this->autoRender = false;
		$map = $this->Setting->findById('bank_enable');
		$settings['bank_enable'] = @$map['Setting']['value'];
		$map = $this->Setting->findById('bank_discount_enable');
		$settings['bank_discount_enable'] = @$map['Setting']['value'];
		$map = $this->Setting->findById('bank_discount');
		$settings['bank_discount'] = @$map['Setting']['value'];

		$response = (object) [
			'enable' => @$settings['bank_enable'],
			'discount_enable'=> @$settings['bank_discount_enable'],
			'discount'=> @$settings['bank_discount']
		];
		return json_encode($response);
	}*/

	public function takeawayStores($cp = null){
		$this->RequestHandler->respondAs('application/json');
		$this->autoRender = false;
		$stores = $this->Store->find('all', [
			'conditions' => ['takeaway' => 1]
		]);
		return json_encode($stores);
	}

	public function coupon($cp = null){
		$items = $this->Session->read('cart');
		$cart_totals = $this->Session->read('cart_totals');
		$this->RequestHandler->respondAs('application/json');
		$this->autoRender = false;

		$coupon = $this->Coupon->find('first', [
			'conditions' => [
				'code' => $this->request->data['coupon'],
				'enabled' => 1
			]
		]);

		if (!$coupon) {
			return json_encode((object) [
				'status' => 'error',
				'title' => $this->request->data['coupon'],
				'message' => "No tenemos esa promo disponible ahora"
			]);
		}
	  // look for coupon configuration
	  $this->loadModel('CouponItem');
	  $coupon_ids = $this->CouponItem->find('all'	, [
	    'conditions' => [
	      'coupon_id' => $coupon['Coupon']['id'],
	    ], 
	    'fields' => ['id', 'category_id', 'product_id']
	  ]);

		$cats = [];
		$prods = [];
	  if(!empty($coupon_ids)){
	    $prods = array_values(array_map(function($e) {
	      return $e['CouponItem']['product_id'];
	    },$coupon_ids));
	    $cats = array_values(array_map(function($e) {
	      return $e['CouponItem']['category_id'];
	    },$coupon_ids));
	  }

		$coupon_bonus = 0;
		$partial_bonus = 0;
		$total = 0;
		$coupon_parsed = \filtercoupon($coupon, $cart_totals, $data['price']);
		$updated = [];
		if($coupon_parsed->status === 'success') {

			$discount = (float) $coupon_parsed->data['discount'];
			$partial_bonus = $discount;

			foreach($items as $item) {
				$price = (float) $item["price"];
				$total+= $price;

				if($partial_bonus < 0) {
					$partial_bonus = 0;
				}
				
				if (
					(!count($cats) && !count($prods)) ||
					in_array($item['category_id'],$cats) || 
					in_array($item['id'],$prods)
				) {
					if($coupon_parsed->data['coupon_type'] === 'percentage') {
						$coupon_bonus+= round($price * ($discount / 100), 2);
						$price = round($price * (1 - $discount / 100), 2);
					} 

					if($coupon_parsed->data['coupon_type'] === 'nominal'){
						if($partial_bonus) {
							if($partial_bonus >= $price) 	{
								$partial_bonus-= $price;
								$coupon_bonus+= $price;
								$price = 0;	
							} else {
								$price = round($price - $partial_bonus,2);
								$coupon_bonus+= $price;
								$partial_bonus-= $price;
							}
						}
					}

					$updated[$item['id']] = (object) [
						'old_price' => $item['price'],
						'price' => $price
					];
				}
			}

			if(count($coupon_ids) && !count($updated)){
				return json_encode((object) [
	        'status' => 'error',
	        'title' => "No aplica a los productos de tu carrito",
	        'message' => "El cupón existe pero no contempla los productos que elegiste"
	       ]); 
			}			
		}

		if($total && $discount){
			if($coupon_parsed->data['coupon_type'] === 'percentage') {
				$total = round($total * (1 - $discount / 100), 2);
			}
			if($coupon_parsed->data['coupon_type'] === 'nominal') {
				$total-= $discount;
			}
			if($total < 0) {
				$total = 0;
			}
			$total = round($total,2);
		}

		$coupon_update = array(
			'updated' => $updated,
			'total' => $total,
			'bonus' => $bonus,
			'coupon_bonus' => $coupon_bonus,
		);

		if($coupon_parsed->paying_with) {
			$coupon_update['paying_with'] = $coupon_parsed->paying_with;
		}

		/* $coupon_parsed->data["updated"] = $updated;
		$coupon_parsed->data["total"] = $total;
		$coupon_parsed->data["bonus"] = $discount; */
		
		$coupon_parsed->data = array_unique(array_merge($coupon_parsed->data,$coupon_update));
		return json_encode($coupon_parsed);
	}

	public function deliveryCost($cp, $code = null, $sale = null){
		if ($sale['cargo'] === 'takeaway') {
			$json['rates'][] = 0;
			return $json;
		}

		$cp = $cp ?? @$sale['postal_address'];
		$code = $code ?? @$sale['shipping'];
		CakeLog::write('debug','deliveryCost(cp):'.$cp);
		CakeLog::write('debug','deliveryCost(code):'.$code);

		$this->RequestHandler->respondAs('application/json');
		$this->autoRender = false;
		$this->loadModel('LogisticsPrices');
		//Codigo Postal
		$this->Session->write('cp', $cp);
		if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
			$dummy = '{"freeShipping":false,"rates":[{"title":"Oca","code":"oca","image":"https:\/\/test.chatelet.com.ar\/files\/uploads\/628eb1ba29efd.svg","info":"Env\u00edos a todo el pa\u00eds","price":987,"centros":[],"valid":true},{"title":"Speed Moto","image":"https:\/\/test.chatelet.com.ar\/files\/uploads\/6292a6f2d79b7.jpg","code":"speedmoto","info":"10 a\u00f1os brindando confianza a nuestros clientes","price":"700.00","centros":[],"valid":true}],"itemsData":{"count":1,"price":1994.99,"package":{"id":"2","amount_min":"1","amount_max":"5","weight":"1000","height":"9","width":"24","depth":"20","created":"2014-11-20 10:25:48","modified":"2014-11-20 10:25:48"},"weight":1,"volume":0.00432}}';
			return json_encode(json_decode($dummy));
		}

		$shipping_price = $this->Setting->findById('shipping_price_min');
		$cp1 = substr($cp, 0, 3) . '*';
		$cp2 = substr($cp, 0, 2) . '**';
		//Data
		$data = $this->getItemsData();
		$unit_price = $data['price'];
		if(!empty($data['discount']) && !empty((float)(@$data['discount']))) {
      $unit_price = @$data['discount'];
    }
		$freeShipping = $this->Cart->isFreeShipping($unit_price, $cp);
		$json = array(
			'freeShipping' => $freeShipping,
			'rates' => [],
			'itemsData' => $data
		);

		if(!empty($data)){
			if ($code) {
				// CakeLog::write('debug', 'deliveryCost(code):'.$code);
				// necesitamos cotizacion de una empresa
				$code = strtolower($code);
				$logistic = $this->Logistic->find('first',[
					'conditions' => [
						'enabled' => true,
						'code' => $code
					]
				])['Logistic'];

				if ($logistic['local_prices']) {
					// CakeLog::write('debug', 'deliveryCost(code)(1)');
					// buscamos las tarifas
					$locals = $this->LogisticsPrices->find('first', [
						'conditions' => [
							'logistic_id' => $logistic['id'],
							'enabled' => true,
	            'OR' => [
	              ['zips LIKE' => "%{$cp1}%"],
	              ['zips LIKE' => "%{$cp2}%"],
	              ['zips LIKE' => "%{$cp}%"]
	            ]
						]
					])['LogisticsPrices'];
					$item = $locals;
          $row = [
            'title' => $logistic['title'],
            'image' => $logistic['image'],
            'info' => implode('. ', array_filter([$logistic['info'], $item['info']])),
            'code' => (float) $logistic['code'],
            'price' => $item['price'],
            'centros' => [],
            'valid' =>  true
          ];
          $json['rates'][] = $row;
				} else {
					if (method_exists($this, "calculate_shipping_{$code}")) {
						$row = [
				      'title' => $logistic['title'],
				      'code' => $logistic['code'],
				      'image' => $logistic['image'],
				      'info' => $logistic['info'],
							'price' => (float) $this->{"calculate_shipping_{$code}"}($data, $cp, $unit_price),
							'centros' => [],
							'valid' =>  true
						];
						$json['rates'][] = $row;
					}
				}
			} else {
				// CakeLog::write('debug', 'deliveryCost(local_prices)');
				// buscamos todas las opciones disponibles
				// buscamos prioridad en envíos gratutios si lo hubiera.
				if ($freeShipping) {
					$local_prices_ids = [];
					$logistics = $this->Logistic->find('all', [
						'conditions' => [
							'enabled' => true,
							'free_shipping' => true
						]
					]);

					// get quotes for free shipping
					foreach($logistics as $logistic) {
						if($logistic['Logistic']['local_prices']) {
							$local_prices_ids[] = $logistic['Logistic']['id'];							
						} else {
							$item = $logistic['Logistic'];
							$code = $item['code'];
							$row = [];
							if (method_exists($this, "calculate_shipping_{$code}")) {
								$row = [
						      'title' => $item['title'],
						      'code' => $item['code'],
						      'image' => $item['image'],
						      'info' => $item['info'],
									'price' => $this->{"calculate_shipping_{$code}"}($data, $cp, $unit_price),
									'centros' => [],
									'valid' =>  true
								];
							}
							$json['rates'][] = $row;
						}
					}	

					$local_prices = $this->LogisticsPrices->find('all', [
						'conditions' => [
							'logistic_id' => $local_prices_ids,
							'enabled' => true,
	            'OR' => [
	              ['zips LIKE' => "%{$cp1}%"],
	              ['zips LIKE' => "%{$cp2}%"],
	              ['zips LIKE' => "%{$cp}%"]
	            ]
						]
					]);

					foreach($local_prices as $logistic_price) {
						$item = $logistic_price['LogisticsPrices'];
						$parent = $this->Logistic->findById($item['logistic_id'])['Logistic'];
	          $row = [
	            'title' => $parent['title'],
	            'image' => $parent['image'],
	            'code' => $parent['code'],
	            'info' => implode('. ', array_filter([$parent['info'], $item['info']])),
	            'price' => $item['price'],
	            'centros' => [],
	            'valid' =>  true
	          ];
	          $json['rates'][] = $row;
					}
				}

				if(empty($json['rates'])) {
	        // buscamos logísticas de alcance nacional
	        $logistics = $this->Logistic->find('all',[
	          'conditions' => [
	            'enabled' => true,
	            'local_prices' => false
	          ]
	        ]);

	        foreach($logistics as $logistic) {
	          $item = $logistic['Logistic'];
	          $code = $item['code'];
	          $row = [];
	          if (method_exists($this, "calculate_shipping_{$code}")) {
	            $row = [
	              'title' => $item['title'],
	              'code' => $item['code'],
	              'image' => $item['image'],
	              'info' => $item['info'],
	              'price' => $this->{"calculate_shipping_{$code}"}($data, $cp, $unit_price),
	              'centros' => [],
	              'valid' =>  true
	            ];
	          }
	          $json['rates'][] = $row;
	        }

	        // buscamos logísticas de alcance local
	        $locals = $this->LogisticsPrices->find('all', [
	          'conditions' => [
	            'enabled' => true,
	            'OR' => [
	              ['zips LIKE' => "%{$cp1}%"],
	              ['zips LIKE' => "%{$cp2}%"],
	              ['zips LIKE' => "%{$cp}%"]
	            ]
	          ]
	        ]);

	        foreach($locals as $logistic_price) {
	          $item = $logistic_price['LogisticsPrices'];
	          $parent = $this->Logistic->findById($item['logistic_id'])['Logistic'];
	          $row = [
	            'title' => $parent['title'],
	            'image' => $parent['image'],
	            'code' => $parent['code'],
	            'info' => implode('. ', array_filter([$parent['info'], $item['info']])),
	            'price' => (float) $item['price'],
	            'centros' => [],
	            'valid' =>  true
	          ];
	          $json['rates'][] = $row;
	        }
	      }
			}
		}

		// CakeLog::write('debug', 'deliveryCost(json):'.json_encode($json));
		return json_encode($json);
	}

	public function andreani_cotiza () {
		$this->autoRender = false;
		$data = $this->getItemsData();
		$cp = '1400';
		$result = $this->calculate_shipping_andreani($data, $cp, $data['price']);
		echo '<pre>';
		var_dump($result);
	}
	
	private function calculate_shipping_andreani ($data, $cp, $price) {
		$ws = new Andreani(getenv('ANDREANI_USUARIO'), getenv('ANDREANI_CLAVE'), getenv('ANDREANI_CONTRATO'), getenv('ANDREANI_DEBUG'));
		$package = $data['package'];
		$bultos = [
	    [
        'volumen' => (float) $package['width'] * (float) $package['height'] * (float) $package['depth'],
        'anchoCm' => (float) $package['width'],
        'largoCm' => (float) $package['height'],
        'altoCm' => (float) $package['depth'],
        'kilos' => (float) $package['weight'] / 1000,
        'valorDeclarado' => (integer) $price // $1200
	    ]
		];
		$cp = (integer) $cp;
		$response = $ws->cotizarEnvio($cp, getenv('ANDREANI_CONTRATO'), $bultos, getenv('ANDREANI_CLIENTE'));
		return isset($response->tarifaConIva) ? $response->tarifaConIva->total : null;
	} 

	private function calculate_shipping_oca ($data, $cp, $price) {
		if(!empty($data)){
			$oca = new Oca();
			//$PesoTotal, $VolumenTotal, $CodigoPostalOrigen, $CodigoPostalDestino, $CantidadPaquetes, $ValorDeclarado, $Cuit, $Operativa
			$response = $oca->tarifarEnvioCorporativo(
				$data['weight'] ,
				$data['volume'] ,
				1708 ,
				$cp ,
				1 ,
				intval($price) ,
				'30-71119953-1',
				271263
				//96637
			);
		} else {
			$response = array();
		}

		//CP Check
		$centros = $this->checkOcaCP($cp);
		//Price
		$price = !empty($response[0]['Precio']) ? (int) $response[0]['Precio'] : 0;
		// CakeLog::write('debug', 'price(2)'.$price.':'.gettype($price));
		return $price;
	}

	private function sale() {
		require_once(APP . 'Vendor' . DS . 'mercadopago.php');
		$settings = $this->load_settings();
		$this->autoRender = false;
		$total=0;
		$total_wo_discount = 0;
		// VAR - Validate
		$cart = $this->Session->read('cart');
		$cart_totals = $this->Session->read('cart_totals');
		$user_id = $this->Auth->user('id');
		$product_ids = array();
		$items = array();
		$customer = $cart_totals['customer'];
		$payment_method = $cart_totals['payment_method'] ?? 'mercadopago';
		$payment_dues = $cart_totals['payment_dues'] ?? 1;

		// lets check some shit
		if(empty($cart) || empty($cart_totals)) {
			// header("Location: /");
			$this->Session->setFlash('Tu carrito está vacío','default',array('class' => 'hidden error'));
			CakeLog::write('debug', 'sale(err): cart empty');
			return array(
				'success' => false,
				'errors' => "Tu carrito está vacío"
			);
			// $this->redirect(array( 'action' => 'clear' ));
		}

		$data = $this->request->data;


		/*$sale['id'] = $this->Auth->user('id');
		$sale['telephone'] = @preg_replace("/[^0-9]/","",$customer['telephone']);
		$sale['email'] = (!empty($customer['email']))?trim($customer['email']):'';
		$sale['floor'] = (!empty($customer['floor']))?trim($customer['floor']):'';
		$sale['depto'] = (!empty($customer['depto']))?trim($customer['depto']):'';
		$sale['coupon'] = (!empty($sale['coupon']))?strtoupper(trim($sale['coupon'])):'';
		//$sale['regalo'] = (isset($sale['regalo']) && $sale['regalo']?1:0);
		$sale['dues'] = (isset($sale['payment_dues']) && $sale['payment_dues']?intval($sale['payment_dues']):1);*/



		CakeLog::write('debug', 'sale(data):'. json_encode($data, JSON_PRETTY_PRINT));
		CakeLog::write('debug', 'sale(cart_totals):'. json_encode($cart_totals, JSON_PRETTY_PRINT));
		// return false; // - - - - - - remove - - - - - - -

		if(!isset($user_id)){
			$check_user = false;

			if(!empty($customer['email'])) {
				$check_user = $this->User->find('first', [
					'conditions' => [
						'email' => $customer['email']
					]
				]);				
			}

			if($check_user) { // match user by email
				// CakeLog::write('debug', '(sale) found user by email:' . $check_user['User']['id']);
				$user_id = $check_user['User']['id'];
				CakeLog::write('debug', 'sale(user): captured'. $user_id);
			} else { // user not found create and assing id
				$user_object = array(
					'email' => $customer['email'],
					'name' => $customer['name'],
					'surname' => $customer['surname'],
					'dni' => $customer['dni'],
					'telephone' => $customer['telephone'],
					'province' => $customer['province'],
					'city' => $customer['city'],
					'street' => $customer['street'],
					'floor' => $customer['floor'],
				);
				$this->User->save($user_object);
				$user_id = $this->User->id;
				CakeLog::write('debug', 'sale(user): created'. $user_id);
			}
		}

		// error_log('payment method: ' . $sale['payment_method']);
		// check if payment method is bank and bank payment is not available
		if (
			!empty($sale['payment_method']) && 
			$sale['payment_method'] === 'bank' && 
			empty($settings['bank_enable'])
		) {
			$this->Session->setFlash('No es posible pagar esta compra con CBU/Alias. Intente con otro método de pago. Disculpe las molestias.','default',array('class' => 'hidden error'));
			// error_log('checkout error: bank not available');
			// $this->redirect(array( 'controller' => 'carrito', 'action' => 'checkout' ));
			// CakeLog::write('debug', 'No es posible pagar esta compra con CBU/Alias. Intente con otro método de pago. Disculpe las molestias');
			CakeLog::write('debug', 'sale(err): No es posible pagar esta compra con CBU/Alias. Intente con otro método de pago. Disculpe las molestias');
			return array(
				'success' => false,
				'errors' => "No es posible pagar esta compra con CBU/Alias. Intente con otro método de pago. Disculpe las molestias",
				'redirect' => Router::url(array( 
					'controller' => 'checkout', 
					'action' => 'confirma' 
				)),
			);
		}

		if(!$this->request->is('post') || (
				$cart_totals['cargo'] === 'shipment' && 
				empty($customer['postal_address']) || 
				empty($customer['street_n']) || 
				empty($customer['street']) || 
				empty($customer['localidad']) || 
				empty($customer['provincia']) || 
				empty($customer['name']) || 
				empty($customer['surname']) || 
				empty($customer['email']) || 
				empty($customer['telephone'])
			)
		){
			
			$this->Session->setFlash('Es posible que el pago aún no se haya hecho efectivo, quizas tome mas tiempo','default',array('class' => 'hidden error'));
			// error_log('checkout error');
			// error_log(json_encode($sale));
			// $this->redirect(array( 'action' => 'clear' ));
			// CakeLog::write('debug', 'No es posible pagar esta compra con CBU/Alias. Intente con otro método de pago. Disculpe las molestias');
			CakeLog::write('debug', 'sale(err): Es posible que el pago aún no se haya hecho efectivo, quizas tome mas tiempo');			
			return array(
				'success' => false,
				'errors' => "Es posible que el pago aún no se haya hecho efectivo, quizas tome mas tiempo. Disculpe las molestias",
				'redirect' => Router::url(array( 'action' => 'clear' )),
			);
		}

		$sale_object = array(
			'id' => null,
			'user_id' => $user_id
		);
		
		$logistic = $this->Logistic->findByCode($cart_totals['shipping']);

		if(isset($logistic['Logistic'])) {
			$sale_object['logistic_id'] = $logistic['Logistic']['id'];
		}

		//Register Sale
		// CakeLog::write('debug', 'sale(save):'.json_encode($sale_object));
		$this->Sale->save($sale_object);
		$sale_id = $this->Sale->id;
		$gift_ids = !empty($data['gifts']) ? explode(",",$data['gifts']) : [];

		// check item prices, promos and coupons
		// Check coupon

		$coupon_bonus = 0;
		$bank_bonus = 0;
		$coupon_parsed = null;
		$cats = [];
		$prods = [];

		if (!empty($cart_totals['coupon'])) {
			// error_log('checking coupon: '.$cart_totals['coupon']);
			CakeLog::write('debug', 'sale(coupon):'.$cart_totals['coupon']);
	    $coupon = $this->Coupon->find('first', [
	      'conditions' => [
	        'code' => $cart_totals['coupon'],
	        'enabled' => 1,
	      ]
	    ]);  
	    if ($coupon) {
			  // look for coupon configuration
			  $this->loadModel('CouponItem');
			  $coupon_ids = $this->CouponItem->find('all', [
			    'conditions' => [
			      'coupon_id' => $coupon['Coupon']['id'],
			    ], 
			    'fields' => ['id', 'category_id', 'product_id']
			  ]);

			  if(!empty($coupon_ids)){
			    $prods = array_values(array_map(function($e) {
			      return $e['CouponItem']['product_id'];
			    },$coupon_ids));
			    $cats = array_values(array_map(function($e) {
			      return $e['CouponItem']['category_id'];
			    },$coupon_ids));
			  }			  
	    	//error_log('suming check coupon:'.json_encode($coupon));
	    	// CakeLog::write('debug', 'sale(coupon):'.json_encode($coupon));
				$coupon_parsed = \filtercoupon($coupon, $this->Session->read('cart_totals'), $data['price']);
			}
		}

		$discount = $coupon_parsed ? 
			(float) $coupon_parsed->data['discount'] : 
			0;

		$partial_bonus = $discount;

		foreach ($cart as $producto) {
			$unit_price = $producto['price'];

			if($partial_bonus < 0) {
				$partial_bonus = 0;
			}

			// check coupon			
			if (
				$coupon_parsed && 
				$coupon_parsed->status === 'success' && (
					(!count($cats) && !count($prods)) ||
					in_array($producto['category_id'],$cats) || 
					in_array($producto['id'],$prods)
				)
			) {
				if($coupon_parsed->data['coupon_type'] === 'percentage') {
					$coupon_bonus+= round($unit_price * ($discount / 100), 2);
					$unit_price = round($unit_price * (1 - $discount / 100), 2);
				} 
				if($coupon_parsed->data['coupon_type'] === 'nominal') {
					if($partial_bonus) {
						if($partial_bonus >= $unit_price) 	{
							$partial_bonus-= $unit_price;
							$coupon_bonus+= $unit_price;
							$unit_price = 0;	
						} else {
							$unit_price = round($unit_price - $partial_bonus,2);
							$coupon_bonus+= $unit_price;
							$partial_bonus-= $unit_price;
						}
					}
				}
			} else {
				//error_log("proderr::". $producto["name"]);
				// CakeLog::write('debug', 'sale(proderr):'.$producto["name"]);
				if(!empty($producto['discount']) && !empty((float)(@$producto['discount']))) {
	        $unit_price = @$producto['discount'];
	      }

				if($cart_totals['payment_method'] === 'mercadopago' && !empty($producto['mp_discount']) && !empty((float)(@$producto['mp_discount']))) {
	        $unit_price = @ceil(round($unit_price * (1 - (float) $producto['mp_discount'] / 100)));
	      }

				if($cart_totals['payment_method'] === 'bank' && !empty($producto['bank_discount']) && !empty((float)(@$producto['bank_discount']))) {
	        $unit_price = @ceil(round($unit_price * (1 - (float) $producto['bank_discount'] / 100)));
	      }				
			}

			$desc = '';
			$separator = ' -|- ';
			$values = array(
				'REGALO'	=> in_array($producto['id'], $gift_ids) ? 'SÍ': 'NO',
				'PEDIDO' 	=> $sale_id,
				'CODIGO'	=> $producto['article'],
				'PRODUCTO'  => $producto['name'],
				'COLOR'  	=> $producto['color'].' '.$producto['alias'],
				'TALLE'  	=> $producto['size'],
				'PRECIO_LISTA'  	=> $producto['price'],
				'PRECIO_DESCUENTO'  => $unit_price,
				'NOMBRE' 	=> $customer['name'],
				'APPELLIDO'	=> $customer['surname'],
				'EMAIL'		=> $customer['email'],
				'TELEFONO'	=> $customer['telephone'],
				'DNI'	=> $customer['dni'],
				'PROV'		=> $customer['provincia'],
				'LOC'		=> $customer['localidad'],
				'CALLE'		=> $customer['street'],
				'NRO'		=> $customer['street_n'],
				'PISO'		=> $customer['floor'],
				'DPTO'		=> $customer['depto'],
				'COD_POST'	=> $cart_totals['postal_address'],
				'CARGO'	=> $cart_totals['cargo'],
				'CUPON'	=> $cart_totals['coupon'],
				'STORE'	=> $cart_totals['store'],
				'STORE_ADDR'	=> $cart_totals['store_address'],
				'SHIPPING'	=> $cart_totals['shipping'],
				'CUOTAS'	=> $cart_totals['payment_dues']
			);

			foreach ($values as $key => $value) {
				$desc.= $key.' : "'.$value.'"'.$separator;
			}

			$items[] = array(
				'title' => $desc,
				'description' => $desc,
				'quantity' => 1,
				'currency_id' => 'ARS',
				'unit_price' => (int) $unit_price
			);
			$total+= (float) $unit_price;
			$product_ids[] = array(
				'product_id' => $producto['id'],
				'color' => $producto['color'],
				'size' => $producto['size'],
				'precio_lista' => (!empty($producto['orig_price']))?$producto['orig_price']:$producto['price'],
				'precio_vendido' => $unit_price,
				'sale_id' => $sale_id,
				'id' => null,
				'description' => $desc
			);
		}

		$total_wo_discount = (int) $total;
		// error_log('suming total (wo_discount): '.$total);
		CakeLog::write('debug', 'sale(wo_discount):'.$total);

	  // Check bank paying method
	  if ($cart_totals['payment_method'] === 'bank') {
	  	if($settings['bank_discount_enable'] && $settings['bank_discount']) {
	  		//error_log('suming applying bank');
	  		$bank_bonus = round($total_wo_discount * ($settings['bank_discount'] / 100), 2);
	  		// error_log('bank bonus: '.$bank_bonus);
	  		// CakeLog::write('debug', 'sale(bank):'.$bank_bonus);
	  	}
	  }

		if($cart_totals['payment_dues'] > 1) {
			$legend = $this->Legend->findByDues($cart_totals['payment_dues']);
			if($legend && $legend['Legend']['interest']) {
				$interest = (float) $legend['Legend']['interest'];
				$total*= ($interest / 100) + 1;
				// error_log('suming total (dues interest): '.$total);
				CakeLog::write('debug', 'sale(dues):'.$total);
				foreach($items as $k => $item) {
					$item_price = round($item['unit_price'] * (1 + $interest / 100), 2);
					$items[$k]['unit_price'] = $item_price;
					if ($product_ids[$k]) {
						$product_ids[$k]['precio_vendido'] = $item_price;
					}
				}				
			}
		}

	  if ($coupon_bonus) {
	  	// $total-= $coupon_bonus;
	  	CakeLog::write('debug', 'sale(coupon):'.$coupon_bonus);
	  	// error_log('suming total (coupon bonus): '.$coupon_bonus);
	  }

	  if ($bank_bonus) {
	  	$total-= $bank_bonus;
	  	CakeLog::write('debug', 'sale(bank):'.$bank_bonus);
	  	// error_log('suming total (bank bonus): '.$bank_bonus);
	  }

		// Add Delivery
		$delivery_cost = 0;
		$freeShipping = $this->Cart->isFreeShipping($total, $cart_totals['postal_address']);

		if ($freeShipping) { 
			CakeLog::write('debug', 'sale(freeshipping):'.'without delivery bc price is :'.$total.', cp:'. @$cart_totals['postal_address'] .'  and date = '.gmdate('Y-m-d'));
     	// error_log('without delivery bc price is :'.$total.', cp:'. @$cart_totals['postal_address'] .'  and date = '.gmdate('Y-m-d'));
			// $delivery_cost=0;
		} else {
			if ($cart_totals['cargo'] === 'shipment') {
				/* if (isset($delivery_data['rates'][0]['price'])) {
				} */
				// error_log('suming delivery to price: '.$delivery_cost);

				$delivery_data = json_decode($this->deliveryCost(
					$cart_totals['postal_address'], 
					$cart_totals['shipping'], 
					$cart_totals
				));

				CakeLog::write('debug', 'sale(delivery_Data): '.json_encode($delivery_data));
				$delivery_cost = (float) $delivery_data->rates[0]->price;
				CakeLog::write('debug', 'sale(deliverycost): '.$delivery_cost);

				$total += $delivery_cost;
			}
			// CakeLog::write('debug', 'sale(total): '.$total);
			// error_log('suming total: '.$total);
			$items[] = array(
				'title' => 'PEDIDO: '.$sale_id.' - COSTO DE ENVIO',
				'description' => 'PEDIDO: '.$sale_id.' - COSTO DE ENVIO',
				'quantity' => 1,
				'currency_id' => 'ARS',
				'unit_price' => $delivery_cost
			);
		}

		$shipping_config = $this->Setting->findById('shipping_type');
		$shipping_type_value = @$shipping_config['Setting']['value'];
		$zipCodes = @$shipping_config['Setting']['extra'];
		
		$sale_object = array(
			'id' => $sale_id,
			//'user_id' => $sale['id'],
			'free_shipping' => $freeShipping,
			'payment_method' => $cart_totals['payment_method'],
			'deliver_cost' => $delivery_cost,
			'shipping_type' => $shipping_type_value
		);

		CakeLog::write('debug', 'sale(object)'.json_encode($sale_object, JSON_PRETTY_PRINT));

		$this->Sale->save($sale_object);
		//Re - Registar Sale Products
		// $sale['Sale']['id'] = $sale_id;

		if (!$this->SaleProduct->saveMany($product_ids)) {
      $this->Session->setFlash(
        'Error al procesar la compra, por favor intente nuevamente',
        'default',
        array('class' => 'hidden error')
      );

      CakeLog::write('debug', 'sale(err): Error al procesar la compra, por favor intente nuevamente');

      $this->Sale->delete($sale_id,true);

      return array(
      	'success' => false,
      	'errors' => 'Error al procesar la compra, por favor intente nuevamente'
      );

      $this->Sale->delete($sale_id,true);
			// return $this->redirect($this->referer());
		}
		//Register Extra Info
		$to_save = array(
			'id' 		=> $sale_id,
			'user_id' => $user_id,
			'nroremito'	=> $sale_id,
			'apellido'	=> $customer['surname'],
			'nombre'	=> $customer['name'],
			'dni'	=> $customer['dni'],
			'calle'		=> $customer['street'],
			'nro'		=> $customer['street_n'],
			'piso'		=> $customer['floor'],
			'depto'		=> $customer['depto'],
			'cp'		=> $customer['postal_address'],
			'localidad'	=> $customer['localidad'],
			'provincia'	=> $customer['provincia'],
			'telefono'	=> $customer['telephone'],
			'email'		=> $customer['email'],
			'regalo'		=> count($gift_ids),
			'package_id'=> @$delivery_data->itemsData->package->id ?? 1,
			'value' 	=> $total, // @$delivery_data['itemsData']['price'],
			'zip_codes' => $zipCodes,
			'cargo'		=> $cart_totals['cargo'],
			'coupon'	=> $cart_totals['coupon'],
			'metodo_pago'	=> $cart_totals['payment_method'],
			'store'		=> $cart_totals['store'],
			'store_address'		=> $cart_totals['store_address'],
			'shipping'		=> $cart_totals['shipping'],
			'dues'		=> $cart_totals['dues']
		);

		CakeLog::write('debug', 'sale(to_save)'.json_encode($to_save));
		CakeLog::write('debug', 'settings(1)'.json_encode($settings));
		// error_log(json_encode($to_save));
		$this->Sale->save($to_save);
		// error_log("total mp: " . $total);
		// CakeLog::write('debug', 'sale(mp): '.$total);

		// check if paying method is bank
		if ($sale['payment_method'] === 'bank') {
			// CakeLog::write('debug', 'destroy session(1)');
			$this->Cart->destroy();

			CakeLog::write('debug', '(cbu) ok - Cuando uses el cbu se iniciará la compra');
			return array(
				'success' => true,
				'message' => "Cuando uses el cbu se iniciará la compra",
				'redirect' => Router::url(array( 'controller' => 'ayuda', 'action' => 'onlinebanking', $sale_id, '#' =>  'f:.datos-bancarios' )),
			);
		}

		//MP
		// $mp = new MP(Configure::read('mercadopago_client_id'), Configure::read('mercadopago_client_secret'));
		
		$mp = new MP($settings['mercadopago_client_id'], $settings['mercadopago_client_secret']);
		$success_url = Router::url(array('controller' => 'checkout', 'action' => 'success'), true);
		$failure_url = Router::url(array('controller' => 'checkout', 'action' => 'error'), true);

		$preference_data = array(
			'external_reference' => $sale_id,
	    'items' => $items,
	    'payer' => array(
	    	'name' => $customer['name'],
	    	'surname' => $customer['surname'],
	    	'email' => $customer['email']
    	),
	    'back_urls' => array(
	    	'success' => $success_url,
	    	'failure' => $failure_url,
	    	'pending' => $failure_url
    	),
    	'payment_methods' => array(
    		'installments' => (int) $cart_totals['payment_dues']
    	)
		);
		CakeLog::write('debug', 'sale(preference):'.json_encode($preference_data));
		$preference = $mp->create_preference($preference_data);
		//Save Data
		$sale_data = array(
			'sale' 		=> $sale,
			'items' 	=> $items,
			'sale_id' 	=> $sale_id,
			'preference'=> $preference,
			'products' => $product_ids,
			'total' => $total
		);

		$this->Session->write('sale_data',$sale_data);
		$redirect = "";

		// $redirect = "/shop/mis_compras/{$sale_id}";
		//Setting
		// if(empty(Configure::read('MP_IN_SANDBOX_MODE'))) {
		if($settings['mercadopago_sanbox_on'] == 'off') {
			//Production
			$mp->sandbox_mode(FALSE);
			$redirect = $preference['response']['sandbox_init'];
			//error_log('entering mp production mode');
			// return $this->redirect($preference['response']['init_point']);
		}else{
			//Sandbox
			$mp->sandbox_mode(TRUE);
			//error_log('entering mp sandbox mode');
			//error_log($preference['response']['sandbox_init_point']);
			$redirect = $preference['response']['sandbox_init_point'];
			// return $this->redirect($preference['response']['sandbox_init_point']);
		}

		CakeLog::write('debug', 'sale(redirect):'.json_encode($redirect));

		return array(
			'success' => true,
			'message' => 'Se creó con éxito la preferencia, espere un momento... ',
			'redirect' => $redirect
		);
	}

	private function notify_user($data, $status){
		if ($status=='success'){

$message = '<p>¡Hola <strong>'.ucfirst($data['user']['name']).'</strong>!<br> Estás recibiendo este e-mail porque realizaste una compra en CHÂTELET.<br/><br/>Tu n&uacute;mero de Pedido es: <strong>'.$data['sale_id'].'</strong>.</p>

<p>Te enviaremos el pedido cuando recibamos la confirmación de la
venta por parte del medio de pago elegido.</p>

<p>Tu compra será procesada dentro de las 72hs de haberse acreditado
el pago.</p>

<p>Ante cualquier consulta no dudes en contactarnos a través de VENTASONLINE@OUTLOOK.COM.AR, indicándonos número de pedido.</p>

<p>¡Muchas gracias!</p>

<br/><a href="https://www.chatelet.com.ar">CHÂTELET</a>';

		}else{

$message = '<p>¡Hola <strong>'.ucfirst($data['user']['name']).'</strong>!<br> Estás recibiendo este e-mail porque realizaste una compra en CHÂTELET.<br/><br/>Tu n&uacute;mero de Pedido es: <strong>'.$data['sale_id'].'</strong>.</p>

<p>Te enviaremos el pedido cuando recibamos la confirmación de la
venta por parte del medio de pago elegido.</p>

<p>Tu compra será procesada dentro de las 72hs de haberse acreditado
el pago.</p>

<p>Ante cualquier consulta no dudes en contactarnos a través de VENTASONLINE@OUTLOOK.COM.AR, indicándonos número de pedido.</p>

<p>¡Muchas gracias!</p>

<br/><a href="https://www.chatelet.com.ar">CHÂTELET</a>';

		}
		error_log('[email] notifying user '.$data['user']['email']);
		$this->sendMail($message,'🌸 Gracias por comprar en CHÂTELET',$data['user']['email']);
	}

	public function failed() {
			$data = $this->Session->read('sale_data');
			// error_log('Failed payment: '.json_encode($data));
			// CakeLog::write('debug', 'Failed payment');
			$this->Session->delete('cart');
			$this->Session->delete('sale_data');
			$this->set('sale_data',$data);
			$this->set('failed', true);
			if (!empty($_GET['collection_status']) && $_GET['collection_status']=='pending'){
				// error_log('pending');
				// CakeLog::write('debug', 'Failed payment: pending');
				$this->notify_user($data, 'pending');
				return $this->render('clear');
			}else{
				// CakeLog::write('debug', 'Failed payment: failed');
				// error_log('failed');
				return $this->render('clear_no');
			}
	}

	public function clear() { //success
		// error_log('success payment: '.json_encode($this->Session->read('sale_data')));
		// CakeLog::write('debug', 'Success payment:'.json_encode($this->Session->read('sale_data')));
		if( $this->Session->check( 'sale_data' ) ){
			$sale_data = $this->Session->read('sale_data');
			$sale_object = array(
				'id' 		=> $sale_data['sale_id'],
				'completed' => 1
			);
			// CakeLog::write('debug', 'sale(4)'.json_encode($to_save));			
			$this->Sale->save($sale_object);
			$this->set('sale_data',$this->Session->read('sale_data'));
			$this->notify_user($this->Session->read('sale_data'), 'success');
			$this->Session->delete('cart');
			$this->Session->delete('sale_data');
			return $this->render('clear');
			//error_log('success');
		}else{
			error_log('no sale data');
			$this->Session->delete('cart');
			$this->Session->delete('sale_data');
			return $this->render('clear_no');
			//return $this->redirect(array('controller' => 'home', 'action' => 'index'));
		}
	}
}
