<?php

header('Content-Type: text/html; charset=utf-8');

require __DIR__ . '/../../functions.php';
require __DIR__ . '/../../Vendor/web-push/vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

App::uses('CakeEmail', 'Network/Email');

class NewsletterShell extends AppShell {
   public $uses = array(
    'User', 
    'Setting', 
    'Webpush', 
    'Newsletter',
    'NewsletterUser',
    'NewsletterSchedule', 
    'NewsletterProduct',
  );

  private $settings = [];
  private $daily_limit = 500;
  private $perminute = 20;
  
  public function main() {
    $this->settings = $this->loadSettings();
    if(empty($this->settings['newsletter_enabled'])) {
      print_r(array(
        'error' => "Newsletter is disabled"
      ));      
      return false;
    }
    $date = date('Y-m-d');
    $hour = date('H'); 
    $min = date('i'); 
    $email_sent = 0;
    $push_sent = 0;
    $newsletters = $this->NewsletterUser->find('all', array(
     'joins' => array(
        array(
          'table' => 'newsletter_schedules',
          'alias' => 'NewsletterSchedule',
          'type' => 'LEFT',
          'conditions' => array( 
            'NewsletterUser.schedule_id = NewsletterSchedule.id' ,
            // 'NewsletterUser.status' => 'pending',
          )
        ),
        array(
          'table' => 'newsletters',
          'alias' => 'Newsletter',
          'type' => 'LEFT',
          'conditions' => array( 
            'NewsletterSchedule.newsletter_id = Newsletter.id' ,
            // 'NewsletterUser.status' => 'pending',
          )
        ),
        array(
          'table' => 'newsletter_products',
          'alias' => 'NewsletterProduct',
          'type' => 'LEFT',
          'conditions' => array( 
            'NewsletterProduct.newsletter_id = Newsletter.id' ,
            // 'NewsletterUser.status' => 'pending',
          )
        ),
        array(
          'table' => 'users',
          'alias' => 'User',
          'type' => 'LEFT',
          'conditions' => array( 'NewsletterUser.user_id = User.id' )
        )
       ),
      'fields' => array(
        'NewsletterUser.id, NewsletterUser.user_id, Newsletter.id, Newsletter.title, Newsletter.body, Newsletter.show_prices, Newsletter.show_follow, NewsletterSchedule.send_email, NewsletterSchedule.send_push, User.name, User.surname, User.email'
      ),
      'conditions' => array( 
        'NewsletterUser.status' => "pending", 
        'NewsletterSchedule.enabled' => 1,
        'NewsletterSchedule.schedule_date <= ' => $date,
        'NewsletterSchedule.schedule_hour <= ' => $hour,
       ),
       'order' => array( 'NewsletterUser.created ASC' ),
       'group' => array( 'NewsletterUser.id' ),
       'limit' => $this->settings['newsletter_perminute'] ?? $perminute,
      )
    );

    foreach($newsletters as $newsletter) {
      // parse email
      $products = $this->NewsletterProduct->find('all', array(
        'joins' => array(
          array(
            'table' => 'products',
            'alias' => 'Product',
            'type' => 'LEFT',
            'conditions' => array( 'NewsletterProduct.product_id = Product.id' )
          ),
          array(
            'table' => 'categories',
            'alias' => 'Category',
            'type' => 'LEFT',
            'conditions' => array( 'Product.category_id = Category.id' )
          )
        ),
        'fields' => array(
          'Product.id, Product.name, Product.desc, Product.img_url, Product.price, Product.ribbon_color, Product.article, Product.mp_discount, Product.bank_discount, Product.discount, Category.id, Category.name'
        ),        
        'conditions' => array(
          'NewsletterProduct.newsletter_id' => $newsletter['Newsletter']['id']
        )
      ));

      $body = !empty($newsletter['Newsletter']['body']) ? 
        \parse_template(
          strip_tags(html_entity_decode($newsletter['Newsletter']['body'])), array(
            'name' => str_replace("\n",'',$newsletter['User']['name']),
            'surname' => str_replace("\n",'',$newsletter['User']['surname']),
            'birthday' => str_replace("\n",'',$newsletter['User']['birthday']),
            //'total' => str_replace(',00','',number_format($cart_totals['grand_total'], 0, ',', '.'))
          )
        ) : $newsletter['Newsletter']['body'];

      $newsletter['Newsletter']['body'] = $body;

      if($newsletter['NewsletterSchedule']['send_email'] == '1') {

        // generate links
        foreach($products as $i => $product) {
          $link = implode('/', array(
            // fix this 
            $this->settings['site_url'], 
            //'https://chatelet.com',
            'shop',
            'detalle',
            $product['Product']['id'],
            $product['Category']['id'],
            strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product['Product']['name'])))
          ));

          $products[$i]['Product']['link'] = $link .'?uid='.$newsletter['NewsletterUser']['id'];
        }

        $email = $this->sendEmail($newsletter, $products);

        if($email['sent']) {

          $this->NewsletterUser->save(
            array(
             'id' => $newsletter['NewsletterUser']['id'],
             'status' => 'sent',
             'email_sent' => $newsletter['NewsletterUser']['email_sent']+1,
            )
          );
          $email_sent++;      
        }
      }

      if($newsletter['NewsletterSchedule']['send_push'] == '1') {
        $pushes = $this->Webpush->find('all', 
          array(
            'conditions' => array(
              'user_id' => $newsletter['NewsletterUser']['user_id']
            )
          )
        );

        foreach($pushes as $push) {
          $push = $this->sendPush($newsletter, $push);
          if($push['sent']) {
            $this->NewsletterUser->save(
              array(
               'id' => $newsletter['NewsletterUser']['id'],
               'status' => 'sent',
               'push_sent' => $newsletter['NewsletterUser']['push_sent']+1,
              )
            );
            $push_sent++;
          }
        }
      }
    }

    print_r(array(
      'date' => $date,
      'hour' => implode(':',array($hour,$min)),
      'email_sent' => $email_sent,
      'push_sent' => $push_sent,
      'users' => count($newsletters)
    ));
  }

  public function sendPush($data, $push) {
    $push = array(
      'subscription' => Subscription::create( 
        json_decode($push['Webpush']['payload'], true) 
      ),
      'payload' => json_encode(
        array(
          'title' => $data['Newsletter']['title'],
          'body' => $data['Newsletter']['body'],
          'icon' => $this->settings['site_url'] . '/img/push-logo.png',
          'badge' => $this->settings['site_url'] . '/img/push-badge.png',
          'data' => array(
            'vibrate' => array(100, 200),
            'additionalData' => array(),
            'url' => $this->settings['site_url'] . '/newsletters/' . $data['NewsletterSchedule']['id'],
          ),
        )
      ),
    );

    $auth = [
      'VAPID' => [
        'subject' => $this->settings['vapid_subject'],
        'publicKey' => $this->settings['vapid_publicKey'],
        'privateKey' => $this->settings['vapid_privateKey']
      ],
    ];

    $webPush = new WebPush($auth);

    try {
      $webPush->queueNotification(
        $push['subscription'],
        $push['payload']
      );
      $report = $webPush->flush()->current();
      $is_success = $report->isSuccess();
      $response = $report->getResponseContent();
    } catch (\Throwable $th) {
      $is_success = false;
      $response = $th->getMessage();
    }

    return array(
      'sent' => $is_success,
      'response' => $response
    );
  }

  public function sendEmail($data, $products = array()) {
    $email = new CakeEmail();
    $email->config(
      array(
        'transport' => 'Smtp',
        'from' => array(
          $this->settings['newsletter_username'] => $this->settings['newsletter_name']
        ),
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'timeout' => 30,
        'username' => $this->settings['newsletter_username'],
        'password' => $this->settings['newsletter_password'],
        //'username' => $this->settings['email_username'],
        //'password' => $this->settings['email_password'],
        'charset' => 'utf-8',
        'tls' => true
      )
    );

    // $email->transport('Debug');
    /*$email->from(array(
      'info@chatelet.com' => 'Châtelet'
    ));*/

    /*print_r(array(
      'mail_data' => $data,
      'template' => $template
    ));*/

    $email->to($data['User']['email']);
    $email->subject($data['Newsletter']['title']);
    $email->template('newsletter', 'default');
    $email->emailFormat('html') ;
    // $email->config('default');
    $email->viewVars(array(
      'data' => $data,
      'products' => $products,
      'socials' => $data['Newsletter']['show_follow'] ? \parsed_socials($this->settings) : null,
      'site_url' => $this->settings['site_url'],
      'cdn_url' => 'https://chatelet.com.ar/files/uploads/'
    ));

    if ($_SERVER['REMOTE_ADDR'] === '127.0.0.11'){
      //CakeLog::write('debug', '[email title]:'. json_encode($data['Newsletter']['title']));   
      //CakeLog::write('debug', '[email body]:'. json_encode($email->message('html')));   
      $sent = true;
    } else {
      $sent = $email->send();
      /*print_r(array(
        'sent' => $sent,
      ));*/
    }

    return array(
      'sent' => $sent
    );
  }

  public function loadSettings(){
    $data = [];        
    $settings = $this->Setting->find('all');
    foreach($settings as $setting) {
      $data[$setting['Setting']['id']] = $setting['Setting']['value'];
    }
    return $data;
  }
}
