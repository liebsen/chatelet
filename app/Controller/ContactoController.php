<?php
class ContactoController extends AppController {
	public $uses = array('Contact','Catalogo','Category','Subscription','LookBook');
	
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


            }elseif ($this->Contact->save($data)) {
				$message = $data['Contact']['message'];
				$message.= '<br /><br />Telefono: '.$data['Contact']['telephone'];
				$message.= '<br />Email: '.$data['Contact']['email'];
				$message.= '<br />Tipo: '.$data['Contact']['client_type'];
				$message.= '<br /><br /><br /> Para contestar este mensaje, debe crear un nuevo correo copiando la dirección de correo electrónico que el cliente completó.';
				
				$subject = '🌸 Contacto Châtelet - NO RESPONDER';
				$to = 'chateletonline@chatelet.com.ar';
				
				$this->sendMail($message, $subject, $to);
	            $this->Session->setFlash(
                    'Gracias por contactarnos', 
                    'default', 
                    array('class' => 'hidden notice')
                );
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