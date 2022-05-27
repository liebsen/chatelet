<?php

require_once(APP . 'Vendor' . DS . 'oca.php');
require_once(APP . 'Vendor' . DS . 'curl.php');
require __DIR__ . '/../Vendor/andreani/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../Vendor/andreani/');
$dotenv->load();

use AlejoASotelo\Andreani;

class CarritoController extends AppController
{
	private $andreani_ep = 'https://apisqa.andreani.com'; 
	// private $andreani_ep = 'https://apis.andreani.com'; 

	public $uses = array('Product', 'ProductProperty', 'Store', 'Sale','Package','User','SaleProduct','Catalogo','Category','LookBook', 'Coupon', 'Logistic');
	public $components = array("RequestHandler");

	public function test() {
		echo "<pre>";
		$products = $this->Product->find('all');
		foreach($products as $product) {
			$name = substr($product['Product']['desc'],0,strpos($product['Product']['desc'],'.'));
			$product['Product']['name'] = $name;
			$this->Product->save($product);
		}
		die("mmm");
		$carro = $this->Session->read('Carro');
		echo "<pre>";
		print_r($carro);
		die();
		$carro = [
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

		$quants = [];
		$promos = [];
		$counted = [];
		/*count prods */
		foreach($carro as $product) {
			if (!isset($quants[$product['id']])) {
				$quants[$product['id']] = 0;
			}
			$quants[$product['id']]++;
		}
		/*count promos */
		foreach($carro as $product) {
			if (!empty($product['promo'])) {
				if (!isset($promos[$product['id']])) {
					$parts = explode('x', $product['promo']);
					$promo_val = intval($parts[0]);
					$promos[$product['id']] = floor($quants[$product['id']] / $promo_val);
				}
			}
		}
		/*set promos prices if exists */
		foreach($carro as $product) {
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

		// $this->sendMail('hello','Test via en Châtelet','overlemonsoft@gmail.com');
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
			echo "<pre>";
			print_r(json_decode($rate->body));
		}
		 
		die('ok');
	}

	public function beforeFilter()
	{
  	parent::beforeFilter();
  	$this->loadModel('Setting');
  	$categories = $this->Category->find('all');
		$this->set('categories', $categories);
		$catalog_flap_map = $this->Setting->findById('catalog_flap');
		$catalog_flap = (!empty($catalog_flap_map['Setting']['value'])) ? $catalog_flap_map['Setting']['value'] : '';
		$this->set('catalog_flap',$catalog_flap);
    $catalog_first_line_map = $this->Setting->findById('catalog_first_line');
		$catalog_first_line = (!empty($catalog_first_line_map['Setting']['value'])) ? $catalog_first_line_map['Setting']['value'] : '';
		$this->set('catalog_first_line',$catalog_first_line);
		$lookbook = $this->LookBook->find('all');
    $shipping_price_min_map = $this->Setting->findById('shipping_price_min');
		$shipping_price_min = (!empty($shipping_price_min_map['Setting']['value'])) ? $shipping_price_min_map['Setting']['value'] : '';
		$this->set('shipping_price_min',$shipping_price_min);
		$this->set('lookBook', $lookbook);
	}

	public function index()
	{
		$data = $this->getItemsData();
		$shipping_price = $this->Setting->findById('shipping_price_min');
		$unit_price = $data['price'];
		if(!empty($producto['discount']) && !empty((float)(@$producto['discount']))) {
            $unit_price = @$producto['discount'];
        }
		$freeShipping = intval($data['price'])>=intval($shipping_price['Setting']['value']);
		error_log('freeshipping unit price: '.intval($unit_price));
		$shipping_config = $this->Setting->findById('shipping_type');
		if (!empty($shipping_config) && !empty($shipping_config['Setting']['value'])) {
			if (@$shipping_config['Setting']['value'] == 'free'){
				// envio gratis siempre
				// $freeShipping = 1;
			}
			if (@$shipping_config['Setting']['value'] == 'zip_code'){
				// $freeShipping = 1;
			}
			error_log('shipping_value: '.@$shipping_config['Setting']['value']);
		}
		$stores = $this->Store->find('all', [
			'conditions' => ['takeaway' => 1]
		]);
		$this->set('stores', $stores);
		$this->set('freeShipping', $freeShipping);
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

	public function checkout()
	{
		$oca = new Oca();
		$provincias = $oca->getProvincias();
		$this->set('provincias',$provincias);

		$user = $this->User->find('first',array('recursive' => -1,'conditions'=>array('User.id' => $this->Auth->user('id'))));
		$this->set('userData',$user);
	}

	private function getItemsData()
	{
		$data = array('count' => 0, 'price' => 0);
		$items = $this->Session->read('Carro');
		if ($items) {
			foreach ($items as $key => $item) {
				$data['count'] ++;
				$data['price'] += $item['discount'] ?: $item['price'];
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

	public function takeaway_stores($cp = null){
		$this->RequestHandler->respondAs('application/json');
		$this->autoRender = false;
		$stores = $this->Store->find('all', [
			'conditions' => ['takeaway' => 1]
		]);
		return json_encode($stores);
	}

	public function coupon($cp = null){
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
				'title' => "Promo desconocida",
				'message' => "No tenemos esa promo disponible ahora"
			]);
		}
		return json_encode(self::filter_coupon($coupon));
	}

	private function filter_coupon ($data) {
		$coupon_type = '';
		$date = date('Y-m-d');
		$week = (string) date('w');
		$time = time();
		$hour = date('H:i:s');
		$item = $data['Coupon'];
		$coupon_type = isset($item['hour_from']) && isset($item['hour_until']) && $item['hour_from'] !== '00:00:00' && $item['hour_until'] !== '00:00:00' ? 'time' : $coupon_type;
		$coupon_type = isset($item['date_from']) && isset($item['date_until']) && $coupon_type === '' ? 'date' : $coupon_type;
		$coupon_type = isset($item['date_from']) && isset($item['date_until']) && $coupon_type === 'time' ? 'datetime' : $coupon_type;

		$inTime = strtotime($item['hour_from']) <= strtotime($hour) && strtotime($item['hour_until']) > strtotime($hour);
		$inDate = strtotime($item['date_from']) <= strtotime($date) && strtotime($item['date_until']) > strtotime($date);
		/* error_log('(1) ' . $item['date_from'] . ' / ' . $item['date_until']);
		error_log('(2) ' . $date );
		error_log('(3) ' . $item['hour_from'] . ' / ' . $item['hour_until']);
		error_log('(4) ' . $hour );
		if ($inTime) error_log('(intime!) ');
		if ($inDate) error_log('(indate!) '); */
		$inDateTime = $inTime && $inDate;
		if (strpos($item['weekdays'], $week) === false) {
			$valid = [];
			$weekdays = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
			foreach(str_split($item['weekdays']) as $week) {
				$valid[] = $weekdays[$week];
			}
			$str = implode(', ', $valid);
			return (object) [
				'status' => 'error',
				'title' => "Restricción horaria",
				'message' => "Esta promo solo es válida para días de semana {$str}. Puede volver a intentar mas adelante"
			];
		}
		switch ($coupon_type) {
			case 'time':
				if ($inTime) {
					return (object) [
						'status' => 'success',
						'data' => $item
					];
				} else {
					return (object) [
						'status' => 'error',
						'title' => "Restricción horaria",
						'message' => "Esta promo solo es válida para horario {$item['hour_from']} / {$item['hour_until']}"
					];
				}
			case 'date':
				if ($inDate) { 
					return (object) [
						'status' => 'success',
						'data' => $item
					];
				} else {
					return (object) [
						'status' => 'error',
						'title' => "Restricción fecha",
						'message' => "Esta promo solo es válida para fecha {$item['date_from']} / {$item['date_until']}"
					];
				}
				break;
			case 'datetime':
				if ($inDateTime) { 
					return (object) [
						'status' => 'success',
						'data' => $item
					];
				} else {
					return (object) [
						'status' => 'error',
						'title' => "Restricción fecha",
						'message' => "Esta promo solo es válida para fecha {$item['date_from']} {$item['hour_from']} / {$item['date_until']} {$item['hour_until']}"
					];
				}
				break;
			case '':
			default:
					return (object) [
						'status' => 'success',
						'data' => $item
					];			
					/* return (object) [
						'status' => 'error',
						'title' => "Promo desconocida",
						'message' => "Este código no pertenece a ninguna promoción."
					]; */			
				break;
		}
	}

	public function delivery_cost($cp, $code = null){
		$this->RequestHandler->respondAs('application/json');
		$this->autoRender = false;
		$this->loadModel('LogisticsPrices');

		if ($_SERVER['REMOTE_ADDR'] === '127.0.0.2') {
			$dummy = '{"valid": 1,"freeShipping":false,"rates":{"oca":{"price":799,"centros":[{"idCentroImposicion":"51","IdSucursalOCA":"27","Sigla":"EQS","Descripcion":"ESQUEL                        ","Calle":"MITRE","Numero":"777  ","Torre":" ","Piso":"     ","Depto":"    ","Localidad":"ESQUEL                   ","IdProvincia":"9","idCodigoPostal":"19681","Telefono":"02945-451164   ","eMail":"","Provincia":"CHUBUT                        ","CodigoPostal":"9200    "}],"valid":1},"andreani":{"price":5295.98,"centros":[],"valid":true}},"itemsData":{"count":2,"price":8280,"package":{"id":"2","amount_min":"1","amount_max":"5","weight":"1000","height":"9","width":"24","depth":"20","created":"2014-11-20 10:25:48","modified":"2014-11-20 10:25:48"},"weight":1,"volume":0.00432}}';
			return json_encode(json_decode($dummy));
		}

		//Codigo Postal
		$this->Session->write('cp',$cp);
		$shipping_price = $this->Setting->findById('shipping_price_min');

		//Data
		$data = $this->getItemsData();
		$unit_price = $data['price'];
		if(!empty($data['discount']) && !empty((float)(@$data['discount']))) {
      $unit_price = @$data['discount'];
    }

		$freeShipping = intval($unit_price)>=intval($shipping_price['Setting']['value']);

		$json = array(
			'freeShipping' => $freeShipping,
			'rates' => [],
			'itemsData' => $data
		);

		if(!empty($data)){
			$conditions = ['enabled' => true];
			if ($code) {
				$conditions['code'] = strtolower($code);
				$logistic = $this->Logistic->find('first',[
					'conditions' => $conditions
				]);
				if ($logistic['Logistic']['local_prices']) {
					// buscamos logísticas de alcance nacional
					$locals = $this->LogisticsPrices->find('first', ['conditions' => ['logistic_id' => $logistic['Logistic']['id'], 'zips LIKE' => "%{$cp}%"]]);
					$item = $locals['LogisticsPrices'];
					$parent = $this->Logistic->findById($item['logistic_id'])['Logistic'];
          $row = [
            'title' => $parent['title'],
            'image' => $parent['image'],
            'code' => $parent['code'],
            'price' => $item['price'],
            'centros' => [],
            'valid' =>  true
          ];
          $json['rates'][] = $row;
				} else {
					if (method_exists($this, "calculate_shipping_{$code}")) {
						$row = [
				      'title' => $item['title'],
				      'code' => $item['code'],
				      'image' => $item['image'],
							'price' => $this->{"calculate_shipping_{$code}"}($data, $cp, $unit_price),
							'centros' => [],
							'valid' =>  true
						];
						$json['rates'][] = $row;
					}
				}
			} else {
				// buscamos logísticas de alcance nacional
				$conditions['local_prices'] = false;
				$logistics = $this->Logistic->find('all',[
					'conditions' => $conditions
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
							'price' => $this->{"calculate_shipping_{$code}"}($data, $cp, $unit_price),
							'centros' => [],
							'valid' =>  true
						];
					}
					$json['rates'][] = $row;
				}

				// buscamos logísticas de alcance local
				$locals = $this->LogisticsPrices->find('all', ['conditions' => ['zips LIKE' => "%{$cp}%"]]);
				foreach($locals as $logistic_price) {
					$item = $logistic_price['LogisticsPrices'];
					$parent = $this->Logistic->findById($item['logistic_id'])['Logistic'];
          $row = [
            'title' => $parent['title'],
            'image' => $parent['image'],
            'code' => $parent['code'],
            'price' => $item['price'],
            'centros' => [],
            'valid' =>  true
          ];
          $json['rates'][] = $row;
				}
			}
		}

		return json_encode($json);
	}

	public function andreani_cotiza () {
		$this->autoRender = false;
		$data = $this->getItemsData();
		$cp = '1400';
		$this->calculate_shipping_andreani($data, $cp, $data['price']);
	}
	
	private function calculate_shipping_andreani ($data, $cp, $price) {
		$ws = new Andreani(getenv('ANDREANI_USUARIO'), env('ANDREANI_CLAVE'), env('ANDREANI_CLIENTE'), getenv('ANDREANI_DEBUG'));
		$package = $data['package'];
		$bultos = [
	    [
        //'volumen' => $data['volume'] * 1000,
        // 'anchoCm' => (float) $package['width'],
        // 'largoCm' => (float) $package['height'],
        // 'altoCm' => (float) $package['depth'],
        'kilos' => (float) $package['weight'],
        'volumen' => (integer) $package['width'] * $package['height'] * $package['depth'],
        // 'pesoAforado' => 5,
        'valorDeclarado' => (integer) $price // $1200
	    ]
		];

		/* $bultos = array(
		    array(
		        'volumen' => 200,
		        'kilos' => 1.3,
		        'pesoAforado' => 5,
		        'valorDeclarado' => 1200, // $1200
		    ),
		); */
		$cp = (integer) $cp;
		// $response = $ws->cotizarEnvio(1832, '300006611', $bultos, 'CL0003750');
		$response = $ws->cotizarEnvio($cp, '300006611', $bultos, 'CL0003750');
		// $result = $ws->cotizarEnvio((integer) $cp, getenv('ANDREANI_CONTRATO'), $bultos, getenv('ANDREANI_USUARIO'));
		return $response->tarifaConIva->total;

		/* $contrato = '300006611';
		$cliente = 'CL0003750';
		$width = $data['package']['width'];
		$height = $data['package']['height'];
		$depth = $data['package']['depth'];
		$width = $data['package']['width'];
		$weight = round($data['package']['weight'] / 1000);
		$url = "{$this->andreani_ep}/v1/tarifas?cpDestino={$cp}&contrato=300006611&cliente=CL0003750&sucursalOrigen=BAR&bultos[0][valorDeclarado]={$price}&bultos[0][volumen]=200&bultos[0][kilos]={$weight}&bultos[0][altoCm]={$depth}&bultos[0][largoCm]={$height}&bultos[0][anchoCm]={$width}";

		$response = json_decode(file_get_contents($url));
		return (float) $response->tarifaConIva->total; */
	} 

	private function andreani_token () {
		$this->autoRender = false;
		$uri =  "{$this->andreani_ep}/login";
		$ch = curl_init($uri);
		$cred = base64_encode('usuario_test:DI$iKqMClEtM');
		curl_setopt_array($ch, array(
	    CURLOPT_HTTPHEADER  => array("Authorization: Basic {$cred}"),
	    CURLOPT_RETURNTRANSFER  =>true,
	    CURLOPT_VERBOSE     => 1
		));
		$out = curl_exec($ch);
		curl_close($ch);
		// echo response output
		$json = json_decode($out);
		return $json->token;
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
		$total=0;
		$total_wo_discount = 0;
		// VAR - Validate
		$carro = $this->Session->read('Carro');
		$user_id = $this->Auth->user('id');
		$product_ids = array();
		$items = array();
		$user = $this->request->data;
		$user['id'] = $this->Auth->user('id');
		$user['telephone'] = @preg_replace("/[^0-9]/","",$user['telephone']);
		$user['floor'] = (!empty($user['floor']))?$user['floor']:'';
		$user['depto'] = (!empty($user['depto']))?$user['depto']:'';
		$user['coupon'] = (!empty($user['coupon']))?strtoupper($user['coupon']):'';
		$user['regalo'] = (isset($user['regalo']) && $user['regalo']?1:0);
		if(!$this->request->is('post') || $user['cargo'] === 'shipment' && empty($user['postal_address']) || empty($user['street_n']) || empty($user['street']) || empty($user['localidad']) || empty($user['provincia']) || empty($user['name']) || empty($user['surname']) || empty($user['email']) || empty($user['telephone'])){
			$this->Session->setFlash(
                'Es posible que el pago aún no se haya hecho efectivo, quizas tome mas tiempo.',
                'default',
                array('class' => 'hidden error')
            );
			$this->redirect(array( 'action' => 'clear' ));
			die;
		}

		//Register Sale
		$this->Sale->save(array('id' => null,'user_id' => $user['id']));
		$sale_id = $this->Sale->id;

		//Mercadopago
		foreach ($carro as $producto) {
			$desc = '';
			$separator = ' -|- ';
			$values = array(
				'PEDIDO' 	=> $sale_id,
				'CODIGO'	=> $producto['article'],
				'PRODUCTO'  => $producto['name'],
				'COLOR'  	=> $producto['color'].' '.$producto['alias'],
				'TALLE'  	=> $producto['size'],
				'PRECIO_LISTA'  	=> $producto['price'],
				'PRECIO_DESCUENTO'  	=> $producto['discount'],
				'NOMBRE' 	=> $user['name'],
				'APPELLIDO'	=> $user['surname'],
				'EMAIL'		=> $user['email'],
				'TELEFONO'	=> $user['telephone'],
				'DNI'	=> $user['dni'],
				'REGALO'	=> $user['regalo'],
				'PROV'		=> $user['provincia'],
				'LOC'		=> $user['localidad'],
				'CALLE'		=> $user['street'],
				'NRO'		=> $user['street_n'],
				'PISO'		=> $user['floor'],
				'DPTO'		=> $user['depto'],
				'COD POST'	=> $user['postal_address'],
				'CARGO'	=> $user['cargo'],
				'CUPON'	=> $user['coupon'],
				'STORE'	=> $user['store'],
				'STORE_ADDR'	=> $user['store_address'],
				'SHIPPING'	=> $user['shipping']
			);
			foreach ($values as $key => $value) {
				$desc.= $key.' : "'.$value.'"'.$separator;
			}

			$unit_price = $producto['price'];

			/* 
			if(!empty($producto['discount']) && !empty((float)(@$producto['discount']))) {
        $unit_price = @$producto['discount'];
      } */
      // error_log('----product price: ' . $unit_price);
			$items[] = array(
				'title' => $desc,
				'description' => $desc,
				'quantity' => 1,
				'currency_id' => 'ARS',
				'unit_price' => (int) $unit_price
			);
			$total+=(int)$unit_price;
			// error_log('suming '.(int)$unit_price);
			$product_ids[] = array(
				'product_id' => $producto['id'],
				'color' => $producto['color'],
				'size' => $producto['size'],
				'precio_lista' => (!empty($producto['old_price']))?$producto['old_price']:$producto['price'],
				'precio_vendido' => $producto['price'],
				'sale_id' => $sale_id,
				'id' => null,
				'description' => $desc
			);
		}
		
		$total_wo_discount = $total;

		error_log('tmp total: '.$total);
		// Check coupon
		if (isset($user['coupon']) && $user['coupon'] !== '')  {
	    $coupon = $this->Coupon->find('first', [
	      'conditions' => [
	        'code' => $user['coupon'],
	        'enabled' => 1
	      ]
	    ]);
	    if ($coupon) {
				$applicable = self::filter_coupon($coupon);
				if ($applicable->status === 'success') {
					$discount = (float) $applicable->data['discount'];
					error_log('coupon type : '.$applicable->data['coupon_type']);
					if($applicable->data['coupon_type'] === 'percentage') {
						error_log('total: '.$total);
						error_log('discount: '.$discount);
						$total = round($total * (1 - $discount / 100), 2);
						foreach($items as $k => $item) {
							$item_price = round($item['unit_price'] * (1 - $discount / 100), 2);
							$items[$k]['unit_price'] = $item_price;
							if ($product_ids[$k]) {
								$product_ids[$k]['precio_vendido'] = $item_price;
							}
							error_log('(coupon) fixing item price (1): ' . $item_price);
						}
					} else {
						$total-= $discount;
						foreach($items as $k => $item) {
							$item_price = $item['unit_price']-= round($discount / count($items), 2);
							$items[$k]['unit_price'] = $item_price;
							if ($product_ids[$k]) {
								$product_ids[$k]['precio_vendido'] = $item_price;
							}
							error_log('(coupon) fixing item price (2): ' . $item_price);
						}
					}
					error_log('coupon applied now total: '.$total);
				}
		  }
	  }

		// Add Delivery
		$delivery_data = json_decode( $this->delivery_cost($user['postal_address'], $user['shipping']),true);
		$delivery_cost = 0;
		if (isset($delivery_data['rates'][0]['price'])) {
			$delivery_cost = (int) $delivery_data['rates'][0]['price'];
		}

		//shipping-code 
		$shipping_price = $this->Setting->findById('shipping_price_min');
		$freeShipping = intval($total)>=intval($shipping_price['Setting']['value']);

		if ($user['cargo'] == 'takeaway') {
			$freeShipping = true;
		}

		error_log('free_shipping: '.$freeShipping);

		$shipping_type_value = 'default';
		$zipCodes='';
		$shipping_config = $this->Setting->findById('shipping_type');
		if (!empty($shipping_config) && !empty($shipping_config['Setting']['value'])) {
			$zipCodes = @$shipping_config['Setting']['extra'];
			$shipping_type_value = @$shipping_config['Setting']['value'];
			if (@$shipping_config['Setting']['value'] == 'default'){
				// default = same
			}
			if (@$shipping_config['Setting']['value'] == 'no_label'){
				// default = same
			}
			if (@$shipping_config['Setting']['value'] == 'free'){
				// envio gratis siempre
				// $freeShipping = true;
			}
			if (@$shipping_config['Setting']['value'] == 'zip_code'){
				// $freeShipping = true;
			}
			error_log('shipping_value: '.@$shipping_config['Setting']['value']);
		}
		// freeShipping until 12/10
		// $freeShipping = true;
		// error_log('Putting freeshipping until 12/10');
		// free delivery
		if ($freeShipping) { 
     	error_log('without delivery bc price is :'.$total.' and date = '.gmdate('Y-m-d'));
			$delivery_cost=0;
		}else{
			error_log('suming delivery to price: '.$delivery_cost);
			$total += $delivery_cost;
			error_log('suming total: '.$total);
			$items[] = array(
				'title' => 'PEDIDO: '.$sale_id.' - COSTO DE ENVIO',
				'description' => 'PEDIDO: '.$sale_id.' - COSTO DE ENVIO',
				'quantity' => 1,
				'currency_id' => 'ARS',
				'unit_price' => $delivery_cost
			);
		}

		$this->Sale->save(array(
			'id' => $sale_id,
			'deliver_cost' => $delivery_cost,
			'shipping_type' => $shipping_type_value
		));

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
			'nroremito'	=> $sale_id,
			'apellido'	=> $user['surname'],
			'nombre'	=> $user['name'],
			'dni'	=> $user['dni'],
			'calle'		=> $user['street'],
			'nro'		=> $user['street_n'],
			'piso'		=> $user['floor'],
			'depto'		=> $user['depto'],
			'cp'		=> $user['postal_address'],
			'localidad'	=> $user['localidad'],
			'provincia'	=> $user['provincia'],
			'telefono'	=> $user['telephone'],
			'email'		=> $user['email'],
			'regalo'		=> $user['regalo'],
			'package_id'=> $delivery_data['itemsData']['package']['id'],
			'value' 	=> $delivery_data['itemsData']['price'],
			'zip_codes' => $zipCodes,
			'cargo'		=> $user['cargo'],
			'coupon'	=> $user['coupon'],
			'store'		=> $user['store'],
			'store_address'		=> $user['store_address'],
			'shipping'		=> $user['shipping']
		);
		error_log(json_encode($to_save));
		$this->Sale->save($to_save);

		//MP
		$mp = new MP(Configure::read('client_id'), Configure::read('client_secret'));
		$success_url = Router::url(array('controller' => 'carrito', 'action' => 'clear'), true);
		$failure_url = Router::url(array('controller' => 'carrito', 'action' => 'failed'), true);

		$preference_data = array(
		    'items' => $items,
		    'payer' => array(
		    	'name' => $user['name'],
		    	'surname' => $user['surname'],
		    	'email' => $user['email']
	    	),
		    'back_urls' => array(
		    	'success' => $success_url,
		    	'failure' => $failure_url,
		    	'pending' => $failure_url
	    	)
		);
		$preference = $mp->create_preference($preference_data);

		//Save Data
		$sale_data = array(
			'user' 		=> $user,
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
			error_log('entering mp production mode');
			return $this->redirect($preference['response']['init_point']);
		}else{
			//Sandbox
			$mp->sandbox_mode(TRUE);
			error_log('entering mp sandbox mode');
			error_log($preference['response']['sandbox_init_point']);
			return $this->redirect($preference['response']['sandbox_init_point']);
		}

	}

	public function add() {
		$this->autoRender = false;
		$this->RequestHandler->respondAs('application/json');
		if ($this->request->is('post') && isset($this->request->data['id'])) {
			$product = $this->Product->findById($this->request->data['id']);
			$urlCheck = Configure::read('baseUrl')."shop/stock/".$product['Product']['article']."/".$this->request->data['size']."/".$this->request->data['color_code'];

			if (empty($this->request->data['size']) && empty($this->request->data['color_code'])){
				//$urlCheck=Configure::read('baseUrl')."shop/stock/".$product['Product']['article'];
				error_log('fake stock');
				$stock=1;
			}else{

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

			error_log('stock:'.$stock);
			// error_log('curl:'.$stock);
			//$stock=1;
			if ($product && $stock) {
				$carro = $this->Session->read('Carro');
				$product = $product['Product'];
				$product['color'] = @$this->request->data['color'];
				$product['size'] = @$this->request->data['size'];
				$product['alias'] = $this->request->data['alias'];

				$carro[] = $product;
				error_log('[carrito] '.json_encode($carro));
				$data = $this->getComputedCart($carro);
				// $this->applyPromosFromCart($carro);
				error_log('[carrito] '.json_encode($data));
				$this->Session->write('Carro', $data);

			//	$this->Session->write('Carro.'. $product['id'], $product);
				return json_encode(array('success' => true));
			}
		}
		return json_encode(array('success' => false));
	}

	private function getComputedCart ($data) {
		return $this->applyPromosFromCart($data ?: $this->Session->read('Carro'));
	}

	private function applyPromosFromCart($carro) {
		$quants = [];
		$promos = [];
		$counted = [];
		/*count prods */
		foreach($carro as $key => $product) {
      $prop = $this->ProductProperty->find('all', array('conditions' => array(
  			'product_id' => $product['id'],
  			'alias' => $product['alias']
  		)));

  		if ($prop) {
  			$arrImages = array_values(array_filter(explode(';', $prop[0]['ProductProperty']['images'])));
  			// error_log('$arrImages:'.json_encode($arrImages));
  			$carro[$key]['alias_image'] = $arrImages[0];
  		}
		
			if (!isset($quants[$product['id']])) {
				$quants[$product['id']] = 0;
			}
			$quants[$product['id']]++;
		}
		/*count promos */
		foreach($carro as $product) {
			if (!empty($product['promo'])) {
				if (!isset($promos[$product['id']])) {
					$parts = explode('x', $product['promo']);
					$promo_val = intval($parts[0]);
					$promos[$product['id']] = floor($quants[$product['id']] / $promo_val);
				}
			}
		}
		/*set promos prices if exists */
		foreach($carro as $key => $product) {
			/*product has promo, check if applies*/
			if (!empty($product['discount']) && (float)@$product['discount']>0) {
        $product['price'] = $product['discount'];
      }
			if (!empty($product['promo'])) {
				$parts = explode('x', $product['promo']);
				$promo_val = intval($parts[0]);
				$promo_min = intval($parts[1]);
				if ($promos[$product['id']]) {
					if (!isset($product['old_price'])) {
	          $carro[$key]['old_price'] = $product['price'];
	          $carro[$key]['price'] = round($promo_min / $promo_val * $product['price']);
	          error_log('[carrito] '.$product['price']);
						if (!isset($counted[$product['id']])) {
							$counted[$product['id']] = 0;
						}
						$counted[$product['id']]++;
						if ($counted[$product['id']] % $promo_val === 0) {
							$promos[$product['id']]--;
						}
					}
				} else {
					if (isset($product['old_price'])) {
						$carro[$key]['price'] = $product['old_price'];
						unset($carro[$key]['old_price']);
					}					
				}
			}
		}

		// error_log('[carrito] '.json_encode($carro));

		return $carro;
	}

	public function remove($row = null) {
		$this->autoRender = false;

		/*if (isset($product_id) && $this->Session->check('Carro.'. $product_id)) {
			$this->Session->delete('Carro.'. $product_id);
		}*/
		$item = false;
		if (isset($row) && $this->Session->check('Carro.'. $row)) {
			$item = $this->Session->read('Carro.'. $row);
			$this->Session->delete('Carro.'. $row);
		}
		$carro = $this->Session->read('Carro');
		$aux = array();
		$i = 0;
		foreach ($carro as $key => $value) {
			$aux[$i] = $value;
			$i++;
		}

		$this->Session->write('Carro', $this->getComputedCart($aux));
		return json_encode($item);
		// return $this->redirect(array('controller' => 'carrito', 'action' => 'index'));
	}

	private function notify_user($data, $status){
		if ($status=='success'){
			$message = '<p>Hola <strong>'.ucfirst($data['user']['name']).'</strong>, gracias por tu compra!.<br/><br/>Tu n&uacute;mero de Pedido es: <strong>'.$data['sale_id'].'</strong>.</p>
			<p>Tu compra será procesada dentro de las 72 hr. de haberse acreditado el pago.
</p><p>Los pedidos se despachan en días hábiles.
</p><p>Te comentamos que los tiempos de entrega se pueden ver afectados por la cuarentena.
</p><p>Recuerde que las fechas son estimativas, dado que por razones de logística el correo
puede reprogramar las fechas, siendo esto ajeno a nosotros. Por favor estate atento
a la fecha de entrega para que la misma sea exitosa. 
</p><p>Ante cualquier consulta no dudes en contactarnos a través de VENTASONLINE@OUTLOOK.COM.AR, indicándonos número de compra.
</p><p>¡Te agradecemos la comprensión!
</p><br/><a href="https://www.chatelet.com.ar">www.chatelet.com.ar</a>';

		}else{
			$message = '<p>Hola <strong>'.ucfirst($data['user']['name']).'</strong>, gracias por tu compra! Aguardamos recibir el pago para contactarte.<br/><br/>Tu n&uacute;mero de Pedido es: <strong>'.$data['sale_id'].'</strong>.</p>
			<p>Tu compra será procesada dentro de las 72 hr. de haberse acreditado el pago.
</p><p>Los pedidos se despachan en días hábiles.
</p><p>Te comentamos que los tiempos de entrega se pueden ver afectados por la cuarentena.
</p><p>Recuerde que las fechas son estimativas, dado que por razones de logística el correo
puede reprogramar las fechas, siendo esto ajeno a nosotros. Por favor estate atento
a la fecha de entrega para que la misma sea exitosa. 
</p><p>Ante cualquier consulta no dudes en contactarnos a través de VENTASONLINE@OUTLOOK.COM.AR, indicándonos número de compra.
</p><p>¡Te agradecemos la comprensión!
</p><br/><a href="https://www.chatelet.com.ar">www.chatelet.com.ar</a>';

		}
		error_log('[email] notifying user '.$data['user']['email']);
		$this->sendMail($message,'Compra Realizada en Châtelet',$data['user']['email']);
	}

	public function failed() {
			$data = $this->Session->read('sale_data');
			error_log('Failed payment: '.json_encode($data));
			$this->Session->delete('Carro');
			$this->Session->delete('sale_data');
			$this->set('sale_data',$data);
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
			$this->Sale->save(array(
				'id' 		=> $sale_data['sale_id'],
				'completed' => 1
			));
			$this->set('sale_data',$this->Session->read('sale_data'));
			$this->notify_user($this->Session->read('sale_data'), 'success');
			$this->Session->delete('Carro');
			$this->Session->delete('sale_data');
			error_log('success');
		}else{
			error_log('no sale data');
			$this->Session->delete('Carro');
			$this->Session->delete('sale_data');
			return $this->redirect(array('controller' => 'home', 'action' => 'index'));
		}
	}
}
