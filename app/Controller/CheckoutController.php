<?php

require_once(APP . 'Vendor' . DS . 'oca.php');
require_once(APP . 'Vendor' . DS . 'curl.php');
require __DIR__ . '/../Vendor/andreani/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../Vendor/andreani/');
$dotenv->load();

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
		'Legend'
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
			'url' => '/checkout/finalizar',
			'label' => 'Confirmación'
		),
	);

	public $components = array('RequestHandler');

	public function beforeFilter()
	{
  	parent::beforeFilter();
  	$this->set('sorted', $this->sort());
		$index = array_search($this->request->here, array_column($this->checkout_steps, 'url'));
		$this->set('checkout_index', $index);
		$this->set('checkout_steps', $this->checkout_steps);
	}

	public function index()
	{
		/*$data = $this->getItemsData();
		$cart = $this->updateCart();
		$this->Session->write('cart', $cart);
		$shipping_price = $this->Setting->findById('shipping_price_min');
		$total_price = $data['price'];
		$freeShipping = $this->isFreeShipping($total_price);
		error_log('freeshipping unit price: '.intval($total_price));
		$stores = $this->Store->find('all', [
			'conditions' => ['takeaway' => 1]
		]);
		$mapper = $this->Setting->findById('shipping_price_min');
		$shipping_price_min = (!empty($mapper['Setting']['value'])) ? $mapper['Setting']['value'] : '';
		$this->set('shipping_price_min',$shipping_price_min);
		$vars = [
			'precio_min_envio_gratis' => str_replace(',00','',number_format($shipping_price_min, 0, ',', '.')),
			'resto_min_envio_gratis' => str_replace(',00','',number_format($shipping_price_min - (integer) $data['price'], 0, ',', '.')),
			'total' => str_replace(',00','',number_format($data['price'], 0, ',', '.'))
		];

    $mapper = $this->Setting->findById('display_text_shipping_min_price');
    $display_text_shipping_min_price = $mapper['Setting']['value'];
    $mapper = $this->Setting->findById('text_shipping_min_price');
		$shipping_config = $this->Setting->findById('shipping_type');

		if (@$shipping_config['Setting']['value'] == 'min_price') {
			$text_shipping_min_price = ($display_text_shipping_min_price && !empty($mapper['Setting']['value'])) ? $this->parseTemplate($mapper['Setting']['value'], $vars) : '';
			$this->set('text_shipping_min_price',$text_shipping_min_price);
		}

		$map = $this->Setting->findById('carrito_takeaway_text');
 		$carrito_takeaway_text = $map['Setting']['extra'];		
		$this->set('carrito_takeaway_text', $carrito_takeaway_text);
		$this->set('freeShipping', $freeShipping);*/

		// $this->set('stores', $stores);
	}

	public function envio() {
		$stores = $this->Store->find('all', [
			'conditions' => ['takeaway' => 1]
		]);
		$this->set('stores', $stores);
	}
	private function parseTemplate ($str, $data) {
		$html = $str;
    foreach ($data as $key => $value) {
      $html = str_replace(["{{" . $key . "}}", "{{ " . $key . " }}"], $value, $html);
    }		
		return $html;
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

	public function pago()
	{
		if (!$this->Session->read('cart')) {
			$this->redirect(array( 'action' => 'clear' ));
			die;
		}

		$oca = new Oca();
		$provincias = $oca->getProvincias();
		$user = $this->User->find('first',array('recursive' => -1,'conditions'=>array('User.id' => $this->Auth->user('id'))));
		$items = $this->getItemsData();
		$map = $this->Setting->findById('shipping_price_min');
		$shipping_price = @$map['Setting']['value'];
		$total_price = $items['price'];
		$freeShipping = $this->isFreeShipping($total_price);
	
		$this->set('shipping_price',$shipping_price);
		$this->set('provincias',$provincias);
		$this->set('freeShipping', $freeShipping);
		$this->set('total',$total_price);
		$this->set('userData',$user);
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
		$bank_enable = @$map['Setting']['value'];
		$map = $this->Setting->findById('bank_discount_enable');
		$bank_discount_enable = @$map['Setting']['value'];
		$map = $this->Setting->findById('bank_discount');
		$bank_discount = @$map['Setting']['value'];

		$response = (object) [
			'enable' => @$bank_enable,
			'discount_enable'=> @$bank_discount_enable,
			'discount'=> @$bank_discount
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
				'title' => "Promo desconocida: " . $this->request->data['coupon'],
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

		$coupon_parsed->data["updated"] = $updated;
		$coupon_parsed->data["total"] = $total;
		$coupon_parsed->data["bonus"] = $discount;
		

		return json_encode($coupon_parsed);
	}

	public function deliveryCost($cp, $sale = null, $encode = true){

		if ($sale['cargo'] === 'takeaway') {
			$json['rates'][] = 0;
			return $json;
		}

		$cp = $cp ? $cp : @$sale['postal_address'];
		$code = @$sale['shipping'];

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
		$freeShipping = $this->isFreeShipping($unit_price, $cp);
		$json = array(
			'freeShipping' => $freeShipping,
			'rates' => [],
			'itemsData' => $data
		);

		if(!empty($data)){
			if ($code) {
				// necesitamos cotizacion de una empresa
				$code = strtolower($code);
				$logistic = $this->Logistic->find('first',[
					'conditions' => [
						'enabled' => true,
						'code' => $code
					]
				])['Logistic'];
				if ($logistic['local_prices']) {
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
            'code' => $logistic['code'],
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
							'price' => $this->{"calculate_shipping_{$code}"}($data, $cp, $unit_price),
							'centros' => [],
							'valid' =>  true
						];
						$json['rates'][] = $row;
					}
				}
			} else {
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
	            'price' => $item['price'],
	            'centros' => [],
	            'valid' =>  true
	          ];
	          $json['rates'][] = $row;
	        }
	      }
			}
		}

		if($encode){
			return json_encode($json);
		} else {
			return $json;	
		}		
	}

	public function isFreeShipping ($price, $zip_code = 0) {
		$shipping_config = $this->Setting->findById('shipping_type');
		$shipping_price = $this->Setting->findById('shipping_price_min');
		$freeShipping = false;
		if (!empty($shipping_config) && !empty($shipping_config['Setting']['value'])) {
			if (@$shipping_config['Setting']['value'] == 'min_price' || $shipping_price['Setting']['value'] > 1){
				$freeShipping = intval($price) >= intval($shipping_price['Setting']['value']);
			}
			if (!$freeShipping && $zip_code && @$shipping_config['Setting']['value'] == 'zip_code'){
				$zip_codes = explode(',',$shipping_config['Setting']['extra']);
				if (count($zip_codes)) {
					$filter = [];
					foreach($zip_codes as $code) {
						$filter[] = trim($code);
					}
					$freeShipping = in_array($zip_code, $filter);
				}
			}
			// error_log('shipping_value: '.@$shipping_config['Setting']['value']);
		}		
		return $freeShipping;
		// return intval($price) >= intval($shipping_price['Setting']['value']);
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

		return $price;
	}


	public function sale() {
		require_once(APP . 'Vendor' . DS . 'mercadopago.php');

		$this->autoRender = false;
		$total=0;
		$total_wo_discount = 0;
		// VAR - Validate
		$cart = $this->Session->read('cart');

		if(empty($cart)) {
			header("Location: /");
			return false;
		}

		$user_id = $this->Auth->user('id');
		$product_ids = array();
		$items = array();
		$sale = $this->request->data;

		CakeLog::write('debug', 'sale:'. json_encode($sale));
		$sale['id'] = $this->Auth->user('id');
		$sale['telephone'] = @preg_replace("/[^0-9]/","",$sale['telephone']);
		$sale['email'] = (!empty($sale['email']))?trim($sale['email']):'';
		$sale['floor'] = (!empty($sale['floor']))?trim($sale['floor']):'';
		$sale['depto'] = (!empty($sale['depto']))?trim($sale['depto']):'';
		$sale['coupon'] = (!empty($sale['coupon']))?strtoupper(trim($sale['coupon'])):'';
		//$sale['regalo'] = (isset($sale['regalo']) && $sale['regalo']?1:0);
		$sale['dues'] = (isset($sale['payment_dues']) && $sale['payment_dues']?intval($sale['payment_dues']):1);

		if(!isset($user_id)){
			$check_user_id = 0;
			$check_user = $this->User->find('first', [
				'conditions' => [
					'email' => $sale['email']
				]
			]);

			if($check_user) { // user found assing id
				CakeLog::write('debug', '(sale) found user by email:' . $check_user['User']['id']);
				$check_user_id = $check_user['User']['id'];
			} else { // user not found create and assing id
				CakeLog::write('debug', '(sale) creating new user:' . $sale['email']);
				$user_object = [
					'email' => $sale['email'],
					'name' => $sale['name'],
					'surname' => $sale['surname'],
					'dni' => $sale['dni'],
					'telephone' => $sale['telephone'],
					'province' => $sale['province'],
					'city' => $sale['city'],
					'street' => $sale['street'],
					'floor' => $sale['floor'],
				];
				$this->User->save($user_object);
				$check_user_id = $this->User->id;
			}
			$user_id = $check_user_id;
		}


		$map = $this->Setting->findById('bank_enable');
		$bank_enable = @$map['Setting']['value'];
		$map = $this->Setting->findById('bank_discount_enable');
		$bank_discount_enable = @$map['Setting']['value'];
		$map = $this->Setting->findById('bank_discount');
		$bank_discount = @$map['Setting']['value'];

		error_log('payment method: ' . $sale['payment_method']);

		// check if payment method is bank and bank payment is not available
		if (!empty($sale['payment_method']) && $sale['payment_method'] === 'bank' && !$bank_enable) {
			$this->Session->setFlash('No es posible pagar esta compra con CBU/Alias. Intente con otro método de pago. Disculpe las molestias.','default',array('class' => 'hidden error'));
			error_log('checkout error: bank not available');
			$this->redirect(array( 'controller' => 'carrito', 'action' => 'checkout' ));
			die;
		}

		if(!$this->request->is('post') || $sale['cargo'] === 'shipment' && empty($sale['postal_address']) || empty($sale['street_n']) || empty($sale['street']) || empty($sale['localidad']) || empty($sale['provincia']) || empty($sale['name']) || empty($sale['surname']) || empty($sale['email']) || empty($sale['telephone'])){
			$this->Session->setFlash('Es posible que el pago aún no se haya hecho efectivo, quizas tome mas tiempo.','default',array('class' => 'hidden error'));
			error_log('checkout error');
			error_log(json_encode($sale));
			$this->redirect(array( 'action' => 'clear' ));
			die;
		}

		$sale_object = array('id' => null,'user_id' => $user_id);
		$logistic = $this->Logistic->findByCode($sale['shipping']);

		if(isset($logistic['Logistic'])) {
			$sale_object['logistic_id'] = $logistic['Logistic']['id'];
		}

		//Register Sale
		CakeLog::write('debug', 'sale(1)'.json_encode($sale_object));
		$this->Sale->save($sale_object);
		$sale_id = $this->Sale->id;
		$gift_ids = !empty($sale['gifts']) ? explode(",",$sale['gifts']) : [];

		// check item prices, promos and coupons

		// Check coupon
		$coupon_bonus = 0;
		$bank_bonus = 0;
		$coupon_parsed = null;
		$cats = [];
		$prods = [];
		if (!empty($sale['coupon'])) {
			error_log('checking coupon: '.$sale['coupon']);
	    $coupon = $this->Coupon->find('first', [
	      'conditions' => [
	        'code' => $sale['coupon'],
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
	    	error_log('suming check coupon:'.json_encode($coupon));
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
				error_log("proderr::". $producto["name"]);
				if(!empty($producto['discount']) && !empty((float)(@$producto['discount']))) {
	        $unit_price = @$producto['discount'];
	      }

				if($sale['payment_method'] === 'mercadopago' && !empty($producto['mp_discount']) && !empty((float)(@$producto['mp_discount']))) {
	        $unit_price = @ceil(round($unit_price * (1 - (float) $producto['mp_discount'] / 100)));
	      }

				if($sale['payment_method'] === 'bank' && !empty($producto['bank_discount']) && !empty((float)(@$producto['bank_discount']))) {
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
				'NOMBRE' 	=> $sale['name'],
				'APPELLIDO'	=> $sale['surname'],
				'EMAIL'		=> $sale['email'],
				'TELEFONO'	=> $sale['telephone'],
				'DNI'	=> $sale['dni'],
				'PROV'		=> $sale['provincia'],
				'LOC'		=> $sale['localidad'],
				'CALLE'		=> $sale['street'],
				'NRO'		=> $sale['street_n'],
				'PISO'		=> $sale['floor'],
				'DPTO'		=> $sale['depto'],
				'COD_POST'	=> $sale['postal_address'],
				'CARGO'	=> $sale['cargo'],
				'CUPON'	=> $sale['coupon'],
				'STORE'	=> $sale['store'],
				'STORE_ADDR'	=> $sale['store_address'],
				'SHIPPING'	=> $sale['shipping'],
				'CUOTAS'	=> $sale['dues']
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
		error_log('suming total (wo_discount): '.$total);

	  // Check bank paying method
	  if ($sale['payment_method'] === 'bank') {
	  	if($bank_discount_enable && $bank_discount) {
	  		//error_log('suming applying bank');
	  		$bank_bonus = round($total_wo_discount * ($bank_discount / 100), 2);
	  		error_log('bank bonus: '.$bank_bonus);
	  	}
	  }

		if($sale['dues'] > 1) {
			$legend = $this->Legend->findByDues($sale['dues']);
			if($legend && $legend['Legend']['interest']) {
				$interest = (float) $legend['Legend']['interest'];
				$total*= ($interest / 100) + 1;
				error_log('suming total (dues interest): '.$total);
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
	  	error_log('suming total (coupon bonus): '.$coupon_bonus);
	  }

	  if ($bank_bonus) {
	  	$total-= $bank_bonus;
	  	error_log('suming total (bank bonus): '.$bank_bonus);
	  }

		// Add Delivery
		$delivery_cost = 0;
		$freeShipping = $this->isFreeShipping($total, $sale['postal_address']);
		$delivery_data = $this->deliveryCost(null, $sale, false);
		$delivery_cost = (integer) $delivery_data['rates'][0]['price'];
		if ($freeShipping) { 
     	error_log('without delivery bc price is :'.$total.', cp:'. @$sale['postal_address'] .'  and date = '.gmdate('Y-m-d'));
			// $delivery_cost=0;
		} else {
			if ($sale['cargo'] === 'shipment') {
				/* if (isset($delivery_data['rates'][0]['price'])) {
				} */
				error_log('suming delivery to price: '.$delivery_cost);
				$total += $delivery_cost;
			}
			error_log('suming total: '.$total);
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
			'payment_method' => $sale['payment_method'],
			'deliver_cost' => $delivery_cost,
			'shipping_type' => $shipping_type_value
		);
		CakeLog::write('debug', 'sale(2)'.json_encode($sale_object));

		$this->Sale->save($sale_object);

		//Re - Registar Sale Products
		$sale['Sale']['id'] = $sale_id;
		if (!$this->SaleProduct->saveMany($product_ids)) {
      $this->Session->setFlash(
          'Error al procesar la compra, por favor intente nuevamente',
          'default',
          array('class' => 'hidden error')
      );
      $this->Sale->delete($sale_id,true);
			return $this->redirect($this->referer());
		}
		//Register Extra Info
		$to_save = array(
			'id' 		=> $sale_id,
			'user_id' => $user_id,
			'nroremito'	=> $sale_id,
			'apellido'	=> $sale['surname'],
			'nombre'	=> $sale['name'],
			'dni'	=> $sale['dni'],
			'calle'		=> $sale['street'],
			'nro'		=> $sale['street_n'],
			'piso'		=> $sale['floor'],
			'depto'		=> $sale['depto'],
			'cp'		=> $sale['postal_address'],
			'localidad'	=> $sale['localidad'],
			'provincia'	=> $sale['provincia'],
			'telefono'	=> $sale['telephone'],
			'email'		=> $sale['email'],
			'regalo'		=> count($gift_ids),
			'package_id'=> @$delivery_data['itemsData']['package']['id'] ?: 1,
			'value' 	=> $total, // @$delivery_data['itemsData']['price'],
			'zip_codes' => $zipCodes,
			'cargo'		=> $sale['cargo'],
			'coupon'	=> $sale['coupon'],
			'metodo_pago'	=> $sale['payment_method'],
			'store'		=> $sale['store'],
			'store_address'		=> $sale['store_address'],
			'shipping'		=> $sale['shipping'],
			'dues'		=> $sale['dues']
		);

CakeLog::write('debug', 'sale(3)'.json_encode($to_save));
		// error_log(json_encode($to_save));
		$this->Sale->save($to_save);
		error_log("total mp: " . $total);

		// check if paying method is bank
		if ($sale['payment_method'] === 'bank') {
			$this->Session->delete('cart');
			return $this->redirect(array( 'controller' => 'ayuda', 'action' => 'onlinebanking', $sale_id, '#' =>  'f:.datos-bancarios' ));
		}

		//MP
		$mp = new MP(Configure::read('mercadopago_client_id'), Configure::read('mercadopago_client_secret'));
		$success_url = Router::url(array('controller' => 'carrito', 'action' => 'clear'), true);
		$failure_url = Router::url(array('controller' => 'carrito', 'action' => 'failed'), true);

		$preference_data = array(
	    'items' => $items,
	    'payer' => array(
	    	'name' => $sale['name'],
	    	'surname' => $sale['surname'],
	    	'email' => $sale['email']
    	),
	    'back_urls' => array(
	    	'success' => $success_url,
	    	'failure' => $failure_url,
	    	'pending' => $failure_url
    	),
    	'payment_methods' => array(
    		'installments' => $sale['dues']
    	)
		);

		/*if(!empty(Configure::read('MP_IN_SANDBOX_MODE'))) {
			echo '<pre>';
			var_dump($preference_data);
			die("no payments yet");
		}*/

		$preference = $mp->create_preference($preference_data);
		//Save Data
		$sale_data = array(
			'sale' 		=> $sale,
			'items' 	=> $items,
			'sale_id' 	=> $sale_id,
			'preference'=> $preference,
			'products'=>$product_ids,
			'total'=>$total
		);
		$this->Session->write('sale_data',$sale_data);

		//Setting
		if(empty(Configure::read('MP_IN_SANDBOX_MODE'))) {
			//Production
			$mp->sandbox_mode(FALSE);
			//error_log('entering mp production mode');
			return $this->redirect($preference['response']['init_point']);
		}else{
			//Sandbox
			$mp->sandbox_mode(TRUE);
			//error_log('entering mp sandbox mode');
			//error_log($preference['response']['sandbox_init_point']);
			return $this->redirect($preference['response']['sandbox_init_point']);
		}
	}

	public function preference(){
		$this->autoRender = false;

		$cart_totals = $this->Session->read('cart_totals');
		$data = $this->request->data;

		// replace session config with post object pairs
		foreach($data as $key => $item) {
			$cart_totals[$key] = $item;
		}

    if(empty($cart_totals['payment_method'])){
      $cart_totals['payment_method'] = 'mercadopago';
    }

		$this->Session->write('cart_totals', $cart_totals);
		error_log('payment_method:'.$cart_totals['payment_method']);
		//CakeLog::write('debug', 'updateCart(3)');
		$cart = $this->updateCart();
		$this->Session->write('cart', $cart);

		return json_encode(array('success' => true, 'data' => array_values($cart)));
	}

	public function empty($row = null) {
		$this->autoRender = false;
		$this->Session->delete('cart');
	}

	public function show($row = null) {
		$this->autoRender = false;
		echo '<pre>';
		var_dump($this->Session->read('cart_totals'));
		var_dump($this->Session->read('cart'));
	}

	public function sorted() {
		$this->autoRender = false;
		echo '<pre>';
		var_dump($this->sort());
	}

	public function add() {
		$this->autoRender = false;
		$this->RequestHandler->respondAs('application/json');
		if ($this->request->is('post')) {
			$data = $this->request->data;
			//$this->RequestHandler->respondAs('application/json');

			if(
				!isset($this->request->data['id']) || 
				!isset($this->request->data['count'])
			) {
				return $this->redirect(array('controller' => 'home', 'action' => 'index'));
			}

			$product = $this->Product->findById($this->request->data['id']);
			$urlCheck = Configure::read('baseUrl')."shop/stock/".$product['Product']['article']."/".$this->request->data['size']."/".$this->request->data['color_code'];

			if (empty($this->request->data['size']) && empty($this->request->data['color_code'])){
				//$urlCheck=Configure::read('baseUrl')."shop/stock/".$product['Product']['article'];
				error_log('fake stock');
				$stock=1;
			} else {
				error_log($urlCheck);
				$ch = curl_init();
			    curl_setopt($ch, CURLOPT_URL, $urlCheck);
			    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
			    $stock = (string)curl_exec($ch);
			    curl_close($ch);
			}

			
			$filter = [];
			error_log('stock:'.$stock);
			// error_log('curl:'.$stock);
			//$stock=1;
			if ($product && $stock) {
				$cart = $this->Session->read('cart');
				$product = $product['Product'];

				/* remove all of the kind */
				$criteria = $this->request->data['id'].$this->request->data['size'].$this->request->data['color'].$this->request->data['alias'];

				if (!empty($cart)) {
					foreach($cart as $key => $item) {
						if($criteria != $item['id'].$item['size'].$item['color'].$item['alias']) {
							$filter[]= $item;
						}
					}
				}

				$product['color'] = @$this->request->data['color'];
				$product['size'] = @$this->request->data['size'];
				$product['alias'] = @$this->request->data['alias'];
				$product['color_code'] = @$this->request->data['color_code'];

				for ($i=0; $i < $this->request->data['count']; $i++) {
					$filter[] = $product;
				}
				// $cart = array_fill(count($cart), $this->request->data['count'], $product);
				// error_log('[carrito] '.json_encode($filter));
				// error_log('[carrito] '.json_encode($this->filter($filter)));

				// filter(1)
			}

			$cart_totals = $this->Session->read('cart_totals');
			$cur = @$cart_totals['add_basket']?: 0;
			$cur++;
			@$cart_totals['add_basket'] = $cur;
			//CakeLog::write('debug', 'updateCart(4)');
			$cart = $this->updateCart($filter);
			$this->Session->write('cart', $cart);
			$this->Session->write('cart_totals', $cart_totals);

			return json_encode(array('success' => true));
		}
		//return $this->redirect(array('controller' => 'carrito', 'action' => 'index'));
		return json_encode(array('success' => false));
	}

	private function sort() {
		$cart = $this->Session->read('cart');
		$cart_totals = $this->Session->read('cart_totals');
		$payment_method = @$cart_totals['payment_method'] ?: 'mercadopago';
		$payment_dues = @$cart_totals['payment_dues'] ?: '1';
		$groups = [];
		$sort = [];

		if (!empty(@$cart)) {
			foreach($cart as $key => $item) {
				$criteria = $item['id'].$item['size'].$item['color'].$item['alias'];
				//CakeLog::write('debug', 'citeria:'. $criteria);
				if (!isset($groups[$criteria])) {
					$groups[$criteria] = 0;
				}

				$groups[$criteria]++;
				if ($groups[$criteria] === 1) {
					$item['count'] = 1;
					$sort[$criteria] = (array) $item;
				} else {
					$sort[$criteria]['count'] = $groups[$criteria];
					$sort[$criteria]['price']+= $item['price'];
					$sort[$criteria]['old_price']+= $item['old_price'];
					if (!empty($item['promo_enabled'])) {
						$sort[$criteria]['promo_enabled'] = $item['promo_enabled'];
					}
				}
				$sort[$criteria]['item_price'] = $item['price'];
				$sort[$criteria]['item_old_price'] = $item['old_price'];
			}
		}

		/* if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
			file_put_contents(__DIR__.'/../logs/carrito_sort.json', json_encode($sort, JSON_PRETTY_PRINT));
		}*/

		return $sort;
	}

	private function updateCart($cart=false) {
		$cart_totals = $this->Session->read('cart_totals');
		$payment_method = @$cart_totals['payment_method'] ?: 'mercadopago';

		//CakeLog::write('debug','cart(1)');
		//CakeLog::write('debug',json_encode($cart));

		if (empty($cart)) {
			$cart = $this->Session->read('cart');
			//CakeLog::write('debug','cart(2)');
			//CakeLog::write('debug',json_encode($cart));
		}

		$groups = [];
		$counts = [];
		$map = $this->Setting->findById('bank_enable');
		$bank_enable = @$map['Setting']['value'];
		$map = $this->Setting->findById('bank_discount_enable');
		$bank_discount_enable = @$map['Setting']['value'];
		$map = $this->Setting->findById('bank_discount');
		$bank_discount = @$map['Setting']['value'];

		// $counted = [];
		/*count prods */

		if (!empty($cart)) {
			/* apply basic prices and fill promos data */
			foreach($cart as $key => $item) {
				$prod = $this->Product->findById($item['id']);

				if(empty($prod)) {
					unset($cart[$key]);
					continue;
				}

				$prod = $prod['Product'];
				$price = $prod['price'];

	      $prop = $this->ProductProperty->find('all', array('conditions' => array(
	  			'product_id' => $prod['id'],
	  			'alias' => $item['alias']
	  		)));

	  		if ($prop) {
	  			$arrImages = array_values(array_filter(explode(';', $prop[0]['ProductProperty']['images'])));
	  			$cart[$key]['alias_image'] = $arrImages[0];
	  		}

				if (!empty($prod['discount']) && (float) @$prod['discount'] > 0) {
					$cart[$key]['old_price'] = $price;
					$price = $prod['discount'];
	        $cart[$key]['price'] = $price;
	      }

	      if (
	      	$payment_method === 'mercadopago' && 
	      	!empty($prod['mp_discount']) && 
	      	(float) @$prod['mp_discount'] > 0
	      ) {
					$cart[$key]['old_price'] = $price;
	        $cart[$key]['price'] = ceil(round($price * (1 - (float) $prod['mp_discount'] / 100)));
	      }

	      if (
	      	!empty($prod['bank_discount']) && 
	      	(float) @$prod['bank_discount'] > 0 && 
	      	$payment_method === 'bank'	      	
	      ) {
					$cart[$key]['old_price'] = $price;
	        $cart[$key]['price'] = ceil(round($price * (1 - (float) $prod['bank_discount'] / 100)));
	      } else {
	      	if (
	      		$payment_method === 'bank' && 
	      		$bank_enable && 
	      		$bank_discount_enable
	      	) {
	      		$p = ceil(round($price * (1 - (float) $bank_discount / 100)));
						$cart[$key]['old_price'] = $price;
		        $cart[$key]['price'] = $p;
		      }
	      }

				$number_ribbon = 0;
	      if(!empty(@$prod['discount_label_show'])) {
	        $number_ribbon = $prod['discount_label_show'];
	      }

	      if(!empty(@$prod['mp_discount'])) {
	        $number_ribbon = $prod['mp_discount'];
	        //$mp_price = \price_format(ceil(round($price * (1 - (float) $prod['mp_discount'] / 100))));
	      }

	      if(!empty(@$prod['bank_discount'])) {
	        $number_ribbon = $prod['bank_discount'];
	        //$bank_price = \price_format(ceil(round($price * (1 - (float) $prod['bank_discount'] / 100))));
	      }
	      $cart[$key]['number_ribbon'] = $number_ribbon;
	      $cart[$key]['uid'] = $key;			
				if (!isset($groups[$prod['promo']])) {
					$groups[$prod['promo']] = [];
				}
				$groups[$prod['promo']][] = $cart[$key];
			}
			// $groups[$item['promo']]++;

			// appy promo qunatities
			foreach($cart as $key => $item) {
				$promo = $item['promo'];
				if (!empty($promo)) {
					$parts = explode('x', $promo);
					$promo_key = intval($parts[0]);
					$promo_val = intval($parts[1]);
					if (count($groups[$promo]) >= $promo_key) {
						$sorted = array_column($groups[$promo], 'price');
						array_multisort($sorted, SORT_DESC, $groups[$promo]);
						$offset = $promo_key - $promo_val;
						$refs = array_slice($groups[$promo], 0, $promo_val);
						$refs_ids = [];
						foreach ($refs as $ref) {
							$refs_ids[] = $ref['uid'];
						}
						$frees = array_slice($groups[$promo], count($groups[$promo]) - $offset, $offset);
						foreach ($frees as $j => $free) {
							foreach ($cart as $k => $i) {
								if($i['uid'] === $free['uid']) {
									$refs_ids[] = $free['uid'];
									$cart[$k]['old_price'] = $i['price'];
									$cart[$k]['price'] = 0;
									$cart[$k]['promo_enabled'] = 1;
									$groups[$promo] = array_filter($groups[$promo], function($item) use ($refs_ids) {
										return !in_array($item['uid'], $refs_ids);
									});
								}
							}
						}
					}
				}
			}
		}

		return $cart;
	}

	public function remove($id = null) {
		$this->autoRender = false;
		$this->RequestHandler->respondAs('application/json');
		$item = false;
		$cart = $this->Session->read('cart');

		if(!$cart)
			return $this->redirect(array('controller' => 'carrito', 'action' => 'index'));
		$data = array();
		$i = 0;
		$removed = 0;
		foreach ($cart as $key => $item) {
			if ($item['id'] !== $id) {
				$data[$i] = $item;
			} else {
				$removed = 1;
			}
			$i++;
		}
		if (count($data)) {
			//CakeLog::write('debug', 'updateCart(1)');
			$this->Session->write('cart', $this->updateCart($data));
		} else {
			$this->Session->delete('cart');
		}
		return json_encode($removed);
		//return $this->redirect(array('controller' => 'carrito', 'action' => 'index'));
	}

	private function notify_user($data, $status){
		if ($status=='success'){

$message = '<p>¡Hola <strong>'.ucfirst($data['user']['name']).'</strong>!<br> Estás recibiendo este e-mail porque realizaste una compra en CHATELET.<br/><br/>Tu n&uacute;mero de Pedido es: <strong>'.$data['sale_id'].'</strong>.</p>

<p>Te enviaremos el pedido cuando recibamos la confirmación de la
venta por parte del medio de pago elegido.</p>

<p>Tu compra será procesada dentro de las 72hs de haberse acreditado
el pago.</p>

<p>Ante cualquier consulta no dudes en contactarnos a través de VENTASONLINE@OUTLOOK.COM.AR, indicándonos número de pedido.</p>

<p>¡Muchas gracias!</p>

<br/><a href="https://www.chatelet.com.ar">CHATELET</a>';

		}else{

$message = '<p>¡Hola <strong>'.ucfirst($data['user']['name']).'</strong>!<br> Estás recibiendo este e-mail porque realizaste una compra en CHATELET.<br/><br/>Tu n&uacute;mero de Pedido es: <strong>'.$data['sale_id'].'</strong>.</p>

<p>Te enviaremos el pedido cuando recibamos la confirmación de la
venta por parte del medio de pago elegido.</p>

<p>Tu compra será procesada dentro de las 72hs de haberse acreditado
el pago.</p>

<p>Ante cualquier consulta no dudes en contactarnos a través de VENTASONLINE@OUTLOOK.COM.AR, indicándonos número de pedido.</p>

<p>¡Muchas gracias!</p>

<br/><a href="https://www.chatelet.com.ar">CHATELET</a>';

		}
		error_log('[email] notifying user '.$data['user']['email']);
		$this->sendMail($message,'🌸 Gracias por comprar en CHATELET',$data['user']['email']);
	}

	public function failed() {
			$data = $this->Session->read('sale_data');
			error_log('Failed payment: '.json_encode($data));
			$this->Session->delete('cart');
			$this->Session->delete('sale_data');
			$this->set('sale_data',$data);
			$this->set('failed', true);
			if (!empty($_GET['collection_status']) && $_GET['collection_status']=='pending'){
				error_log('pending');
				$this->notify_user($data, 'pending');
				return $this->render('clear');
			}else{
				error_log('failed');
				return $this->render('clear_no');
			}
	}

	public function clear() { //success
		error_log('success payment: '.json_encode($this->Session->read('sale_data')));
		if( $this->Session->check( 'sale_data' ) ){
			$sale_data = $this->Session->read('sale_data');
			$sale_object = array(
				'id' 		=> $sale_data['sale_id'],
				'completed' => 1
			);
			CakeLog::write('debug', 'sale(4)'.json_encode($to_save));			
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
