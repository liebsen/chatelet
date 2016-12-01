<?php
class CatalogoController extends AppController {
	public $uses = array('Catalog','Category','LookBook','Product','ProductProperty');
	public function beforeFilter() {
    	parent::beforeFilter();
    	$this->loadModel('Setting');
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
   //     pr($lookbook);die;

       
	
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
        	$img_url = $img_url.'.jpg';
            $lookbook_id = $this->LookBook->find('all',array('conditions' => array('LookBook.img_url' => $img_url)));
        }else{
            $lookbook_id = $this->LookBook->find('all',array('limit'=> '3'));
        }
            $product = array();
            $properties = array();
            foreach ($lookbook_id as $key => $value) {
            	$product_id = $value['LookBook']['product_id'];
            	$product[] = $this->Product->findById($product_id);
            	
            }
     
            $properties = $this->ProductProperty->findAllByProductId($product_id);
		
			$this->set('product', $product);
		    $this->set('properties', $properties);
			
             
	    
	}

}

?>

