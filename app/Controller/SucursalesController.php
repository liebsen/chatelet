<?php
class SucursalesController extends AppController {
	public $uses = array('Store','Catalogo','Category','Subscription','LookBook');
	
	public function beforeFilter() {
    	parent::beforeFilter();
    	$this->loadModel('Setting');
         
        $lookbook = $this->LookBook->find('all');
		$this->set('lookBook', $lookbook); 

     	$setting 			= $this->Setting->findById('catalog_first_line');
		$catalog_first_line = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_first_line',$catalog_first_line);
		unset($setting);
	}
	
	public function index() {
		$stores = $this->Store->find('all');
		$this->set('stores', $stores);

		$this->loadModel('Setting');
		$setting 			 = $this->Setting->findById('catalog_flap');
		$catalog_flap = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('catalog_flap',$catalog_flap);
		unset($setting);


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