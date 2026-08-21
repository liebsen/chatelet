<?php

require __DIR__ . '/../Vendor/andreani/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../Vendor/andreani/');
$dotenv->load();

use AlejoASotelo\Andreani;

class ShopController extends AppController {
	public $uses = array('Product', 'ProductProperty','Promo','Catalogo','Category','CategorySize','LookBook');
	public $helpers = array('Number', 'App');
	// public $components = array('SQL', 'RequestHandler');
	public $components = array('RequestHandler');

	public function beforeFilter() {
  	parent::beforeFilter();
    $this->loadModel('LookBook');
		$lookbook = $this->LookBook->find('all');
		$this->set('lookBook', $lookbook);
  	$setting 			= $this->Setting->findById('catalog_first_line');
		$catalog_first_line = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('cart', $this->Session->read('cart'));
		$this->set('cart_totals', $this->Session->read('cart_totals'));		
		$this->set('catalog_first_line',$catalog_first_line);
	}

	public function index() {
		$page_video = !empty($this->settings['page_video']) ? 
			$this->settings['page_video'] : 
			'';

		$this->set('page_video',$page_video);

		//var_dump($categories);die;

		$catalog_flap = !empty($this->settings['catalog_flap']) ? 
			$this->settings['catalog_flap'] : 
			'';

		$this->set('catalog_flap',$catalog_flap);
		unset($setting);

		/******** JSONSD ********/
		$this->set('schema', $this->categorySchema($this->viewVars['categories']));
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

	public function smtp_465() {
		$this->autoRender = false;

		$host = 'smtp-relay.brevo.com';
		$port = 465;
		$timeout = 10;

		// 1. Test TCP Connection
		$fp = @fsockopen($host, $port, $errno, $errstr, $timeout);
		if (!$fp) {
		    die("Connection failed: $errstr ($errno)");
		}

		echo "TCP Connection successful.\n";

		// 2. Test TLS Handshake
		$ssl = stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
		if (!$ssl) {
		    die("TLS Handshake failed on port 465. Ensure the server supports implicit TLS (SMTPS).");
		}

		echo "TLS Handshake successful. Port 465 is reachable and configured correctly.\n";
		fclose($fp);
	}

	public function smtp_587() {
		$this->autoRender = false;
		$host = 'smtp-relay.brevo.com'; // Replace with your SMTP host
		$port = 587;
		$timeout = 5; // Timeout in seconds

		// Attempt connection
		$connection = @fsockopen($host, $port, $errno, $errstr, $timeout);

		if ($connection) {
		    echo "Connection to $host:$port successful.";
		    fclose($connection);
		} else {
		    echo "Connection failed: Error $errno - $errstr";
		}
	}

	public function test_email_text($id) {
		$this->autoRender = false;
		if (!empty($id)) {
      $user_data = $this->User->find('first', array(
        'recursive' => -1, 
        'conditions' => array('User.id' => $id)
      ));

      if ($user_data) {
	      $email_data = array(
	        'id_user' => $user_data['User']['id'],
	        'receiver_email' => $user_data['User']['email'],
	        'name' =>  $user_data['User']['name'],
	      );			
				$this->sendEmailMessage($email_data,'🌸 Test via en Châtelet (HTML)', 'test');
			} else {
				die('User not found');
			}
		}
		die();
	}

	public function cart_expired() {}	

	public function test_email($email) {
		$this->autoRender = false;
		$this->RequestHandler->respondAs('application/json');
		$sent = false;

		if (!empty($email)) {
      $email_data = array(
        'id_user' => 1,
        'receiver_email' => $email,
        'name' =>  'Prueba',
      );
			$sent = $this->sendEmail($email_data, 'Hemos recibido tu solicitud', 'test_email');
		}

		return json_encode(array('sent' => $sent));
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


	public function sitemap_index() {
    $this->autoRender = false;
    
    // Build dynamic data array
    $data = array(
        'sitemapindex' => array(
            'sitemap' => array(
                'loc' => $this->settings['site_url']
            )
        )
    );
    
    // Convert array to XML using Cake's Xml utility
    $xmlObject = Xml::fromArray($data, array('format' => 'tags'));
    $xmlObject->addAttribute('xmlns', 'http://sitemaps.org');

    $xmlString = $xmlObject->asXML();
    
    // Set content type header to application/xml
    $this->response->type('xml');
    
    // Return the final XML string as the response body
    $this->response->body($xmlString);
    return $this->response;
	}

	public function sitemap_categories() {
    $this->autoRender = false;
    /*
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://sitemaps.org">
   <url>
      <loc>https://tutienda.com</loc>
      <lastmod>2026-08-12</lastmod>
   </url>
   <url>
      <loc>https://tutienda.comtenis-running/</loc>
      <lastmod>2026-08-14</lastmod>
   </url>
</urlset>
    */
    // Build dynamic data array
    $data = array(
      'urlset' => array(
        'url' => array()
      )
    );
	
		foreach($this->viewVars['categories'] as $category) {
			$slug =  str_replace(' ','-',strtolower($category['Category']['name']));
			$data['urlset']['url'][] = array(
				'loc' => $this->settings['site_url'] .'/tienda/productos/'. $slug,
				'lastmod' => date('Y-m-d')
			);
		}

    // Convert array to XML using Cake's Xml utility
    $xmlObject = Xml::fromArray($data, array('format' => 'tags'));
    $xmlObject->addAttribute('xmlns', 'http://sitemaps.org');
    $xmlString = $xmlObject->asXML();
    
    // Set content type header to application/xml
    $this->response->type('xml');
    
    // Return the final XML string as the response body
    $this->response->body($xmlString);
    return $this->response;
	}

	public function sitemap_products() {
    $this->autoRender = false;
    /*
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://sitemaps.org"
        xmlns:image="http://google.com">
   <url>
      <loc>https://tutienda.com</loc>
      <lastmod>2026-08-14</lastmod>
      <image:image>
         <image:loc>https://tutienda.com</image:loc>
         <image:title>Tenis Running Pro V2 Color Rojo</image:title>
      </image:image>
   </url>
</urlset>
    */
    // Build dynamic data array
    $data = array(
      'urlset' => array(
        'url' => array()
      )
    );

		$products = $this->Product->find('all',[
			'conditions' => [
				'visible' => 1,
			],
			'order' => ['Product.name ASC']
		]);

		foreach($products as $product) {
			$slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', trim($product['Product']['name']))));
			$data['urlset']['url'][] = array(
				'loc' => $this->settings['site_url'] .'/tienda/producto/'. $product['Product']['id'] . '/' . $product['Product']['category_id'] . '/'. $slug,
				'lastmod' => date('Y-m-d'),
				'image:image' => array(
					'image:loc' => $this->settings['site_url'] .''. $this->settings['upload_url'] . ''. $product['Product']['img_url'],
					'image:title' => trim($product['Product']['name']),
				)
			);
		}

    // Convert array to XML using Cake's Xml utility
    $xmlObject = Xml::fromArray($data, array('format' => 'tags'));
    $xmlObject->addAttribute('xmlns', 'http://sitemaps.org');
    $xmlObject->addAttribute('xmlns-image', 'http://google.com');
    $xmlString = $xmlObject->asXML();
    
    // Set content type header to application/xml
    $this->response->type('xml');
    
    // Return the final XML string as the response body
    $this->response->body(str_replace('xmlns-image', 'xmlns:image',$xmlString));
    return $this->response;
	}


	public function die_general_stock(){
		$this->autoRender = false;
		$this->SQL = $this->Components->load('SQL');
		$this->loadModel('StockCount');
		$this->loadModel('Product');
		$all_stock = $this->SQL->general_stock();
		$prod_saved = 0;
		if (!empty($all_stock)){
			foreach ($all_stock as $row){
				$record = [];
				// echo "------\n".json_encode($row,true);
				$article_id = substr($row['cod_articulo'],0,strpos($row['cod_articulo'],'.'));
				//echo "article_id: ".$article_id;
				$existArticle = $this->Product->findByArticle($article_id);
				if (!empty($existArticle)){
					// CakeLog::write('debug',"exists article_id: ".json_encode($article_id));
					if ($row['cod_articulo'] === $article_id.'.0000'){

						$toUpdate = array(
							'Product.stock_total' => (int)$row['cantidad']
						);
						$replaceNames = false;
						// update article name
						if ($replaceNames){
							$details_name = $this->SQL->product_name_by_article($article_id);
							CakeLog::write('debug',"die_general_stock(details): ".json_encode($details_name));
						}
							// update article stock
						if($replaceNames){
							$this->Product->updateAll(
								array(
									'Product.stock_total' => (int)$row['cantidad'],
									'Product.name' => "'". (string)@$row['nombre'] ."'",
									//'Product.desc' => "'". (string)@$details_name['Descripcion'] ."'"
								),
								array('Product.article' => $article_id)
							);
						}else{
							$this->Product->updateAll(
								array(
									'Product.stock_total' => (int)$row['cantidad'],
									'Product.desc' => "'". (string)@$row['Descripcion'] ."'"
									//'Product.name' => "'". (string)@$details_name['nombre'] ."'"
								),
								array('Product.article' => $article_id)
							);
						}
						echo "article_id updated: ".$article_id;
						$prod_saved++;
						//CakeLog::write('debug',"Detail(updated): ".json_encode($article_id));
					}
					$exists = $this->StockCount->findByCodArticulo($row['cod_articulo']);
					if (!empty($exists)){
						$record['id'] = $exists['StockCount']['id'];
					}else{
						$this->StockCount->create();
					}
					$record['article_id'] = $article_id;
					$record['cod_articulo'] = $row['cod_articulo'];
					$record['stock'] = (int)$row['cantidad'];
					//$record['desc'] = (string)$row['Descripcion'];
					//CakeLog::write('debug',"Saving: ".json_encode($record));
					$success = $this->StockCount->save($record);
					if (!$success){
						echo "\r\nFailed to save";
					}
				}else{
				//	echo "\r\nArticle {$article_id} not needed";
				}
			}
			CakeLog::write('debug',"die_general_stock(prod_saved): ".json_encode($prod_saved));
		}else{
			echo "\r\nGeneral stock response is empty.";
		}
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
  	//apc_clear_cache();
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

	public function stock($product_id, $article = null,$size_number = null,$color_code = null,$list_code = null){
		$this->RequestHandler->respondAs('application/json');
		$this->autoRender = false;
		$this->loadModel('Stat');
		$stock = 0;
		$list_code = $this->settings['list_code'];
		$stock_min = $this->settings['stock_min'];

		$this->Stat->save(array(
			'id' => null,
      'tag' => 'variant-select',
      'user_id' => $this->Auth->user('id') ?? 1,
      'product_id' => $product_id,
      'context' => json_encode(array(
      	'size_number' => $size_number,
      	'color_code' => $color_code,
      ))
    ));

		if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
			return 1;
		}

		$this->SQL = $this->Components->load('SQL');

		if(!empty($article) && !empty($color_code) && !empty($size_number) ){
			// CakeLog::write('debug','article: '.$article.' | size: '.$size_number.' | color_code: '.$color_code.' | list_code: '.$list_code);
	    $stock = $this->SQL->product_stock($article,$size_number,$color_code,$list_code,$stock_min);
		} elseif (!empty($article)) {
			$stock = 1;
		}

		// CakeLog::write('debug','stock: article: '.$article.' | size: '.$size_number.' | color_code: '.$color_code.' | list_code: '.$list_code . ':' . $stock);
		return json_encode((string) $stock);
	}

	public function check_stock($product_id){
		$this->autoRender = false;
		$this->SQL = $this->Components->load('SQL');
		$this->loadModel('Product');
		$product = $this->Product->findById($product_id);
		$stock = 0;
		$list_code = $this->settings['list_code'];
		$stock_min = $this->settings['stock_min'];
		if(!empty($product['Product']['article'])){
			CakeLog::write('debug','checking SQL '.$product_id.' / '.$product['Product']['article'].' / list_code: '.$list_code);
			$stock = $this->SQL->product_exists_general($product['Product']['article'],$list_code, $stock_min);
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
    $this->loadModel('Legend');
		$this->loadModel('Setting');

    $legends = $this->Legend->find('all', [
      'conditions' => ['enabled' => 1],
      'order' => ['Legend.ordernum ASC']
    ]);

    $this->set('legends', $legends);

		$setting 	= $this->Setting->findById('page_video');
		$page_video = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('page_video',$page_video);
		$categories = $this->Category->find('all',array(
			'conditions'=>array('visible' => 1),
			'order'=>array( 'Category.ordernum ASC' )
		));
		$this->set('categories', $categories);
    $this->set('category_id', $category_id);

		if (!empty($category_id)) {
			$mapper = $this->Category->findById($category_id);
      $category = $mapper['Category'];

			//$products = $this->Product->findAllByCategoryId($category_id,['order' => ['Product.ordernum ASC']]);
			$products = $this->Product->find('all',[
				'conditions' => [
					'category_id' => $category_id,
					'visible' => 1,
				],
				'order' => ['Product.ordernum ASC'],
				'limit' => 10 // *******
			]);

			if (empty($products)){ 
				return $this->redirect(array('controller' => 'shop', 'action' => 'index'));
			}

			foreach ($products as &$product) {
				$product['Product']['stock'] = 0;
				$all_colors = array();

				if (
					isset($product['Product']['discount']) && 
					$product['Product']['discount'] !== $product['Product']['price'] && 
					$product['Product']['discount'] > 1
				) {
					$product['Product']['old_price'] = $product['Product']['price'];
					$product['Product']['price'] = $product['Product']['discount'];
				}

				if(!empty($product['Product']['article'])){
					$product['Product']['stock'] = 1;
				}

				$find_colors = $this->ProductProperty->find('all', 
					array(
						'conditions' => array(
							'type' => 'color',
							'product_id' => $product['Product']['id']
						),
					)
				);

				foreach($find_colors as $data_color) {
					$colors = array_filter(
						array_values(
							explode(';', $data_color['ProductProperty']['images'])
						)
					);

					foreach($colors as $color) {
						array_push($all_colors, $color);
					}

					if(!empty($final_color)) {
						array_push($all_colors, $final_color);
					}
				}
				$product['Product']['colors'] = array_splice($all_colors, 5);
			}

			//rsort($products);
      $this->set('category',$category);
			$this->set('products', $products);
	    if(!empty($category['name'])) {
	    	$site_title = $category['name'];
	    	$site_description = $category['name'];

				$this->set('site_title', $site_title);		
				$this->set('site_description', $site_description);		
	    }
		}

		if(empty($category)) {
			throw new NotFoundException();
		}

		$setting = $this->Setting->findById('catalog_flap');
		$catalog_flap = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_flap',$catalog_flap);
		unset($setting);

    $this->render('product');
	}

	private function categorySchema($categories){
		// 1. Define your category metadata dynamically
		$categoryName = $this->settings['site_title'];
		$categoryUrl = $this->settings['site_url'];
		$categoryDescription = $this->settings['site_description'];

		foreach($categories as $p => $cat) {
			$name = $cat['Category']['name'];
			$slug =  str_replace(' ','-',strtolower($name));

			$categoryItems[] = [
        "position" => $p+1,
        "name" => $name,
        "url" => implode('/',[$this->settings['site_url'],'tienda', 'productos', $slug])
			];
		}

		// 3. Build the Structured Data Array
		$itemListElements = [];
		foreach ($categoryItems as $item) {
	    $itemListElements[] = [
        "@type" => "ListItem",
        "position" => $item['position'],
        "url" => $item['url'],
        "name" => $item['name']
	    ];
		}

		$schema = [
	    "@context" => "https://schema.org",
	    "@type" => "CollectionPage",
	    "@id" => $categoryUrl . "#collection",
	    "url" => $categoryUrl,
	    "name" => $categoryName,
	    "description" => $categoryDescription,
	    "mainEntity" => [
        "@type" => "ItemList",
        "numberOfItems" => count($categoryItems),
        "itemListElement" => $itemListElements
	    ]
		];

		return $schema;
	}

  public function mis_compras()
  {
    $this->loadModel('Sale');
    $this->loadModel('SaleProduct');

    $user_id = $this->Auth->user('id');
    $sales = $this->Sale->find('all',[
      'conditions' => [
        'user_id' => $user_id,
      ],     
      'order' => ['Sale.id DESC'],
      'limit' => 500,
    ]);

    foreach($sales as $i => $sale) {
    	$items = $this->SaleProduct->find('all',[
		    'joins' => [
	        [
	          'table' => 'products',
	          'alias' => 'Product',
	          'type' => 'LEFT',
	          'conditions' => [ 'Product.id = SaleProduct.product_id' ]
	        ]
		    ],
		  	'fields' => ['Product.img_url, Product.article, SaleProduct.*'],
        'conditions' => [
          'sale_id' => $sale['Sale']['id'],
        ],     
        'order' => ['SaleProduct.id DESC'],
        'limit' => 1000,
      ]);

      $sales[$i]['Products'] = $items;
    }

    $this->set('sales', $sales);
  }

  public function detalle($product_id = 0, $category_id = 0) {

  	if(empty($product_id)) {
  		throw new NotFoundException();
  	}

		$product = $this->Product->findById($product_id);
		$category_sizes = $this->CategorySize->findAllByCategoryId($product['Product']['category_id']);

		if (!isset($product)) {
			throw new NotFoundException();
		}

		if(!empty($this->request->query('schedule_item') || !empty($this->request->query('uid')))) {
			$uid = $this->request->query('schedule_item') ?? $this->request->query('uid');
			$this->addClick($uid, $this->request->query('click_origin'));
		}

		$this->loadModel('Legend');
    $legends = $this->Legend->find('all', [
      'conditions' => ['enabled' => 1, 'title <>' => ''],
      'order' => ['Legend.dues ASC']
    ]);

		$category = $this->Category->findById($category_id);
		$name_categories = @$category['Category']['name'];
		$isGiftCard=false;
        if (strpos(strtolower($name_categories),'gift')!==FALSE){
        	$isGiftCard=true;
        }
		$properties = $this->ProductProperty->findAllByProductId($product_id);
		$sizes = array();
		$colors = array();
		foreach ($properties as $property) {
			$property['ProductProperty']['label'] = $property['ProductProperty']['variable'];
		  switch ($property['ProductProperty']['type']) {
		    case 'color':
		      if (!empty($property['ProductProperty']['images'])) {
		          $arrImages = explode(';', $property['ProductProperty']['images']);
		          $colorImages[] = array(
		            'alias' => $property['ProductProperty']['alias'], 
		            'images' => $arrImages
		          );
		      }

		      array_push($colors, $property['ProductProperty']);
		      break;
		    case 'size':
		    	//echo '<pre>';
		    	foreach($category_sizes as $cat_size) {
		    		//var_dump($cat_size);
			    	if((int) $property['ProductProperty']['label'] == (int) $cat_size['CategorySize']['code']) {
			    		$property['ProductProperty']['label'] = $cat_size['CategorySize']['name'];
			    	} 
			    }
		      array_push($sizes, $property['ProductProperty']);
		      break;
		  }
		}

		if(count($sizes) == 1 && $sizes[0]['variable'] == "11") {
		  $sizes[0]['label'] = "Talle único";
		}



		$cloudzoom = false;
		$unique_size = "11";
		$cloudzoomdata = 'zoomSizeMode:"zoom", lensWidth: 100, lensHeight: 100, zoomWidth:300, zoomHeight: 300, autoInside: 600';
		$images  = array();
		$images_aux = explode(';', $product['gallery']);

		foreach ($images_aux as $key => $value) {
		  if(!empty($value))
		    $images[] = $settings['upload_url'].$value;
		}

		$this->set('colorImages',$colorImages);
		$this->set('colors',$colors);
		$this->set('sizes',$sizes);
		$this->set('cloudzoom',$cloudzoom);
		$this->set('cloudzoomdata',$cloudzoomdata);
		$this->set('images',$images);

		/*
		$details = $this->SQL->product_name_by_article($product['Product']['article']);
		if(!empty($details)){
	        foreach ($details as $key => $value) {
	        	$details = $value;
	        }
        } */

		$all_but_me = $this->Product->find('all', [
      'conditions' => [
				'Product.category_id' => $category_id,
				'Product.visible' => 1,
				'Product.id <>' => $product_id,
				'Product.stock_total > ' => 0
      ],     
			'order' => ['Product.ordernum ASC'],
      'limit' => 100
    ]);
		$all_colors = array();

		foreach ($all_but_me as &$item) {
			if (isset($item['Product']['discount']) && $item['Product']['discount']) {
				$item['Product']['old_price'] = $item['Product']['price'];
				$item['Product']['price'] = $item['Product']['discount'];
			}
			$item['Product']['stock'] = 0;
			if(!empty($item['Product']['article'])){
				$item['Product']['stock'] = 1;
			}

			$find_colors = $this->ProductProperty->find('all', 
				array(
					'conditions' => array(
						'type' => 'color',
						'product_id' => $item['Product']['id']
					),
				)
			);

			foreach($find_colors as $data_color) {
				$colors = array_filter(
					array_values(
						explode(';', $data_color['ProductProperty']['images'])
					)
				);

				foreach($colors as $color) {
					array_push($all_colors, $color);
				}
			}

			$item['Product']['colors'] = array_splice($all_colors, 5);
		}

		if (isset($product['Product']['discount']) && $product['Product']['discount']) {
			$product['Product']['old_price'] = $product['Product']['price'];
			$product['Product']['price'] = $product['Product']['discount'];
		}
		
    // $this->set('details',$details);
		$this->set('category_id',$category_id);
    $this->set('name_categories',$name_categories);
		$this->set('category', $category);
		$this->set('product', @$product['Product']);
		//$this->set('category_sizes', @$sizes);
		$this->set('properties', $properties);
		$this->set('isGiftCard', $isGiftCard);
		if ($isGiftCard && !empty($product['Product']['img_url'])) {
			$this->set('img_url', $product['Product']['img_url']);
		}

    if(!empty($product['Product']['name'])) {
    	$site_title = $product['Product']['name'];
    	$site_description = str_replace("\n", "", $product['Product']['desc']);

			$this->set('site_title', $site_title);		
			$this->set('site_description', $site_description);		
    }

		$this->set('legends', $legends);
		$this->set('all_but_me', $all_but_me);
	}

	public function add($product) {
		$product = json_decode($product);
		//$this->Session->write('cart.' . $product['name'], $product);
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

	public function catalog_xml(){
		$this->layout = false;
		$this->RequestHandler->respondAs("xml");

		$data = $this->Product->find('all', array(
	    'joins' => array(
        array(
          'table' => 'categories',
          'alias' => 'Category',
          'type' => 'LEFT',
          'conditions' => array( 'Category.id = Product.category_id' )
        )
	    ),
	  	'fields' => array('Product.id, Product.category_id, Product.article, Product.name, Product.desc, Product.img_url, Product.price, Product.article, Product.discount, Product.stock_total', 'Category.name as category'),
			'conditions' => array( 'Product.visible' => "1" ),
			//'order' => array( 'Product.price ASC' )
		));
		
		$this->set('products',$data);
	}

	public function catalog_rss(){
		$this->layout = false;
		$this->RequestHandler->respondAs("xml");

		$data = $this->Product->find('all', array(
	    'joins' => array(
        array(
          'table' => 'categories',
          'alias' => 'Category',
          'type' => 'LEFT',
          'conditions' => array( 'Category.id = Product.category_id' )
        )
	    ),
	  	'fields' => array('Product.id, Product.category_id, Product.article, Product.name, Product.desc, Product.img_url, Product.price, Product.article, Product.discount, Product.stock_total', 'Category.name as category'),
			'conditions' => array( 'Product.visible' => "1" ),
			//'order' => array( 'Product.price ASC' )
		));
		
		$this->set('products',$data);
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
					'visible' => 1,
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

	public function registro() {
		$this->loadModel('User');
		$user = $this->User->find('first',array('recursive' => -1,'conditions'=>array('User.id' => $this->Auth->user('id'))));
		$this->set('userData',$user['User']);	
	}

	public function cuenta() {}
	public function politica() {}
	public function terminos() {}
	public function recuperar_acceso() {}
	public function login() {
		if($this->Auth->user('id')) {
			$this->redirect(array('controller' => 'shop', 'action' => 'cuenta'));
		}
	}

	public function buscar(){
		$this->loadModel('Product');
		$this->loadModel('Stat');
		$this->loadModel('Legend');

    $legends = $this->Legend->find('all', [
      'conditions' => ['enabled' => 1],
      'order' => ['Legend.ordernum ASC']
    ]);

    $this->set('legends', $legends);
		$q = (string) $this->request->query['q'];

		if(strlen($q) > 30) { // query string too large, desist
			$this->set('q', "");
			$this->set('results', array());
			return $this->render('buscar');
		}

		$p = $this->request->query['p'] ? intval($this->request->data['p']) : 0;
		$s = $this->request->query['s'] ? intval($this->request->data['s']) : 10;
		//\d("search", $q);
		//$query = $this->Product->query("SELECT count(*)  as count FROM products WHERE products.name LIKE '%$q%' OR products.desc LIKE '%$q%'")[0];
		$ors = array();
		$q = trim($q);
		$parts = explode(' ',$q);

		foreach($parts as $part) {
			$part = trim($part);
			if(substr($part, -1) == 's' && strlen($part) > 3) {
				array_push($ors, array('Product.name LIKE' => "%".substr($part, 0, -1)."%"));
				array_push($ors, array('Product.desc LIKE' => "%".substr($part, 0, -1)."%"));
				array_push($ors, array('Product.promo LIKE' => "%".substr($part, 0, -1)."%"));
			}
			if(substr($part, -2) == 'es' && strlen($part) > 3) {
				array_push($ors, array('Product.name LIKE' => "%".substr($part, 0, -2)."%"));
				array_push($ors, array('Product.desc LIKE' => "%".substr($part, 0, -2)."%"));
				array_push($ors, array('Product.promo LIKE' => "%".substr($part, 0, -2)."%"));
			}
			array_push($ors, array('Product.name LIKE' => "%$part%"));
			array_push($ors, array('Product.desc LIKE' => "%$part%"));
			array_push($ors, array('Product.promo LIKE' => "%$part%"));			
		}

		// CakeLog::write('debug', 'ors: "'.json_encode($ors, JSON_PRETTY_PRINT));
		if(!empty($q) && strlen($q) > 2) {
			$results1 = $this->Product->find('all',[
		    'joins' => array(
	        array(
	          'table' => 'categories',
	          'alias' => 'Category',
	          'type' => 'LEFT',
	          'conditions' => array( 'Category.id = Product.category_id' )
	        )
		    ),
		  	'fields' => array('Product.id, Product.category_id, Product.article, Product.name, Product.desc, Product.img_url, Product.price, Product.article, Product.discount, Product.mp_discount, Product.bank_discount, Product.ribbon_color, Product.stock_total, Category.name, Category.mp_discount_enable, Category.bank_discount_enable, Category.mp_discount, Category.bank_discount'),
				'conditions' => [
					'or' => [
						'Product.name LIKE' => "%$q%",
						'Product.desc LIKE' => "%$q%",
						'Product.promo LIKE' => "%$q%"
					],
					'Product.visible' => 1,
					'Product.stock_total > ' => 0
				],
				// 'order' => ['Product.promo DESC'],
				'order' => ["LOCATE('".$q."', Product.name)"],
				// 'limit' => $s,
				// 'offset' => $s * $p
			]);

			$pids = array();
			foreach($results1 as $item) {
				array_push($pids, $item['Product']['id']);
			}
			$conditions = [
				'or' => $ors,
				'Product.visible' => 1,
				'Product.stock_total > ' => 0
			];
			if(count($pids)){
				$conditions['and'] = array(
					'Product.id NOT IN' => $pids,
				);
			}
			$results2 = $this->Product->find('all',[
		    'joins' => array(
	        array(
	          'table' => 'categories',
	          'alias' => 'Category',
	          'type' => 'LEFT',
	          'conditions' => array( 'Category.id = Product.category_id' )
	        )
		    ),
		  	'fields' => array('Product.id, Product.category_id, Product.article, Product.name, Product.desc, Product.img_url, Product.price, Product.article, Product.discount, Product.mp_discount, Product.bank_discount, Product.stock_total, Category.name, Category.mp_discount_enable, Category.bank_discount_enable, Category.mp_discount, Category.bank_discount'),				
				'conditions' => $conditions,
				// 'order' => ['Product.promo DESC'],
				'order' => ["LOCATE('".$q."', Product.name)"],
				// 'limit' => $s,
				// 'offset' => $s * $p
			]);

			//\d("results1",array_reverse($results1));
			//\d("results2",$results2);

			$results = array_merge(array_reverse($results1), $results2);

			foreach ($results as &$item) {
				if (!empty($item['Product']['discount'])) {
					$item['Product']['old_price'] = $item['Product']['price'];
					$item['Product']['price'] = $item['Product']['discount'];
				}
				$item['Product']['stock'] = 0;
				if(!empty($item['Product']['article'])){
					$item['Product']['stock'] = 1;
				}
			}
		}

		$this->set('q', $q);
		$this->set('results', $results);

		// save search
		$save = array();
		$save['tag'] = 'page-search';
		$save['page'] = '/shop/buscar';
		$save['user_id'] = $this->Auth->user('id') ?? 1;
		// $save['referer'] = $_SERVER['HTTP_REFERER'];
		// $save['page'] = $p+1;
		$save['context'] = json_encode(
			array(
				'result_count' => count($results ?? []),
				'query' => $q
			)
		);

		$this->Stat->save($save);
	}
}
