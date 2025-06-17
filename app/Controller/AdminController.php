<?php
App::uses('CakeTime', 'Utility');
require_once(APP . 'Vendor' . DS . 'oca.php');
require __DIR__ . '/../Vendor/andreani/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../Vendor/andreani/');
$dotenv->load();

use AlejoASotelo\Andreani;

class AdminController extends AppController {
	public $uses = array('AdminMenu','Promo','Package','SaleProduct','Sale','Setting');
	//public $components = array('SQL', 'RequestHandler');
	public $components = array('RequestHandler');

	public function beforeFilter() {
    	parent::beforeFilter();
    	$this->Auth->deny();
    	$this->Auth->allow('login','test','update_products');
    	// Template variables
		$template = array(
		    'name'          => 'Châtelet',
		    'version'       => Configure::read('APP_VERSION'),
		    'author'        => 'Infinixsoft <desarrollo@infinixsoft.com>',
		    'title'         => 'Admin panel - Châtelet',
		    'description'   => '',
		    // 'fixed-top'         for a top fixed header
		    // 'fixed-bottom'      for a bottom fixed header
		    // ''                  empty for a static header
		    'header'        => '',
		    // 'sticky'            for a sticky sidebar
		    'sidebar'       => '',
		    // 'hide-side-content' for hiding sidebar by default
		    'side_content'  => '',
		    // 'full-width'        for full width page
		    // ''                  empty to remove full width from the page in large resolutions
		    'page'          => 'full-width',
		    // Available themes: 'fire', 'wood', 'ocean', 'leaf', 'tulip', 'amethyst',
		    //                   'dawn', 'city', 'oil', 'deepsea', 'stone', 'grass',
		    //                   'army', 'autumn', 'night', 'diamond', 'cherry', 'sun'
		    //                   'asphalt'
		    'theme'         => '',
        'active_page'   => $this->request->params['action']
		);

		$this->set('template', $template);

		// Primary navigation array (the primary navigation will be created automatically based on this array, up to 3 level deep)
		$menu = $this->AdminMenu->find('all',['order' => ['AdminMenu.ordernum ASC']]);

		$data = [];
		$map = $this->Setting->findById('bank_enable');
		$bank_enable = @$map['Setting']['value'];
		$map = $this->Setting->findById('whatsapp_enabled');
		$whatsapp_enabled = @$map['Setting']['value'];
		$coupon_enable = self::couponsAvailable();
		$banners_enable = self::bannersAvailable();

		foreach($menu as $i => $v) {
			if($v['url']==='/admin/whatsapp'){
				$menu[$i]['update'] = !empty($whatsapp_enabled);
			}
			if($v['url']==='/admin/cupones'){
				$menu[$i]['update'] = !empty($coupon_enable);
			}
			if($v['url']==='/admin/bank'){
				$menu[$i]['update'] = !empty($bank_enable);
			}
			if($v['url']==='/admin/banners'){
				$menu[$i]['update'] = !empty($banners_enable);
			}
		}
		$this->set('primary_nav', $menu);
		$this->Auth->loginAction = array('controller' => 'admin', 'action' => 'login');
		$this->Auth->logoutRedirect = array('controller' => 'admin', 'action' => 'login');
		$this->Auth->unauthorizedRedirect = array('controller' => 'admin', 'action' => 'login');
		$this->layout = 'admin';
	}

	private function couponsAvailable(){
		$this->loadModel('Coupon');
		$available = false;
		$map = $this->Coupon->find('all', [
			'conditions' => [
				'enabled' => 1
			]
		]);
		foreach($map as $item) {
			if (\filtercoupon($item)->status !== 'error') {
				$available = true;
				break;
			}
		}
		return $available;
	}

	private function bannersAvailable(){
		$this->loadModel('Banner');
		$available = false;
		$map = $this->Banner->find('all', [
			'conditions' => [
				'enabled' => 1
			]
		]);
		return count($map);
	}

	public function test2() {
		$this->loadModel('LogisticsPrices');
		$this->autoRender = false;
		$price = $this->LogisticsPrices->find('first', [
			'conditions' => [
				'logistic_id' => 3
			]
		]);		
		echo '<pre>';
		var_dump($price);
		die();
	}
	public function test_andreani() {
		$this->autoRender = false;
    $ws = new Andreani(getenv('ANDREANI_USUARIO'), getenv('ANDREANI_CLAVE'), getenv('ANDREANI_CLIENTE'), getenv('ANDREANI_DEBUG'));

		echo '<pre>';
		$bultos = array(
	    array(
        'volumen' => 200,
        'kilos' => 1.3,
        'altoCm' => 1,
				'anchoCm' => 2,
				'largoCm' => 1.5,
        'pesoAforado' => 5,
        'valorDeclarado' => 1200
	    )
		);
		/* https://apis.andreani.com/v1/tarifas?cpDestino=1400&contrato=300006611&cliente=CL0003750&sucursalOrigen=BAR&bultos[0][valorDeclarado]=1200&bultos[0][volumen]=200&bultos[0][kilos]=1.3&bultos[0][altoCm]=1&bultos[0][largoCm]=1.5&bultos[0][anchoCm]=2 */ 
		// $response = $ws->cotizarEnvio($_GET['cp'], '300006611', $bultos, 'CL0003750');
  	$response = $ws->cotizarEnvio(intval($_GET['cp']), getenv('ANDREANI_CONTRATO'), $bultos, getenv('ANDREANI_CLIENTE'));
    // echo '<pre>';
    // echo "cp " . $_GET['cp'] . "\n";
		// var_dump($response);
		exit();
	}

	public function test(){
		
		$this->autoRender = false;

		//$details = $this->SQL->product_price_by_list('V7000','180','05');
		//$details = $this->SQL->product_details( 'V7000' ,'05' );
		//$details = $this->SQL->productsByLisCod('V7000','05');
		//$details =   $this->SQL->product_name_by_article('V7000');
	//EXAMPLE: I5005/03/02/173
		// $details =   $this->SQL->product_stock('v7269','44','02','179');
//		pr($details);

		require_once(APP . 'Vendor' . DS . 'mercadopago.php');
		$mp = new MP(Configure::read('client_id'), Configure::read('client_secret'));
		$filters = array(
      "range" => "date_created",
      "begin_date" => "2020-10-31T00:00:00Z",
      "end_date" => "NOW",
			"limit" => 500, 
			"status" => "approved",
      "sort" => "id",
      "criteria" => "desc",
      "operation_type" => "regular_payment"
    );
		$searchResult = $mp->search_payment($filters,0,1000);
		echo '<pre>';
		print_r($searchResult);die;
		
	}

	public function test_ticket ($id) {
		$this->autoRender = false;

		var_dump($id);
		/* procedimiento de chequear estado de envío y generar etiquetas */

		$sale = $this->Sale->findById($id)['Sale'];

		if (!$sale) {
			throw new Exception("No existe tal venta", 500);
		}

		$shipping = $sale['shipping'];
		$logistic = $this->Logistic->findByCode($shipping)['Logistic'];

		if (!$logistic) {
			throw new Exception("Esta venta no registra envíos", 500);
		}

		$response = null;

		if($logistic['local_prices'] && method_exists($this, "add_order_{$shipping}")) {
			$response = $this->{"add_order_{$shipping}"}($sale);
		} else {
			$response = $this->add_order_logistic($sale, $logistic);
		}
		echo '<pre>';
		var_dump($response);
		return $response;
	}

	private function add_order_logistic($sale, $logistic){
		$order_nro = @strtoupper($logistic['code']).$sale['id'];
		$sale['def_orden_retiro'] = $order_nro;
		$sale['def_orden_tracking'] = $order_nro;
		$t = @$this->Sale->save($sale);
		$sale['raw_xml'] = 'default';
		return $sale;		
	}

	public function get_product($prod_cod = null, $lis_cod = null , $lis_cod2 = null) {
		$this->RequestHandler->respondAs('application/json');
		$this->autoRender = false;
		$this->SQL = $this->Components->load('SQL');
		$prod_parts = explode('.', $prod_cod);
		$products = $this->SQL->productsByLisCod($prod_parts[0], $lis_cod);
		 // CakeLog::write('error', $full_now.' '.$full_end);
		if (!empty($prod_parts[1])) {
			$color_id = substr($prod_parts[1], -2);
			$this->loadModel('Color');
			$color = $this->Color->find('first', array(
					'conditions' => array(
						'cod_chatelet' => $color_id
					)
				)
			);
		} else {
			$color = array();
		}

		foreach ($products as &$product) {
			$details = $this->SQL->product_price_by_list($prod_cod,$lis_cod,$lis_cod2);
			$details_name = $this->SQL->product_name_by_article($prod_cod);
		    if(!empty($details_name)){
              $product['nombre'] = $details_name['nombre'] ;
            }else{
		      $product['nombre'] = $product['descripcion'] ;
	        }

			$product['discount'] = $details['discount'];
			$product['details'] = $this->SQL->product_details( $prod_cod , $lis_cod );
		}

		return json_encode(array('results' => $products, 'colors' => $color ));
	}

	public function check_article($article = null){
		$this->autoRender = false;
		$this->SQL = $this->Components->load('SQL');
		$list_code = Configure::read('list_code');
		$exists = $this->SQL->product_exists($article,$list_code);
		if($exists){
			return 'ok';
		}else{
			return 'fail';
		}
	}


	 /*
		* ordernum
		* recieves two parameters id and order, being order the desired order 
		* number position of the table.
		* 
	  */

	public function ordernum($tag){
		$this->autoRender = false;
		$data = $this->request->data;
		$name = ucfirst($tag);
		$this->loadModel($name);

		if($this->request->is('post') && !empty($this->{$name})){
			$list = $this->{$name}->find('all',[
				'order' => [
					"{$name}.ordernum ASC"
				]
			]);

			$active_item = $this->{$name}->find('first',[
				'conditions' => [
					'id' => $data['id']
				]
			]);

			$orderlist = [];
			$active_order = 0;
			// we save the current ordering in a separate array
			foreach($list as $i => $item) {
				if ($item[$name]['id'] == $data['id']) {
					$active_order = $i;
				}
				$orderlist[$i] = $item[$name]['id'];
			}

			// now we manipulate the list and update to the new ordering requested.
			// the order parameter is the desired new position of the list.

			// we delete the old position of the active item being requested order for

			unset($orderlist[$active_order]);
			//array_splice($orderlist, $active_item[$name]['ordernum'] - 1, 1);
			// reindex
			$orderlist = array_values($orderlist);
			// now we add the active item into the new slot required
			array_splice($orderlist, $data['ordernum'] - 1, 0, $data['id']);

			// finally we update database based on our new orderlist
			foreach($orderlist as $ordernum => $id) {
				$this->{$name}->save([
					'id' => $id,
					'ordernum' => $ordernum + 1
				]);			
			}
		}
	}

	public function ordernum2($tag){
		$this->autoRender = false;
		$name = ucfirst($tag);
		$this->loadModel($name);
		$data = $this->request->data;
		$list = $this->{$name}->find('all',[
			'order' => ["{$name}.ordernum ASC"]
		]);

		$json = [];

		foreach($list as $i => $item) {
			$j = $i + 1;
			if ($item[$name]['id'] == (int) $data['id']) {
				$j = (int) $data['index'];
			}
			if ($item[$name]['id'] == (int) $data['id2']) {
				$j = (int) $data['index2'];
			}
			$json[$j] = $item[$name]['name'];
			$this->{$name}->save([
				'id' => $item[$name]['id'],
				'ordernum' => $j
			]);
		}

		//print_r(json_encode($json, JSON_PRETTY_PRINT));
		die(json_encode($json, JSON_PRETTY_PRINT));
		//print_r($map);
	}

	public function oca(){
		if($this->request->is('post')){
			$this->Package->save($this->request->data);
		}

		$h1 = array(
			'name' => 'Paquetería',
			'icon' => 'gi gi-package'
			);
		$this->set('h1', $h1);
		$this->loadModel('Home');

		$packages = $this->Package->find('all');
		$this->set('packages',$packages);
	}

	private function setOrdenRetiro($sale){
		$this->loadModel('Logistic');
		$sale = $sale['Sale'];
		$shipping = $sale['shipping'];
		$logistic = $this->Logistic->findByCode($shipping);
		$response = null;
		if(!$logistic['Logistic']['local_prices'] && method_exists($this, "add_order_{$shipping}")) {
			error_log('shipping ' . $shipping);
			$response = $this->{"add_order_{$shipping}"}($sale);
		} else {
			error_log('locals');
      $response = $this->add_order_logistic($sale, $logistic['Logistic']);
    }
		return $response;
	}

	private function add_order_oca ($sale) {
		$oca = new Oca();
		$this->loadModel('Setting');
		$nrocuenta = $this->Setting->findById('oca_nro_cuenta');
		$nrocuenta = @$nrocuenta['Setting']['value'];
		$idoperativa = $this->Setting->findById('oca_id_operativa');
		$idoperativa = @$idoperativa['Setting']['value'];
		$usr = $this->Setting->findById('oca_usr');
		$usr = @$usr['Setting']['value'];
		$psw = $this->Setting->findById('oca_psw');
		$psw = @$psw['Setting']['value'];

		//$sale = $sale['Sale'];
		$package = $this->Package->findById($sale['package_id']);
		$package = $package['Package'];
		
		$oca_result = $oca->ingresoORNuevo($nrocuenta, $idoperativa, $usr, $psw, $sale['id'],$sale['apellido'],$sale['nombre'],$sale['calle'],$sale['nro'],$sale['piso'],$sale['depto'],$sale['cp'],$sale['localidad'],$sale['provincia'],$sale['telefono'],$sale['email'],$package['height'],$package['width'],$package['depth'],($package['weight']/1000),$sale['value']);
		$sale['def_orden_retiro'] = @$oca_result['retiro'];
		$sale['def_orden_tracking'] = @$oca_result['tracking'];
		$t = @$this->Sale->save($sale);
		$sale['raw_xml'] = @$oca_result['rawXML'];
		return $sale;		
	}

	private function add_order_andreani ($sale) {
    $mapper = $this->Package->findById($sale['package_id']);
    $package = @$mapper['Package'];
		$ws = new Andreani(getenv('ANDREANI_USUARIO'), getenv('ANDREANI_CLAVE'), getenv('ANDREANI_CLIENTE'), getenv('ANDREANI_DEBUG'));
		$orden = [
	    'contrato' => getenv('ANDREANI_CONTRATO'),
	    'origen' => [
        'postal' => [
          'codigoPostal' => '1708',
          'calle' => '25 de Mayo',
          'numero' => '497',
          'localidad' => 'Morón',
          'region' => '',
          'pais' => 'Argentina',
          'componentesDeDireccion' => [
            [
              'meta' => 'entreCalle',
              'contenido' => 'Mitre y Norberto García Silva',
            ]
          ]
        ]
	    ],
	    'destino' => [
	      'postal' => [
	        'codigoPostal' => @$sale['cp'],
	        'calle' => @$sale['calle'],
	        'numero' => @$sale['nro'],
	        'localidad' => @$sale['localidad'],
	        'region' => @$sale['provincia'],
	        'pais' => 'Argentina'
	      ]
	    ],
	    'remitente' => [
	      'nombreCompleto' => 'Chatelet',
	      'email' => 'chateletonline@outlook.com.ar',
	      'documentoTipo' => 'DNI',
	      'documentoNumero' => '35881327',
	      'telefonos' => [
	        [
	          'tipo' => 1,
	          'numero' => '1155042428'
	        ]
	      ]
	    ],
	    'destinatario' => [
        [
          'nombreCompleto' => @$sale['nombre'] . ' ' . @$sale['apellido'],
          'email' => @$sale['email'],
          'documentoTipo' => 'DNI',
          'documentoNumero' => @$sale['dni'],
          'telefonos' => [
            [
              'tipo' => 1,
              'numero' => @$sale['telefono']
            ]
          ]
        ]
	    ],
	    'productoAEntregar' => 'Compra en Chatelet',
	    'bultos' => [
        [
				'anchoCm' => (float) $package['width'],
				'largoCm' => (float) $package['height'],
				'altoCm' => (float) $package['depth'],
        'volumenCm' => (float) $package['width'] * (float) $package['height'] * (float) $package['depth'],
				'kilos' => (float) $package['weight'] / 1000,
        'valorDeclaradoSinImpuestos' => (float) @$sale['value'],
        'valorDeclaradoConImpuestos' => (float) @$sale['value'],
        'referencias' => [
            [
              'meta' => 'Detalle',
              'contenido' => 'Compra en Chatelet'
            ],
            [
              'meta' => 'Cód. Cliente',
              'contenido' => @$sale['user_id']
            ]
          ]
        ]
	    ]
		];

		if (!empty($sale['piso']) || !empty($sale['depto'])) {
			$orden['destino']['postal']['componentesDeDireccion'] = [
        [
          'meta' => 'piso',
          'contenido' => @$sale['piso']
        ],
        [
          'meta' => 'departamento',
          'contenido' => @$sale['depto']
        ]
      ];
		}

		$response = $ws->addOrden($orden);
		file_put_contents(__DIR__.'/../logs/'.@$sale['id'].'_response.json', json_encode($response, JSON_PRETTY_PRINT));

		if (!is_null($response)) {
			$nroEnvio = @$response->bultos[0]->numeroDeEnvio;
	    $sale['def_orden_retiro'] = $nroEnvio;
	    $sale['def_orden_tracking'] = $nroEnvio;
	    $t = @$this->Sale->save($sale);
		}

	  $sale['raw_xml'] = @$response->detail ?: @$response->message;
		file_put_contents(__DIR__.'/../logs/'.@$sale['id'].'_orden.json', json_encode($orden, JSON_PRETTY_PRINT));

   	return $sale;   
	}

	public function updateSaleLogistic($sale_id = null){
		$this->autoRender = false;
		$this->loadModel('Logistics');
		$json = [
			'status' => 'error',
			'message' => 'La venta no fue actualizada'
		];
    if ($this->request->is('POST')) {
    	$data = $this->request->data;
			$json = [
				'status' => 'success',
				'message' => 'La venta fue actualizada'
			];
			$logistic = $this->Logistics->find('first', [
				'conditions' => [
					'id' => $data['logistic_id']
				]
			]);
			$sale = $this->Sale->findById($sale_id);
			$save = [];
			$save = ['id' => $sale_id];
			$save['logistic_id'] = (integer) $data['logistic_id'];
			$save['shipping'] = $logistic['Logistics']['code'];
			$t = $this->Sale->save($save);
		}
		die(json_encode($json));
	}

	public function getTicketFake($sale_id = null){
		$this->autoRender = false;
		$this->Sale->recursive = -1;
		$sale = $this->Sale->findById($sale_id);
		$sale = $sale['Sale'];
		$orden = "{$sale['shipping']}$sale_id";
		$this->Sale->save([
			'id' => $sale_id,
			'def_orden_retiro' => $orden
		]);
		$data = [
			'status' => 'success',
			'message' => 'Notificación enviada',
			'shipping' => "{$sale['shipping']}",
			'cargo' => "{$sale['cargo']}",
			'width' => 400,
			'height' => 300,
			'url' => Configure::read('baseUrl') . "admin/tickets/{$orden}"
		];
		die(json_encode($data));		
	}

	public function categoryDiscount($category_id = null){
		$this->autoRender = false;
		if(!$this->isAuthorized()) {
			die(json_encode(['status' => "error", 'message' => "Unauthorized"]));
		}

		$mode = $this->request->data['mode'];
		$this->loadModel('Product');
		$conds = [];
		$conds['Product.category_id'] = (int) $this->request->data['id'];
		if($this->request->data['existent_only'] === 'true') {
			$conds['Product.'.$mode.'_discount > '] = 0;
		}

		$this->Product->updateAll(
			[
				'Product.'.$mode.'_discount' => (float) $this->request->data['discount']
			],
			$conds			
		);

		die(json_encode([
			'status' => "success", 
			"conds" => $conds,
		]));	
	}

	public function saleComplete($sale_id = null){
		$this->autoRender = false;
		$this->Sale->recursive = -1;

		if(!$this->isAuthorized()) {
			die(json_encode(['status' => "error", 'message' => "Unauthorized"]));
		}


		$sale = $this->Sale->findById($sale_id);
		$data = [
			'status' => 'success',
			'message' => 'Venta completada'
		];
		if(!empty($sale)) {
			$this->Sale->save([
				'id' => $sale_id,
				'completed' => 1
			]);
		} else {
			$data = [
				'status' => 'danger',
				'message' => 'No se encontró la venta'
			];
		}
		$message = '<p>Hola '.ucfirst($sale['Sale']['nombre']).', ¡recibimos tu pago!<br>
Te confirmamos el pago por tu compra en Chatelet.</p>
<p>Tu número de pedido es: #' . $sale['Sale']['id'] . '. Tu compra será procesada dentro de las 72hs de haberse acreditado el pago. Si elegiste envío por correo Oca, Andreani o SpeedMoto te llegará un segundo email con el número de seguimiento para que puedas ver el estado del mismo. Si elegiste retiro por sucursal te avisaremos por este medio cuando el pedido se encuentre listo para retirar!</p><br>
<p>¡Muchas gracias!</p><br>
<a href="https://www.chatelet.com.ar">CHATELET</a>';
		error_log('[email] notifying user bank ok '.$sale['Sale']['email']);
		$this->sendMail($message,'🌸 Confirmación de pago de la orden #' . $sale['Sale']['id'],$sale['Sale']['email']);

		die(json_encode($data));
	}

	public function getTicket($sale_id = null){
		$this->autoRender = false;
		$data = [
			'status' => 'danger',
			'message' => 'Error'
		];
		error_log('[ticket] generating for sale ' . $sale_id);
		$this->loadModel('User');
		$this->Sale->recursive = -1;
		$send_email = false;
		$sale = $this->Sale->findById($sale_id);
		$nro = @$sale['Sale']['nro'];

		if(empty($nro)) {
			$nro = 1;
		}

		if (empty($sale) || empty($sale['Sale']['package_id']) || empty($sale['Sale']['value']) || empty($sale['Sale']['email']) || empty($sale['Sale']['telefono']) || empty($sale['Sale']['provincia']) || empty($sale['Sale']['localidad']) || empty($sale['Sale']['cp']) || empty($sale['Sale']['calle']) || empty($sale['Sale']['nombre']) || empty($sale['Sale']['apellido'])) {
			// die('Venta no encontrada o incompleta.');
			$data['message'] = 'Venta incompleta';
		} else {
			if (empty($sale['Sale']['def_mail_sent'])) {
				$send_email = true;
			}

			$sale = $this->setOrdenRetiro($sale);
			$data['shipping'] = @strtolower($sale['shipping']);
			if (!empty($sale['def_orden_retiro'])) {
				if (!empty($sale['def_orden_tracking']) && $send_email) {
					// $user = $this->User->findById($sale['user_id']);
					$mapper = $this->Logistic->findById($sale['logistic_id']);
					$logistic = [
						// 'tracking_url' => Configure::read('baseUrl') . 'envios/',
						'width' => 400,
						'height' => 300
					];
					
					if (isset($mapper)) {
						$logistic = $mapper['Logistic'];
					}

					$data['width'] = $logistic['width'];
					$data['height'] = $logistic['height'];

					$emailTo = @$sale['email'];
					//$emailTo = 'francisco.marasco@gmail.com';
					$message = '<p>Hola <strong>'.ucfirst(@$sale['nombre']).'</strong>, gracias por tu compra!</p>';
					if (isset($logistic) && $logistic['tracking_url'])  {
						$message.= '<p>Puedes seguir tu envío a través del sitio de ' . strtoupper($sale['shipping']) . ': ' . @$logistic['tracking_url'] . '<br /> Ingresando el número de envio: '.@$sale['def_orden_tracking'].'</p>';
					} else {
						// find price info
						$this->loadModel('LogisticsPrices');
						$price = $this->LogisticsPrices->find('first', [
							'conditions' => [
								'logistic_id' => @$sale['logistic_id'],
		            'OR' => [
		              ['zips LIKE' => "%{$cp1}%"],
		              ['zips LIKE' => "%{$cp2}%"],
		              ['zips LIKE' => "%{$cp}%"]
		            ]
							]
						]);

						$message.= '<p>El envío de tu compra está a cargo de '.strtoupper($sale['shipping']).' y código de envío es '.@$sale['def_orden_tracking'].' </p>';
						$info = array_filter([$logistic['info'], $price['LogisticsPrices']['info']]);
						if (!empty($info)) {
							$message.= '<p>'.implode('</p><p>', $info).'</p>';
						}
					}

					$message.= '<br/><a href="https://www.chatelet.com.ar">www.chatelet.com.ar</a>';

					error_log('[email] notifying the tracking for user '.$emailTo);

					$data['status'] = 'success';
					$data['message'] = 'Notificación enviada';
					$this->sendMail($message,'🌸 Compra Realizada en Châtelet', $emailTo);
					$this->Sale->save(['def_mail_sent' => 1]);
				} else {
					error_log('[email] ignored bc was sent before');
					$data['status'] = 'success';
					$data['message'] = 'Ya solicitado previamente';
				}
				// $data['url'] = "https://www1.oca.com.ar/ocaepak/Envios/EtiquetasCliente.asp?IdOrdenRetiro={$sale['def_orden_retiro']}&CUIT=30-71119953-1";


				// etiquetas
				if ($sale['shipping'] == 'andreani') {
					$ws = new Andreani(getenv('ANDREANI_USUARIO'), getenv('ANDREANI_CLAVE'), getenv('ANDREANI_CLIENTE'), getenv('ANDREANI_DEBUG'));

					$response = $ws->getEtiqueta(@$sale['def_orden_tracking'], Andreani::ETIQUETA_ESTANDAR);
					if (!is_null($response) && isset($response->pdf)) {
						$dest = __DIR__ . '/../webroot/files/andreani/' . $sale['def_orden_tracking'] . '.pdf';
					  file_put_contents($dest, $response->pdf);
					  $url = Configure::read('baseUrl') . 'files/andreani/' . $sale['def_orden_tracking'] . '.pdf';
					}
				} else if ($sale['shipping'] == 'oca') { 
					$url = "http://www5.oca.com.ar/OcaEPakNet/Views/Impresiones/Etiquetas.aspx?IdOrdenRetiro={$sale['def_orden_retiro']}&CUIT=30-71119953-1";
				} else {
					$url = Configure::read('baseUrl') . "admin/tickets/{$sale['def_orden_retiro']}";
				}
				$data['url'] = $url;
				$data['shipping'] = $sale['shipping'];
				$data['cargo'] = $sale['cargo'];
			} else {
				$data['message'] = strip_tags($sale['raw_xml']);
			}
		}
		die(json_encode($data));
	}

	public function tickets ($order_retiro) {
		$this->layout = false;

		if(!$this->isAuthorized()) {
			die(json_encode(['status' => "error", 'message' => "Unauthorized"]));
		}


		$sale = $this->Sale->find('first', [
			'conditions' => [
				'def_orden_retiro' => $order_retiro
			]
		]);
		$package = $this->Package->findById($sale['Sale']['package_id']);
		$this->set('ticket', $sale['Sale']);
		$this->set('package', $package['Package']);
		return $this->render('ticket');
	}

	public function delete_package($id = 0){
		$this->Package->delete($id);
		$this->redirect(array( 'action' => 'oca' ));
	}

	public function delete_sale($id = 0){
		$this->loadModel('Sale');
		$this->Sale->delete($id);
		$this->redirect(array( 'action' => 'sales' ));
	}

	private function getMPSales(){
		if ($_SERVER['REMOTE_ADDR'] == '127.0.0.11') {
			return json_decode(file_get_contents(__DIR__ . '/dummy/mpsales.json'), true);
		}
		require_once(APP . 'Vendor' . DS . 'mercadopago.php');
		$mp = new MP(Configure::read('client_id'), Configure::read('client_secret'));
		$limit = isset($_GET['extended']) ? 500 : 10;
		$filters = array(
      "range" => "date_created",
      "begin_date" => "2022-01-01T00:00:00Z",
      "end_date" => "NOW",
      "limit" => $limit,
      "status" => "approved",
      "sort" => "id",
      "criteria" => "desc",
      "operation_type" => "regular_payment"
    );
    $searchResult = $mp->search_payment($filters,0,$limit);
    return (!empty($searchResult['response']['results']))?$searchResult['response']['results']:array();
	}

  public function newsletter_export_emails(){
    $this->autoRender=false;
		$this->loadModel('Subscription');

    //$list = [];
    //$arraux = [];
	
    $config = array(
    	'conditions' => array( 'Subscription.email LIKE' => "%@%" ),
    	'order' => array('Subscription.id DESC')
    );

    if (!empty($_REQUEST['limit'])) {
    	$config['limit'] = $_REQUEST['limit'];
    }

    $subscriptions = $this->Subscription->find('all',$config);
    $output = fopen("php://output",'w') or die("Can't open php://output");
    header("Content-Type:application/csv");
    header("Content-Disposition:attachment;filename=subscriptions_emails.csv");
    fputcsv($output, ['Email']);

    foreach($subscriptions as $subscription) {
      fputcsv($output, [$subscription['Subscription']['email']]);
    }
    fclose($output);
  }

	public function sales_export_mails(){
		$this->autoRender=false;
		$list = [];
    $arraux = [];
		$sales = $this->getMPSales();

		foreach ($sales as &$sale) {
			$details 		= explode('-|-', $sale['collection']['reason']);
			$sale_number 	= (!empty($details[0]))?$details[0]:'PEDIDO : "00"';
			if(strpos($sale_number, "&quot;")!== false){
				$sale_number = html_entity_decode($sale_number);
			}

			//Info Mergeapp/webroot/css/custom.css
			$sale['collection']['deliver_cost'] = 0;
			$local_desc		= $this->SaleProduct->find('all',array('conditions'=>array( 'SaleProduct.description LIKE' => "%$sale_number%" )));
			if(!empty($local_desc)){
				$sale['collection']['sale_products'] = Hash::extract($local_desc, '{n}.SaleProduct.description');
			}else{
				$sale['collection']['sale_products'] = array($sale['collection']['reason']);
			}
		}

		$sales = Hash::sort($sales, '{n}.collection.date_approved', 'desc');
		$exists=[];

    foreach($sales as $sale) {
			foreach ($sale['collection']['sale_products'] as $reason){
				error_log($reason);
				$details = explode('-|-', $reason);
				foreach ($details as $key => $detail){
					$extra = explode(' : ', $detail);
					if (!empty($extra[0]) && !empty($extra[1])){
						if (strtolower(trim($extra[0]))==='email'){
							$email=str_replace(array("\"","&quot;"), "",@$extra[1]);
							if (in_array($email, $exists)){

							}else{
								$exists[] = $email;
								array_push($arraux, $email);
								array_push($list, $arraux);
					      $arraux = [];
							}
						}
					}
				}
			}
    }

    $output = fopen("php://output",'w') or die("Can't open php://output");
    header("Content-Type:application/csv");
    header("Content-Disposition:attachment;filename=sales_emails.csv");
    fputcsv($output, array('Email'));
    foreach ($list as $campos) {
      fputcsv($output, $campos);
    }

    fclose($output);
	}

	private function getSales(){
		//$online = $this->getMPSales();
		$date = strtotime("-2 week");
		// Local data
		/*if ($online) {
			$date = strtotime($online[count($online)-1]['collection']['date_created']);
		}*/
		$stamp = date('Y-m-d H:i', $date);
		$mapper = $this->Sale->find('all',[
			'conditions' => [
				/*'or' => [
					'Sale.payment_method <>' => "mercadopago",
					'Sale.completed' => "1",					
				],*/
				'and' => [
					'Sale.created >' => "$stamp"
				]
			]
		]);
		$manual = [];
		foreach($mapper as $item) {
			$manual[] = [
				'collection' => [
					'reason' => "PEDIDO : \"{$item['Sale']['id']}\"",
					'date_approved' => date('c', strtotime($item['Sale']['created']))					
				]
			];
		}

		return $manual;
	}

	public function sales(){
		$h1 = array(
			'name' => 'Ventas',
			'icon' => 'gi gi-money'
		);

		$this->set('h1', $h1);
		$this->loadModel('Home');
		$this->loadModel('Setting');
		$this->loadModel('Logistics');

		//Get and merge local-remote data.
		$sales = $this->getSales();
		/*echo '<pre>';
		var_dump($sales);
		die('--');*/

		foreach ($sales as &$sale) {
			$details = explode('-|-', $sale['collection']['reason']);
			$sale_number 	= (!empty($details[0]))?$details[0]:'PEDIDO : "00"';
			if(strpos($sale_number, "&quot;")!== false){
				$sale_number = html_entity_decode($sale_number);
			}

			if (strpos($sale_number,'PEDIDO') !== false) {
				//Info metaphone(str)rgeapp/webroot/css/custom.css
				$sale['collection']['deliver_cost'] = 0;
				$local_desc		= $this->SaleProduct->find('all',array('conditions'=>array( 'SaleProduct.description LIKE' => "%$sale_number%" )));
				if(!empty($local_desc)){
					$sale['collection']['sale_products'] = Hash::extract($local_desc, '{n}.SaleProduct.description');
				}else{
					$sale['collection']['sale_products'] = array($sale['collection']['reason']);
				}
				// $package = $this->Package->find('first',array( 'conditions' => array( 'Package.amount_max >=' => count( $sale['collection']['sale_products'] ) , 'Package.amount_min <=' => count( $sale['collection']['sale_products'] ) ) ));

				//Deliver Cost
				foreach ($local_desc as $key => $value) {
					$sale_id = (!empty($value['SaleProduct']['sale_id']))?$value['SaleProduct']['sale_id']:0;

					if ($sale_id) {
						$local_sale = $this->Sale->findById($sale_id);
						$sale['collection']['deliver_cost'] = (!empty($local_sale['Sale']['deliver_cost']))?$local_sale['Sale']['deliver_cost']:0;
						$sale['local_sale'] = $local_sale['Sale'];
					}
				}
			}
		}

		$sales = Hash::sort($sales, '{n}.collection.date_approved', 'desc');
		if (!empty($this->request->query['test'])){
			echo '<pre>';
			var_dump($sales);
			die();
		  // var_dump(json_decode(json_encode($sales)));die;
		}		
		//pr($sales);die;
    $logistics = $this->Logistics->find('all',array('conditions'=>array( 'enabled' => 1 )));

    $logistics_images = [];
    foreach($logistics as $logistic) {
    	$logistics_images[$logistic['Logistics']['code']] = $logistic['Logistics']['image'];
    }

		$this->set('logistics_images', $logistics_images);
		$this->set('list_payments', [
	    '' => "CBU/Alias",
	    'credit_card' => "Crédito",
	    'debit_card' => "Débito",
	    'ticket' => "Ticket",
	    'account_money' => "Efectivo",
		]);

		$this->set('list_status', [
	    '' => "Pendiente",
	    'approved' => "Aprobado",
	    'processing' => "Procesando...",
	    'rejected' => "Rechazado",
		]);

		$this->set('shipping_price_min',$this->Setting->findById('shipping_price_min'));
		$this->set('logistics',$logistics);
		$this->set('sales',$sales);
	}

	public function remove_whatsapp($id = null){
		$this->Promo->delete($id);
		$this->redirect(array( 'action' => 'whatsapp' ));
	}

	public function save_file_orientation()
	{
		$this->autoRender = false;
		$response = ["status" => "success"];
		$data = $this->request->data;


		$this->loadModel('Home');
		$p = $this->Home->find('first');
		$field = $p['Home'][$data['origin']];

		$parts = array_filter(explode(';',$field));
		$arr = [];
		foreach($parts as $part) {
			if(strpos($part, $data['file']) != false) {
				$parts2 = explode('-',$part);
				$orientation = $parts2[0] == 'mobile' ? 'desktop' : 'mobile';
				$response['orientation'] = $orientation;
				$arr[] = $orientation .'-'. $parts2[1];
			} else {
				$arr[] = $part;
			}
		}

		
		$save = [];
		$save['id'] = 1;
		$save[$data['origin']] = ';' . implode(';', $arr);

		error_log(json_encode($save));

		$this->Home->save($save);

		error_log(json_encode($field));

/*		if (!empty($this->request->data['file']['name'])) {
			$response = $this->save_file($this->request->data['file']);
		} else {
			die('fail');
		}
		if(empty($response)){
			$response = 'fail';
		}*/
		die(json_encode($response));
	}

	public function save_file_admin()
	{
		$this->autoRender = false;
		$response = null;
		if (!empty($this->request->data['file']['name'])) {
			$response = $this->save_file($this->request->data['file']);
		} else {
			die('fail');
		}
		if(empty($response)){
			$response = 'fail';
		}
		die($response);
	}

	public function isAuthorized() {
    // If we're trying to access the admin view, verify permission:
    if ('admin' === $this->Auth->user('role')) return true;  // User is admin, allow
    return false;                                // User isn't admin, deny
	}

	public function index() {
	  $this->loadModel('Category');
		$cats = $this->Category->find('all',['order' => ['Category.ordernum ASC']]);
  	$this->set('cats', $cats);

		$h1 = array(
		'name' => 'Presentación',
		'icon' => 'fa fa-eye'
		);
		$this->set('h1', $h1);
		$this->loadModel('Home');

		if ($this->request->is('post')) {
      $data = $this->request->data;

      // img_url: define image orientation
      $imgs = array_filter(explode(";",$data['img_url']));
      $media = [];
      foreach($imgs as $img) {
      	$parts = explode('-', $img);
      	if(count($parts) < 2) {
	      	$fname = __DIR__ . '/../webroot' . Configure::read('uploadUrl') . $img;
	      	if(file_exists($fname)) {
						$img_data = getimagesize();
						$orientation = $img_data[0] > $img_data[1] ? 'desktop' : 'mobile';
						error_log(json_encode($img_data));
						error_log('fname: '. $fname);
						error_log('orientation: '. $orientation);
			    	$media[] = implode('-', [$orientation, $img]);
			    } 
			  } else {
			    $media[] = $img;
			  }
	    }

	    if(count($media)) {
	    	//$media = array_filter($media);
	    	$data['img_url'] = ';' . implode(";", $media);
	    	error_log(json_encode($media));
	    }

	    // img_popup_newsletter: define image orientation
      $imgs = array_filter(explode(";",$data['img_popup_newsletter']));
      $media = [];
      foreach($imgs as $img) {
      	$parts = explode('-', $img);
      	if(count($parts) < 2) {
	      	$fname = __DIR__ . '/../webroot' . Configure::read('uploadUrl') . $img;
	      	if(file_exists($fname)) {
						$img_data = getimagesize();
			    	$media[] = implode('-', [($img_data[0] > $img_data[1] ? 'desktop' : 'mobile'), $img]);
			    } 
			  } else {
			    $media[] = $img;
			  }
	    }

	    if(count($media)) {
	    	//$media = array_filter($media);
	    	$data['img_popup_newsletter'] = ';' . implode(";", $media);
	    	//error_log(json_encode($media));
	    }

	    
	    //$img_url_media = implode(";",$media);
      //error_log(json_encode($media));

    	if(empty($data['url_mod_one'])) {
    		$data['url_mod_one']=null;
    	}    	
    	if(empty($data['url_mod_two'])) {
    		$data['url_mod_two']=null;
    	}
    	if(empty($data['url_mod_three'])) {
    		$data['url_mod_three']=null;
    	}
    	if(empty($data['url_mod_four'])) {
    		$data['url_mod_four']=null;
			}
		
    	if ($data['category_mod_one'] == 'url') {
    		$data['category_mod_one'] = null;
    	} else {
    		$data['url_mod_one'] = null;
    	}
    	if ($data['category_mod_two'] == 'url') {
    		$data['category_mod_two'] = null;
    	} else {
    		$data['url_mod_two'] = null;
    	}
    	if ($data['category_mod_three'] == 'url') {
    		$data['category_mod_three'] = null;
    	} else {
    		$data['url_mod_three'] = null;
    	}
    	if ($data['category_mod_four'] == 'url') {
    		$data['category_mod_four'] = null;
    	} else {
    		$data['url_mod_four'] = null;
    	}
    	if(!isset($data['display_popup_form'])){
    		$data['display_popup_form'] = 0;
    	}
    	if(!isset($data['display_popup_form_in_last'])){
    		$data['display_popup_form_in_last'] = 0;
    	}
    	
    	$this->Home->save($data);
		}

		$p = $this->Home->find('first');
		$this->set('p', $p);
	}

	public function index_old() {
	  $this->loadModel('Category');
		$cats = $this->Category->find('all',['order' => ['Category.ordernum ASC']]);
  	$this->set('cats', $cats);

		$h1 = array(
		'name' => 'Presentación',
		'icon' => 'fa fa-eye'
		);
		$this->set('h1', $h1);
		$this->loadModel('Home');

		if ($this->request->is('post')) {
      $data = $this->request->data;

      // img_url: define image orientation
      $imgs = array_filter(explode(";",$data['img_url']));
      $media = [];
      foreach($imgs as $img) {
      	$parts = explode('-', $img);
      	if(count($parts) < 2) {
	      	$fname = __DIR__ . '/../webroot' . Configure::read('uploadUrl') . $img;
	      	if(file_exists($fname)) {
						$img_data = getimagesize();
						$orientation = $img_data[0] > $img_data[1] ? 'desktop' : 'mobile';
						error_log(json_encode($img_data));
						error_log('fname: '. $fname);
						error_log('orientation: '. $orientation);
			    	$media[] = implode('-', [$orientation, $img]);
			    } 
			  } else {
			    $media[] = $img;
			  }
	    }

	    if(count($media)) {
	    	//$media = array_filter($media);
	    	$data['img_url'] = ';' . implode(";", $media);
	    	error_log(json_encode($media));
	    }

	    // img_popup_newsletter: define image orientation
      $imgs = array_filter(explode(";",$data['img_popup_newsletter']));
      $media = [];
      foreach($imgs as $img) {
      	$parts = explode('-', $img);
      	if(count($parts) < 2) {
	      	$fname = __DIR__ . '/../webroot' . Configure::read('uploadUrl') . $img;
	      	if(file_exists($fname)) {
						$img_data = getimagesize();
			    	$media[] = implode('-', [($img_data[0] > $img_data[1] ? 'desktop' : 'mobile'), $img]);
			    } 
			  } else {
			    $media[] = $img;
			  }
	    }

	    if(count($media)) {
	    	//$media = array_filter($media);
	    	$data['img_popup_newsletter'] = ';' . implode(";", $media);
	    	//error_log(json_encode($media));
	    }

	    
	    //$img_url_media = implode(";",$media);
      //error_log(json_encode($media));

    	if(empty($data['url_mod_one'])) {
    		$data['url_mod_one']=null;
    	}    	
    	if(empty($data['url_mod_two'])) {
    		$data['url_mod_two']=null;
    	}
    	if(empty($data['url_mod_three'])) {
    		$data['url_mod_three']=null;
    	}
    	if(empty($data['url_mod_four'])) {
    		$data['url_mod_four']=null;
			}
		
    	if ($data['category_mod_one'] == 'url') {
    		$data['category_mod_one'] = null;
    	} else {
    		$data['url_mod_one'] = null;
    	}
    	if ($data['category_mod_two'] == 'url') {
    		$data['category_mod_two'] = null;
    	} else {
    		$data['url_mod_two'] = null;
    	}
    	if ($data['category_mod_three'] == 'url') {
    		$data['category_mod_three'] = null;
    	} else {
    		$data['url_mod_three'] = null;
    	}
    	if ($data['category_mod_four'] == 'url') {
    		$data['category_mod_four'] = null;
    	} else {
    		$data['url_mod_four'] = null;
    	}
    	if(!isset($data['display_popup_form'])){
    		$data['display_popup_form'] = 0;
    	}
    	if(!isset($data['display_popup_form_in_last'])){
    		$data['display_popup_form_in_last'] = 0;
    	}
    	
    	$this->Home->save($data);
		}

		$p = $this->Home->find('first');
		$this->set('p', $p);
	}


	public function catalogo($action = null) {
		$this->loadModel('Setting');
		$h1 = array(
			'name' => 'Catálogo',
			'icon' => 'gi gi-display'
		);
		$this->set('h1', $h1);
		$this->loadModel('Catalog');

		if ($this->request->is('post') && $action == 'deleteimg') {
			$catalog = $this->Catalog->find('first');
			$catalog = $catalog['Catalog'];
			$images = explode(';', $catalog['images']);
			$target = $this->request->data['id'];
			if(($key = array_search($target, $images)) !== false) {
			    unset($images[$key]);
			    $catalog['images'] = implode(';', $images);
			    $this->Catalog->save($catalog);
			}
		} else if ($this->request->is('post')) {
			$data = $this->request->data;
			$old = $this->Catalog->find('first');
			$old = $old['Catalog'];
            $pictures = array();
            $pictures_tmp = $this->request->params['form']['pictures'];
            //var_dump($pictures_temp);
            $count_max_pictures = count($pictures_tmp['name']);

            if(isset($data['page_video'])) {
            	$this->Setting->save(array( 'id' => 'page_video' , 'value' => $data['page_video'] ));
            }

            if(isset($data['catalog_first_line']) && isset($data['catalog_second_line'])) {
            	$this->Setting->save(array( 'id' => 'catalog_first_line' , 'value' => $data['catalog_first_line'] ));
            	$this->Setting->save(array( 'id' => 'catalog_second_line' , 'value' => $data['catalog_second_line'] ));
            }

            if(isset($data['catalog_text'])) {
               	$this->Setting->save(array( 'id' => 'catalog_text' , 'value' => $data['catalog_text'] ));
            }

            if(isset($data['catalog_flap'])) {
               	$this->Setting->save(array( 'id' => 'catalog_flap' , 'value' => $data['catalog_flap'] ));
            }

            for ($i=0; $i < $count_max_pictures; $i++) {
            	$current = array(
            		'name' => $pictures_tmp['name'][$i],
            		'type' => $pictures_tmp['type'][$i],
            		'tmp_name' => $pictures_tmp['tmp_name'][$i],
            		'error' => $pictures_tmp['error'][$i],
            		'size' => $pictures_tmp['size'][$i]
        		);

                $file_real_name = $this->save_file($current);
                if($file_real_name){
                    $pictures[] = $file_real_name;
                }
            }
            if (empty($old['images'])) $old['images'] = '';
            if (!empty($old['images'])) {
            	$data['images'] = $old['images'] .';'. implode(';', $pictures);
        	} else {
        		$data['images'] = implode(';', $pictures);
        	}
			$this->Catalog->save($data);
		}

		$setting 	= $this->Setting->findById('page_video');
		$page_video = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('page_video',$page_video);
		unset($setting);

		$setting 	= $this->Setting->findById('catalog_first_line');
		$catalog_first_line = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_first_line',$catalog_first_line);

		unset($setting);

		$setting 	= $this->Setting->findById('catalog_second_line');
    	$catalog_second_line = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_second_line',$catalog_second_line);
		unset($setting);

		$setting 	= $this->Setting->findById('catalog_text');
		$catalog_text = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_text',$catalog_text);
		unset($setting);

		$setting 	= $this->Setting->findById('catalog_flap');
		$catalog_flap = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_flap',$catalog_flap);
		unset($setting);

		$p = $this->Catalog->find('first');
		$this->set('p', $p);

	}

	public function categorias($action = null) {
		$navs = array(
			'Lista' => array(
				'icon' 		=> 'gi gi-picture',
				'url'		=> Configure::read('mUrl').'/admin/categorias',
				'active'	=> '/admin/categorias'
			),
			'Nueva Categoria' => array(
				'icon' 		=> 'gi gi-circle_plus',
				'url'		=> Configure::read('mUrl').'/admin/categorias/add',
				'active'	=> '/admin/categorias/add'
			)
		);

		$this->set('navs', $navs);
		$h1 = array(
			'name' => 'Categorías',
			'icon' => 'gi gi-picture'
		);
		$this->set('h1', $h1);
    $this->loadModel('Category');
    switch ($action) {
    	case 'add':
    	    if ($this->request->is('POST')){
		        $this->autoRender = false;

		        $data = $this->request->data;

		        $file_real_name = null;
		        if(!empty($this->request->params['form']['image']['name'])){
		          $file_real_name = $this->save_file($this->request->params['form']['image']);
		        }

		        $file_size = null;
		        if(!empty($this->request->params['form']['size']['name'])){
		          $file_size = $this->save_file($this->request->params['form']['size']);
		        }

		        if($file_real_name){
		          $data['img_url'] = $file_real_name;
		        }
		        
		        if($file_size){
		          $data['size'] = $file_size;
		        }

		        $this->Category->save($data);
		        return $this->redirect(array('action'=>'categorias'));
  			} else {
    			return $this->render('categorias-detail');
    		}
    		break;
    	case 'delete':
	    	if ($this->request->is('post')) {
	    		$this->autoRender = false;
	    		$this->loadModel('Product');
	    		$this->Product->deleteall(array('Product.category_id' => $this->request->data['id']));
	    		$this->Category->delete($this->request->data['id']);
	    	}
    		break;
    	case 'edit':
    		if ($this->request->is('post')) {
    			$this->autoRender = false;
    			$data = $this->request->data;
	        $file_real_name = null;
	        if(!empty($this->request->params['form']['image']['name'])){
            $file_real_name = $this->save_file($this->request->params['form']['image']);
	        }

	        $file_real_name1 = null;
	        if(!empty($this->request->params['form']['banner']['name'])){
	           $file_real_name1 = $this->save_file($this->request->params['form']['banner']);
	        }

	        $file_size = null;
	        if(!empty($this->request->params['form']['size']['name'])){
	          $file_size = $this->save_file($this->request->params['form']['size']);
	        }

	        if($file_real_name){
	          $data['img_url'] = $file_real_name;
	        }

	        if($file_real_name1){
	          $data['banner_url'] = $file_real_name1;
	        }

	        if($file_size){	
	          $data['size'] = $file_size;
	        }

	        $this->Category->save($data);
    		} else {
	    		$hasId = array_key_exists(1, $this->request->pass);
	    		if (!$hasId) break;
	    		$cat = $this->Category->find('first', array('conditions' => array('id' => $this->request->pass[1])));
	    		$this->set('cat', $cat);
	    		return $this->render('categorias-detail');
    		}
    		break;
    }
	  $cats = $this->Category->find('all',['order' => ['Category.ordernum ASC']]);
		$this->set('cats', $cats);
	  $this->render('categorias');
	}

	public function whatsapp(){
	  $this->loadModel('Setting');
		if($this->request->is('post')){
			$data = $this->request->data;
			$promo = $data['Promo'];

			unset($data['Promo']);
      foreach($data as $id => $value) {
        $this->Setting->save(['id' => $id, 'value' => $value]);
      }

			if(!empty($promo['image']['name'])){
				$file = $this->save_file( $promo['image'] );
				$this->Promo->save(array(
					'id' => null,
					'image' => $file,
				));
			}
		}
		$h1 = array(
			'name' => 'Compra por WhatsApp',
			'icon' => 'gi gi-display'
			);
		$this->set('h1', $h1);

		$data = [];
		$map = $this->Setting->findById('whatsapp_enabled');
		$data['whatsapp_enabled'] = $map['Setting']['value'];
		$map = $this->Setting->findById('whatsapp_phone');
		$data['whatsapp_phone'] = $map['Setting']['value'];
		$map = $this->Setting->findById('whatsapp_text');
		$data['whatsapp_text'] = $map['Setting']['value'];
		$map = $this->Setting->findById('whatsapp_autohide');
		$data['whatsapp_autohide'] = $map['Setting']['value'];
		$map = $this->Setting->findById('whatsapp_animated');
		$data['whatsapp_animated'] = $map['Setting']['value'];

		$items = $this->Promo->find('all');
		$this->set('data', $data);		
		$this->set('items',$items);
	}

	public function application(){
	  $this->loadModel('Setting');
		if($this->request->is('post')){
			$data = $this->request->data;
			$og = $data['opengraph'];
			unset($data['opengraph']);

      foreach($data as $id => $value) {
        $this->Setting->save(['id' => $id, 'value' => $value]);
      }

			if(!empty($og['image']['name'])){
				$file = $this->save_file( $og['image'] );
				$this->Setting->save(['id' => 'opengraph_image', 'value' => Configure::read('uploadUrl') . $file]);
			}
		}
		$h1 = array(
			'name' => 'Aplicación',
			'icon' => 'fa fa-cog'
			);

		$this->set('h1', $h1);

		$data = [];
		$map = $this->Setting->findById('opengraph_title');
		$data['opengraph_title'] = @$map['Setting']['value'];
		$map = $this->Setting->findById('opengraph_text');
		$data['opengraph_text'] = @$map['Setting']['value'];
		$map = $this->Setting->findById('opengraph_image');
		$data['opengraph_image'] = @$map['Setting']['value'];
		$map = $this->Setting->findById('opengraph_type');
		$data['opengraph_type'] = @$map['Setting']['value'];
		$map = $this->Setting->findById('opengraph_width');
		$data['opengraph_width'] = @$map['Setting']['value'];
		$map = $this->Setting->findById('opengraph_height');
		$data['opengraph_height'] = @$map['Setting']['value'];

		$this->set('data', $data);		
	}

	public function promos(){
		if($this->request->is('post')){
			$data = $this->request->data;
			if(!empty($data['Promo']['image']['name'])){
				$file = $this->save_file( $data['Promo']['image'] );
				$this->Promo->save(array(
					'id' => null,
					'image' => $file,
				));
			}
		}
		$h1 = array(
			'name' => 'Compra por WhatsApp',
			'icon' => 'gi gi-display'
			);
		$this->set('h1', $h1);

		$promos = $this->Promo->find('all');
		$this->set('promos',$promos);
	}

	public function products_settings(){
		$this->loadModel('Setting');
		if($this->request->is('post')){
			$data = $this->request->data;

			$this->Setting->save(array(
				'id' => 'stock_min',
				'value' => $data['stock_min']
			));
			$this->Setting->save(array(
				'id' => 'list_code',
				'value' => $data['list_code']
			));

			$this->Setting->save(array(
				'id' => 'list_code_desc',
				'value' => $data['list_code_desc']
			));


            $image_bannershop = $this->Setting->save(array(
				'id' => 'image_bannershop',
				'value' =>$data['image_bannershop']
			));


			$this->Setting->save(array(
				'id' => 'image_menushop',
				'value' => $data['image_menushop']
			));



            $this->Setting->save(array(
				'id' => 'image_prodshop',
				'value' => $data['image_prodshop']
			));


			$this->Setting->save(array(
				'id' => 'show_shop',
				'value' => (isset($data['show_shop']))?1:0
			));
			if (!empty($data['no-update-prices']) && $data['no-update-prices']=='yes'){
				return $this->redirect(array( 'action' => 'productos' ));
			}
			if (!empty($data['execute_discounts']) && $data['execute_discounts']=='yes') {
				CakeLog::write('debug', 'Apply discount labels');
				$this->loadModel('Product');
				$this->Product->updateAll(
					array('Product.discount_label_show' => 'Product.discount_label'));
				$this->redirect(array( 'action' => 'productos' ));

			}else{

			if (empty($data['only_categories']) || $data['only_categories'] != 'yes'){
				CakeLog::write('debug', 'Apply discount to all');
				$this->update_products( $data['list_code'] , $data['list_code_desc']);
			}
			CakeLog::write('debug', 'More discounts?');
			if (!empty($data['more_list_code_desc'])){
				CakeLog::write('debug', 'More discounts? yes');
           		$this->loadModel('DiscountList');
   				$this->DiscountList->query('DELETE FROM discount_lists;');
           		for($i=0;$i<10;$i++){
           			if (!empty($data['more_list_code_desc'][$i]) && !empty($data['rubro'][$i])){
						CakeLog::write('debug', 'Rubro: '.$data['rubro'][$i].' / list: '.$data['more_list_code_desc'][$i]);
           				$this->DiscountList->create();
           				$dl = array(
           				'category_id' => $data['rubro'][$i],
           				'list_code' => $data['more_list_code_desc'][$i],
           				'item_index'=>$i,
           				'updated_at'=>date('Y-m-d H:i:s',time())
           				);
           				$this->DiscountList->save($dl);
           				$condition = array('Product.category_id'=>$data['rubro'][$i]);
						$this->update_products( $data['list_code'] , $data['more_list_code_desc'][$i], $condition);
           			}
           		}
           	}
		}
		return $this->redirect(array( 'action' => 'productos' ));

		}
	}

	public function update_products( $list_code , $list_code_desc, $conditions=false )
	{
		$this->loadModel('Product');
		$this->SQL = $this->Components->load('SQL');
		$params = array( 'recursive' => -1);
		if (!empty($conditions)) {
			$params['conditions']=$conditions;
			CakeLog::write('debug', '[update_products] updating by params: ' . json_encode($params));
		}else{
			CakeLog::write('debug', '[update_products] all');
		}
		$products = $this->Product->find('all', $params);

		foreach ($products as &$product) {
			if( !empty( $product['Product']['article'] ) && !empty( $list_code ) ) {
				CakeLog::write('debug', 'Looking price for product #'.$product['Product']['id'].' / article: '.$product['Product']['article'].' / list: '.$list_code.' / list_desc: '.$list_code_desc);
				$price = $this->SQL->product_price_by_list( $product['Product']['article'] , $list_code , $list_code_desc);
				CakeLog::write('debug', 'result: '.json_encode($price));
				if( !empty($price) ) {
					$this->Product->id = $product['Product']['id'];
					$precio = $price['precio']*100;
					$precio = ((int)$precio) / 100;

					$discount = $price['discount']*100;
					$discount = ((int)$discount) / 100;

					$this->Product->saveField('discount', $discount);
					$this->Product->saveField('price', $precio);
					CakeLog::write('debug', 'Update Product: '.$product['Product']['id'].' [price: '.$precio.' / discount: '.$discount.']');
					//Debugger::log( $price );
				}
			}
		}
		// by list
		return true;
	}

	public function productos($action = null) {
		$this->loadModel('Setting');
		$this->loadModel('Category');
		$this->SQL = $this->Components->load('SQL');

		$a = $this->Setting->findById('stock_min');
		$b = $this->Setting->findById('list_code');
		$c = $this->Setting->findById('show_shop');
		$d = $this->Setting->findById('image_bannershop');
		$e = $this->Setting->findById('image_menushop');
		$f = $this->Setting->findById('image_prodshop');
		$g = $this->Setting->findById('list_code_desc');

		$this->set('stock_min',@$a['Setting']['value']);
		$this->set('list_code',@$b['Setting']['value']);
		$this->set('show_shop',@$c['Setting']['value']);
    $this->set('image_bannershop',@$d['Setting']['value']);
    $this->set('image_menushop',@$e['Setting']['value']);
    $this->set('image_prodshop',@$f['Setting']['value']);
    $this->set('list_code_desc',@$g['Setting']['value']);

        //create table discount_lists (id int unsigned auto_increment primary key, item_index int unsigned, category_id int(10) unsigned not null, list_code varchar(30) not null,updated_at date);
    
		$navs = array(
			'Lista' => array(
				'icon' 		=> 'gi gi-shirt',
				'url'		=> Configure::read('mUrl').'/admin/productos',
				'active'	=> '/admin/productos'
				),
			'Nuevo Producto' => array(
				'icon' 		=> 'gi gi-circle_plus',
				'url'		=> Configure::read('mUrl').'/admin/productos/add',
				'active'	=> '/admin/productos/add'
				)

			);
		$this->set('navs', $navs);

		$h1 = array(
			'name' => 'Productos',
			'icon' => 'gi gi-shirt'
			);
		$this->set('h1', $h1);

		$colors = $this->SQL->new_colors();
	    $this->set('colors',$colors);

	    $this->loadModel('Product');
	    $this->loadModel('ProductProperty');
    	switch ($action) {
	    	case 'add':
	    	    if ($this->request->is('POST')){
			        $this->autoRender = false;

			        $data = $this->request->data;

			        $file_real_name = null;
			        if(!empty($this->request->params['form']['image']['name'])){
			            $file_real_name = $this->save_file($this->request->params['form']['image'], true, 2000);
			        }

			        if($file_real_name){
			            $data['img_url'] = $file_real_name;
			        }
							$data['with_thumb']=1;
			        $this->Product->save($data);


			        if(!empty($data['props'])) {
				        foreach ($data['props'] as &$prop) {
				        	$prop['product_id'] = $this->Product->id;
				        }
			        	$this->ProductProperty->saveMany($data['props']);
			        }

			        return $this->redirect(array('action'=>'productos'));
    			} else {
    				$this->loadModel('Category');
				    $cats = $this->Category->find('all',['order' => ['Category.ordernum ASC']]);
					$this->set('cats', $cats);
					$this->set('sel', true);

					$this->loadModel('Season');
					$temps = $this->Season->find('all');
					$this->set('temps', $temps);
	    			return $this->render('productos-detail');
	    		}
	    		break;
	    	case 'delete':
		    	if ($this->request->is('post')) {
		    		$this->autoRender = false;

					$this->ProductProperty->deleteall(array('ProductProperty.product_id' => $this->request->data['id']));
		    		$this->Product->delete($this->request->data['id']);
		    	}
	    		break;
	    	case 'edit':
	    		if ($this->request->is('post')) {
	    			$this->autoRender = false;

	    			$data = $this->request->data;

			        $file_real_name = null;
			        if(!empty($this->request->params['form']['image']['name'])){
			            $file_real_name = $this->save_file($this->request->params['form']['image'], true, 2000);
			        }
							$data['with_thumb']=1;
			        if($file_real_name){
			            $data['img_url'] = $file_real_name;
			        }

			        $this->Product->save($data);
			        /*if(!empty($this->request->data['id'])){
			        	$this->ProductProperty->deleteAll(array( 'ProductProperty.product_id' => $this->request->data['id'] ));
			        }*/
			        if(!empty($data['props'])){
			        	$this->ProductProperty->saveMany($data['props']);
			        }
	    		} else {
		    		$hasId = array_key_exists(1, $this->request->pass);
		    		if (!$hasId) break;
		    		$prod = $this->Product->find('first', array('conditions' => array('id' => $this->request->pass[1])));
		    		$this->set('prod', $prod);

    				$this->loadModel('Category');
				    $cats = $this->Category->find('all',['order' => ['Category.ordernum ASC']]);
					$this->set('cats', $cats);
					$this->set('sel', true);

					$props = $this->ProductProperty->find('all', array('conditions' => array(
						'product_id' => $this->request->pass[1]
					)));
					$this->set('props', $props);

					$this->loadModel('Season');
					$temps = $this->Season->find('all');
					$this->set('temps', $temps);
		    		return $this->render('productos-detail');
	    		}
	    		break;
	    }

	    $prods = $this->Product->find('all',array('order'=>array( 'Product.category_id ASC','Product.ordernum ASC' )));
	    $cats = $this->Category->find('all',['order' => ['Category.ordernum ASC']]);
	    $more_list_code_desc=[0,0,0,0,0,0,0,0,0,0];
	    $more_list_category=[0,0,0,0,0,0,0,0,0,0];
	    $this->loadModel('DiscountList');
	    $discount_lists = $this->DiscountList->find('all',array('order'=>array( 'DiscountList.item_index ASC' )));
	    foreach ($discount_lists as $dl){
	    	$more_list_category[(int)$dl['DiscountList']['item_index']] = $dl['DiscountList']['category_id'];
	    	$more_list_code_desc[(int)$dl['DiscountList']['item_index']] = $dl['DiscountList']['list_code'];
	    }
		$this->set('more_list_code_desc', $more_list_code_desc);
		$this->set('more_list_category', $more_list_category);
		$this->set('cats', $cats);
		$this->set('prods', $prods);
	    $this->render('productos');
	}

	public function sucursales($action = null) {
		$navs = array(
			'Lista' => array(
				'icon' 		=> 'fa fa-map-marker',
				'url'		=> Configure::read('mUrl').'/admin/sucursales',
				'active'	=> '/admin/sucursales'
				),
			'Nueva Sucursal' => array(
				'icon' 		=> 'gi gi-circle_plus',
				'url'		=> Configure::read('mUrl').'/admin/sucursales/add',
				'active'	=> '/admin/sucursales/add'
				)

			);
		$this->set('navs', $navs);

		$h1 = array(
			'name' => 'Sucursales',
			'icon' => 'fa fa-map-marker'
			);
		$this->set('h1', $h1);

    $this->loadModel('Store');
  	switch ($action) {
    	case 'add':
    	    if ($this->request->is('POST')){
		        $this->autoRender = false;
		        $this->Store->save($this->request->data);
		        return $this->redirect(array('action'=>'sucursales'));
  			} else {
  				$this->loadModel('Store');
			    $cats = $this->Store->find('all');
				$this->set('cats', $cats);
				$this->set('sel', true);
    			return $this->render('sucursales-detail');
    		}
    		break;
    	case 'delete':
	    	if ($this->request->is('post')) {
	    		$this->autoRender = false;

	    		$this->Store->delete($this->request->data['id']);
	    	}
    		break;
    	case 'edit':
    		if ($this->request->is('post')) {
    			$this->autoRender = false;
    			$data = $this->request->data;
		        $this->Store->save($data);
    		} else {
	    		$hasId = array_key_exists(1, $this->request->pass);
	    		if (!$hasId) break;
	    		$store = $this->Store->find('first', array('conditions' => array('id' => $this->request->pass[1])));
	    		$this->set('store', $store);
	    		return $this->render('sucursales-detail');
    		}
    		break;
    }
    $stores = $this->Store->find('all');
    $this->set('stores', $stores);
		return $this->render('sucursales');
	}

	public function coupon_add() {
		$this->autoRender = false;
    if ($this->request->is('POST')) {
    	$this->loadModel('CouponItem');
    	$data = $this->request->data;
    	$ids = $this->CouponItem->find('all', [
    		'conditions' => [
    			'coupon_id' => $data['coupon'],
    			$data['type'] . '_id' => $data['id'],
    		], 
    		'fields' => ['id']
    	]);
			$ids = array_map(function($e) {
				return $e['CouponItem']['id'];
			},$ids);    	
    	$this->CouponItem->delete($ids);
      $result = $this->CouponItem->save([
      	$data['type'] . '_id' => $data['id'],
      	'coupon_id' => $data['coupon'],
      ]);
      return json_encode(['success' => true, 'data' => $result['CouponItem']]);
    }
	}

	public function coupon_remove() {
		$this->autoRender = false;
    if ($this->request->is('POST')) {
    	$this->loadModel('CouponItem');
    	$data = $this->request->data;
    	$ids = $this->CouponItem->find('all', [
    		'conditions' => [
    			'coupon_id' => $data['coupon'],
    			$data['type'] . '_id' => $data['id'],
    		], 
    		'fields' => ['id']
    	]);
			$ids = array_map(function($e) {
				return $e['CouponItem']['id'];
			},$ids);    	
    	$this->CouponItem->delete($ids);
      return json_encode(['success' => true]);
    }
	}


	public function cupones($action = null) {
		$weekdays = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

		$navs = array(
			'Lista' => array(
				'icon' 		=> 'gi gi-tags',
				'url'		=> Configure::read('mUrl').'/admin/cupones',
				'active'	=> '/admin/cupones'
				),
			'Nuevo Cupón' => array(
				'icon' 		=> 'gi gi-circle_plus',
				'url'		=> Configure::read('mUrl').'/admin/cupones/add',
				'active'	=> '/admin/cupones/add'
				)

			);

    $this->loadModel('Coupon');
    $this->loadModel('CouponItem');
    $this->loadModel('Product');
    $this->loadModel('Category');

  	switch ($action) {
    	case 'add':
  	    if ($this->request->is('POST')){
	        $this->autoRender = false;
	        $this->request->data['coupon_payment'] = implode(",",$this->request->data['coupon_payment']);
	        $this->request->data['min_amount'] = $this->request->data['min_amount']?: 0;
	        $this->Coupon->save($this->request->data);
	        return $this->redirect(array('action'=>'cupones'));
  			} else {
  				$this->loadModel('Coupon');
			    $cats = $this->Coupon->find('all');
					$this->set('cats', $cats);
					$this->set('sel', true);
					$h1 = array(
						'name' => 'Nuevo Cupón',
						'icon' => 'gi gi-tags'
						);
					$this->set('h1', $h1);	
					$this->set('weekdays', $weekdays);
    			return $this->render('cupones-detail');
    		}
    		break;
    	case 'delete':
	    	if ($this->request->is('post')) {
	    		$this->autoRender = false;

	    		$this->Coupon->delete($this->request->data['id']);
	    	}
    		break;
    	case 'edit':
    		if ($this->request->is('post')) {
    			$this->autoRender = false;
    			$data = $this->request->data;

    			if(isset($data['coupon_payment'])){
    				$data['coupon_payment'] = implode(',',array_filter($data['coupon_payment']));
    			}

		      $this->Coupon->save($data);
    		} else {
	    		$hasId = array_key_exists(1, $this->request->pass);
	    		if (!$hasId) break;
	    		$coupon = $this->Coupon->find('first', array('conditions' => array('id' => $this->request->pass[1])));

					$coupon_items = $this->CouponItem->find('all', array('conditions' => array('coupon_id', $coupon->id), 'fields' => array('product_id', 'category_id')));

	    		// categories
					$categories = $this->Category->find('all', array('fields' => array('id', 'name')));
					$coupon_categories = array_filter(array_map(function($e) {
						return $e['CouponItem']['category_id'];
					},$coupon_items));

					if(!empty($categories)) {
						foreach($categories as &$category) {
							$category['Category']['enabled'] = in_array($category['Category']['id'], $coupon_categories);
						}
					}

	    		// products
					$products = $this->Product->find('all', array('fields' => array('id', 'name')));
					$coupon_items = $this->CouponItem->find('all', array('conditions' => array('coupon_id', $coupon->id), 'fields' => array('product_id')));
					$coupon_products = array_filter(array_map(function($e) {
						return $e['CouponItem']['product_id'];
					},$coupon_items));
					if(!empty($products)) {
						foreach($products as &$product) {
							$product['Product']['enabled'] = in_array($product['Product']['id'], $coupon_products);
						}
					}

	    		$this->set('coupon', $coupon);
	    		$this->set('products', $products);
	    		$this->set('categories', $categories);
	    		$this->set('products_count', count($coupon_products));
	    		$this->set('categories_count', count($coupon_categories));
	    		$this->set('weekdays', $weekdays);

					$h1 = array(
						'name' => $coupon['Coupon']['code'],
						'icon' => 'gi gi-tags'
					);
					$this->set('h1', $h1);	    		
	    		return $this->render('cupones-detail');
    		}
    		break;
    }
    $coupons = $this->Coupon->find('all');
    $this->loadModel('CouponItem');
  	$coupon_items = $this->CouponItem->query('SELECT ci.coupon_id,ci.category_id,ci.product_id,p.name product,c.name category 
  		FROM coupon_items ci 
  		LEFT JOIN categories c ON c.id = ci.category_id
  		LEFT JOIN products p ON p.id = ci.product_id');

    foreach($coupons as &$coupon){
    	$filtered = array_values(array_map(function($e) use ($coupon){
    		return $coupon['Coupon']['id'] == $e['ci']['coupon_id'] ? [
    			"product_id" => $e['ci']["product_id"], 
    			"category_id" => $e['ci']["category_id"], 
    			"category" => $e["c"]["category"], 
    			"product" => $e["p"]["product"]
    		] : false;
    	}, $coupon_items));
    	$cats = [];
    	$prods = [];
    	foreach($filtered as $item){
    		if($item['category_id']){
					$cats[]= [
						"id" => $item['category_id'],
						"name" => $item['category']
					];
				}
				if($item['product_id']){
					$prods[]= [
						"id" => $item['product_id'],
						"name" => $item['product']
					];
				}
			}
			$coupon['cats'] = $cats;
			$coupon['prods'] = $prods;
    }

    $this->set('coupons', $coupons);

		$h1 = array(
			'name' => 'Cupones',
			'icon' => 'gi gi-tags'
			);
		$this->set('h1', $h1);	 
		$this->set('navs', $navs);
   
		return $this->render('cupones');
	}

	public function admin_menu($action = null) {
		$navs = array(
			'Lista' => array(
				'icon' 		=> 'gi gi-list',
				'url'		=> Configure::read('mUrl').'/admin/admin_menu',
				'active'	=> '/admin/admin_menu'
			),
			'Nuevo Menú de Administrador' => array(
				'icon' 		=> 'gi gi-circle_plus',
				'url'		=> Configure::read('mUrl').'/admin/admin_menu/add',
				'active'	=> '/admin/admin_menu/add'
			)
		);

		$this->set('navs', $navs);
		$h1 = array(
			'name' => 'Menu',
			'icon' => 'gi gi-list'
		);
		$this->set('h1', $h1);
    $this->loadModel('AdminMenu');
    switch ($action) {
    	case 'add':
    	    if ($this->request->is('POST')){
		        $this->autoRender = false;

		        $data = $this->request->data;
		        $this->AdminMenu->save($data);

		        return $this->redirect(array('action'=>'admin_menu'));
  			} else {
    			return $this->render('admin-menu-detail');
    		}
    		break;
    	case 'delete':
	    	if ($this->request->is('post')) {
	    		$this->autoRender = false;
	    		$this->AdminMenu->delete($this->request->data['id']);
	    	}
    		break;
    	case 'edit':
    		if ($this->request->is('post')) {
    			$this->autoRender = false;

    			$data = $this->request->data;
	        $this->AdminMenu->save($data);
    		} else {
	    		$hasId = array_key_exists(1, $this->request->pass);
	    		if (!$hasId) break;
	    		$item = $this->AdminMenu->find('first', [
	    			'conditions' => [
	    				'id' => $this->request->pass[1]
	    			],
	    			'order' => ['AdminMenu.ordernum ASC']
	    		]);
	    		$this->set('item', $item);
	    		return $this->render('admin-menu-detail');
    		}
    		break;
    }
	  $menu = $this->AdminMenu->find('all',['order' => ['AdminMenu.ordernum ASC']]);
		$this->set('adminMenu', $menu);
	  $this->render('admin-menu');
	}

	public function banners($action = null) {
		$navs = array(
			'Lista' => array(
				'icon' 		=> 'fa fa-shirtsinbulk',
				'url'		=> Configure::read('mUrl').'/admin/banners',
				'active'	=> '/admin/banners'
			),
			'Nuevo Banner' => array(
				'icon' 		=> 'gi gi-circle_plus',
				'url'		=> Configure::read('mUrl').'/admin/banners/add',
				'active'	=> '/admin/banners/add'
			)
		);

		$this->set('navs', $navs);
		$h1 = array(
			'name' => 'Banners',
			'icon' => 'fa fa-shirtsinbulk'
		);
		$this->set('h1', $h1);
    $this->loadModel('Banner');
    switch ($action) {
    	case 'add':
    	    if ($this->request->is('POST')){
		        $this->autoRender = false;
		        $data = $this->request->data;
		        $file_real_name = null;
		        if(!empty($this->request->params['form']['image']['name'])){
		            $file_real_name = $this->save_file($this->request->params['form']['image']);
		        }

		        if($file_real_name){
		            $data['img_url'] = $file_real_name;
		        }

		        $this->Banner->save($data);

		        return $this->redirect(array('action'=>'banners'));
  			} else {
    			return $this->render('banners-detail');
    		}
    		break;
    	case 'delete':
	    	if ($this->request->is('post')) {
	    		$this->autoRender = false;
	    		$this->Banner->delete($this->request->data['id']);
	    	}
    		break;
    	case 'edit':
    		if ($this->request->is('post')) {
    			$this->autoRender = false;

    			$data = $this->request->data;

	        $file_real_name = null;
	        if(!empty($this->request->params['form']['image']['name'])){
							error_log('trying to edit save file');
	            $file_real_name = $this->save_file($this->request->params['form']['image']);
	        }

	        if($file_real_name){
	            $data['img_url'] = $file_real_name;
	        }

	        $data['target_blank'] = @$data['target_blank'] ?: '';
	        $this->Banner->save($data);
    		} else {
	    		$hasId = array_key_exists(1, $this->request->pass);
	    		if (!$hasId) break;
	    		$item = $this->Banner->find('first', array('conditions' => array('id' => $this->request->pass[1])));
	    		$this->set('item', $item);
	    		return $this->render('banners-detail');
    		}
    		break;
    }
	  $banners = $this->Banner->find('all',['order' => ['Banner.ordernum ASC']]);
		$this->set('banners', $banners);
	  $this->render('banners');
	}

	public function legends($action = null) {
		$navs = array(
			'Lista' => array(
				'icon' 		=> 'fa fa-credit-card',
				'url'		=> Configure::read('mUrl').'/admin/legends',
				'active'	=> '/admin/legends'
			),
			'Nueva Financiación' => array(
				'icon' 		=> 'gi gi-circle_plus',
				'url'		=> Configure::read('mUrl').'/admin/legends/add',
				'active'	=> '/admin/legends/add'
			)
		);

		$this->set('navs', $navs);
		$h1 = array(
			'name' => 'Financiación',
			'icon' => 'fa fa-credit-card'
		);
		$this->set('h1', $h1);
    $this->loadModel('Legend');
    switch ($action) {
    	case 'add':
    	    if ($this->request->is('POST')){
		        $this->autoRender = false;
		        $data = $this->request->data;
		        $this->Legend->save($data);
		        return $this->redirect(array('action'=>'legends'));
  			} else {
    			return $this->render('legends-detail');
    		}
    		break;
    	case 'delete':
	    	if ($this->request->is('post')) {
	    		$this->autoRender = false;
	    		$this->Legend->delete($this->request->data['id']);
	    	}
    		break;
    	case 'edit':
    		if ($this->request->is('post')) {
    			$this->autoRender = false;
    			$data = $this->request->data;
	        $this->Legend->save($data);
    		} else {
	    		$hasId = array_key_exists(1, $this->request->pass);
	    		if (!$hasId) break;
	    		$item = $this->Legend->find('first', array('conditions' => array('id' => $this->request->pass[1])));
	    		$this->set('item', $item);
	    		return $this->render('legends-detail');
    		}
    		break;
    }
	  $legends = $this->Legend->find('all',['order' => ['Legend.ordernum ASC']]);
		$this->set('legends', $legends);
	  $this->render('legends');
	}	

	public function menu($action = null) {
		$navs = array(
			'Lista' => array(
				'icon' 		=> 'fa fa-ellipsis-v',
				'url'		=> Configure::read('mUrl').'/admin/menu',
				'active'	=> '/admin/menu'
			),
			'Nuevo Menú' => array(
				'icon' 		=> 'gi gi-circle_plus',
				'url'		=> Configure::read('mUrl').'/admin/menu/add',
				'active'	=> '/admin/menu/add'
			)
		);

		$this->set('navs', $navs);
		$h1 = array(
			'name' => 'Menu',
			'icon' => 'fa fa-ellipsis-v'
		);
		$this->set('h1', $h1);
    $this->loadModel('Menu');
    $this->loadModel('Category');
    $cats = $this->Category->find('all',['order' => ['Category.ordernum ASC']]);
		$this->set('cats', $cats);

    switch ($action) {
    	case 'add':
    	    if ($this->request->is('POST')){
		        $this->autoRender = false;
		        $data = $this->request->data;
		        $file_real_name = null;
		        if(!empty($this->request->params['form']['image']['name'])){
		          $file_real_name = $this->save_file($this->request->params['form']['image']);
		        }

		        if($file_real_name){
		          $data['img_url'] = $file_real_name;
		        }

		        $this->Menu->save($data);

		        return $this->redirect(array('action'=>'menu'));
  			} else {
    			return $this->render('menu-detail');
    		}
    		break;
    	case 'delete':
	    	if ($this->request->is('post')) {
	    		$this->autoRender = false;
	    		$this->Menu->delete($this->request->data['id']);
	    	}
    		break;
    	case 'edit':
    		if ($this->request->is('post')) {
    			$this->autoRender = false;

    			$data = $this->request->data;

	        $file_real_name = null;
	        if(!empty($this->request->params['form']['image']['name'])){
							error_log('trying to edit save file');
	            $file_real_name = $this->save_file($this->request->params['form']['image']);
	        }

	        if($file_real_name){
	          $data['img_url'] = $file_real_name;
	        }

	        $data['target_blank'] = @$data['target_blank'] ?: '';
	        $this->Menu->save($data);
    		} else {
	    		$hasId = array_key_exists(1, $this->request->pass);
	    		if (!$hasId) break;
	    		$item = $this->Menu->find('first', array('conditions' => array('id' => $this->request->pass[1])));

				  
	    		$this->set('item', $item);
	    		return $this->render('menu-detail');
    		}
    		break;
    }
	  $menu = $this->Menu->find('all',['order' => ['Menu.ordernum ASC']]);

		foreach($menu as $i => $item) {
			$name = '';
			foreach($cats as $cat) {
				if ($cat['Category']['id'] === $item['Menu']['category_id']) {
					$name = $cat['Category']['name'];
				}
			}
			if (strlen($name)) {
				$menu[$i]['Menu']['category_name'] = $name;
			}
	  }
	  /*foreach($menu as $item) {
			$item['category_name'] = array_search(function($e){ $e['Category']['id'] === $item['Menu']['category'] }, $cats)['Category']['name'];
	  }*/
		$this->set('menu', $menu);
	  $this->render('menu');
	}	

	public function searches($action = null) {
		$navs = array(
			'Lista' => array(
				'icon' 		=> 'gi gi-search',
				'url'		=> Configure::read('mUrl').'/admin/search',
				'active'	=> '/admin/search'
			),
			/*'Nuevo Banner' => array(
				'icon' 		=> 'gi gi-circle_plus',
				'url'		=> Configure::read('mUrl').'/admin/search/add',
				'active'	=> '/admin/search/add'
			)*/
		);

		$this->set('navs', $navs);
		$h1 = array(
			'name' => 'Búsquedas',
			'icon' => 'gi gi-search'
		);
		$this->set('h1', $h1);
    $this->loadModel('Search');
	  $searches = $this->Search->find('all',array(
	    'joins' => array(
        array(
          'table' => 'users',
          'alias' => 'UserJoin',
          'type' => 'LEFT',
          'conditions' => array(
              'UserJoin.id = Search.user_id'
          )
        )
	    ),
	    'fields' => array('UserJoin.name, UserJoin.surname, UserJoin.birthday', 'Search.*'),
	  	'order' => array('Search.id DESC'),
    ));
		$this->set('searches', $searches);
	  $this->render('searches');
	}

	public function batch_productos($action = null) {
	  $this->autoRender = false;
		$this->loadModel('Product');

		$data = $this->request->data;

		if(isset($data['id'])){
			$ids = explode(',',$data['id']);
			foreach($ids as $id){
				if($action == 'remove') {
					$this->Product->delete($id);	
				}

				if($action == 'disable') {
					$this->Product->save([
						'id' => $id,
						'visible' => 0
					]);	
				}

				if($action == 'enable') {
					$this->Product->save([
						'id' => $id,
						'visible' => 1
					]);	
				}
			}

			$text = '';
			$count = count($ids);
			if($action == 'remove') {
				$text = $count > 1 ? 'eliminaron' : 'eliminó';
			}
			if($action == 'disable') {
				$text = $count > 1 ? 'desactivaron' : 'desactivó';
			}
			if($action == 'enable') {
				$text = $count > 1 ? 'activaron' : 'activó';
			}
			$s = $count > 1 ? 's': '';

			return json_encode([
				'status' => 'success', 
				'message' => "Se {$text} {$count} producto{$s}",
				'id' => $data['id'],
			]);			
		}
		
		return json_encode([
			'status' => 'error', 
			'message' => 'No hay suficientes parámetros'
		]);
	}


	public function batch_categorias($action = null) {
	  $this->autoRender = false;
		$this->loadModel('Category');

		$data = $this->request->data;

		if(isset($data['id'])){
			$ids = explode(',',$data['id']);
			foreach($ids as $id){
				if($action == 'remove') {
					$this->Category->delete($id);	
				}

				if($action == 'disable') {
					$this->Category->save([
						'id' => $id,
						'visible' => 0
					]);	
				}

				if($action == 'enable') {
					$this->Category->save([
						'id' => $id,
						'visible' => 1
					]);	
				}
			}

			$text = '';
			$count = count($ids);
			if($action == 'remove') {
				$text = $count > 1 ? 'eliminaron' : 'eliminó';
			}
			if($action == 'disable') {
				$text = $count > 1 ? 'desactivaron' : 'desactivó';
			}
			if($action == 'enable') {
				$text = $count > 1 ? 'activaron' : 'activó';
			}
			$s = $count > 1 ? 's': '';

			return json_encode([
				'status' => 'success', 
				'message' => "Se {$text} {$count} categoría{$s}",
				'id' => $data['id'],
			]);			
		}
		
		return json_encode([
			'status' => 'error', 
			'message' => 'No hay suficientes parámetros'
		]);
	}	

	public function logistica($action = null) {
		$navs = array(
			'Lista' => array(
				'icon' 		=> 'gi gi-cargo',
				'url'		=> Configure::read('mUrl').'/admin/logistica',
				'active'	=> '/admin/logistica'
				),
			'Nueva Logística' => array(
				'icon' 		=> 'gi gi-circle_plus',
				'url'		=> Configure::read('mUrl').'/admin/logistica/add',
				'active'	=> '/admin/logistica/add'
				)
			);
		$this->set('navs', $navs);
    $this->loadModel('Logistic');
    $this->loadModel('LogisticsPrices');
    $this->loadModel('Setting');
  	switch ($action) {
    	case 'add':
  	    if ($this->request->is('POST')){
	        $this->autoRender = false;
	        $data = $this->request->data;
	        if (isset($_FILES['image']) && $_FILES['image']['size']) {
	        	$data['image'] = $this->saveFile('image');
	        }
	        $result = $this->Logistic->save($data);
					$url = array(
				    'action' => 'logistica',
				    'edit',
				    $result['Logistic']['id'],
				    '#' => 'tarifas'
					);
					return $this->redirect($url);
	        // return $this->redirect(array('action'=>'logistica'));
  			} else {
			    $cats = $this->Logistic->find('all');
					$this->set('cats', $cats);
					$this->set('sel', true);
					$h1 = [
						'name' => 'Nueva logística',
						'icon' => 'gi gi-truck'
					];
					$this->set('h1', $h1);  					
    			return $this->render('logistica-detail');
    		}
    		break;
    	case 'delete':
	    	if ($this->request->is('post')) {
	    		$this->autoRender = false;
	    		$this->Logistic->delete($this->request->data['id']);
		    	$this->LogisticsPrices->deleteall([
		    		'logistic_id' => $this->request->data['id']
		    	]);
	    	}
    		break;
    	case 'edit':
    		if ($this->request->is('post')) {
    			$this->autoRender = false;
    			$data = $this->request->data;
    			if (isset($_FILES['image']) && $_FILES['image']['size']) {
    				$data['image'] = $this->saveFile('image');
    			}
		      $this->Logistic->save($data);
          if(!empty($this->request->data['config'])) {
            foreach($this->request->data['config'] as $id => $value) {
              $this->Setting->save([
                'id' => $id,
                'value' => $value
              ]);
            }
          }		      
    		} else {
    			$this->loadModel('LogisticsPrices');
	    		$hasId = array_key_exists(1, $this->request->pass);
	    		if (!$hasId) break;
	    		$logistic = $this->Logistic->find('first', array('conditions' => array('id' => $this->request->pass[1])));
    			$prices = $this->LogisticsPrices->find('all', ['conditions' => ['logistic_id' => $this->request->pass[1]]]);
					$h1 = [
						'name' => $logistic['Logistic']['title'],
						'icon' => 'gi gi-truck'
					];
					$this->set('h1', $h1);    			
	    		$this->set('logistic', $logistic);
	    		$this->set('logistic_prices', $prices);
          $code = $logistic['Logistic']['code'];
          $config = $this->Setting->find('all', [
            'conditions' => [
              'id LIKE' => "{$code}%"
            ]
          ]);

          $this->set('config', $config);	    		
	    		return $this->render('logistica-detail');
    		}
    		break;
    }
    $logistics = $this->Logistic->find('all');
		$h1 = [
			'name' => 'Logística',
			'icon' => 'gi gi-truck'
		];
		$this->set('h1', $h1);      
    $this->set('logistics', $logistics);

		return $this->render('logistica');
	}

	public function save_logistic_price() {
		$this->autoRender = false;
    if ($this->request->is('POST')) {
    	$this->loadModel('LogisticsPrices');
    	$data = $this->request->data;
      $result = $this->LogisticsPrices->save($data);
      return json_encode(['status' => 'success', 'data' => $result['LogisticsPrices']]);
    }
	}

	public function remove_logistic_price() {
		$this->autoRender = false;
		$this->loadModel('LogisticsPrices');
		$this->LogisticsPrices->delete($this->request->data['id']);
		return json_encode(['status' => 'success']);
	}

	public function shipping($action = null) {
		$navs = array();
		$this->set('navs', $navs);

		$h1 = array(
			'name' => 'Envíos',
			'icon' => 'gi gi-car'
			);
		$this->set('h1', $h1);

	  $this->loadModel('Setting');
		if ($this->request->is('post')) {
			$this->autoRender = false;
			$data = $this->request->data;
			$data['extra'] = $data['zip_code'];
			$this->Setting->save($data);

			/* shipping min price */
			$data['id'] = 'shipping_price_min';
			$data['value'] = $data['shipping_price_min'];
			$data['extra'] = null;
			$this->Setting->save($data);
		} 
		
		$setting = $this->Setting->find('first', array('conditions' => array('id' => 'shipping_type')));
		$price = $this->Setting->find('first', array('conditions' => array('id' => 'shipping_price_min')));
		$amount = 0;

		if (!empty($setting) && !empty($setting['Setting']['extra'])) {
			$zp = explode(',', trim($setting['Setting']['extra']));
			$amount = count($zp);
		}

		$this->set('price', $price);
		$this->set('setting', $setting);
		$this->set('amount', $amount);
		return $this->render('settings-shipping');
	}

	public function contacto($action = null) {
		$navs = array(
			'Lista' => array(
				'icon' 		=> 'gi gi-envelope',
				'url'		=> Configure::read('mUrl').'/admin/contacto',
				'active'	=> '/admin/contacto'
			)
		);
		$this->set('navs', $navs);

		$h1 = array(
			'name' => 'Contacto',
			'icon' => 'gi gi-envelope'
			);
		$this->set('h1', $h1);

		$this->loadModel('Contact');
    	if ($action == 'delete' && $this->request->is('post')) {
    		$this->autoRender = false;
    		$this->Contact->delete($this->request->data['id']);
    	}

	    $contacts = $this->Contact->find('all',array('order'=>array( 'Contact.id DESC' )));
	    $this->set('contacts', $contacts);
		return $this->render('contacto');
	}

	public function usuarios($action = null) {
		$navs = array(
			'Lista' => array(
				'icon' 		=> 'gi gi-user',
				'url'		=> Configure::read('mUrl').'/admin/usuarios',
				'active'	=> '/admin/usuarios'
				),
			'Nuevo Usuario' => array(
				'icon' 		=> 'gi gi-circle_plus',
				'url'		=> Configure::read('mUrl').'/admin/usuarios/add',
				'active'	=> '/admin/usuarios/add'
				)

			);
		$this->set('navs', $navs);

		$h1 = array(
			'name' => 'Usuarios',
			'icon' => 'gi gi-user'
			);
		$this->set('h1', $h1);

	    $this->loadModel('User');
	   	switch ($action) {
	    	case 'add':
	    	    if ($this->request->is('POST')){
			        $this->autoRender = false;
			        $this->User->save($this->request->data);
			        return $this->redirect(array('action'=>'usuarios'));
    			} else {
	    			return $this->render('usuarios-detail');
	    		}
	    		break;
	    	case 'delete':
		    	if ($this->request->is('post')) {
		    		$this->autoRender = false;
		    		$this->User->delete($this->request->data['id']);
		    	}
	    		break;
	    	case 'edit':
	    		if ($this->request->is('post')) {
	    			$this->autoRender = false;
			        $this->User->save($this->request->data);
	    		} else {
		    		$hasId = array_key_exists(1, $this->request->pass);
		    		if (!$hasId) break;
		    		$usuario = $this->User->find('first', array('conditions' => array('id' => $this->request->pass[1])));
		    		$this->set('usuario', $usuario);
		    		return $this->render('usuarios-detail');
	    		}
	    		break;
	    }
	    $users = $this->User->find('all');
	    $this->set('users', $users);
		return $this->render('usuarios');
	}

	public function refresh_colors() {
		$this->RequestHandler->respondAs('application/json');
		$this->SQL = $this->Components->load('SQL');
		$this->autoRender = false;
		$this->loadModel('Color');
		$colors = $this->SQL->colors();
		$this->Color->deleteAll(array('1 = 1'), false);
		$this->Color->saveMany($colors);
		return json_encode($colors);
	}

	public function refresh_seasons() {
		$this->RequestHandler->respondAs('application/json');
		$this->autoRender = false;
		$this->SQL = $this->Components->load('SQL');
		$this->loadModel('Season');
		$seasons = $this->SQL->seasons();
		$this->Season->deleteAll(array('1 = 1'), false);
		$this->Season->saveMany($seasons);
		return json_encode($seasons);
	}

	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect(array('controller' => 'admin', 'action' => 'index'));
			} else {
				return $this->redirect(array('controller' => 'admin', 'action' => 'login'));
			}
		}
	}

	public function logout() {
		$this->redirect($this->Auth->logout());
	}

	public function lookbook($action = null) {
		$navs = array(
			'Lista' => array(
				'icon' 		=> 'gi gi-justify',
				'url'		=> Configure::read('mUrl').'/admin/lookbook',
				'active'	=> '/admin/lookbook'
			),
			'Nuevo Look Book' => array(
				'icon' 		=> 'gi gi-circle_plus',
				'url'		=> Configure::read('mUrl').'/admin/lookbook/add',
				'active'	=> '/admin/lookbook/add'
			)
		);

		$this->set('navs', $navs);

		$h1 = array(
			'name' => 'Look Book',
			'icon' => 'gi gi-display'
		);

		$this->set('h1', $h1);
    $this->loadModel('Product');
    $prods = $this->Product->find('all');
		$this->set('prods', $prods);
    $this->render('productos');
    $this->loadModel('LookBooks');
    $lookb = $this->LookBooks->find('all');
		$this->set('lookb', $lookb);
    $this->render('lookbook');

  	switch ($action) {
    	case 'add':
  	    if ($this->request->is('POST')){
	        $this->autoRender = false;
	        $data = $this->request->data;

	        if(!empty($data['props']) && !empty($data['img_url'])) {
		        foreach ($data['props'] as &$prop) {
              $product_detail = $this->Product->find('first', array('conditions'=>array('id'=>$prop['id'])));
		        	$toSave[] = array(
      	   	    'img_url' => $data['img_url'],
			          'product_id' => $prop['id'],
                'article' => $product_detail['Product']['article'],
                'name'=>$product_detail['Product']['name'],
            	);
   	        }
            $this->LookBooks->saveAll($toSave);
	        }

	        return $this->redirect(array('action'=>'lookbook'));
  			} else {

    			return $this->render('lookbook-detail');
    		}

    	break;

    	case 'delete':

	    	if ($this->request->is('post')) {
	    		$this->autoRender = false;
	    		$this->LookBooks->delete($this->request->data['id']);
	    	}

    	break;
    }
	}

	public function carrito() {
		$h1 = array(
			'name' => 'Carrito',
			'icon' => 'gi gi-shopping_cart'
		);

		$this->set('h1', $h1);
		$this->set('navs', []);
		$this->loadModel('Setting');

		if ($this->request->is('post')) {
      foreach($this->request->data as $id => $value) {
      	$this->Setting->save(['id' => $id, 'value' => $value]);
      }
		}

		$data = [];
		$map = $this->Setting->findById('display_text_shipping_min_price');
		$data['display_text_shipping_min_price'] = $map['Setting']['value'];
		$map = $this->Setting->findById('text_shipping_min_price');
		$data['text_shipping_min_price'] = $map['Setting']['value'];
		$map = $this->Setting->findById('carrito_takeaway_text');
		$data['carrito_takeaway_text'] = $map['Setting']['extra'];

		$this->set('data', $data);
	}

	public function bank() {
		$h1 = array(
			'name' => 'CBU/Alias',
			'icon' => 'gi gi-bank'
		);

		$this->set('h1', $h1);
		$this->set('navs', []);
		$this->loadModel('Setting');

		if ($this->request->is('post')) {
      foreach($this->request->data as $id => $value) {
      	$this->Setting->save(['id' => $id, 'value' => $value]);
      }
		}

		$data = [];
		$map = $this->Setting->findById('bank_enable');
		$data['bank_enable'] = @$map['Setting']['value'];
		$map = $this->Setting->findById('bank_explain_title');
		$data['bank_explain_title'] = @$map['Setting']['value'];
		$map = $this->Setting->findById('bank_explain_text');
		$data['bank_explain_text'] = @$map['Setting']['value'];
		$map = $this->Setting->findById('bank_instructions_title');
		$data['bank_instructions_title'] = @$map['Setting']['value'];
		$map = $this->Setting->findById('bank_instructions_text');
		$data['bank_instructions_text'] = @$map['Setting']['value'];
		$map = $this->Setting->findById('bank_total_text');
		$data['bank_total_text'] = @$map['Setting']['value'];
		$map = $this->Setting->findById('bank_whatsapp');
		$data['bank_whatsapp'] = @$map['Setting']['value'];
		$map = $this->Setting->findById('bank_discount_enable');
		$data['bank_discount_enable'] = @$map['Setting']['value'];
		$map = $this->Setting->findById('bank_discount');
		$data['bank_discount'] = @$map['Setting']['value'];
		$map = $this->Setting->findById('bank_discount_text');
		$data['bank_discount_text'] = @$map['Setting']['value'];

		$this->set('data', $data);
	}	

  public function subscriptions($action = null) {
		$navs = array(
			'Lista' => array(
				'icon' 		=> 'gi gi-envelope',
				'url'		=> Configure::read('mUrl').'/admin/subscriptions',
				'active'	=> '/admin/newsletter'
			)
		);
		$this->set('navs', $navs);

		$h1 = array(
			'name' => 'Newsletter',
			'icon' => 'gi gi-envelope'
			);
		$this->set('h1', $h1);

		$this->loadModel('Subscription');
  	if ($action == 'delete' && $this->request->is('post')) {
  		$this->autoRender = false;
  		$this->Subscription->delete($this->request->data['id']);
  	}

  	$config = array(
    	'order'=> array( 'Subscription.id DESC' )
    );

    if (empty($_REQUEST['extended'])) {
    	$config['limit'] = 10;
    }

    $subscriptions = $this->Subscription->find('all',$config);

    $this->set('subscriptions', $subscriptions);
		return $this->render('subscriptions');
	}

	public function onlyUploadImageColor()
	{
		header("Content-Type: application/json");
		$this->autoRender = false;
		$response = null;
		if (!empty($this->request->data['file']['name'])) {
			$response = $this->save_file($this->request->data['file'], true);//true param para generar thumbnail
			$response = array('image'=>$response);
		} else {
			die('fail');
		}
		if (empty($response)) {
			$response = 'fail';
		}
		die(json_encode($response, true));
	}

	//TODO validar que no exista un registro con ese alias
	public function uploadImageColor()
	{
		header("Content-Type: application/json");
		$this->loadModel('ProductProperty');
		$this->autoRender = false;
		$response = null;
		if(!empty($this->request->data['file']['name']) && !empty($this->request->data['alias']) && !empty($this->request->data['id'])){
			$response = $this->save_file($this->request->data['file'], true);//true param para generar thumbnail
			if (isset($this->request->data['ppId'])) {
				$colorProduct = $this->ProductProperty->findById($this->request->data['ppId']);
			} else {
				$colorProduct = $this->ProductProperty->find('first', array('conditions'=>array('product_id'=>$this->request->data['id'], 'alias'=>$this->request->data['alias'])));
				if (!empty($colorProduct)) {
					header('http/1.0 400');
					die(json_encode(array('status'=>'fail', 'message'=>'elija otro alias para este color')));
				}
			}
			$saved = array();
			$updateFieldImages = array();
			if (empty($colorProduct)) {
				$updateFieldImages['images'] = $response;
				$updateFieldImages['alias'] = $this->request->data['alias'];
				$updateFieldImages['product_id'] = $this->request->data['id'];
				$updateFieldImages['type'] = 'color';
			} else {
				$updateFieldImages['id'] = $colorProduct['ProductProperty']['id'];
				$updateFieldImages['alias'] = $this->request->data['alias'];
				$updateFieldImages['images'] = (!empty($colorProduct['ProductProperty']['images']))?$colorProduct['ProductProperty']['images'].';'.$response:$response;
			}
			$saved = $this->ProductProperty->save($updateFieldImages, true);
			$response = array('image'=>$response, 'ppId'=>$saved['ProductProperty']['id'], 'allImages'=>$updateFieldImages['images']);
		} else {
			die('fail');
		}

		if(empty($response)){
			$response = 'fail';
		}
		die(json_encode($response, true));
	}

	public function deleteImageColor()
	{
		$this->loadModel('ProductProperty');
		$this->autoRender = false;
		$response = null;
		if(!empty($this->request->data['image']) && !empty($this->request->data['id'])){
			$productProperty = $this->ProductProperty->find('first', array('conditions'=>array('id'=>$this->request->data['id'])));
			if (!empty($productProperty)) {
				$imagesArr = explode(';', $productProperty['ProductProperty']['images']);
				$newImgs = '';
				foreach ($imagesArr as $key => $img) {
					if ($img!=$this->request->data['image']) {
						if (empty($newImgs)) {
							$newImgs = $img;
						} else {
							$newImgs = $newImgs . ';'.$img;
						}
					}
				}
				$updateFieldImages = array();
				$updateFieldImages['id'] = $productProperty['ProductProperty']['id'];
				$updateFieldImages['images'] = $newImgs;
				$response = $newImgs;
				$this->ProductProperty->save($updateFieldImages, true);
			}
		} else {
			die('fail');
		}
		if (empty($response)) {
			$response = 'fail';
		}
		die($response);
	}

	public function deleteProductProperty()
	{
		header("Content-Type: application/json");
		$this->loadModel('ProductProperty');
		$this->autoRender = false;
		$status = false;
		if ($this->request->is('post')) {
			$status = $this->ProductProperty->delete($this->data['id']);
		}
		echo json_encode(['status' => $status]);
		die();
	}

}