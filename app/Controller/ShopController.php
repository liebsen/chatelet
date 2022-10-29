<?php

require __DIR__ . '/../Vendor/andreani/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../Vendor/andreani/');
$dotenv->load();

use AlejoASotelo\Andreani;


class ShopController extends AppController {
	public $uses = array('Product', 'ProductProperty','Promo','Catalogo','Category','LookBook');
	public $helpers = array('Number');
	// public $components = array('SQL', 'RequestHandler');
	public $components = array('RequestHandler');

	public function beforeFilter() {
  	parent::beforeFilter();
  	$this->loadModel('Setting');
		$categories = $this->Category->find('all');
		$this->set('categories', $categories);
    $setting = $this->Setting->findById('image_prodshop');
		$image_prodshop = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('image_prodshop',$image_prodshop);
    $setting = $this->Setting->findById('image_bannershop');
		$image_bannershop = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('image_bannershop',$image_bannershop);
    $this->loadModel('LookBook');
		$lookbook = $this->LookBook->find('all');
		$this->set('lookBook', $lookbook);
    unset($setting);
  	$setting 			= $this->Setting->findById('catalog_first_line');
		$catalog_first_line = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_first_line',$catalog_first_line);
		unset($setting);
	}

	public function index() {
	  $this->loadModel('Setting');
		$setting 	= $this->Setting->findById('page_video');
		$page_video = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('page_video',$page_video);

		$categories = $this->Category->find('all');
		$this->set('categories', $categories);
		//var_dump($categories);die;
		$setting 			 = $this->Setting->findById('catalog_flap');
		$catalog_flap = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_flap',$catalog_flap);
		unset($setting);
   	$this->render('index');
	}

	public function log_error() {
		$this->autoRender = false;
		if($this->request->is('post')) {
			echo '<pre>';
			var_dump($this->request->data);
			error_log('*** client error *** ' . json_encode($this->request->data));
		}
		die();
	}

	public function test_email($email) {
		$this->autoRender = false;
		if (!empty($email)) {
			$this->sendMail('hello','🌸 Test via en Châtelet',$email);
		}
		die();
	}

	public function test_andreani() {
		$this->autoRender = false;
		echo '<h4>Cotizaciones Andreani</h4>
		<p>Las cotizaciones se realizan en ambiente ' . (getenv('ANDREANI_DEBUG') ? 'pruebas': 'real' ) .' de Andreani</p>';
    $ws = new Andreani(getenv('ANDREANI_USUARIO'), getenv('ANDREANI_CLAVE'), getenv('ANDREANI_CLIENTE'), getenv('ANDREANI_DEBUG'));
		$bultos = array(
	    array(
        'volumen' => 200,
        'kilos' => 1.3,
        'altoCm' => 1,
				'anchoCm' => 2,
				'largoCm' => 1.5,
        // 'pesoAforado' => 5,
        'valorDeclarado' => 1200
	    )
		);
		/* https://apis.andreani.com/v1/tarifas?cpDestino=1400&contrato=300006611&cliente=CL0003750&sucursalOrigen=BAR&bultos[0][valorDeclarado]=1200&bultos[0][volumen]=200&bultos[0][kilos]=1.3&bultos[0][altoCm]=1&bultos[0][largoCm]=1.5&bultos[0][anchoCm]=2 */ 
		// $response = $ws->cotizarEnvio($_GET['cp'], '300006611', $bultos, 'CL0003750');
  	$response = $ws->cotizarEnvio(intval($_GET['cp']), getenv('ANDREANI_CONTRATO'), $bultos, getenv('ANDREANI_CLIENTE'));
    echo '<pre>';
    echo "cp " . $_GET['cp'] . "\n";
		var_dump($response);
		exit();
	}

	public function test_andreani_business() {
		$this->autoRender = false;
		extract($_POST);
		echo '<h4 style="margin:0.25rem">Cotizaciones Andreani</h4>
		<p style="margin:0.25rem">Las cotizaciones se realizan en ambiente real de Andreani</p>';
		if (isset($nrocliente) && isset($contrato)) {
	    $ws = new Andreani(getenv('ANDREANI_USUARIO'), getenv('ANDREANI_CLAVE'), $nrocliente, 0);
			$bultos = array(
		    array(
	        'volumen' => $volumen,
	        'kilos' => $kilos,
	        //'altoCm' => 1,
					//'anchoCm' => 2,
					//'largoCm' => 1.5,
	        //'pesoAforado' => 5,
	        'valorDeclarado' => $valor
		    )
			);
			/* https://apis.andreani.com/v1/tarifas?cpDestino=1400&contrato=300006611&cliente=CL0003750&sucursalOrigen=BAR&bultos[0][valorDeclarado]=1200&bultos[0][volumen]=200&bultos[0][kilos]=1.3&bultos[0][altoCm]=1&bultos[0][largoCm]=1.5&bultos[0][anchoCm]=2 */ 
			// $response = $ws->cotizarEnvio($_GET['cp'], '300006611', $bultos, 'CL0003750');
	  	$response = $ws->cotizarEnvio($cp, $contrato, $bultos, $nrocliente);
	    $price = isset($response->tarifaConIva) ? $response->tarifaConIva->total : null;
	    echo "<h1>$" . $price . "</h1>";
		}

		echo '<form action="" method="POST">
			<fieldset>
				<legend>Cod cliente</legend>
				<select name="nrocliente">
					<option value="CL0003750"'.(@$nrocliente==='CL0003750'?' selected':'').'>Basico CL0003750</option>
					<option value="0012009105"'.(@$nrocliente==='0012009105'?' selected':'').'>Empresa 0012009105</option>
				</select>
			</fieldset>
			<fieldset>
				<legend>Contrato envío simple</legend>
					<select name="contrato">
					<option value="300006611"'.(@$contrato==='300006611'?' selected':'').'>Basico 300006611</option>
					<option value="400025425"'.(@$contrato==='400025425'?' selected':'').'>Empresa 400025425</option>
				</select>
			</fieldset>
			<fieldset>
				<legend>CP Destino</legend>
				<input type="number" name="cp" placeholder="1824" value="'.@$cp.'">
			</fieldset>
			<fieldset>
				<legend>Valores paquete</legend>
					<label>Volumen (cm3)</label>
					<input type="number" name="volumen" placeholder="4200" value="'.@$volumen.'">
					<label>Peso (kg)</label>
					<input type="number" name="kilos" placeholder="1" value="'.@$kilos.'">
					<label>Valor declarado (ARS)</label>
					<input type="number" name="valor" placeholder="2200" value="'.@$valor.'">
				</select>
			</fieldset>			
			<input style="margin:0.25rem" type="submit" value="Cotizar">
		</form>';
		exit();
	}	

	public function die_general_stock(){
			$this->autoRender = false;
			$this->SQL = $this->Components->load('SQL');
			$this->loadModel('StockCount');
			$this->loadModel('Product');
			$all_stock = $this->SQL->general_stock();
			if (!empty($all_stock)){
				foreach ($all_stock as $row){
					$record = [];
					// echo "------\n".json_encode($row,true);
					$article_id = substr($row['cod_articulo'],0,strpos($row['cod_articulo'],'.'));
					//echo "article_id: ".$article_id;
					$existArticle = $this->Product->findByArticle($article_id);
					if (!empty($existArticle)){
						echo "exists article_id: ".$article_id;
						if ($row['cod_articulo'] === $article_id.'.0000'){

							$toUpdate = array(
								'Product.stock_total' => (int)$row['cantidad']
							);
							$replaceNames = false;
							// update article name
							if ($replaceNames){
								$details_name = $this->SQL->product_name_by_article($article_id);
								echo "\r\ndetail name: ".json_encode($details_name);
							}

							// update article stock

								if ($replaceNames){
									$this->Product->updateAll(
										array(
											'Product.stock_total' => (int)$row['cantidad'],
											'Product.name' => "'". (string)@$details_name['nombre'] ."'"
										),
										array('Product.article' => $article_id)
									);
								}else{
									$this->Product->updateAll(
										array(
											'Product.stock_total' => (int)$row['cantidad'],
											//'Product.name' => "'". (string)@$details_name['nombre'] ."'"
										),
										array('Product.article' => $article_id)
									);
								}
								echo "article_id updated: ".$article_id;

						}
						//
						$exists = $this->StockCount->findByCodArticulo($row['cod_articulo']);
						if (!empty($exists)){
							$record['id'] = $exists['StockCount']['id'];
						}else{
							$this->StockCount->create();
						}
						$record['article_id'] = $article_id;
						$record['cod_articulo'] = $row['cod_articulo'];
						$record['stock'] = (int)$row['cantidad'];
						echo "\r\nSaving ".json_encode($record);
						$success=$this->StockCount->save($record);
						if (!$success){
							echo "\r\nFailed to save";
						}
					}else{
					//	echo "\r\nArticle {$article_id} not needed";
					}
				}
			}else{
				echo "\r\nGeneral stock response is empty.";
			}

		/* upate products names */
		/* 
		$products = $this->Product->find('all');
		foreach($products as $product) {
			$product['Product']['name'] = substr($product['Product']['desc'],0,strpos($product['Product']['desc'],'.'));
			$this->Product->save($product);
		} */
	}
	public function die_categories(){
		$this->loadModel('Category');
		$categories = $this->Category->find('all');
		var_dump($categories);die;
	}
  /**
   * function to clear all cache data
   * by default accessible only for admin
   *
   * @access Public
   * @return void
   */
  public function clear_cache() {
  	$this->autoRender = false;
  	apc_clear_cache();
    Cache::clear();
    clearCache();

    $files = array();
    $files = array_merge($files, glob(CACHE . '*')); // remove cached css
    $files = array_merge($files, glob(CACHE . 'css' . DS . '*')); // remove cached css
    $files = array_merge($files, glob(CACHE . 'js' . DS . '*'));  // remove cached js           
    $files = array_merge($files, glob(CACHE . 'models' . DS . '*'));  // remove cached models           
    $files = array_merge($files, glob(CACHE . 'persistent' . DS . '*'));  // remove cached persistent           

    foreach ($files as $f) {
        if (is_file($f)) {
            unlink($f);
        }
    }

    if(function_exists('apc_clear_cache')):      
    apc_clear_cache();
    apc_clear_cache('user');
    endif;

    $this->set(compact('files'));
    $this->layout = 'ajax';
  }

	public function fix_names(){
		$this->autoRender = false;
		$this->loadModel('Product');		
		/* upate products names */
		$products = $this->Product->find('all');
		foreach($products as $product) {
			if(strpos($product['Product']['desc'], '.') !== false) {
				$product['Product']['name'] = substr($product['Product']['desc'],0,strpos($product['Product']['desc'],'.'));
			}
			if(strpos($product['Product']['name'], ',') !== false) {
				$product['Product']['name'] = substr($product['Product']['name'],0,strpos($product['Product']['name'],','));
			}
			$this->Product->save($product);
		}
	}

	public function stock($article = null,$size_number = null,$color_code = null,$list_code = null){
		$this->autoRender = false;
		if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['SERVER_NAME'] === 'test.chatelet.com.ar') {
			return 1;
		}
		$this->SQL = $this->Components->load('SQL');
		$stock = 0;
		$list_code = Configure::read('list_code');
		if(!empty($article) && !empty($color_code) && !empty($size_number) ){
			CakeLog::write('debug','article: '.$article.' | size: '.$size_number.' | color_code: '.$color_code.' | list_code: '.$list_code);
	    $stock = $this->SQL->product_stock($article,$size_number,$color_code,$list_code);
		} elseif (!empty($article)) {
			$stock = 1;
		}
		CakeLog::write('debug','stock: '.$stock);
		return (string)$stock;
	}

	public function check_stock($product_id){
		$this->autoRender = false;
		$this->SQL = $this->Components->load('SQL');
		$this->loadModel('Product');
		$product = $this->Product->findById($product_id);
		$stock = 0;
		$list_code = Configure::read('list_code');

		if(!empty($product['Product']['article'])){
			CakeLog::write('debug','checking SQL '.$product_id.' / '.$product['Product']['article'].' / list_code: '.$list_code);
			$stock = $this->SQL->product_exists_general($product['Product']['article'],$list_code);
		}
		CakeLog::write('debug','checking stock '.$product_id.': '.(int)$stock);
		if (empty($stock)) {
			return 'empty';
		}
		die("$stock");
	}

	public function product($category_id = null) {
		if (!empty($this->request->params['category'])) {
			$tag = str_replace("-"," ",urldecode($this->request->params['category']));
			$tag = str_replace('otoño invierno', 'otoño-invierno', $tag);
			$category = $this->Category->findByName($tag);
			if (!empty($category['Category']['id'])){
				$category_id = $category['Category']['id'];
				// error_log('url match category: '.$category_id);
			}
		}
		$this->loadModel('Setting');
		$setting 	= $this->Setting->findById('page_video');
		$page_video = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('page_video',$page_video);



		$categories = $this->Category->find('all');
		$this->set('categories', $categories);
    	$this->set('category_id', $category_id);

		if (!empty($category_id)) {
			$name_categories = $this->Category->findById($category_id);
            $name_categories = $name_categories['Category']['name'];

			$products = $this->Product->findAllByCategoryId($category_id);


			if (empty($products)) return $this->redirect(array('controller' => 'shop', 'action' => 'index'));

			foreach ($products as &$product) {
				$product['Product']['stock'] = 0;
				if (isset($product['Product']['discount']) && $product['Product']['discount'] !== $product['Product']['price']) {
					$product['Product']['old_price'] = $product['Product']['price'];
					$product['Product']['price'] = $product['Product']['discount'];
				}

				if(!empty($product['Product']['article'])){

					$product['Product']['stock'] = 1;


				}
			}

			rsort($products);

      $this->set('name_categories',$name_categories);
			$this->set('products', $products);
		}

		$setting 			 = $this->Setting->findById('catalog_flap');
		$catalog_flap = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_flap',$catalog_flap);
		unset($setting);
    	$this->render('product');

	}

  public function detalle($product_id, $category_id) {
		$product = $this->Product->findById($product_id);

		if (!isset($product)) {
			throw new NotFoundException();
		}

		$category = $this->Category->findById($category_id);
		$name_categories = $category['Category']['name'];
		$isGiftCard=false;
        if (strpos(strtolower($name_categories),'gift')!==FALSE){
        	$isGiftCard=true;
        }
		$properties = $this->ProductProperty->findAllByProductId($product_id);

		/*
		$details = $this->SQL->product_name_by_article($product['Product']['article']);
		if(!empty($details)){
	        foreach ($details as $key => $value) {
	        	$details = $value;
	        }
        } */

		$all_but_me = $this->Product->find('all', array(
				'recursive' => -1,
				'conditions' => array(
					'category_id' => $category_id,
					'id <>' => $product_id,
					'stock_total > ' => 0
				),
				'order' => ['Product.promo DESC']
			)
		);

		foreach ($all_but_me as &$products) {
			if (isset($products['Product']['discount']) && $products['Product']['discount']) {
				$products['Product']['old_price'] = $products['Product']['price'];
				$products['Product']['price'] = $products['Product']['discount'];
			}
			$products['Product']['stock'] = 0;
			if(!empty($products['Product']['article'])){
				$products['Product']['stock'] = 1;
			}
		}

		if (isset($product['Product']['discount']) && $product['Product']['discount']) {
			$product['Product']['old_price'] = $product['Product']['price'];
			$product['Product']['price'] = $product['Product']['discount'];
		}
		
    // $this->set('details',$details);
		$this->set('category_id',$category_id);
    $this->set('name_categories',$name_categories);
		$this->set('category', $category);
		$this->set('product', $product['Product']);
		$this->set('properties', $properties);
		$this->set('isGiftCard', $isGiftCard);
		if ($isGiftCard && !empty($product['Product']['img_url'])) {
			$this->set('img_url', $product['Product']['img_url']);
		}
		$this->set('all_but_me', $all_but_me);
	}

	public function add($product) {
		$product = json_decode($product);
		$this->Session->write('Carrito.' . $product['name'], $product);
	}

	public function promos(){
		$promos = $this->Promo->find('all');
		$this->set('promos',$promos);

        $this->loadModel('Setting');
		$setting 			 = $this->Setting->findById('catalog_flap');
		$catalog_flap = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_flap',$catalog_flap);
		unset($setting);

	}

	public function detalletest($product_id, $category_id) {
		$product = $this->Product->findById($product_id);
		$category = $this->Category->findById($category_id);
		$name_categories = $category['Category']['name'];

		$properties = $this->ProductProperty->findAllByProductId($product_id);


		$details = $this->SQL->product_name_by_article($product['Product']['article']);
		if(!empty($details)){
        foreach ($details as $key => $value) {
        	$details = $value;
        }
        }

		$all_but_me = $this->Product->find('all', array(
				'recursive' => -1,
				'conditions' => array(
					'category_id' => $category_id,
					'id <>' => $product_id,
					'stock_total > ' => 0
				),
				'order' => ['Product.promo DESC']
			)
		);

        $this->set('details',$details);
		$this->set('category_id',$category_id);
        $this->set('name_categories',$name_categories);
		$this->set('category', $category);
		$this->set('product', $product['Product']);
		$this->set('properties', $properties);
		$this->set('all_but_me', $all_but_me);
	}

	public function search(){
		$this->autoRender = false;
		$this->loadModel('Product');
		$this->loadModel('Search');

		$results = [];
		$q = $this->request->data['q'];
		$p = $this->request->data['p'] ? intval($this->request->data['p']) : 0;
		$s = $this->request->data['s'] ? intval($this->request->data['s']) : 10;
		$query = $this->Product->query("SELECT count(*)  as count FROM products WHERE products.name LIKE '%$q%' OR products.desc LIKE '%$q%'")[0];
		$data = $this->Product->find('all',[
			'conditions' => [
				'or' => [
					'Product.name LIKE' => "%$q%",
					'Product.desc LIKE' => "%$q%",
					'Product.promo' => "$q"
				],
				'stock_total > ' => 0
			],
			'order' => ['Product.promo DESC'],
			'limit' => $s,
			'offset' => $s * $p
		]);

		foreach($data as $item) {
			$price = $item['Product']['price'];
			$result = [
				'id' => $item['Product']['id'],
				'category_id' => $item['Product']['category_id'],
				'name' => $item['Product']['name'],
				'desc' => $item['Product']['desc'],
				'promo' => $item['Product']['promo'],
				'discount_label' => intval($item['Product']['discount_label_show']),
				'slug' => str_replace(' ','-',strtolower($item['Product']['desc'])),
				'img_url' => Configure::read('imageUrlBase') . $item['Product']['img_url']
			];
			if (isset($item['Product']['discount']) && $item['Product']['discount'] !== $price) {
				$result['old_price'] = str_replace(',00','',number_format($price, 2, ',', '.'));
				$price = $item['Product']['discount'];
			}
			$result['price'] = str_replace(',00','',number_format($price, 2, ',', '.'));
			$results[]= $result;
		}

		echo json_encode([
			'results' => $results,
			'query' => $query
		]);

		// save search
		$search = [];
		$search['name'] = $q;
		$search['user_id'] = $this->Auth->user('id');
		$search['created'] = date('Y-m-d H:i:s');
		$search['referer'] = $_SERVER['HTTP_REFERER'];
		$search['page'] = $p+1;
		$search['results'] = count($results);

		$this->Search->save($search);

		exit();		
	}
}
