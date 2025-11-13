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
		$this->loadModel('Subscription');
		if ($this->request->is('post')) {
			$data = $this->request->data;
			$ajax = $data['ajax'] ?? 0;
			$subscriber_email = trim($data['Subscription']['email']) ?? 0;
         if (!empty($subscriber_email)) {
         	$exists = $this->Subscription->findByEmail($subscriber_email);

         	if ($exists) {
					if(!empty($ajax)) {
						die(json_encode(array(
							'success' => true,
							'is_already_subscribed' => true, 
							'message' => 'Este email ya existe en nuestra base de datos. Ingresa otro.'
						)));
					}

	            $this->Session->setFlash(
                 'El email ya está registrado', 
                 'default', 
                 array('class' => 'hidden notice')
	             );         		
         	}

	         $toSave = array(
	            'email' => $data['Subscription']['email'],
	         );
	        
	         $saved = $this->Subscription->save($toSave);
	          
	         if(!empty($saved)){
					if(!empty($ajax)) {
						die(json_encode(array(
							'success' => true, 
							'message' => 'Bienvenido a Châtelet'
						)));
					}

	            $this->Session->setFlash(
                 'Bien!,email registrado', 
                 'default', 
                 array('class' => 'hidden notice')
	             );	
	         }
	      } elseif ($this->Contact->save($data)) {
				$message = $data['Contact']['message'];
				$message.= '<br /><br />Telefono: '.$data['Contact']['telephone'];
				$message.= '<br />Email: '.$data['Contact']['email'];
				$message.= '<br />Tipo: '.$data['Contact']['client_type'];
				$message.= '<br /><br /><br /> Para contestar este mensaje, debe crear un nuevo correo copiando la dirección de correo electrónico que el cliente completó.';
				$subject = '🌸 Contacto Châtelet - NO RESPONDER';
				$to = 'chateletonline@chatelet.com.ar';
				
				$this->sendMail($message, $subject, $to);

				if(!empty($ajax)) {
					die(json_encode(array(
						'success' => true, 
						'message' => 'Gracias por contactarnos'
					)));
				}

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
