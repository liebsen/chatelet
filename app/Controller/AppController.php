<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

require_once __DIR__ . '/../functions.php';

App::uses(
  'Controller', 
  'Setting',
  'Stat',
  'CakeEmail', 
  'Network/Email'
);

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	public $components = array(
    'Session',
    'S3',
    'ResizeImage',
    'Auth' => array(
      'authenticate' => array(
          'Basic',
          'Form' => array(
              'fields' => array('username' => 'email')
          )
      ),
      'loginRedirect' => array(
          'controller' => 'home',
          'action' => 'index'
      ),
      'logoutRedirect' => array(
          'controller' => 'home',
          'action' => 'index'
      ),
      'authorize' => array('Controller')
    )
  );


  public $settings = [];
  public $localips = [
    '127.0.0.11', 
    '192.168.2.102', 
    '192.168.2.105'
  ];

  private $setting_tags = [
    'stock_min',
    'list_code',
    'whatsapp_enable',
    'whatsapp_text',
    'whatsapp_phone',
    'whatsapp_autohide',
    'whatsapp_animated',
    'opengraph_type',
    'opengraph_title',
    'opengraph_text',
    'opengraph_image',
    'opengraph_width',
    'opengraph_height',
    'google_analytics_code',
    'google_font_name',
    'google_font_size',
    'facebook_pixel_id',
    'mercadopago_client_id',
    'mercadopago_client_secret',
  ];

  public function load_settings(){
    #$this->loadModel('Setting');


    $tags = [];        
    $settings = $this->Setting->find('all');
    $data = [
      'env_staging' => $_SERVER['SERVER_NAME'] !== 'chatelet.com.ar'
    ];
    $path = Router::url(null, false);

    foreach($settings as $setting) {
      $id = $setting['Setting']['id'];
      $value = $setting['Setting']['value'];
      // $extra = $setting['Setting']['extra'];
      $data[$id] = $value;

      if(!in_array($id, $this->setting_tags)) {
        continue;
      }

      if($setting  == 'whatsapp_enable' &&(strstr($path, "carrito") || strstr($path, "envio") || strstr($path, "pago"))) {
          continue;
      }
    }
    return $data;
  }

  private function site_visits(){
    $this->loadModel('Setting');
    $site_visits = $this->Setting->findById('site_visits');
    if(!$this->Session->check('logged_visit')){
      $site_visits['Setting']['value']++;
      $this->Setting->save($site_visits['Setting']);
      $this->Session->write('logged_visit',1);
    }
    return $site_visits['Setting']['value'];
  }

  public function beforeFilter() {

    $version_file = __DIR__ . '/../app_version';
    $version_count = 1111;

    $this->loadModel('Menu');
    $this->loadModel('Banner');
    $this->loadModel('Category');
    $this->loadModel('Product');
    $this->loadModel('Setting');
    $this->loadModel('Stat');

    //CakeLog::write('debug', 'beforeFilter executed for ' . $this->name . 'Controller::' . $this->action);
    $this->Auth->allow();
    $this->set('loggedIn', $this->Auth->loggedIn());
    $this->set('user', $this->Auth->user());
    
    $cart_totals = $this->Session->read('cart_totals');
    // ensure certain config entries...
    if(empty($cart_totals['add_basket'])){
      $cart_totals['add_basket'] = 0;
    }
    
    if(empty($cart_totals['payment_method'])){
      $cart_totals['payment_method'] = 'mercadopago';
    }

    $this->set('cart', $this->Session->read('cart'));
    $this->set('cart_totals', $cart_totals);
    
    $mapper = $this->Setting->findById('shipping_price_min');
    $shipping_price_min = $mapper['Setting']['value'] ?? '';
    $this->set('shipping_price_min',$shipping_price_min);

    $banners = $this->Banner->find('all', [
      'conditions' => ['enabled' => 1, 'text <>' => ''],
      'order' => ['Banner.ordernum ASC']
    ]);

    $menus = $this->Menu->query('SELECT menus.title, menus.text, menus.href, menus.target_blank, categories.name AS category_name FROM menus LEFT JOIN categories ON categories.id = menus.category_id WHERE menus.enabled ORDER BY menus.ordernum ASC');

    $this->set('menus', $menus);
    $this->set('banners', $banners);

    $cats_enabled = $this->Product->query('SELECT DISTINCT category_id FROM products WHERE visible = 1');
    $catsids = [];

    foreach($cats_enabled as $cat) {
      $catsids[]= $cat['products']['category_id'];
    }

    $categories = $this->Category->find('all',array(
      'conditions'=> array('visible' => 1, 'id IN' => $catsids),
      'order' => array( 'Category.ordernum ASC' )
    ));
    
    $this->set('categories', $categories);

    if(file_exists($version_file)) {
      $version_date = date("d/m/Y H:i", filemtime($version_file));
      $version_count = (int) file_get_contents($version_file);
    }

    # register session resume event for stats 
    if(!empty($this->Auth->user('id'))) {
      $now = time();
      #$resume_hours = 3;
      #$resume_seconds = 3600 * $resume_hours;
      $resume_seconds = 10; // short for now
      $session_last = $this->Session->read('session_last') ?? null;

      if(!empty($session_last)) {
        $diff_seconds = abs($now - $session_last);
        if($diff_seconds > $resume_seconds) {
          $this->Stat->save(
            array(
              'id' => null,
              'tag' => 'session-resume',
              'user_id' => $this->Auth->user('id') ?? 0,
              'context' => json_encode(
                array(
                  'secs' => $diff_seconds
                )
              )
            )
          );
        }
      }
      $this->Session->write('session_last', $now);
    }

    $settings = $this->load_settings();
    $settings_update = false;
    $this->settings = $settings;
    $this->set('settings', $settings);

    $keys = ["upload_url", "upload_local", "site_url"];

    foreach($keys as $key)
      if(empty($this->settings[$key]))
        $this->Setting->save(array(
          'id' => $key,
          'value' => call_user_func($key)
        ));

    /* if(!empty($this->Auth->user('role')) && $this->Auth->user('role') == 'admin'){
        $site_visits = $this->site_visits();
        $this->set('site_visits',$site_visits);
        if ($this->request->params['controller']!='admin') {
            $this->redirect('/admin');
        } 
    }*/

    $this->set(
      'version', 
      array( 
        'ver' => $version_count,
        'count' => \version_readable($version_count),
        'date' => $version_date,
        'text' => \version_readable($version_count) . ' (' . $version_date . ')'
      )
    );
  }

  public function addClick($id) {
    $this->loadModel('NewsletterScheduleItem');
    $this->NewsletterScheduleItem->updateAll(
      array(
        'NewsletterScheduleItem.clicks' => 'NewsletterScheduleItem.clicks + 1'          
      ), array(
        'id' => $id,
      )
    );    
  }

  public function sendEmail($data, $subject, $template) {    
    CakeLog::write('debug', 'sendEmail:'.json_encode(array(
      //'data' => $data,
      'subject' => $subject,
      'template' => $template,
      'remote_addr' => $_SERVER['REMOTE_ADDR'],
      'smtp' => array(
        'transport' => 'Smtp',
        'from' => array($this->settings['email_username'] => 'Châtelet'),
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'timeout' => 30,
        'username' => $this->settings['email_username'],
        'password' => $this->settings['email_password'],
        'charset' => 'utf-8',
        'tls' => true
      )
    )));

    $email = new CakeEmail();
    $email->config(array(
      'transport' => 'Smtp',
      'from' => array($this->settings['email_username'] => 'Châtelet'),
      'host' => 'smtp.gmail.com',
      'port' => 587,
      'timeout' => 30,
      'username' => $this->settings['email_username'],
      'password' => $this->settings['email_password'],
      'charset' => 'utf-8',
      'tls' => true
    ));

    // $email->transport('Debug');
    /*$email->from(array(
        'info@chatelet.com' => 'Châtelet'
    ));*/
    
    //pr($data);die;
    $email->to($data['receiver_email']);
    $email->subject($subject);
    $email->template($template, 'default');
    $email->emailFormat('html');
    // $email->config('default');
    $email->viewVars(array(
      'data' => $data,
      'site_url' => $this->settings['site_url'],
      'socials' => \parsed_socials($this->settings)
    ));

    if (
      $_SERVER['REMOTE_ADDR'] == '127.0.0.11' ||
      empty($data['receiver_email']))
    {
      // CakeLog::write('debug', 'email:'. json_encode($email->message('html')));
      return true;
    }

    return $email->send();
  }

  public function sendEmailMessage($message, $subject, $to){
    if ($this->settings['env_staging'] || empty($to)){
      return true;
    }

    $email = new CakeEmail();
    $email->config(array(
      'transport' => 'Smtp',
      'from' => array('no-responder@chatelet.com.ar' => 'Châtelet'),
      'host' => 'smtp.gmail.com',
      'port' => 587,
      'timeout' => 30,
      'username' => $this->settings['email_username'],
      'password' => $this->settings['email_password'],
      'charset' => 'utf-8',
      'tls' => true
    ));    
    $email->from(array(
        'info@chatelet.com' => 'Châtelet'
    )); 
    $email->to($to);
    $email->subject($subject);
    //$email->template($template, 'default');
    $email->emailFormat('html');
    $email->config('default');
    //$email->viewVars(array(
    //    'data' => $data
    //));
    return $email->send($message);
  }

  public function saveFile($file, $thumb = false, $size = 300, $folder = null) {
    
    $folder = !empty($folder) ? $folder . '/' : '';

    /* save file if any */
    $filepath = '';
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $key = uniqid() . '.' . $ext;
    $dest = __DIR__ . '/../webroot' . $this->settings['upload_url'] . $folder . $key;
    $url = "";

    if(copy($file['tmp_name'],$dest)){
      $filepath = $this->settings['upload_url'] . $folder . $key;
      if(!empty($this->settings['upload_local'])){
        $filepath = $key;
      }
    }

    if ($thumb) {
      $thumb_new_name = 'thumb_' . $key;
      $dest =__DIR__ . '/../webroot' . $this->settings['upload_url'] . $folder . $thumb_new_name;
      //Creamos thumbnail
      $this->ResizeImage->thumbnail($file['tmp_name'], $thumb_new_name, $size);
      if(!copy($file['tmp_name'],$dest)){
        CakeLog::write('error','Error al generar thumbnail:'.$dest);
      }
    }

    \d('a(2)',$filepath);

    return $filepath;
  }

  public function save_file($file, $withThumb = false, $size=300) {

    if (empty($file['name'])) {
      return false;
    }

    if($this->settings['upload_local']) {
      return $this->saveFile($file,$withThumb,$size);
    }
    
    $type = $file['type'];
    $tmp_name = $file['tmp_name'];
    $terms = explode('/', $type);
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < 25; $i++) {
      $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_name = $randomString.'.'.$ext;
    $upload = copy($tmp_name, $new_name);
	//$uploadToS3 = $this->S3->save($tmp_name, $new_name);
	//error_log('saved: '.$new_name);
    if ($withThumb) {
      $thumb_new_name = 'thumb_' . $new_name;
      //Creamos thumbnail
      $this->ResizeImage->thumbnail($tmp_name, $thumb_new_name, $size);
      $thumbUploadToS3 = $this->S3->save($tmp_name, $thumb_new_name);
		  error_log('saved: '.$thumb_new_name);
    }

    //$aux = explode(';', $uploadToS3);
    //$response = array_pop($aux);
    // return $uploadToS3;
    return $upload;
  }

  function random_password() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
      $n = rand(0, $alphaLength);
      $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
  } 
}
