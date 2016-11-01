<?php
class ShopController extends AppController {
	public $uses = array('Category', 'Product', 'ProductProperty','Promo','Catalogo');
	public $helpers = array('Number');
	

	public function beforeFilter() {
    	parent::beforeFilter();
	}


	public function index($category_id = null) {
		$this->loadModel('Setting');
		$categories = $this->Category->find('all');
		$this->set('categories', $categories);

		if ($category_id) {
			$products = $this->Product->findAllByCategoryId($category_id);
			if (empty($products)) return $this->redirect(array('controller' => 'shop', 'action' => 'index'));

			foreach ($products as &$product) {				
				$product['Product']['stock'] = 0;
				if(!empty($product['Product']['article'])){
					$list_code = Configure::read('list_code');
					$product['Product']['stock'] = $this->SQL->product_exists_general($product['Product']['article'],$list_code);
				}
			}
			
			$this->set('products', $products);
		}

		$setting 			 = $this->Setting->findById('catalog_flap');
		$catalog_flap = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_flap',$catalog_flap);
		unset($setting);
	}

	public function stock($article = null,$size_number = null,$color_code = null,$list_code = null){
		$stock = 0;
		$list_code = Configure::read('list_code');
		$this->autoRender = false;
		if(!empty($article) && !empty($color_code) && !empty($size_number) && !empty($list_code))
			$stock = $this->SQL->product_stock($article,$size_number,$color_code,$list_code);
		return $stock;
	}

	public function product($product_id, $category_id) {
		$product = $this->Product->findById($product_id);
		$category = $this->Category->findById($category_id);
		$properties = $this->ProductProperty->findAllByProductId($product_id);
		$all_but_me = $this->Product->find('all', array(
				'recursive' => -1,
				'conditions' => array(
					'category_id' => $category_id,
					'id <>' => $product_id
				)
			)
		);

		$this->set('category', $category);
		$this->set('product', $product['Product']);
		$this->set('properties', $properties);
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
}
?>