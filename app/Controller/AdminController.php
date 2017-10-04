<?php
App::uses('CakeTime', 'Utility');
require_once(APP . 'Vendor' . DS . 'oca.php');
class AdminController extends AppController {
	public $uses = array('AdminMenu','Promo','Package','SaleProduct','Sale');
	public $components = array('SQL', 'RequestHandler');
	
	public function beforeFilter() {
    	parent::beforeFilter();
    	$this->Auth->deny();
    	$this->Auth->allow('login','test','update_products');
    	// Template variables
		$template = array(
		    'name'          => 'Chatelet',
		    'version'       => '1.5',
		    'author'        => 'Infinixsoft <desarrollo@infinixsoft.com>',
		    'title'         => 'Admin panel - Chatelet',
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
            'active_page'   => $this->request->params['action'],
            'active_sub'   => $this->request->params['action']
		);

		$this->set('template', $template);
  
		// Primary navigation array (the primary navigation will be created automatically based on this array, up to 3 level deep)
		$menu = $this->AdminMenu->find('all');
		$this->set('primary_nav', $menu);


		$this->Auth->loginAction = array('controller' => 'admin', 'action' => 'login');
		$this->Auth->logoutRedirect = array('controller' => 'admin', 'action' => 'login');
		$this->Auth->unauthorizedRedirect = array('controller' => 'admin', 'action' => 'login');
		$this->layout = 'admin';
	}

	public function test(){
		$this->autoRender = false;

		//$details = $this->SQL->product_price_by_list('V7000','180','05');
		//$details = $this->SQL->product_details( 'V7000' ,'05' );
		//$details = $this->SQL->productsByLisCod('V7000','05');
		//$details =   $this->SQL->product_name_by_article('V7000');
	//EXAMPLE: I5005/03/02/173
		$details =   $this->SQL->product_stock('v7269','44','02','179');
		
		pr($details);
	}


	public function get_product($prod_cod = null, $lis_cod = null , $lis_cod2 = null) {
		$this->RequestHandler->respondAs('application/json');
		$this->autoRender = false;
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
		$list_code = Configure::read('list_code');
		$exists = $this->SQL->product_exists($article,$list_code);

		if($exists){
			return 'ok';
		}else{
			return 'fail';
		}
	}

	public function oca(){
		if($this->request->is('post')){
			$this->Package->save($this->request->data);
		}

		$h1 = array(
			'name' => 'Oca',
			'icon' => 'gi gi-display'
			);
		$this->set('h1', $h1);
		$this->loadModel('Home');

		$packages = $this->Package->find('all');
		$this->set('packages',$packages);
	}

	private function setOrdenRetiro($sale){
		$oca = new Oca();
		$sale = $sale['Sale'];
		$package = $this->Package->findById($sale['package_id']);
		$package = $package['Package'];
		 
		$sale['orden_retiro'] = $oca->ingresoORNuevo($sale['id'],$sale['apellido'],$sale['nombre'],$sale['calle'],$sale['nro'],$sale['piso'],$sale['depto'],$sale['cp'],$sale['localidad'],$sale['provincia'],$sale['telefono'],$sale['email'],$package['height'],$package['width'],$package['depth'],($package['weight']/1000),$sale['value']);
		//$t = $this->Sale->save($sale);

		return $sale;
	}

	public function getTicket($sale_id = null){
		$this->autoRender = false;
		$this->Sale->recursive = -1;
		$sale = $this->Sale->findById($sale_id);
		
		if(empty($sale) || empty($sale['Sale']['package_id']) || empty($sale['Sale']['value']) || empty($sale['Sale']['email']) || empty($sale['Sale']['telefono']) || empty($sale['Sale']['provincia']) || empty($sale['Sale']['localidad']) || empty($sale['Sale']['cp']) || empty($sale['Sale']['nro']) || empty($sale['Sale']['calle']) || empty($sale['Sale']['nombre']) || empty($sale['Sale']['apellido']))
			die('Venta no encontrada o incompleta.');
		
		//if(empty($sale['Sale']['orden_retiro'])){
			$sale = $this->setOrdenRetiro($sale);
		//}else{
	//		$sale = $sale['Sale'];
	//	}

		if(!empty($sale['orden_retiro'])){
			$this->redirect( "https://www1.oca.com.ar/ocaepak/Envios/EtiquetasCliente.asp?IdOrdenRetiro={$sale['orden_retiro']}&CUIT=30-71119953-1" );
		}else{
			die('Error: no se pudo generar la etiqueta.');	
		}
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
		require_once(APP . 'Vendor' . DS . 'mercadopago.php');
		$mp = new MP(Configure::read('client_id'), Configure::read('client_secret'));
		$filters = array(
            "range" => "date_created",
            "begin_date" => "NOW-120MONTH",
            "end_date" => "NOW",
            "limit" => 1000,
            "status" => "approved",
            "operation_type" => "regular_payment"
        );
        $searchResult = $mp->search_payment($filters,0,1000);
        return (!empty($searchResult['response']['results']))?$searchResult['response']['results']:array();
	}

	public function sales(){
		$h1 = array(
			'name' => 'Ventas',
			'icon' => 'gi gi-display'
			);
		$this->set('h1', $h1);
		$this->loadModel('Home');


		//Get and merge local-remote data.
		$sales = $this->getMPSales();
if (!empty($this->request->query['test'])){
        pr($sales);die;
}

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
			$package = $this->Package->find('first',array( 'conditions' => array( 'Package.amount_max >=' => count( $sale['collection']['sale_products'] ) , 'Package.amount_min <=' => count( $sale['collection']['sale_products'] ) ) ));
		
			//Deliver Cost
			foreach ($local_desc as $key => $value) {
				$sale_id = (!empty($value['SaleProduct']['sale_id']))?$value['SaleProduct']['sale_id']:0;
				$local_sale = $this->Sale->findById($sale_id);
				$sale['collection']['deliver_cost'] = (!empty($local_sale['Sale']['deliver_cost']))?$local_sale['Sale']['deliver_cost']:0;
				$sale['local_sale'] = $local_sale['Sale'];
			}
		}
		$sales = Hash::sort($sales, '{n}.collection.date_approved', 'desc');

		$this->set('sales',$sales);
	}


	public function remove_promo($id = null){
		$this->Promo->delete($id);
		$this->redirect(array( 'action' => 'promos' ));
	}

	public function save_file_admin()
	{
		$this->autoRender = false;
		$response = null;
		if (!empty($this->request->data['file']['name'])) {
			$response = $this->save_file( $this->request->data['file']);
		} else {
			die('fail');
		}
		if(empty($response)){
			$response = 'fail';
		}
		die($response);
	}
	
	public function isAuthorized($user) {
	    // If we're trying to access the admin view, verify permission:
	    if ('admin' === $this->Auth->user('role')) return true;  // User is admin, allow
	    return false;                                // User isn't admin, deny
	}

	public function index() {
		
	    $this->loadModel('Category');
		$cats = $this->Category->find('all');
  		$this->set('cats', $cats);

		$h1 = array(
			'name' => 'Página Principal',
			'icon' => 'gi gi-display'
			);
		$this->set('h1', $h1);
		$this->loadModel('Home');

		if ($this->request->is('post')) {
	        $data = $this->request->data;
	    	if(empty($data['url_mod_four'])) {
	    		$data['url_mod_four']=null;
	    	}
	    	if ($data['category_mod_four'] == 'url') {
	    		$data['category_mod_four'] = null;
	    	} else {
	    		$data['url_mod_four'] = null;
	    	}
	    	if(!isset($data['display_popup_form'])){
	    		$data['display_popup_form'] = 0;
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
				'icon' 		=> 'gi gi-list',
				'url'		=> Configure::read('mUrl').'/admin/categorias',
				'active'	=> 'categorias'
				),
			'Nueva Categoria' => array(
				'icon' 		=> 'gi gi-circle_plus',
				'url'		=> Configure::read('mUrl').'/admin/categorias/add',
				'active'	=> 'add'
				)

			);
		$this->set('navs', $navs);

		$h1 = array(
			'name' => 'Categorias',
			'icon' => 'gi gi-list'
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

			        $file_real_name2 = null;
			        if(!empty($this->request->params['form']['size']['name'])){
			            $file_real_name2 = $this->save_file($this->request->params['form']['size']);
			        }

			        if($file_real_name){
			            $data['img_url'] = $file_real_name;
			        }
			        if($file_real_name2){
			            $data['size'] = $file_real_name2;
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

			        $file_real_name2 = null;
			        if(!empty($this->request->params['form']['size']['name'])){
			            $file_real_name2 = $this->save_file($this->request->params['form']['size']);
			        }

			        if($file_real_name){
			            $data['img_url'] = $file_real_name;
			        }

			        if($file_real_name2){
			            $data['size'] = $file_real_name2;
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
	    $cats = $this->Category->find('all');
		$this->set('cats', $cats);
	    $this->render('categorias');
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
			'name' => 'Promociones',
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
           
			$this->update_products( $data['list_code'] , $data['list_code_desc']);
		}
		$this->redirect(array( 'action' => 'productos' ));
	}

	public function update_products( $list_code , $list_code_desc )
	{    
		$this->loadModel('Product');
		$products = $this->Product->find('all',array( 'recursive' => -1 ));
		
		foreach ($products as &$product) {
			if( !empty( $product['Product']['article'] ) && !empty( $list_code ) ) {
				$price = $this->SQL->product_price_by_list( $product['Product']['article'] , $list_code , $list_code_desc);
				
				if( !empty($price) ) {
					$this->Product->id = $product['Product']['id'];
					$precio = $price['precio']*100;
					$precio = ((int)$precio) / 100;
					
					$discount = $price['discount']*100;
					$discount = ((int)$discount) / 100;

					$this->Product->saveField('discount', $discount);
					$this->Product->saveField('price', $precio);
					//Debugger::log( $price );
				}
			}
		}

		return true;
	}

	public function productos($action = null) {
		$this->loadModel('Setting');
		
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

		$navs = array(
			'Lista' => array(
				'icon' 		=> 'gi gi-justify',
				'url'		=> Configure::read('mUrl').'/admin/productos',
				'active'	=> 'productos'
				),
			'Nuevo Producto' => array(
				'icon' 		=> 'gi gi-circle_plus',
				'url'		=> Configure::read('mUrl').'/admin/productos/add',
				'active'	=> 'add'
				)

			);
		$this->set('navs', $navs);

		$h1 = array(
			'name' => 'Productos',
			'icon' => 'gi gi-list'
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
			            $file_real_name = $this->save_file($this->request->params['form']['image']);
			        }

			        if($file_real_name){
			            $data['img_url'] = $file_real_name;
			        }
                  
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
				    $cats = $this->Category->find('all');
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
			            $file_real_name = $this->save_file($this->request->params['form']['image']);
			        }

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
				    $cats = $this->Category->find('all');
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

	    $prods = $this->Product->find('all',array('order'=>array( 'Product.id DESC' )));
		$this->set('prods', $prods);
	    $this->render('productos');
	}

	public function sucursales($action = null) {
		$navs = array(
			'Lista' => array(
				'icon' 		=> 'gi gi-list',
				'url'		=> Configure::read('mUrl').'/admin/sucursales',
				'active'	=> 'sucursales'
				),
			'Nueva Sucursal' => array(
				'icon' 		=> 'gi gi-circle_plus',
				'url'		=> Configure::read('mUrl').'/admin/sucursales/add',
				'active'	=> 'add'
				)

			);
		$this->set('navs', $navs);

		$h1 = array(
			'name' => 'Sucursales',
			'icon' => 'gi gi-list'
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

	public function contacto($action = null) {
		$navs = array(
			'Lista' => array(
				'icon' 		=> 'gi gi-list',
				'url'		=> Configure::read('mUrl').'/admin/contacto',
				'active'	=> 'contacto'
			)
		);
		$this->set('navs', $navs);

		$h1 = array(
			'name' => 'Contacto',
			'icon' => 'gi gi-list'
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
				'icon' 		=> 'gi gi-list',
				'url'		=> Configure::read('mUrl').'/admin/usuarios',
				'active'	=> 'usuarios'
				),
			'Nuevo Usuario' => array(
				'icon' 		=> 'gi gi-circle_plus',
				'url'		=> Configure::read('mUrl').'/admin/usuarios/add',
				'active'	=> 'add'
				)

			);
		$this->set('navs', $navs);

		$h1 = array(
			'name' => 'Usuarios',
			'icon' => 'gi gi-list'
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
				'active'	=> 'lookbook'
				),
			'Nuevo Look Book' => array(
				'icon' 		=> 'gi gi-circle_plus',
				'url'		=> Configure::read('mUrl').'/admin/lookbook/add',
				'active'	=> 'add'
				)

			);
		$this->set('navs', $navs);
       
		$h1 = array(
			'name' => 'Look Book',
			'icon' => 'gi gi-list'
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
   

    public function subscriptions($action = null) {
		$navs = array(
			'Lista' => array(
				'icon' 		=> 'gi gi-list',
				'url'		=> Configure::read('mUrl').'/admin/subscription',
				'active'	=> 'Newsletter'
			)
		);
		$this->set('navs', $navs);
        
		$h1 = array(
			'name' => 'Newsletter',
			'icon' => 'gi gi-list'
			);
		$this->set('h1', $h1);

		$this->loadModel('Subscription');
    	if ($action == 'delete' && $this->request->is('post')) {
    		$this->autoRender = false;
    		$this->Subscription->delete($this->request->data['id']);
    	}

	    $subscriptions = $this->Subscription->find('all',array('order'=>array( 'Subscription.id DESC' )));
	    $this->set('subscriptions', $subscriptions);
		return $this->render('subscriptions');
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
		if ($this->request->is('post')) {
			$this->ProductProperty->delete($this->data['id']);
		}
		die();
	}

}
