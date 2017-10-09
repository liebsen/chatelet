<?php
class CatalogoController extends AppController {
	public $uses = array('Catalog','Category','LookBook','Product','ProductProperty');
	public function beforeFilter() {
    	parent::beforeFilter();
    	$this->loadModel('Setting');
    	
    	$setting 			= $this->Setting->findById('catalog_first_line');
		$catalog_first_line = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_first_line',$catalog_first_line);
		unset($setting);

    	$categories = $this->Category->find('all');
		$this->set('categories', $categories);

        $lookbook = $this->LookBook->find('all');
		$this->set('lookBook', $lookbook);
	}
	
	public function index($img_url = null) {

		$this->loadModel('Setting');
		$cat = $this->Catalog->find('first');
		$this->set('cat', $cat);
    
        $lookbook = $this->LookBook->find('all',array('group'=>'LookBook.img_url','fields' => 'LookBook.img_url' ));
		$this->set('lookbook', $lookbook);
        unset($setting);

		$setting 	= $this->Setting->findById('page_video');
		$page_video = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('page_video',$page_video);


		$setting 			= $this->Setting->findById('catalog_first_line');
		$catalog_first_line = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_first_line',$catalog_first_line);
		unset($setting);

		$setting 			 = $this->Setting->findById('catalog_second_line');
		$catalog_second_line = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_second_line',$catalog_second_line);
		unset($setting);

	    $setting 			= $this->Setting->findById('catalog_text');
		$catalog_text = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_text',$catalog_text);
		unset($setting);

		$setting 			 = $this->Setting->findById('catalog_flap');
		$catalog_flap = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_flap',$catalog_flap);
		unset($setting);



        if(!empty($img_url)){
        	$img_url = (strpos(strtolower($img_url), 'jpg')===false)?$img_url.'.jpg':$img_url;
            $lookbook_id = $this->LookBook->find('all',array('conditions' => array('LookBook.img_url' => $img_url)));
        }elseif(!empty($lookbook[0]['LookBook']['img_url'])){
            $img_url = $lookbook[0]['LookBook']['img_url'];
            $lookbook_id = $this->LookBook->find('all',array('conditions' => array('LookBook.img_url' => $img_url)));
        }
            $product = array();
           // $properties = array();
        if(!empty($lookbook_id)){
            foreach ($lookbook_id as $key => $value) {
            	$product_id = $value['LookBook']['product_id'];
            	$product[] = $this->Product->findById($product_id);
            }
        }
            $this->set('img_url', $img_url); 
            $properties_all = $this->ProductProperty->find('all');
            $this->set('properties_all',$properties_all);
        	$this->set('product', $product);
	}

}

?>

