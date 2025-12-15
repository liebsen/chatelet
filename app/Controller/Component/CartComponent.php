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

    $delivery_cost = $cart_totals['delivery_cost'] ?? 0;
    // CakeLog::write('debug','isFreeShipping(4)');
    $free_shipping = $this->isFreeShipping(
      $grand_total, 
      $payment_method,
      $cart_totals['postal_address']
    );
    // CakeLog::write('debug', 'update(free_shipping):'. json_encode($free_shipping,JSON_PRETTY_PRINT));

    if(!empty($free_shipping)) {
      $delivery_cost = 0;
    } else {
      if($cart_totals['cargo'] == 'shipment' && !empty($cart_totals['shipping'])) {
        $delivery_data = json_decode($this->controller->deliveryCost(
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

    // CakeLog::write('debug', 'update(cart_totals):'. json_encode($cart_totals,JSON_PRETTY_PRINT));
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
    $shipping_type_extra = $settings['shipping_type_extra'];
		$shipping_price_min = $settings['shipping_price_min'];
    $bank_free_shipping = $settings['bank_free_shipping'];

    // CakeLog::write('debug', 'shipping_type:'.json_encode($shipping_type));
    // CakeLog::write('debug', 'shipping_type_extra:'.json_encode($shipping_type_extra));
    // CakeLog::write('debug', 'shipping_price_min:'.json_encode($shipping_price_min));
    // CakeLog::write('debug', 'bank_free_shipping:'.json_encode($bank_free_shipping));
    // CakeLog::write('debug', 'payment_method(2):'.json_encode($payment_method));

    if(!empty($bank_free_shipping) && $payment_method == 'bank') {
      return true;
    }

		$freeShipping = false;

		if (!empty($shipping_type)) {
			if (@$shipping_type == 'min_price' || $shipping_price_min > 1){
				$freeShipping = intval($price) >= intval($shipping_price_min);
			}
			if (!$freeShipping && $zip_code && @$shipping_type == 'zip_code'){
				$zip_codes = explode(',',$shipping_type_extra);
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
}
