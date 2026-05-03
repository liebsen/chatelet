<?php

require_once(APP . 'Vendor' . DS . 'oca.php');
require_once(APP . 'Vendor' . DS . 'curl.php');
require_once(APP . 'Vendor' . DS . 'andreani' . DS . 'andreani.php');

use AlejoASotelo\Andreani;

class CarritoController extends AppController
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
		'LogisticsPrices', 
		'Setting', 
		'Legend',
		'Router'
	);
	
	public $components = array('Cart', 'Mailchimp', 'RequestHandler');

	public function test() {
		echo "<pre>";
		$products = $this->Product->find('all');
		foreach($products as $product) {
			$name = substr($product['Product']['desc'],0,strpos($product['Product']['desc'],'.'));
			$product['Product']['name'] = $name;
			$this->Product->save($product);
		}
		die("mmm");
		$cart = $this->Session->read('cart');
		echo "<pre>";
		print_r($cart);
		die();
		$cart = [
			[
				"id" => 4120,
	      "name" => "Remera Keili (1)",
	      "price" => 2989.99,
	      "discount" => 2989.99,
	      "promo" => "3x2"
			],[
				"id" => 4120,
	      "name" => "Remera Keili (2)",
	      "price" => 2989.99,
	      "discount" => 2989.99,
	      "promo" => "3x2"
			],[
				"id" => 4120,
	      "name" => "Remera Keili (3)",
	      "price" => 2989.99,
	      "discount" => 2989.99,
	      "promo" => "3x2"
			],[
				"id" => 4120,
	      "name" => "Remera Keili (4)",
	      "price" => 2989.99,
	      "discount" => 2989.99,
	      "promo" => "3x2"
			],[
				"id" => 4120,
	      "name" => "Remera Keili (5)",
	      "price" => 2989.99,
	      "discount" => 2989.99,
	      "promo" => "3x2"
			]
		];
		echo "<pre>";

		$groups = [];
		$promos = [];
		$counted = [];
		/*count prods */
		foreach($cart as $product) {
			if (!isset($groups[$product['id']])) {
				$groups[$product['id']] = 0;
			}
			$groups[$product['id']]++;
		}
		/*count promos */
		foreach($cart as $product) {
			if (!empty($product['promo'])) {
				if (!isset($promos[$product['id']])) {
					$parts = explode('x', $product['promo']);
					$promo_val = intval($parts[0]);
					$promos[$product['id']] = floor($groups[$product['id']] / $promo_val);
				}
			}
		}
		/*set promos prices if exists */
		foreach($cart as $product) {
			/*product has promo, check if applies*/
			if (!empty($product['promo'])) {
				$parts = explode('x', $product['promo']);
				$promo_val = intval($parts[0]);
				$promo_min = intval($parts[1]);
				if ($promos[$product['id']]) {
					if (!isset($counted[$product['id']])) {
						$counted[$product['id']] = 0;
					}
					$counted[$product['id']]++;
					if ($counted[$product['id']] % $promo_val === 0) {
						$promos[$product['id']]--;
					}
				}
			}
		}
		
		die();

		// $this->sendEmailMessage('hello','Test via en Châtelet','overlemonsoft@gmail.com');
		$curl = new Curl();
		$token = $curl->post('https://api.ar.treggo.co/1/token', [
			"email" => "overlemonsoft@gmail.com",
			"secret" => "cc202e78-56d3-4e07-82bb-1e7452e54453",
			"mode" => "production"
		]);

		$body = json_decode($token->body);

		if ($body->token) {
			var_dump($body->token);
			die();
			
			$curl2 = new Curl();
			$curl2->headers['Authorization'] = "Bearer {$body->token}";
			$rate = $curl2->post('https://api.ar.treggo.co/1/rates', [
				/*  "pickup" => [
					"address" => "Campora 636",
					"locality" => "Esquel",
					"zip" => 9200
				],
				"delivery" => [
					"address" => "Alvear 636",
					"locality" => "Esquel",
					"zip" => 9200
				], */
				"pickup" => [
					"address" => "Rivadavia 1234",
					"locality" => "CABA",
				    "latitude" => "-71.0833300",
				    "longitude" => "-41.5500000",
					"zip" => 1424
				],
				"delivery" => [
				    "address" => "Corrientes 12345",
				    "latitude" => "-71.0833300",
				    "longitude" => "-41.5500000",
				    "locality" => "CABA",
				    "zip" => 1424
				],
				"size" => [
				    "weight" => 200,
				    "height" => 200,
				    "length" => 200,
				    "width" => 200
				],
				"method" => "ondemand",
				"type" => "auto",
				"packages" => 1
			]);
		}
	}

	public function beforeFilter()
	{
  	parent::beforeFilter();

  	if($this->Cart->expired()) {
  		$this->Cart->destroy();
  		return $this->redirect(array( 'controller' => 'shop', 'action' => 'cart_expired' ));
  	}

		/* $legends = $this->Legend->find('all', [
			'conditions' => ['enabled' => 1],
			'order' => ['Legend.dues ASC']
		]);
		$this->set('legends', $legends);*/
	}

	public function index()
	{
		$stores = $this->Store->find('all', [
			'conditions' => ['takeaway' => 1]
		]);

		$this->set('sorted', $this->Cart->sorted());
		$this->set('stores', $stores);
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
		// $items = $this->getItemsData();
		// $map = $this->Setting->findById('shipping_price_min');
		// $freeShipping = $this->isFreeShipping($total_price);
	
		$this->set('provincias',$provincias);
		// $this->set('freeShipping', $freeShipping);
		$this->set('userData',$user);
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

	public function takeawayStores($cp = null){
		$this->RequestHandler->respondAs('application/json');
		$this->autoRender = false;
		$stores = $this->Store->find('all', [
			'conditions' => ['takeaway' => 1]
		]);
		return json_encode($stores);
	}

	public function coupon($code=null){
		$this->RequestHandler->respondAs('application/json');
		$this->autoRender = false;

		$code = $code ?? $this->request->data['coupon'];
		$cart = $this->Session->read('cart');
		$cart_totals = $this->Session->read('cart_totals');
		$payment_method = $cart_totals['payment_method'] ?? 'bank';
		$payment_method = $this->request->data['payment_method'] ?? $payment_method;
		$cart_totals['payment_method'] = $payment_method;

		$coupon = $this->Coupon->find('first', [
			'conditions' => [
				'code' => $code,
				'enabled' => 1
			]
		]);

		if (!$coupon) {
			return json_encode((object) [
				'status' => 'error',
				'title' => strtoupper($code),
				'message' => "No tenemos esa promo disponible"
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
		$coupon_code = null;
		$coupon_parsed = \parse_coupon($coupon, $cart_totals);
		$updated = [];
		$products_total = 0;
		if($coupon_parsed->status === 'success') {
			$coupon_code = $coupon['Coupon']['code'];
			$discount = (float) $coupon_parsed->data['discount'];
			$partial_bonus = $discount;
			foreach($cart as $item) {
				$price = (float) $item["old_price"];
				CakeLog::write('debug', 'price(1):'.$price);

				if($payment_method === 'mercadopago' && !empty($item['mp_discount']) && !empty((float)(@$item['mp_discount']))) {
	        $price = @ceil(round($price * (1 - (float) $item['mp_discount'] / 100)));
	        CakeLog::write('debug', 'price(2):'.$price);
	      }

				if($payment_method === 'bank' && !empty($item['bank_discount']) && !empty((float)(@$item['bank_discount']))) {
	        $price = @ceil(round($price * (1 - (float) $item['bank_discount'] / 100)));
	        CakeLog::write('debug', 'price(3):'.$price);
	      }

	      $products_total+= $price;

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
						CakeLog::write('debug', 'price(4):'.$price);
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
					
					$total+= $price;

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

		CakeLog::write('debug', 'total(1):'.$total);

		/*if($total && $discount){
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
		}*/

		CakeLog::write('debug', 'total(2):'.$total);

		// CakeLog::write('debug', 'coupon_bonus:'. $coupon_bonus);

		$coupon_parsed->data["updated"] = $updated;
		$coupon_parsed->data["total"] = $total;
		$coupon_parsed->data["products"] = $products_total;
		$coupon_parsed->data["bonus"] = $discount;
		$coupon_parsed->data["coupon_benefits"] = $coupon_bonus;

		if($coupon_code) {
			$cart_totals['coupon'] = $coupon_code;
			$cart_totals['coupon_benefits'] = $coupon_bonus;
		}

		$cart_totals['grand_total'] = $total;

		//CakeLog::write('debug', 'cart_totals(2):'. json_encode($cart_totals));
		$this->Session->write('cart_totals', $cart_totals);		
		
		return json_encode($coupon_parsed);
	}

	public function andreani_cotiza () {
		$this->autoRender = false;
		$items_data = $this->Cart->getItemsData();
		$cp = '1400';
		$result = $this->calculate_shipping_andreani($items_data, $cp, $data['price']);
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

	public function empty($row = null) {
		$this->autoRender = false;
		$this->Session->delete('cart');
		$this->Session->delete('cart_totals');
	}

	public function show($row = null) {

		$this->autoRender = false;
		echo '<pre>';
		echo "cart_totals:\n----------------------\n";
		var_dump($this->Session->read('cart_totals'));
		echo "cart:\n-------------\n";
		var_dump($this->Session->read('cart'));
		echo '</pre>';
	}

	public function show_settings($row = null) {
		$this->autoRender = false;
		var_dump($this->settings);
	}

	public function sorted() {
		$this->autoRender = false;
		echo '<pre>';
		var_dump($this->Cart->sorted());
	}

	public function add() {
		$this->autoRender = false;
		$this->RequestHandler->respondAs('application/json');
		if ($this->request->is('post')) {
			$data = $this->request->data;
			if(
				!isset($data['id']) || 
				!isset($data['count'])
			) {
				return json_encode(array(
					'success' => false,
					'message' => "No se recibieron datos",
					'redirect' => Route::url('/home')
				));
			}

			$product = $this->Product->findById($data['id']);
			$urlCheck = \site_url()."/shop/stock/".$product['Product']['id']."/".$product['Product']['article']."/".$data['size']."/".$data['color_code'];
			if (empty($data['size']) && empty($data['color_code'])){
				//$urlCheck=$settings['site-url']."/shop/stock/".$product['Product']['article'];
				// CakeLog::write('debug', 'b(1)');
				$stock=1;
			} else {
				// CakeLog::write('debug', 'urlCheck:'.$urlCheck);
				$ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $urlCheck);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		    curl_setopt($ch, CURLOPT_TIMEOUT, 20);

		    $stock = (string) curl_exec($ch);
		    curl_close($ch);
			}

			$items = [];
			// error_log('stock:'.$stock);
			if ($product && $stock) {
				$product = $product['Product'];
				$this->loadModel('Stat');

				/* remove all of the kind */
				$criteria = $data['id'].$data['size'].$data['color'].$data['alias'];

				$this->Stat->save(array(
					'id' => null,
		      'tag' => 'cart-add',
		      'user_id' => $this->Auth->user('id') ?? 1,
		      'product_id' => $data['id'],
		      'context' => json_encode(array(
		      	'size' => $data['size'],
		      	'color' => $data['color'],
		      	'alias' => $data['alias']
		      ))
		    ));

				if (!empty($cart)) {
					foreach($cart as $item) {
						if($criteria != $item['id'].$item['size'].$item['color'].$item['alias']) {
							$items[]= $item;
						}
					}
				}

				$product['color'] = @$data['color'];
				$product['size'] = @$data['size'];
				$product['alias'] = @$data['alias'];
				$product['color_code'] = @$data['color_code'];

				for ($i=0; $i < $data['count']; $i++) {
					$items[] = $product;
				}

				$cart_totals = $this->Session->read('cart_totals');
				$cur = @$cart_totals['add_basket']?: 0;
				$cur++;			
				@$cart_totals['add_basket'] = $cur;
				$cart = $this->Cart->add($items);
					
				#if($this->settings['mailchimp_on'] == '1' && $this->settings['mc_store_on'] == '1') {
					#$this->Mailchimp->cart_update($this->settings['mc_store']);
				#}

				return json_encode(array('success' => true));
			} else {
				return json_encode(array('success' => false));
			}
		}
		//return $this->redirect(array('controller' => 'carrito', 'action' => 'index'));
		return json_encode(array('success' => false));
	}

	public function remove($id) {
		$this->autoRender = false;
		$this->RequestHandler->respondAs('application/json');
		$item = false;
		$cart = $this->Session->read('cart');

		if(!$cart){
			return $this->redirect(array('controller' => 'carrito', 'action' => 'index'));
		}

		$update = array();
		$removed = 0;
		$sorted = $this->Cart->sorted();
		$j = 0;

		$removed = array();
		foreach ($sorted as $key => $item) {
			if ($j != $id) {
				array_push($update, $item);
			} else {
				$removed = $item;
				$removed++;
			}
			$j++;
		}

		if($this->Product->findById($item['id'])) {
			$this->loadModel('Stat');
			$stat = array(
				'id' => null,
	      'tag' => 'cart-remove',
	      'user_id' => $this->Auth->user('id') ?? 1,
	      'product_id' => $item['id'],
	      'context' => json_encode(
	      	array(
		      	'size' => $item['size'],
		      	'color' => $item['color'],
		      	'alias' => $item['alias']
		      )
		    )
	    );
	    \d("stat",$stat);
			$this->Stat->save($stat);
		}

		if (count($update)) {
			// CakeLog::write('debug', 'updateCart(1)');
			// CakeLog::write('debug', 'updateCart(2):'. json_encode($update));
			$this->Cart->update($update);
			#if($this->settings['mailchimp_on'] == '1' && $this->settings['mc_store_on'] == '1') {
				#$this->Mailchimp->cart_update($this->settings['mc_store'],$update);
			#}
		} else {
			$this->Cart->destroy();
			#if($this->settings['mailchimp_on'] == '1' && $this->settings['mc_store_on'] == '1') {
				#$this->Mailchimp->cart_destroy($this->settings['mc_store']);
			#}
		}

		return json_encode($removed);
		//return $this->redirect(array('controller' => 'carrito', 'action' => 'index'));
	}
}
