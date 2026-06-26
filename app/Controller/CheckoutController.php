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
		'Logistic',
		'LogisticsPrices',
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

  	if($this->Cart->expired()) {
  		$this->Cart->destroy();
  		return $this->redirect(array( 'controller' => 'shop', 'action' => 'cart_expired' ));
  	}

  	$this->set('sorted', $this->Cart->sorted());
		$index = array_search($this->request->here, array_column($this->checkout_steps, 'url'));
		$this->set('checkout_index', $index);
		$this->set('checkout_steps', $this->checkout_steps);
		// $freeShipping = $this->Cart->isFreeShipping($total_price);
		// $this->set('freeShipping', $freeShipping);		
	}

	public function index() {}

	public function subscribe() {
	}

	
	public function envio() {
		if(empty($this->Session->read('cart_totals'))) {
			$this->redirect(array( 'controller' => 'carrito', 'action' => 'index' ));
		}

		if ($this->request->is('post')) {
			$this->RequestHandler->respondAs('application/json');
			$this->autoRender = false;

			$data = $this->request->data;

			#CakeLog::write('debug', $data.':'.json_encode($data));
			$cart_totals = $this->Session->read('cart_totals');

			if(empty($data)) {
	      return json_encode(array(
	        'success' => false, 
	        'errors' => 'No se recibió datos de envío'
	      ));
			}

			if($data['cargo'] == 'shipment') { 
				if(empty($data['customer']))
		      return json_encode(array(
		        'success' => false, 
		        'errors' => 'No se recibió datos de persona'
		      ));
				if(empty($data['shipping']))
		      return json_encode(array(
		        'success' => false, 
		        'errors' => 'No se recibió datos del carrier'
		      ));

		    $data['store'] = null;
		    $data['store_address'] = null;
			}
      
      if($data['cargo'] == 'takeaway') { 
				if(empty($data['store']) || empty($data['store_address']))
		      return json_encode(array(
		        'success' => false, 
		        'errors' => 'No se recibió datos de store'
		      ));

		   	$data['shipping'] = null;
		   	$data['delivery_cost'] = 0;
      }

      $response = array(
        'success' => true, 
        'message' => 'OK, pasemos a pago'
      );

			$delivery_cost = 0;
			#CakeLog::write('debug', 'envio(data):'.json_encode($data, JSON_PRETTY_PRINT));	
			// CakeLog::write('debug', 'envio(cart_totals):'.json_encode($cart_totals, JSON_PRETTY_PRINT));	

			if($data['cargo'] == 'shipment' && empty($cart_totals['free_shipping'])) {
				$delivery_data = json_decode($this->Cart->deliveryCost(
					$data['postal_address'], 
					$data['shipping'],
					$cart_totals['grand_total'],
					$cart_totals['payment_method']
				));
				
				// CakeLog::write('debug', 'envio(3)');
				// CakeLog::write('debug', 'envio(delivery_data):'.json_encode($delivery_data));	
				if(!empty($delivery_data->rates[0]->price)) {
					// CakeLog::write('debug', 'envio(4)');
					$delivery_cost = (float) $delivery_data->rates[0]->price;
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
				CakeLog::write('debug', $part.':'.json_encode($data[$part]));
				$cart_totals[$part] = $data[$part];
			}

			$cart_totals['postal_address'] = intval($cart_totals['postal_address']);
			// CakeLog::write('debug', 'envio(cart_totals)'.json_encode($cart_totals));
			
			$this->Cart->update(null, $cart_totals);
			#if($this->settings['mailchimp_on'] == '1' && $this->settings['mc_store_on'] == '1') {
				#$this->Mailchimp->cart_update($this->settings['mc_store'],null, $cart_totals);
			#}
      return json_encode($response);
		}

		$stores = $this->Store->find('all', [
			'conditions' => ['takeaway' => 1]
		]);

		CakeLog::write('debug', 'envio(user_id)'.json_encode($this->Auth->user('id')));
		
		$oca = new Oca();
		$provincias = $oca->getProvincias();
		$user = $this->User->find('first',array('recursive' => -1,'conditions'=>array('User.id' => $this->Auth->user('id'))));
		$this->set('userData',$user);		
		$this->set('provincias',$provincias);		
		$this->set('stores', $stores);
	}

	public function deliveryCost($cp, $code = null){
    $this->RequestHandler->respondAs('application/json');
    $this->autoRender = false;
    $cart_totals = $this->Session->read('cart_totals');
    $total = $cart_totals['grand_total'];
    $payment_method = $cart_totals['payment_method'];
		return $this->Cart->deliveryCost($cp, $code, $total, $payment_method);
	}

	public function pago() {
		if ($this->request->is('post')) {
			$this->RequestHandler->respondAs('application/json');
			$this->autoRender = false;

			$data = $this->request->data;
			$response = array(
				'success' => true,
				'message' => 'OK, pasemos a pago'
			);

			if(empty($data)) {
				return json_encode(array(
					'success' => false,
					'errors' => 'Datos de pago no recibidos'
				));
			}

			if(empty($data['payment_method'])) {
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
				$cart_totals[$part] = $data[$part];
			}

			CakeLog::write('debug', 'pago(data)'.json_encode($data));
			CakeLog::write('debug', 'pago(cart_totals)'.json_encode($cart_totals));
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

	public function payWith($code=null){
		$this->RequestHandler->respondAs('application/json');
		$this->autoRender = false;

		$cart_totals = $this->Session->read('cart_totals');
		$payment_method = $cart_totals['payment_method'] ?? 'bank';
		$payment_method = $this->request->data['payment_method'] ?? $payment_method;
    #CakeLog::write('debug', '--------------------------------------');		
		#CakeLog::write('debug','payment_method(1):'.json_encode($payment_method), JSON_PRETTY_PRINT);

		$cart_totals['payment_method'] = $payment_method;		
		$cart = $this->Cart->update(null, $cart_totals);
		// $this->Mailchimp->cart_update("chatelet",null, $cart_totals);
		// CakeLog::write('debug','cart(3):'.json_encode($cart), JSON_PRETTY_PRINT);
		$cart['status'] = 'success';

		return json_encode($cart);
	}

	public function confirma() {
		$cart_totals = $this->Session->read('cart_totals');
		if(empty($this->Session->read('cart'))) {
			$this->redirect(array( 'controller' => 'carrito', 'action' => 'index' ));
		}
		
		if ($this->request->is('post')) {
			$this->RequestHandler->respondAs('application/json');
			$this->autoRender = false;
			$data = $this->request->data;
			CakeLog::write('debug', 'confirma(data):'. json_encode($data));
			$response = array(
				'success' => false,
				'errors' => 'No se puedo procesar tu compra'
			);

			if(empty($data['confirm'])) {
	      return json_encode(array(
	        'success' => false, 
	        'errors' => 'No se recibieron datos de confirmacion'
	      ));
			}

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

			// CakeLog::write('debug', '-.-.-.-.-.-.-.-.-.-.- sale -.-.-.-.-.-.-.-.-.-');
			$sale = $this->sale($data);
			// here we start the sale
			CakeLog::write('debug', 'confirma(sale):'. json_encode($sale));
			return json_encode($sale);
		}
	}

	public function getLocalidadProvincia($id){
		$this->RequestHandler->respondAs('application/json');
		$this->autoRender = false;

		$response = array();
		if ($id) {
			$oca = new Oca();
			$response = $oca->getLocalidadesByProvincia($id);
		}

		return json_encode($response);
	}


/*	private function getItemsData()
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
	} */

	public function takeawayStores($cp = null){
		$this->RequestHandler->respondAs('application/json');
		$this->autoRender = false;
		$stores = $this->Store->find('all', [
			'conditions' => ['takeaway' => 1]
		]);
		return json_encode($stores);
	}



	public function andreani_cotiza () {
		$this->autoRender = false;
		$data = $this->getItemsData();
		$cp = '1400';
		$result = $this->calculate_shipping_andreani($data, $cp, $data['price']);
		echo '<pre>';
		var_dump($result);
	}
	
	private function sale($data) {
		require_once(APP . 'Vendor' . DS . 'mercadopago.php');
		// $settings = $this->load_settings();
		$this->autoRender = false;
		$settings = $this->settings;
		$total=0;
		$total_wo_discount = 0;
		// VAR - Validate
		$cart = $this->Session->read('cart');
		$cart_totals = $this->Session->read('cart_totals');
		$user_id = $this->Auth->user('id');
		$product_ids = array();
		$items = array();
		$customer = $cart_totals['customer'];
		$payment_method = $cart_totals['payment_method'] ?? 'bank';
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

		// $data = $this->request->data;

		/*$sale['id'] = $this->Auth->user('id');
		$sale['telephone'] = @preg_replace("/[^0-9]/","",$customer['telephone']);
		$sale['email'] = (!empty($customer['email']))?trim($customer['email']):'';
		$sale['floor'] = (!empty($customer['floor']))?trim($customer['floor']):'';
		$sale['depto'] = (!empty($customer['depto']))?trim($customer['depto']):'';
		$sale['coupon'] = (!empty($sale['coupon']))?strtoupper(trim($sale['coupon'])):'';
		//$sale['regalo'] = (isset($sale['regalo']) && $sale['regalo']?1:0);
		$sale['dues'] = (isset($sale['payment_dues']) && $sale['payment_dues']?intval($sale['payment_dues']):1);*/

		CakeLog::write('debug', 'sale(data):'. json_encode($data, JSON_PRETTY_PRINT));
		// CakeLog::write('debug', 'sale(cart_totals):'. json_encode($cart_totals, JSON_PRETTY_PRINT));
		// return false; // - - - - - - remove - - - - - - -

		if(!isset($user_id)){
			$check_user = false;

			if(!empty($customer['email'])) {
				$check_user = $this->User->find('first', [
					'conditions' => [
						'email' => trim($customer['email'])
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
					'address' => $customer['address'],
					'postal_address' => $customer['postal_address'],
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
		// CakeLog::write('debug', 'sale(settings):'. json_encode($settings));

		if (
			!empty($cart_totals['payment_method']) && 
			$cart_totals['payment_method'] === 'bank' && 
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

		$missing_data = false;
		if(!$this->request->is('post')) {
			if ($cart_totals['cargo'] === 'shipment') {
				if (
					empty($customer['postal_address']) || 
					empty($customer['street_n']) || 
					empty($customer['street']) || 
					empty($customer['localidad']) || 
					empty($customer['provincia']) || 
					empty($customer['name']) || 
					empty($customer['surname']) || 
					empty($customer['email']) || 
					empty($customer['telephone'])
				) {
					$missing_data = true;
				}
			}

			if ($cart_totals['cargo'] === 'takeaway') {
				if (
					empty($customer['store']) || 
					empty($customer['store_address'])
				) {
					$missing_data = true;
				}
			}
			
			if($missing_data) {
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

		// CakeLog::write('debug', 'sale(gifts):'. $data['gifts']);
		$gift_ids = !empty($data['gifts']) ? $data['gifts'] : [];
		
		// check item prices, promos and coupons
		// Check coupon

		$coupon_bonus = 0;
		$bank_bonus = 0;
		$coupon_parsed = null;
		$cats = [];
		$prods = [];

		if (!empty($cart_totals['coupon'])) {
			// error_log('checking coupon: '.$cart_totals['coupon']);
			//CakeLog::write('debug', 'sale(coupon):'.$cart_totals['coupon']);
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
				$coupon_parsed = \parse_coupon($coupon, $cart_totals);
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
				'PEDIDO' 	=> $sale_id,
				'CODIGO'	=> $producto['article'],
				'PRODUCTO'  => $producto['name'],
				'COLOR'  	=> $producto['color'].' '.$producto['alias'],
				'TALLE'  	=> $producto['size'],
				'REGALO'	=> in_array($producto['id'], $gift_ids) ? 'SÍ': 'NO',
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
				'OBS'	=> $customer['obs'],
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
				'id' => $producto['id'],
				'title' => $producto['name'],
				'description' => $producto['desc'],
				'quantity' => 1,
				'currency_id' => 'ARS',
				'unit_price' => (int) ceil($unit_price)
			);

			$total+= ceil($unit_price);

			//CakeLog::write('debug', 'sale(unit_price):'.$unit_price);
			//CakeLog::write('debug', 'sale(total):'.$total);

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
		//CakeLog::write('debug', 'sale(items):'.json_encode($items, JSON_PRETTY_PRINT));
		//CakeLog::write('debug', 'sale(wo_discount):'.$total);

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
		CakeLog::write('debug','isFreeShipping(3)');
		$freeShipping = $this->Cart->isFreeShipping(
			$total, 
			$cart_totals['payment_method'],
			$cart_totals['postal_address']
		);

		$delivery_data = json_decode($this->Cart->deliveryCost(
			$cart_totals['postal_address'], 
			$cart_totals['shipping'],
			$cart_totals['grand_total'],
			$cart_totals['payment_method']
		));

		$delivery_cost = (float) $delivery_data->rates[0]->old_price;
		CakeLog::write('debug', 'sale(deliverycost): '.$delivery_cost);


		if ($freeShipping) { 
			CakeLog::write('debug', 'sale(freeshipping):'.'without delivery bc price is :'.$total.', cp:'. @$cart_totals['postal_address'] .'  and date = '.gmdate('Y-m-d'));
		} else {
			if ($cart_totals['cargo'] === 'shipment') {
				// CakeLog::write('debug', 'sale(delivery_Data): '.json_encode($delivery_data));
				$total+= $delivery_cost;
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

		$sale_object = array(
			'id' => $sale_id,
			//'user_id' => $sale['id'],
			'free_shipping' => $freeShipping,
			'payment_method' => $cart_totals['payment_method'],
			'deliver_cost' => $delivery_cost,
			'shipping_type' => $this->settings['shipping_type']
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

      // CakeLog::write('debug', 'sale(err): Error al procesar la compra, por favor intente nuevamente');

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
			'obs'		=> $customer['obs'],
			'package_id'=> @$delivery_data->itemsData->package->id ?? 1,
			'value' 	=> $total, // @$delivery_data['itemsData']['price'],
			'zip_codes' => $this->settings['shipping_zips'],
			'cargo'		=> $cart_totals['cargo'],
			'coupon'	=> $cart_totals['coupon'],
			'metodo_pago'	=> $cart_totals['payment_method'],
			'store'		=> $cart_totals['store'],
			'store_address'		=> $cart_totals['store_address'],
			'shipping'		=> $cart_totals['shipping'],
			'dues'		=> $cart_totals['dues'] ?? 1
		);

		// CakeLog::write('debug', 'sale(to_save)'.json_encode($to_save));
		// CakeLog::write('debug', 'settings(1)'.json_encode($settings));
		// error_log(json_encode($to_save));
		$this->Sale->save($to_save);
		// error_log("total mp: " . $total);
		// CakeLog::write('debug', 'sale(mp): '.$total);

		// check if paying method is bank
		if ($cart_totals['payment_method'] === 'bank') {
			// CakeLog::write('debug', 'destroy session(1)');
			$this->Cart->destroy();

			CakeLog::write('debug', '(cbu) ok - Realiza la transferencia para terminar la compra');
			return array(
				'success' => true,
				'message' => "Espera mientras te redirigimos...",
				'redirect' => Router::url(array( 'controller' => 'ayuda', 'action' => 'onlinebanking', $sale_id )),
			);
		}

		//MP
		// $mp = new MP(Configure::read('mercadopago_client_id'), Configure::read('mercadopago_client_secret'));
		// check simulation

		if(!empty($this->request->data['simulate'])) {
			$redirect = '/checkout/mp_fail?status=pending&collection_status=pending&preference_id=161684025-45653d36-57d8-4f70-b166-896d2d8886b5&site_id=MLA&external_reference='.$sale_id.'&collection_id=142159856356&payment_id=142159856356&payment_type=credit_card&processing_mode=aggregator&merchant_order_id=37304657565';

			if(!empty($this->request->data['simulate_success'])) {
				$redirect = '/checkout/mp_success?status=approved&collection_status=approved&preference_id=161684025-45653d36-57d8-4f70-b166-896d2d8886b5&site_id=MLA&external_reference='.$sale_id.'&collection_id=142159856356&payment_id=142159856356&payment_type=credit_card&processing_mode=aggregator&merchant_order_id=37304657565';
			}

			return array(
				'success' => true,
				'message' => 'Espera mientras te redirigimos...',
				'redirect' => $redirect
			);
		}

		$mp = new MP($settings['mercadopago_client_id'], $settings['mercadopago_client_secret']);
		$success_url = Router::url(array('controller' => 'checkout', 'action' => 'mp_success'), true);
		$failure_url = Router::url(array('controller' => 'checkout', 'action' => 'mp_fail'), true);

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
		/*$sale_data = array(
			'user' => array(
				'name' => $customer['name'],
				'email' => $customer['email']
			),
			'sale' => $cart_totals,
			//'items' 	=> $items,
			'sale_id' 	=> $sale_id,
			//'preference'=> $preference,
			'products' => $product_ids,
			'total' => $total
		);

		$this->Session->write('sale_data',$sale_data);*/

		$redirect = "";

		// $redirect = "/shop/mis_compras/{$sale_id}";
		//Setting
		if($settings['mercadopago_sandbox_on'] == 'off') {
			//Production
			$mp->sandbox_mode(FALSE);
			$redirect = $preference['response']['init_point'];
		}else{
			//Sandbox
			$mp->sandbox_mode(TRUE);
			$redirect = $preference['response']['sandbox_init_point'];
		}

		CakeLog::write('debug', 'sale(redirect):'.json_encode($redirect));

		return array(
			'success' => true,
			'message' => 'Espera mientras te redirigimos...',
			'redirect' => $redirect
		);
	}

	private function notify_user($data, $status){
		$message = \parse_template($this->settings["notification_sale_{$status}_text"], 
			array(
				'name' => $data['nombre'],
				'surname' => $data['apellido'],
				'email' => $data['email'],
				'telephone' => $data['telefono'],
				'dni' => $data['dni'],
				'sale_total' => \price_format($data['value']),
				'sale_id' => \price_format($data['id']),
			)
		);

		error_log('[email] notifying user '.$data['email']);
		
		$this->sendEmailMessage(
			$message,
			$this->settings["{$status}_title"],
			$data['email']
		);
	}

	public function mp_success() { //success
		// /checkout/mp_success?status=approved&collection_status=approved&preference_id=161684025-45653d36-57d8-4f70-b166-896d2d8886b5&site_id=MLA&external_reference=16757&collection_id=142159856356&payment_id=142159856356&payment_type=credit_card&processing_mode=aggregator&merchant_order_id=37304657565

		$status = $this->request->query('status') ?? '';
		$sale_id = $this->request->query('external_reference') ?? 0;

		$this->loadModel('Sale');
		$this->loadModel('SaleProduct');

		if($status == 'approved') {
	  	$data = $this->SaleProduct->find('all',[
		    'joins' => [
	        [
	          'table' => 'sales',
	          'alias' => 'Sale',
	          'type' => 'LEFT',
	          'conditions' => [ 'Sale.id = SaleProduct.sale_id' ]
	        ]
		    ],
		  	'fields' => ['Sale.id, Sale.value, Sale.nombre, Sale.apellido, Sale.email, SaleProduct.*'],
	      'conditions' => [
	        'SaleProduct.sale_id' => $sale_id,
	      ],     
	      'order' => ['SaleProduct.id DESC'],
	      'limit' => 1000,
	    ]);

	    if(!empty($data[0])){
				$sale = $data[0]['Sale'];
				$sale_items = [];
				$cart_totals = $this->Session->read('cart_totals');

				foreach($data as $item) {
					$sale_items[] = array(
						'id' => $item['SaleProduct']['product_id'],
						'name' => $item['SaleProduct']['name']
					);
				}

				$sale_object = array(
					'id' 		=> $sale_id,
					'completed' => 1
				);


				// CakeLog::write('debug', 'sale(4)'.json_encode($sale_object));			
				$this->Sale->save($sale_object);

				$this->notify_user($sale, 'notification_sale_success');

				#if($this->settings['mailchimp_on'] == '1' && $this->settings['mc_store_on'] == '1') {
					#$this->Mailchimp->delete_cart($this->settings['mc_store'], $cart_totals['cart_id']);
					#$this->Mailchimp->order($this->settings['mc_store'], $sale_id, $sale['value'], $sale_items);
				#}
				$this->set('sale',$sale);
				$this->set('sale_items',$sale_items);
				
				$this->Session->delete('cart');
				$this->Session->delete('cart_totals');

				return $this->render('mp_success');
	    }
		}

		return $this->mp_fail();
	}

	public function mp_fail() {

		$collection_status  =$this->request->query('collection_status') ?? '';
		$sale_id  =$this->request->query('external_reference') ?? 0;

		$this->loadModel('Sale');

		if($collection_status == 'pending') {

	  	$data = $this->Sale->find('first', 
	  		array(
		      'conditions' => array(
		        'Sale.id' => $sale_id,
		      ),
		    )
	  	);

	    if(!empty($data)){
				$this->notify_user($data['Sale'], 'notification_sale_pending');
			}
		}
		
		return $this->render('mp_fail');
	}
}
