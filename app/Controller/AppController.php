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
        $this->Auth->allow();
        $this->set('loggedIn', $this->Auth->loggedIn());
        $this->set('user', $this->Auth->user());
        $carro = $this->Session->read('Carro');
        $this->set('carro', $carro);

        Configure::write('client_id', '6773841105361656');
        Configure::write('client_secret', 'hBHd6LiSEaTqgQXI2KSGO5C7uCBSINhW');

        $this->loadModel('Setting');
        $a = $this->Setting->findById('stock_min');
        $b = $this->Setting->findById('list_code');
        
        Configure::write('stock_min', @$a['Setting']['value']);
        Configure::write('list_code', @$b['Setting']['value']);

        if(!empty($this->Auth->user('role')) && $this->Auth->user('role') == 'admin'){
            $site_visits = $this->site_visits();
            $this->set('site_visits',$site_visits);
            if ($this->request->params['controller']!='admin') {
                $this->redirect('/admin');
            }
            
        }

        $this->loadModel('Setting');
        $setting    = $this->Setting->findById('show_shop');
        $show_shop  = (!empty($setting['Setting']['value'])) ? 1 : 0;
        $this->set('show_shop',$show_shop);


        $setting_menu    = $this->Setting->findById('image_menushop');
        $image_menushop = (!empty($setting_menu['Setting']['value'])) ? $setting_menu['Setting']['value'] : '';
        $this->set('image_menushop',$image_menushop);
    }

  
    public function sendEmail($data, $subject, $template) {
        if (empty($data['receiver_email'])){
            return true;
        }

        $Email = new CakeEmail();
        $Email->from(array(
            'info@chatelet.com' => 'Chatelet'
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


    protected function save_file($file, $withThumb = false) {
        if (empty($file['name'])) {
            return false;
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
        $uploadToS3 = $this->S3->save($tmp_name, $new_name);
        if ($withThumb) {
            $thumb_new_name = 'thumb_' . $new_name;
            //Creamos thumbnail
            $this->ResizeImage->thumbnail($tmp_name, $thumb_new_name, 100);
            $thumbUploadToS3 = $this->S3->save($tmp_name, $thumb_new_name);
        }
        //$aux = explode(';', $uploadToS3);
        //$response = array_pop($aux);
        return $uploadToS3;
    }
}
