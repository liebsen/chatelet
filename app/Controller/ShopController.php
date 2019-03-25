<?php
class ShopController extends AppController {
	public $uses = array('Product', 'ProductProperty','Promo','Catalogo','Category','LookBook');
	public $helpers = array('Number');
	public $components = array('SQL', 'RequestHandler');


	public function beforeFilter() {
    	parent::beforeFilter();
    	$this->loadModel('Setting');

		$categories = $this->Category->find('all');
		$this->set('categories', $categories);

        $setting 	= $this->Setting->findById('image_prodshop');
		$image_prodshop = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('image_prodshop',$image_prodshop);

        $setting 	= $this->Setting->findById('image_bannershop');
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
	public function die_general_stock(){
			$this->autoRender = false;
			$this->loadModel('StockCount');
			$this->loadModel('Product');
			$all_stock = $this->SQL->general_stock();
			if (!empty($all_stock)){
				foreach ($all_stock as $row){
					$record = [];
					$article_id = substr($row['cod_articulo'],0,strpos($row['cod_articulo'],'.'));

					$existArticle = $this->Product->findByArticle($article_id);
					if (!empty($existArticle)){

						if ($row['cod_articulo'] === $article_id.'.0000'){

							$toUpdate = array(
								'stock_total' => (int)$row['cantidad']
							);

							// update article name
							$details_name = $this->SQL->product_name_by_article($article_id);
							echo "\r\ndetail name: ".json_encode($details_name);

					    if(!empty($details_name['nombre'])){
		              $toUpdate['Product.name'] = (string)@$details_name['nombre'] ;
							}
							echo "\r\nUpdating ".json_encode($toUpdate);
							// update article stock
							$this->Product->updateAll(
								$toUpdate,
								array('Product.article' => $article_id)
							);
							die('OK');
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
						//echo "\r\nSaving ".json_encode($record);
						$success=$this->StockCount->save($record);
						if (!$success){
							echo "\r\nFailed to save";
						}
					}else{
						//echo "\r\nArticle {$article_id} not needed";
					}
				}
			}else{
				echo "\r\nGeneral stock response is empty.";
			}
	}
	public function die_categories(){
		$this->loadModel('Category');
		$categories = $this->Category->find('all');
		var_dump($categories);die;
	}
	public function stock($article = null,$size_number = null,$color_code = null,$list_code = null){
		$stock = 0;
		$list_code = Configure::read('list_code');
		$this->autoRender = false;
		if(!empty($article) && !empty($color_code) && !empty($size_number) ){
			CakeLog::write('debug','article: '.$article.' | size: '.$size_number.' | color_code: '.$color_code.' | list_code: '.$list_code);
	        	$stock = $this->SQL->product_stock($article,$size_number,$color_code,$list_code);
		}elseif (!empty($article)) {
			$stock = 1;
		}
		CakeLog::write('debug','stock: '.$stock);
		return (string)$stock;
	}

	public function check_stock($product_id){
		$this->autoRender = false;
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
				error_log('url match category: '.$category_id);
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
		$category = $this->Category->findById($category_id);
		$name_categories = $category['Category']['name'];
		$isGiftCard=false;
        if (strpos(strtolower($name_categories),'gift')!==FALSE){
        	$isGiftCard=true;
        }
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
					'id <>' => $product_id
				)
			)
		);

		foreach ($all_but_me as &$products) {
				$products['Product']['stock'] = 0;
				if(!empty($products['Product']['article'])){
					$products['Product']['stock'] = 1;
				}
			}


        $this->set('details',$details);
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
					'id <>' => $product_id
				)
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

}
?>
