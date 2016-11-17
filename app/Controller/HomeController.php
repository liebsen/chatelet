<?php
class HomeController extends AppController {
	public function beforeFilter() {
    	parent::beforeFilter();
            
        


	     $setting  = $this->Setting->findById('catalog_flap');
	     $catalog_flap = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
	     $this->set('catalog_flap',$catalog_flap);
	     unset($setting);
	}
	
	public function index() {
		$home = $this->Home->find('first');
		$this->set('home', $home['Home']);

		$this->loadModel('Setting');
		$setting 	= $this->Setting->findById('page_video');
		$page_video = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('page_video',$page_video);


		$this->loadModel('Category');
		$categories = $this->Category->find('all');
		$this->set('categories', $categories);


		$this->loadModel('Subscription');
        $data = $this->request->data;

		if ($this->request->is('post')) {
			
            if(!empty($data['Subscription']['email'])){
              
             $toSave = array(
            
                'email' => $data['Subscription']['email'],
           
             );
           
            $saved = $this->Subscription->save($toSave);
             
	            if(!empty($saved)){
	               $this->Session->setFlash(
	                    'Bien!,email registrado', 
	                    'default', 
	                    array('class' => 'hidden notice')
	                );	
	            }


            } else {
                $this->Session->setFlash(
	                'Por favor intente nuevamente',
	                'default',
	                array('class' => 'hidden error')
	            );
			}
		}
	}
}
?>