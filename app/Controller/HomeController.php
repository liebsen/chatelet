<?php
class HomeController extends AppController {
	public function beforeFilter() {
    parent::beforeFilter();
    $this->loadModel('Setting');
    $setting 			= $this->Setting->findById('catalog_first_line');
    $catalog_first_line = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
    $this->set('catalog_first_line',$catalog_first_line);
    unset($setting);   
    $setting  = $this->Setting->findById('catalog_flap');
	  $catalog_flap = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
	  $this->set('catalog_flap',$catalog_flap);
	  unset($setting);
    $this->loadModel('LookBook'); 
    $lookbook = $this->LookBook->find('all');
		$this->set('lookBook', $lookbook);
	}
	
	public function index() {
		
		$home = $this->Home->find('first');

    $filtered = \filterOrientation($home['Home']['img_url']);
    $home['Home']['img_url'] = implode(';', $filtered);

    $filtered = \filterOrientation($home['Home']['img_popup_newsletter']);
    $home['Home']['img_popup_newsletter'] = implode(';', $filtered);

    error_log(json_encode($home));
    
		$this->set('home', $home['Home']);

    if (isset($home['Home']['img_popup_newsletter']) && !empty($home['Home']['img_popup_newsletter'])) {
      $popupBG=explode(';', $home['Home']['img_popup_newsletter']);
      if (empty($popupBG[0])) {
        $aux = array();
        foreach ($popupBG as $key => $value) {
          if (!empty($value)) {
            $aux[] = $value;
          }
        }
        $popupBG = $aux;
      }
      @list($ancho, $alto, $tipo, $atributos) = getimagesize(Configure::read('uploadUrl').$popupBG[0]);
      if ($ancho<=990) {
        $this->set('popupBgWidth', $ancho);
        $this->set('popupBgHeight', $alto);
      }
    }

		$this->loadModel('Setting');
		$setting 	= $this->Setting->findById('page_video');
		$page_video = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
		$this->set('page_video',$page_video);
		$this->loadModel('Category');
    $this->loadModel('Store');
		$stores = $this->Store->find('all');
		$this->set('stores', $stores);
		$this->loadModel('Subscription');
    $data = $this->request->data;

		if ($this->request->is('post')) {
      if(!empty($data['Subscription']['email'])){

        $toSave = array(
          'email' => $data['Subscription']['email'],
        );

        $exists = $this->Subscription->find('first', [
          'conditions' => $toSave
        ]);
        if(!empty($exists)) {
          $this->Session->setFlash(
            "El email {$data['Subscription']['email']} ya está suscripto al newsletter",
            'default',
            array('class' => 'hidden error')
          );
        } else {
          $saved = $this->Subscription->save($toSave);
          if(!empty($saved)){
             $this->Session->setFlash(
                  'Gracias por unirte a las novedades', 
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
	}

  public function index_old(){
    $home = $this->Home->find('first');
    $this->set('home', $home['Home']);

    if (isset($home['Home']['img_popup_newsletter']) && !empty($home['Home']['img_popup_newsletter'])) {
      $popupBG=explode(';', $home['Home']['img_popup_newsletter']);
      if (empty($popupBG[0])) {
        $aux = array();
        foreach ($popupBG as $key => $value) {
          if (!empty($value)) {
            $aux[] = $value;
          }
        }
        $popupBG = $aux;
      }
      @list($ancho, $alto, $tipo, $atributos) = getimagesize(Configure::read('uploadUrl').$popupBG[0]);
      if ($ancho<=990) {
        $this->set('popupBgWidth', $ancho);
        $this->set('popupBgHeight', $alto);
      }
    }

    $this->loadModel('Setting');
    $setting  = $this->Setting->findById('page_video');
    $page_video = (!empty($setting['Setting']['value'])) ? $setting['Setting']['value'] : '';
    $this->set('page_video',$page_video);
    $this->loadModel('Category');
    $this->loadModel('Store');
    $stores = $this->Store->find('all');
    $this->set('stores', $stores);
    $this->loadModel('Subscription');
    $data = $this->request->data;

    if ($this->request->is('post')) {
      if(!empty($data['Subscription']['email'])){

        $toSave = array(
          'email' => $data['Subscription']['email'],
        );

        $exists = $this->Subscription->find('first', [
          'conditions' => $toSave
        ]);
        if(!empty($exists)) {
          $this->Session->setFlash(
            "El email {$data['Subscription']['email']} ya está suscripto al newsletter",
            'default',
            array('class' => 'hidden error')
          );
        } else {
          $saved = $this->Subscription->save($toSave);
          if(!empty($saved)){
             $this->Session->setFlash(
                  'Gracias por unirte a las novedades', 
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
  }
}
