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

App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');

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

    private $setting_tags = [
      'stock_min',
      'list_code',
      'whatsapp_enabled',
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
        $this->loadModel('Setting');
        $tags = [];        
        $settings = $this->Setting->find('all');
        $data = [];
        $path = Router::url(null, false);

        foreach($settings as $setting) {
            $id = $setting['Setting']['id'];
            $value = $setting['Setting']['value'];
            $data[$id] = $value;

            if(!in_array($id, $this->setting_tags)) {
                continue;
            }

            if($setting  == 'whatsapp_enabled' &&(strstr($path, "carrito") || strstr($path, "checkout"))) {
                continue;
            }

            Configure::write($id, $value);
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
        //CakeLog::write('debug', 'beforeFilter executed for ' . $this->name . 'Controller::' . $this->action);
        $this->Auth->allow();
        $this->set('loggedIn', $this->Auth->loggedIn());
        $this->set('user', $this->Auth->user());
        $this->set('carro', $this->Session->read('cart'));
        $config = $this->Session->read('cart_totals');
        // ensure certain config entries...
        if(empty($config['add_basket'])){
            $config['add_basket'] = 0;
        }
        
        if(empty($config['payment_method'])){
            $config['payment_method'] = 'mercadopago';
        }

        $this->set('config', $config);
        $this->loadModel('Menu');
        $this->loadModel('Banner');
        $this->loadModel('Category');
        $this->loadModel('Product');

        $banners = $this->Banner->find('all', [
          'conditions' => ['enabled' => 1, 'title <>' => ''],
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

        // 'Fira Sans Condensed', 'Sniglet','Roboto Condensed', 'Archivo Narrow'
        $version_file = __DIR__ . '/../version';
        $version_count = 1111;

        if(file_exists($version_file)) {
            $version_date = date("\~ \U\A d/m/Y H:i\h", filemtime($version_file));
            $version_count = (int) file_get_contents($version_file);
        }

        if (isset($_REQUEST['font'])) {
            $this->Session->write('font',urldecode($_REQUEST['font']));
        }

        if (isset($_REQUEST['exitfont'])) {
            $this->Session->delete('font');
        }

        //Configure::write('client_id', '6773841105361656');
        //Configure::write('client_secret', 'hBHd6LiSEaTqgQXI2KSGO5C7uCBSINhW');

        $this->loadModel('Setting');

        $data = $this->load_settings();        

        $this->set('data', $data);

        /* if(!empty($this->Auth->user('role')) && $this->Auth->user('role') == 'admin'){
            $site_visits = $this->site_visits();
            $this->set('site_visits',$site_visits);
            if ($this->request->params['controller']!='admin') {
                $this->redirect('/admin');
            } 
        }*/

        $version_short = number_format($version_count / 10000, 2);
        $this->set('version_text', str_replace('.0', '', $version_short) . ' ' . $version_date);
    }

    public function sendEmail($data, $subject, $template) {
        if (empty($data['receiver_email']) || $_SERVER['REMOTE_ADDR'] == '127.0.0.1'){
            return true;
        }

        $Email = new CakeEmail();
        $Email->from(array(
            'info@chatelet.com' => 'Châtelet'
        ));
        //pr($data);die;
        $Email->to($data['receiver_email']);
        $Email->subject($subject);
        $Email->template($template, 'default');
        $Email->emailFormat('html');
        $Email->config('default');
        $Email->viewVars(array(
            'data' => $data
        ));
        $Email->send();

    }

    public function sendMail($message, $subject, $to)
    {
        $Email = new CakeEmail();
        $Email->from(array(
            'info@chatelet.com' => 'Châtelet'
        )); 
        $Email->to($to);
        $Email->subject($subject);
        //$Email->template($template, 'default');
        $Email->emailFormat('html');
        $Email->config('default');
        //$Email->viewVars(array(
        //    'data' => $data
        //));
        $Email->send($message);
    }


    private function saveFile($file, $thumb = false, $size = 300) {
        /* save file if any */
        $filepath = '';
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $key = uniqid() . '.' . $ext;
        $dest = __DIR__ . '/../webroot' . Configure::read('uploadUrl') . $key;
        $url = "";

        if(copy($file['tmp_name'],$dest)){
          $filepath = Configure::read('uploadUrl') . $key;
          if(!empty(Configure::read('uploadLocal'))){
            $filepath = $key;
          }
        }

        if ($thumb) {
            $thumb_new_name = 'thumb_' . $key;
            $dest = __DIR__ . '/../webroot/files/uploads/' . $thumb_new_name;
            //Creamos thumbnail
            $this->ResizeImage->thumbnail($file['tmp_name'], $thumb_new_name, $size);
            if(!copy($file['tmp_name'],$dest)){
                error_log('Error al generar thumbnail',$dest);
            }
        }

        return $filepath;
    }

    protected function save_file($file, $withThumb = false, $size=300) {

        if (empty($file['name'])) {
            return false;
        }

        if(Configure::read('uploadLocal')) {
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
