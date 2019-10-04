<?php
require_once(APP . 'Vendor' . DS . 'oca.php');
class CarritoController extends AppController
{
	public $uses = array('Product', 'Sale','Package','User','SaleProduct','Catalogo','Category','LookBook');
	public $components = array("RequestHandler");

	public function beforeFilter()
	{
    	parent::beforeFilter();
    	$this->loadModel('Setting');
    	$categories = $this->Category->find('all');
		$this->set('categories', $categories);
		$setting = $this->Setting->findById('catalog_flap');
		$catalog_flap = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_flap',$catalog_flap);
		unset($setting);
        $this->loadModel('Setting');
    	$setting = $this->Setting->findById('catalog_first_line');
		$catalog_first_line = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_first_line',$catalog_first_line);
		unset($setting);
		$lookbook = $this->LookBook->find('all');
		$this->set('lookBook', $lookbook);
	}

	public function index()
	{
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
		foreach ($items as $key => $item) {
			$data['count'] ++;
			$data['price'] += $item['price'];
		}
		$package = $this->Package->find('first',array('conditions' => array( 'Package.amount_min <=' => $data['count'] , 'Package.amount_max >=' => $data['count'] )));
		if(!empty($package)){
			$data['package']= $package['Package'];
			$data['weight'] = $package['Package']['weight']/1000;
			$data['volume'] = ($package['Package']['width']/100)*($package['Package']['height']/100)*($package['Package']['depth']/100);
			return $data;
		}
		return false;
	}

	private function checkCP($cp){
		$oca = new Oca();
		$centers = $oca->getCentrosImposicionPorCP( $cp );
		if( !empty($centers) ){
			return 1;
		}else{
			return 0;
		}
	}

	public function delivery_cost($cp = null){
		$this->RequestHandler->respondAs('application/json');
		$this->autoRender = false;

		//Codigo Postal
		$this->Session->write('cp',$cp);

		//Data
		$data = $this->getItemsData();
		if(!empty($data)){
			$oca = new Oca();
			//$PesoTotal, $VolumenTotal, $CodigoPostalOrigen, $CodigoPostalDestino, $CantidadPaquetes, $ValorDeclarado, $Cuit, $Operativa
			$response = $oca->tarifarEnvioCorporativo(
				$data['weight'] ,
				$data['volume'] ,
				1708 ,
				$cp ,
				1 ,
				intval($data['price']) ,
				'30-71119953-1',
				271263
				//96637
			);
		}else{
			$response = array();
		}

		//CP Check
		$valid = $this->checkCP($cp);

		//Price
		$price = (!empty($response[0]['Precio'])) ? (int)$response[0]['Precio'] : 0 ;

		return json_encode(array( 'price' => $price , 'valid' => $valid , 'itemsData' => $data ));
	}

	public function sale() {
		require_once(APP . 'Vendor' . DS . 'mercadopago.php');
		$total=0;
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

		if(!$this->request->is('post') || empty($user['postal_address']) || empty($user['street_n']) || empty($user['street']) || empty($user['localidad']) || empty($user['provincia']) || empty($user['name']) || empty($user['surname']) || empty($user['email']) || empty($user['telephone'])){
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
				'PROV'		=> $user['provincia'],
				'LOC'		=> $user['localidad'],
				'CALLE'		=> $user['street'],
				'NRO'		=> $user['street_n'],
				'PISO'		=> $user['floor'],
				'DPTO'		=> $user['depto'],
				'COD POST'	=> $user['postal_address'],
			);
			foreach ($values as $key => $value) {
				$desc.= $key.' : "'.$value.'"'.$separator;
			}
			$unit_price =$producto['price'];
			if(!empty($producto['discount']) && !empty((float)(@$producto['discount']))) {
                $unit_price = @$producto['discount'];
            }

			$items[] = array(
				'title' => $desc,
				'description' => $desc,
				'quantity' => 1,
				'currency_id' => 'ARS',
				'unit_price' => (int) $unit_price
			);
			$total+=(int)$unit_price;
			error_log('suming '.(int)$unit_price);
			$product_ids[] = array(
				'product_id' => $producto['id'],
				'color' => $producto['color'],
				'size' => $producto['size'],
				'precio_lista' => $producto['price'],
				'precio_vendido' => (!empty($producto['discount']))?$producto['discount']:$producto['price'],
				'sale_id' => $sale_id,
				'id' => null,
				'description' => $desc
			);
		}

		// Add Delivery
		$delivery_data = json_decode( $this->delivery_cost($user['postal_address']) ,true);
		$price = (int)$delivery_data['price'];

		if (intval($total)>=3200 || gmdate('Y-m-d',time())<'2019-11-01'){
      error_log('without delivery bc price is :'.$total.' and date = '.gmdate('Y-m-d'));
			$price=0;
		}else{
			error_log('suming delivery to price: '.$total);
			$total += $price;
			$items[] = array(
				'title' => 'PEDIDO: '.$sale_id.' - COSTO DE ENVIO',
				'description' => 'PEDIDO: '.$sale_id.' - COSTO DE ENVIO',
				'quantity' => 1,
				'currency_id' => 'ARS',
				'unit_price' => $price
			);
		}
		$this->Sale->save(array(
			'id' => $sale_id,
			'deliver_cost' => $price
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
			'calle'		=> $user['street'],
			'nro'		=> $user['street_n'],
			'piso'		=> $user['floor'],
			'depto'		=> $user['depto'],
			'cp'		=> $user['postal_address'],
			'localidad'	=> $user['localidad'],
			'provincia'	=> $user['provincia'],
			'telefono'	=> $user['telephone'],
			'email'		=> $user['email'],
			'package_id'=> $delivery_data['itemsData']['package']['id'],
			'value' 	=> $delivery_data['itemsData']['price'],
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
			$urlCheck=Configure::read('baseUrl')."shop/stock/".$product['Product']['article']."/".$this->request->data['size']."/".$this->request->data['color_code'];

			if (empty($this->request->data['size']) && empty($this->request->data['color_code'])){
				//$urlCheck=Configure::read('baseUrl')."shop/stock/".$product['Product']['article'];
				error_log('fake stock');
				$stock=1;
			}else{

				error_log($urlCheck);
				$ch = curl_init();
			    curl_setopt($ch, CURLOPT_URL, $urlCheck);
			    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
			    $stock = (string)curl_exec($ch);
			    curl_close($ch);
			}

			error_log('stock:'.$stock);
			//$stock=1;
			if ($product && $stock) {
				$product = $product['Product'];
				$product['color'] = @$this->request->data['color'];
				$product['size'] = @$this->request->data['size'];
				$product['alias'] = $this->request->data['alias'];


				$carro = $this->Session->read('Carro');
				$carro[] = $product;
				$this->Session->write('Carro', $carro);

			//	$this->Session->write('Carro.'. $product['id'], $product);
				return json_encode(array('success' => true));
			}
		}
		return json_encode(array('success' => false));
	}



	public function remove($row = null) {
		$this->autoRender = false;

		/*if (isset($product_id) && $this->Session->check('Carro.'. $product_id)) {
			$this->Session->delete('Carro.'. $product_id);
		}*/
		if (isset($row) && $this->Session->check('Carro.'. $row)) {
			$this->Session->delete('Carro.'. $row);
		}
		$carro = $this->Session->read('Carro');
		$aux = array();
		$i = 0;
		foreach ($carro as $key => $value) {
			$aux[$i] = $value;
			$i++;
		}
		$this->Session->write('Carro', $aux);
		return $this->redirect(array('controller' => 'carrito', 'action' => 'index'));
	}

	private function notify_user($data, $status){
		if ($status=='success'){
			$message = '<p>Hola <strong>'.ucfirst($data['user']['name']).'</strong>, gracias por tu compra!.<br/><br/>Tu n&uacute;mero de Pedido es: <strong>'.$data['sale_id'].'</strong>.</p><p>Tu compra ser&aacute; preparada para su env&iacute;o a la brevedad.</p><p>Los pedidos se realizan y despachan los d&iacute;as h&aacute;biles de 10 a 17hs.<br/></p><br/><a href="https://www.chatelet.com.ar">www.chatelet.com.ar</a>';

		}else{
			$message = '<p>Hola <strong>'.ucfirst($data['user']['name']).'</strong>, gracias por tu compra! Aguardamos recibir el pago para contactarte.<br/><br/>Tu n&uacute;mero de Pedido es: <strong>'.$data['sale_id'].'</strong>.</p><p>Tu compra ser&aacute; preparada para su env&iacute;o a la brevedad.</p><p>Los pedidos se realizan y despachan los d&iacute;as h&aacute;biles de 10 a 17hs.<br/></p><br/><a href="https://www.chatelet.com.ar">www.chatelet.com.ar</a>';

		}
		error_log('[email] notifying user '.$data['user']['email']);
		$this->sendMail($message,'Compra Realizada en Chatelet',$data['user']['email']);
	}

	public function test() {
		$this->sendMail('hello','Test via en Chatelet','francisco.marasco@gmail.com');
		die('ok');

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
