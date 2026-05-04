<?php
App::uses('Component', 'Controller', 'Session');

class CartComponent extends Component {
  public $controller; // To store a reference to the Controller

  public function initialize(Controller $controller) {
    $this->controller = $controller;
    parent::initialize($controller);
  }

  public function add($items) {
    $cart = $this->controller->Session->read('cart') ?? [];
    $cart['create'] = false;

    $ids = array_column($items, 'id');
    $cart = array_filter($cart, function($e) use ($ids) {
      return !in_array($e['id'], $ids);
    });

    $this->update(array_merge($cart,$items));
  }

  public function update($cart=false, $cart_totals=false) {

    $settings = $this->controller->settings;

    // CakeLog::write('debug', 'update(cart_totals):'. json_encode($cart_totals,JSON_PRETTY_PRINT));
    // CakeLog::write('debug', 'cart(param):'. json_encode($cart));

    if (empty($cart)) {
      $cart = $this->controller->Session->read('cart');
    }

    if (empty($cart_totals)) {
      $cart_totals = $this->controller->Session->read('cart_totals');
    }

    if(!isset($cart_totals['cart_id'])) {
      #CakeLog::write('debug', 'cart(1)');
      $cart_totals['cart_id'] = $this->controller->Auth->user('id') . '-' . date('ymd-Hi');
      #CakeLog::write('debug', 'cart(2)');
      // $cart['create'] = true;
    }

    // CakeLog::write('debug', 'cart_totals(start):'. json_encode($cart_totals,JSON_PRETTY_PRINT));
    // CakeLog::write('debug', 'cart(start):'. json_encode($cart));

	  $payment_method = $cart_totals['payment_method'] ?: 'bank';
    // CakeLog::write('debug', 'update(payment_method):'. json_encode($payment_method));

    $groups = [];
    $counts = [];
    $total = 0;

    // $counted = [];
    /*count prods */

    if (!empty($cart)) {
      /* apply basic prices and fill promos data */
      foreach($cart as $key => $item) {
        $prod = $this->controller->Product->findById($item['id']);

        if(empty($prod)) {
          unset($cart[$key]);
          continue;
        }

        $prod = $prod['Product'];
        $price = $prod['price'];
        $prod['old_price'] = $price;

        $prop = $this->controller->ProductProperty->find('all', array('conditions' => array(
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
          $price = ceil(round($price * (1 - (float) $prod['mp_discount'] / 100)));
          $cart[$key]['price'] = $price;
        }

        if (
          !empty($prod['bank_discount']) && 
          (float) @$prod['bank_discount'] > 0 && 
          $payment_method === 'bank'          
        ) {
          $cart[$key]['old_price'] = $price;
          $price = ceil(round($price * (1 - (float) $prod['bank_discount'] / 100)));
          $cart[$key]['price'] = $price;
        } else {
          // CakeLog::write('debug', 'payment_method:'.$payment_method);
          // CakeLog::write('debug', 'bank_enable:'.$settings['bank_enable']);
          if (
            $payment_method === 'bank' && 
            !empty($settings['bank_enable']) && 
            !empty($settings['bank_discount_enable']) && 
            !empty($settings['bank_discount'])
          ) {
            $cart[$key]['old_price'] = $price;
            $price = ceil(round($price * (1 - (float) $settings['bank_discount'] / 100)));
            $cart[$key]['price'] = $price;
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

        $total+= $price;
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

    #CakeLog::write('debug', 'update(cart_totals)(before):'. json_encode($cart_totals,JSON_PRETTY_PRINT));
    $delivery_cost = $cart_totals['delivery_cost'] ?? 0;
    #CakeLog::write('debug','isFreeShipping(b):'.json_encode(array('total'=>$total,'payment_method'=>$payment_method,'postal_address'=>$cart_totals['postal_address'])));

    $free_shipping = $this->isFreeShipping(
      $total, 
      $payment_method,
      $cart_totals['postal_address'] ?: 0
    );
    // CakeLog::write('debug', 'update(free_shipping):'. json_encode($free_shipping,JSON_PRETTY_PRINT));

    if(!empty($free_shipping)) {
      $delivery_cost = 0;
    } else {
      if($cart_totals['cargo'] == 'shipment' && !empty($cart_totals['shipping'])) {
        $delivery_data = json_decode($this->deliveryCost(
          $cart_totals['postal_address'], 
          $cart_totals['shipping'],
          $cart_totals['grand_total'],
          $payment_method
        ));

        $delivery_cost = (float) $delivery_data->rates[0]->price;

        // CakeLog::write('debug', 'update(delivery_data): '.json_encode($delivery_data));
        // CakeLog::write('debug', 'update(delivery_cost): '.json_encode($delivery_cost));
      }
    }

    $cart_totals['free_shipping'] = $free_shipping;
    $cart_totals['total_products'] = (float) $total;
    $cart_totals['delivery_cost'] = (float) $delivery_cost;
    $cart_totals['coupon_benefits'] = (float) $cart_totals['coupon_benefits'] ?? 0;

    $grand_total = $cart_totals['total_products'] - 
      $cart_totals['coupon_benefits'] + 
      $cart_totals['delivery_cost'];

    $cart_totals['grand_total'] = $grand_total;
    $cart_totals['payment_method'] = $payment_method;
    $cart_totals['updated'] = date('Y-m-d H:i');
    #CakeLog::write('debug', 'update(cart_totals)(after):'. json_encode($cart_totals,JSON_PRETTY_PRINT));
    // CakeLog::write('debug', 'update(cart):'. json_encode($cart,JSON_PRETTY_PRINT));
    $this->controller->Session->write('cart_totals', $cart_totals);
    $this->controller->Session->write('cart', $cart);
    return [
      'cart' => $cart, 
      'cart_totals' => $cart_totals
    ];
  }

  public function destroy() {
		$this->controller->Session->delete('cart');
		$this->controller->Session->delete('cart_totals');
  }

	public function expired() {
    $min = $this->controller->settings['carrito_life_hours'] || 12;
    $cart_totals = $this->controller->Session->read('cart_totals');
    $t1 = strtotime( date('Y-m-d H:i') );
    $t2 = strtotime( $cart_totals['updated'] );
    $diff = $t1 - $t2;
    $hours = $diff / ( 60 * 60 );    
    // CakeLog::write('debug', 'expired(hours):'. json_encode($hours,JSON_PRETTY_PRINT));
    return $hours > $min;
  }

  public function sorted() {
		$cart = $this->controller->Session->read('cart');
		$cart_totals = $this->controller->Session->read('cart_totals');
		$payment_method = @$cart_totals['payment_method'] ?: 'bank';
		$payment_dues = @$cart_totals['payment_dues'] ?: '1';
		$groups = [];
		$sort = [];

		if (!empty(@$cart)) {
			foreach($cart as $key => $item) {
				$criteria = $item['id'].$item['size'].$item['color'].$item['alias'];
        $price = $item['price'];
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
					$sort[$criteria]['price']+= $price;
					$sort[$criteria]['old_price']+= $item['old_price'];
					if (!empty($item['promo_enabled'])) {
						$sort[$criteria]['promo_enabled'] = $item['promo_enabled'];
					}
				}
				$sort[$criteria]['item_price'] = $price;
				$sort[$criteria]['item_old_price'] = $item['old_price'];
			}
		}

		/* if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
			file_put_contents(__DIR__.'/../logs/carrito_sort.json', json_encode($sort, JSON_PRETTY_PRINT));
		}*/

		return $sort;
	}

	public function isFreeShipping($price, $payment_method = 'bank', $zip_code = 0) {
    $settings = $this->controller->settings;

		$shipping_type = $settings['shipping_type'];
    $shipping_zips = $settings['shipping_zips'];
		$shipping_price_min = $settings['shipping_price_min'];
    $bank_free_shipping = $settings['bank_free_shipping'];

    // CakeLog::write('debug', 'shipping_type:'.json_encode($shipping_type));
    // CakeLog::write('debug', 'shipping_zips:'.json_encode($shipping_zips));
    // CakeLog::write('debug', 'shipping_price_min:'.json_encode($shipping_price_min));
    // CakeLog::write('debug', 'bank_free_shipping:'.json_encode($bank_free_shipping));
    
    #CakeLog::write('debug', 'price(3):'.json_encode($price));
    #CakeLog::write('debug', 'payment_method(3):'.json_encode($payment_method));
    #CakeLog::write('debug', 'zip_code(3):'.json_encode($zip_code));

    if(!empty($bank_free_shipping) && $payment_method == 'bank') {
      #CakeLog::write('debug', 'cart(bank_free_shipping)');
      return true;
    }

		$free_shipping = false;

		if (!empty($shipping_type)) {
			if (@$shipping_type == 'min_price' || $shipping_price_min > 1){
				$free_shipping = intval($price) >= intval($shipping_price_min);
			}
			if (!$free_shipping && $zip_code && @$shipping_type == 'zip_code'){
				$zip_codes = explode(',',$shipping_zips);
				if (count($zip_codes)) {
					$filter = [];
					foreach($zip_codes as $code) {
						$filter[] = trim($code);
					}
					$free_shipping = in_array($zip_code, $filter);
				}
			}
			// error_log('shipping_value: '.@$shipping_config['Setting']['value']);
		}
    // CakeLog::write('debug', 'free_shipping(2):'.json_encode($free_shipping));

		return $free_shipping;
		// return intval($price) >= intval($shipping_price['Setting']['value']);
	}

  public function getItemsData(){
    $items_data = array('count' => 0, 'price' => 0);
    $items = $this->controller->Session->read('cart');
    //CakeLog::write('debug', 'getItemsData:'. json_encode($items));
    if ($items) {
      foreach ($items as $key => $item) {
        $items_data['count']++;
        $items_data['price']+= $item['price'];
      }
      $package = $this->controller->Package->find('first',array('conditions' => array( 'Package.amount_min <=' => $items_data['count'] , 'Package.amount_max >=' => $items_data['count'] )));
      if(!empty($package)){
        $items_data['package']= $package['Package'];
        $items_data['weight'] = $package['Package']['weight']/1000;
        $items_data['volume'] = ($package['Package']['width']/100)*($package['Package']['height']/100)*($package['Package']['depth']/100);
        return $items_data;
      }
    }
    return false;
  }

  public function deliveryCost($cp, $code = null, $total = 0, $payment_method = 'bank'){
    #CakeLog::write('debug','deliveryCost(cp):'.$cp);
    #CakeLog::write('debug','deliveryCost(code):'.$code);
    // $this->loadModel('LogisticsPrices');
    //Codigo Postal
    $this->controller->Session->write('cp', $cp);
    $cart_totals = $this->controller->Session->read('cart_totals') ?? [];
    $fake_enabled = false;
    if ($fake_enabled && $this->controller->settings['env_staging']) {
      return json_encode(json_decode('{"freeShipping":false,"rates":[{"title":"Oca","code":"oca","image":"https:\/\/test.chatelet.com.ar\/files\/uploads\/628eb1ba29efd.svg","info":"Env\u00edos a todo el pa\u00eds","price":987,"centros":[],"valid":true},{"title":"Speed Moto","image":"https:\/\/test.chatelet.com.ar\/files\/uploads\/6292a6f2d79b7.jpg","code":"speedmoto","info":"10 a\u00f1os brindando confianza a nuestros clientes","price":"700.00","centros":[],"valid":true}],"itemsData":{"count":1,"price":1994.99,"package":{"id":"2","amount_min":"1","amount_max":"5","weight":"1000","height":"9","width":"24","depth":"20","created":"2014-11-20 10:25:48","modified":"2014-11-20 10:25:48"},"weight":1,"volume":0.00432}}'));
    }

    $cp1 = substr($cp, 0, 3) . '*';
    $cp2 = substr($cp, 0, 2) . '**';
    //Data
    $data = $this->getItemsData();
    $unit_price = $data['price'];
    if(!empty($data['discount']) && !empty((float)(@$data['discount']))) {
      $unit_price = @$data['discount'];
    }

    #CakeLog::write('debug','deliveryCosy(isFreeShipping):'.json_encode(array($cart_totals['total_products'], $payment_method, $cp)));

    $free_shipping = $this->isFreeShipping($cart_totals['total_products'], $payment_method, $cp);

    // CakeLog::write('debug','deliveryCost(free_shipping):'.json_encode($free_shipping));
    //error_log("free_shipping:".json_encode($free_shipping));

    $json = array(
      'freeShipping' => $free_shipping,
      'rates' => [],
      'itemsData' => $data
    );

    if(!empty($data)){
      if (!empty($code)) {
        // CakeLog::write('debug', 'deliveryCost(code):'.$code);
        // necesitamos cotizacion de una empresa
        $code = strtolower($code);
        $logistic = $this->controller->Logistic->find('first',[
          'conditions' => [
            'enabled' => true,
            'code' => $code
          ]
        ])['Logistic'];
        if ($logistic['local_prices']) {
          // CakeLog::write('debug', 'deliveryCost(code)(1)');
          // buscamos las tarifas
          $item = $this->controller->LogisticsPrices->find('first', [
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
          $row = [
            'title' => $logistic['title'],
            'image' => $logistic['image'],
            'info' => implode('. ', array_filter([$logistic['info'], $item['info']])),
            'code' => (float) $logistic['code'],
            'price' => $free_shipping ? 
              0 : 
              (float) $item['price'],
            'old_price' => (float) $item['price'],
            'centros' => [],
            'valid' =>  true
          ];
          $json['rates'][] = $row;
        } else {
          #CakeLog::write('debug', 'deliveryCost(a)');
          if (method_exists($this, "calculate_shipping_{$code}")) {
            $calc_price = $this->{"calculate_shipping_{$code}"}($data, $cp, $unit_price);
            $row = [
              'title' => $logistic['title'],
              'code' => $logistic['code'],
              'image' => $logistic['image'],
              'info' => $logistic['info'],
              'price' => $free_shipping ? 
                0 : 
                (float) $calc_price,
              'old_price' => (float) $calc_price,
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

        if ($free_shipping) {
          $local_prices_ids = [];
          $logistics = $this->controller->Logistic->find('all', [
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
                $calc_price = $this->{"calculate_shipping_{$code}"}($data, $cp, $unit_price);
                $row = [
                  'title' => $item['title'],
                  'code' => $item['code'],
                  'image' => $item['image'],
                  'info' => $item['info'],
                  'price' => $free_shipping ? 
                    0 : 
                    (float) $calc_price,
                  'old_price' => (float) $calc_price,
                  'centros' => [],
                  'valid' =>  true
                ];
              }
              $json['rates'][] = $row;
            }
          } 

          $local_prices = $this->controller->LogisticsPrices->find('all', [
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
            $parent = $this->controller->Logistic->findById($item['logistic_id'])['Logistic'];
            $row = [
              'title' => $parent['title'],
              'image' => $parent['image'],
              'code' => $parent['code'],
              'info' => implode('. ', array_filter([$parent['info'], $item['info']])),
              'price' => $free_shipping ? 
                0 : 
                (float) $item['price'],
              'old_price' => (float) $item['price'],
              'centros' => [],
              'valid' =>  true
            ];
            $json['rates'][] = $row;
          }
        }

        if(empty($json['rates'])) {
          // buscamos logísticas de alcance nacional
          $logistics = $this->controller->Logistic->find('all',[
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
              $calc_price = $this->{"calculate_shipping_{$code}"}($data, $cp, $unit_price);
              $row = [
                'title' => $item['title'],
                'code' => $item['code'],
                'image' => $item['image'],
                'info' => $item['info'],
                'price' => $free_shipping ? 
                  0 : 
                  (float) $calc_price,
                'old_price' => (float) $calc_price,
                'centros' => [],
                'valid' =>  true
              ];
            }
            $json['rates'][] = $row;
          }

          // buscamos logísticas de alcance local
          $locals = $this->controller->LogisticsPrices->find('all', [
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
            $parent = $this->controller->Logistic->findById($item['logistic_id'])['Logistic'];
            $row = [
              'title' => $parent['title'],
              'image' => $parent['image'],
              'code' => $parent['code'],
              'info' => implode('. ', array_filter([$parent['info'], $item['info']])),
              'price' => $free_shipping ? 
                0 : 
                (float) $item['price'],
              'old_price' => (float) $item['price'],
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
    // CakeLog::write('debug', 'calculate_shipping_oca(1)');
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
    // $centros = $this->checkOcaCP($cp);
    //Price
    $price = !empty($response[0]['Precio']) ? (int) $response[0]['Precio'] : 0;
    #CakeLog::write('debug', 'oca(price)'.$price.':'.gettype($price));
    return $price;
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
}
