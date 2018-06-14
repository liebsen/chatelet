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

		$setting 			 = $this->Setting->findById('catalog_flap');
		$catalog_flap = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_flap',$catalog_flap);
		unset($setting);
    	$this->render('index');

	}

	public function stock($article = null,$size_number = null,$color_code = null,$list_code = null){
		$stock = 0;
		$list_code = Configure::read('list_code');
		$this->autoRender = false;
		if(!empty($article) && !empty($color_code) && !empty($size_number) && !empty($list_code)){
        	$stock = $this->SQL->product_stock($article,$size_number,$color_code,$list_code);
		}elseif (!empty($article)) {
			$stock = 1;
		}

		die((string)$stock);
	}

	public function check_stock($product_id){
		$this->autoRender = false;
		$this->loadModel('Product');
		$product = $this->Product->findById($product_id);
		$stock = 0;
		$list_code = Configure::read('list_code');

		if(!empty($product['Product']['article'])){
			$stock = $this->SQL->product_exists_general($product['Product']['article'],$list_code);
		}
		if (empty($stock)) return 'empty';
		error_log('check stock');
		echo "$stock";
		die;
	}

	public function product($category_id = null) {
		if (!empty($this->request->params['category'])) {
			$tag = str_replace("-"," ",urldecode($this->request->params['category']));
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
/*
					$list_code = Configure::read('list_code');
				    $products['Product']['stock'] = $this->SQL->product_exists_general($products['Product']['article'],$list_code);
				    $details = $this->SQL->product_name_by_article($products['Product']['article']);
				    if(!empty($details)){ 
                    $products['Product']['name'] = $details['nombre'] ;
				    }
*/
				}
			}

		
		
        $this->set('details',$details);
		$this->set('category_id',$category_id);
        $this->set('name_categories',$name_categories);
		$this->set('category', $category);
		$this->set('product', $product['Product']);
		$this->set('properties', $properties);
		$this->set('isGiftCard', $isGiftCard);
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
