<?php
class ContactoController extends AppController {
	public $uses = array(
		'Contact',
		'Setting',
		'Catalogo',
		'Category',
		'User',
		'LookBook'
	);
	
	public $components = array(
		// "Mailchimp", 
		"RequestHandler"
	);

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
		$this->loadModel('Contact');
		if ($this->request->is('post')) {
			$data = $this->request->data;
			$ajax = $data['ajax'] ?? 0;

			if (!empty($data['website'])) {
		    // A bot filled the hidden field
		    die("Spam detected.");
		    if(!empty($ajax)) {
					die(json_encode(
						array(
							'success' => false, 
							'message' => 'Spam detected'
						)
					));
				}

        $this->Session->setFlash(
					'Por favor intente nuevamente',
					'default',
					array('class' => 'hidden error')
        );
			}

			if ($this->Contact->save($data)) {
				$message = $data['Contact']['message'];
				$message.= '<br /><br />Telefono: '.$data['Contact']['telephone'];
				$message.= '<br />Email: '.$data['Contact']['email'];
				$message.= '<br />Tipo: '.$data['Contact']['client_type'];
				$message.= '<br /><br /><br /> Para contestar este mensaje, debe crear un nuevo correo copiando la dirección de correo electrónico que el cliente completó.';
				$subject = '🌸 Contacto Châtelet - NO RESPONDER';
				$to = 'chateletonline@chatelet.com.ar';
				
				$this->sendEmailMessage($message, $subject, $to);

	      #$this->Mailchimp->subscribe($data['Contact'], "d168ae47ee");

				if(!empty($ajax)) {
					die(json_encode(array(
						'success' => true, 
						'message' => 'Gracias por contactarnos.'
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
