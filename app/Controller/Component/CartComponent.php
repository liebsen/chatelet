<?php
App::uses('Component', 'Controller', 'Session');
class CartComponent extends Component {
  public $controller; // To store a reference to the Controller

  public function initialize(Controller $controller) {
    $this->controller = $controller;
    parent::initialize($controller);
  }


  public function update($cart=false, $cart_totals=false) {
  
    //CakeLog::write('debug','cart(1)');

    if (empty($cart)) {
      $cart = $this->controller->Session->read('cart');
    }

    if (empty($cart_totals)) {
      $cart_totals = $this->controller->Session->read('cart_totals');
    }

	  $payment_method = @$cart_totals['payment_method'] ?: 'mercadopago';
    $groups = [];
    $counts = [];
    $total = 0;
    $bank_enable = $this->settings['bank_enable'];
    $bank_discount_enable = $this->settings['bank_discount_enable'];
    $bank_discount = $this->settings['bank_discount'];

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
          if (
            $payment_method === 'bank' && 
            $bank_enable && 
            $bank_discount_enable
          ) {
            $cart[$key]['old_price'] = $price;
            $price = ceil(round($price * (1 - (float) $bank_discount / 100)));
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

    $cart_totals['total_products'] = $total;
    $cart_totals['delivery_cost'] = $cart_totals['delivery_cost'] ?? 0;
    $cart_totals['coupon_benefits'] = $cart_totals['coupon_benefits'] ?? 0;

    $grand_total = $cart_totals['total_products'] - 
      $cart_totals['coupon_benefits'] + 
      $cart_totals['delivery_cost'];

    $cart_totals['free_shipping'] = $this->isFreeShipping($grand_total);
    $cart_totals['grand_total'] = $grand_total;

    CakeLog::write('debug', 'cart_totals(1):'. json_encode($cart_totals,JSON_PRETTY_PRINT));
    // CakeLog::write('debug', 'cart(1):'. json_encode($cart));

    $this->controller->Session->write('cart_totals', $cart_totals);
    $this->controller->Session->write('cart', $cart);

    return $cart;
  }

  public function destroy() {
		$this->controller->Session->delete('cart');
		$this->controller->Session->delete('cart_totals');
  }

	public function sort() {
		$cart = $this->controller->Session->read('cart');
		$cart_totals = $this->controller->Session->read('cart_totals');
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


	public function isFreeShipping ($price, $zip_code = 0) {
		$shipping_config = $this->controller->Setting->findById('shipping_type');
		$shipping_price = $this->controller->Setting->findById('shipping_price_min');
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
}
