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
    'NewsletterSchedule', 
    'NewsletterList', 
    'NewsletterScheduleItem',
    'NewsletterProduct',
  );

  private $settings = [];
  private $daily_limit = 500;
  private $perminute = 20;
  private $simulate = 0;
  
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
    $limit = 0;
    $perminute = $this->settings['newsletter_perminute'] ?? $this->perminute;
    $this->simulate = in_array("simulate=1", $this->args);
    $this->update = in_array("update=1", $this->args);

    // FIND QUOTA
    $quota = $this->NewsletterScheduleItem->find('count', array(
      'conditions' => array(
        'NewsletterScheduleItem.status' => "sent",
        'NewsletterScheduleItem.modified > ' => date("Y/m/d H:00", strtotime("-24 hours")),
      )
    ));

    if($quota >= $this->daily_limit) {
      die("Daily limit reached. Aborting.");
    }

    //$daily_limit
    $newsletters = $this->NewsletterScheduleItem->find('all', array(
      'joins' => array(
        array(
          'table' => 'newsletter_schedules',
          'alias' => 'NewsletterSchedule',
          'type' => 'LEFT',
          'conditions' => array( 
            'NewsletterScheduleItem.schedule_id = NewsletterSchedule.id',
            'NewsletterSchedule.id IS NOT NULL'
          )
        ),
        array(
          'table' => 'newsletter_lists',
          'alias' => 'NewsletterList',
          'type' => 'LEFT',
          'conditions' => array( 
            'NewsletterSchedule.list_id = NewsletterList.id',
            'NewsletterList.id IS NOT NULL'
          )
        ),
        array(
          'table' => 'newsletters',
          'alias' => 'Newsletter',
          'type' => 'LEFT',
          'conditions' => array( 
            'NewsletterSchedule.newsletter_id = Newsletter.id',
            'Newsletter.id IS NOT NULL'
          )
        ),
        array(
          'table' => 'newsletter_products',
          'alias' => 'NewsletterProduct',
          'type' => 'LEFT',
          'conditions' => array( 
            'NewsletterProduct.newsletter_id = Newsletter.id',
            'Newsletter.id IS NOT NULL'
          )
        ),
        array(
          'table' => 'users',
          'alias' => 'User',
          'type' => 'LEFT',
          'conditions' => array( 
            'NewsletterScheduleItem.user_id = User.id',
            'User.id IS NOT NULL'
          )
        )
      ),
      'fields' => array(
        'NewsletterScheduleItem.id, NewsletterScheduleItem.user_id, Newsletter.id, Newsletter.title, Newsletter.body, Newsletter.show_prices, Newsletter.show_follow, NewsletterList.name, NewsletterSchedule.send_email, NewsletterSchedule.send_push, User.name, User.surname, User.email, User.birthday'
      ),
      'conditions' => array( 
        'NewsletterScheduleItem.status' => "pending", 
        'NewsletterSchedule.enabled' => 1,
        'NewsletterList.enabled' => 1,
        'NewsletterSchedule.schedule_date <= ' => $date,
        'NewsletterSchedule.schedule_hour <= ' => $hour,
       ),
       'order' => array( 'NewsletterScheduleItem.created ASC' ),
       'group' => array( 'NewsletterScheduleItem.id' ),
       'limit' => $perminute,
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

      // parse body
      $newsletter['Newsletter']['body'] = !empty($newsletter['Newsletter']['body']) ? 
        \parse_template(
          strip_tags(html_entity_decode($newsletter['Newsletter']['body'])), array(
            'name' => str_replace("\n",'',$newsletter['User']['name']),
            'surname' => str_replace("\n",'',$newsletter['User']['surname']),
            'birthday' => str_replace("\n",'',$newsletter['User']['birthday']),
            //'total' => str_replace(',00','',number_format($cart_totals['grand_total'], 0, ',', '.'))
          )
        ) : $newsletter['Newsletter']['body'];

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

          $products[$i]['Product']['link'] = $link .'?uid='.$newsletter['NewsletterScheduleItem']['id'];
        }


        $email = $this->sendEmail($newsletter, $products);

        if($email['sent']) {

          $this->NewsletterScheduleItem->save(
            array(
             'id' => $newsletter['NewsletterScheduleItem']['id'],
             'status' => 'sent',
             'email_sent' => $newsletter['NewsletterScheduleItem']['email_sent']+1,
            )
          );
          $email_sent++;      
        }
      }
      if($newsletter['NewsletterSchedule']['send_push'] == '1') {
        $pushes = $this->Webpush->find('all', 
          array(
            'conditions' => array(
              'user_id' => $newsletter['NewsletterScheduleItem']['user_id']
            )
          )
        );

        foreach($pushes as $push) {
          $push = $this->sendPush($newsletter, $push);
          if($push['sent']) {
            $this->NewsletterScheduleItem->save(
              array(
               'id' => $newsletter['NewsletterScheduleItem']['id'],
               'status' => 'sent',
               'push_sent' => $newsletter['NewsletterScheduleItem']['push_sent']+1,
              )
            );
            $push_sent++;
          }
        }

        if(empty($pushes)) {
          echo "[push] unsubscribed" . "\n";
        }
      }
    }

    print_r(array(
      'date' => $date,
      'perminute' => $perminute,
      'quota' => $quota,
      'hour' => implode(':',array($hour,$min)),
      'email_sent' => $email_sent,
      'push_sent' => $push_sent,
      'count' => count($newsletters)
    ));
  }

  public function sendPush($data, $push) {
    if($this->simulate) {
      echo "[push] " . $data['NewsletterScheduleItem']['name'] . '(' .$data['Newsletter']['title'] .'-'.$data['NewsletterList']['name'] .')'. "\n";
      return array(
        'sent' => $this->update,
        'response' => array()
      );
    }

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

    $viewVars = array(
      'data' => $data,
      'products' => $products,
      'socials' => $data['Newsletter']['show_follow'] ? \parsed_socials($this->settings) : null,
      'site_url' => $this->settings['site_url'],
      'cdn_url' => 'https://chatelet.com.ar/files/uploads/'
    );

    if($this->simulate) {
      $content = $email->template('newsletter', 'default')
          ->emailFormat('html')
          ->viewVars($viewVars)
          //->message('html');
          ->send(null, true);

      //$email_body = $content['message'];
      echo "[email] " . $data['User']['email'] . '(' .$data['Newsletter']['title'] .'-'.$data['NewsletterList']['name'] .')'. "\n";
      //echo $email_body;

      return array(
        'sent' => $this->update,
      );
    }

    $email->to($data['User']['email']);
    $email->subject($data['Newsletter']['title']);
    $email->template('newsletter', 'default');
    $email->emailFormat('html') ;
    $email->viewVars($viewVars);

    return array(
      'sent' => $email->send()
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
