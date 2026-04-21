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
    'Stat',
    'Product', 
    'Setting', 
    'Webpush', 
    'Newsletter',
    'NewsletterSchedule', 
    'NewsletterList', 
    'NewsletterScheduleItem',
    'NewsletterProduct',
  );

  private $settings = [];
  private $perday = 500;
  private $perminute = 20;
  private $simulate = 0;

  protected function _welcome() {
      // Leave empty to suppress the header
  }  

  public function main() {
    $this->settings = $this->loadSettings();

    if($this->settings['newsletter_enabled'] != '1') {
      echo "Newsletter is disabled";
      return false;
    }

    $date = date('Y-m-d');
    $hour = date('H'); 
    $min = date('i'); 
    $email_sent = 0;
    $push_sent = 0;
    $limit = 0;
    $perminute = $this->settings['newsletter_perminute'] ?? $this->perminute;
    $perday = $this->settings['newsletter_perday'] ?? $this->perday;
    $this->simulate = in_array("simulate=1", $this->args);
    $this->showmail = in_array("showmail=1", $this->args);
    $this->update = in_array("update=1", $this->args);

    #echo "\nStarting process: " . implode(':',array($hour,$min)) . "\n";
    // FIND QUOTA
    $quota = $this->NewsletterScheduleItem->find('count', array(
      'conditions' => array(
        'NewsletterScheduleItem.status' => "sent",
        'NewsletterScheduleItem.modified > ' => date("Y/m/d H:00", strtotime("-24 hours")),
      )
    ));

    if($quota >= $perday) {
      die("Daily limit reached. Aborting.");
    }

    if($perday - $quota < $perminute) {
      $perminute = $perday - $quota;
    }

    $schedules = $this->NewsletterScheduleItem->find('all', array(
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
        'NewsletterScheduleItem.id, NewsletterScheduleItem.user_id, Newsletter.id, Newsletter.title, Newsletter.body, Newsletter.message, Newsletter.show_price, Newsletter.show_text, Newsletter.show_social, Newsletter.show_header,Newsletter.show_cta, Newsletter.cta_text, Newsletter.cta_url, NewsletterList.name, NewsletterList.filter, Newsletter.send_email, Newsletter.send_push, User.name, User.surname, User.email, User.birthday'
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

    foreach($schedules as $schedule) {
      $products = array();
      $products_ids = array();
      $parsed_body = '';
      $filter = json_decode($schedule['NewsletterList']['filter']);

      if($filter->filter->type == 'carts') {
        \d('cart',$schedule['NewsletterScheduleItem']['user_id']);
        $items = $this->Stat->find('all',array(
          'joins' => array(
            array(
              'table' => 'users',
              'alias' => 'User',
              'type' => 'LEFT',
              'conditions' => array(
                'User.id = Stat.user_id',
              )
            )
          ),
          'conditions' => array(
            'User.email IS NOT ' => null,
            'JSON_EXTRACT(context, "$.cart") IS NOT NULL',
            'Stat.user_id' => $schedule['NewsletterScheduleItem']['user_id'],
          ),
          'fields' => array('Stat.context'),
          'order' => array('Stat.id DESC'),
          'limit' => 500,
        ));

        if(!empty($items)) {
          foreach($items as $item) {
            $context = json_decode($item['Stat']['context'], true);
            if(!empty($context['cart'])) {
              foreach($context['cart'] as $cart_item) {
                if(!in_array($cart_item['id'], $products_ids)) {
                  array_push($products_ids, $cart_item['id']);
                }
              }
            }
          }

          \d('products_ids',$products_ids);
          if(!empty($products_ids)) {
            $products = $this->Product->find('all', 
              array(
                'joins' => array(
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
                  'Product.id' => $products_ids
                )
              )
            );
          }
        }
      } 

      if(empty($products)) {
        $products = $this->NewsletterProduct->find('all', array(
          'joins' => array(
            array(
              'table' => 'products',
              'alias' => 'Product',
              'type' => 'LEFT',
              'conditions' => array(
                'NewsletterProduct.product_id = Product.id'
              )
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
            'NewsletterProduct.newsletter_id' => $schedule['Newsletter']['id']
          )
        ));
      }

      if(!empty($schedule['Newsletter']['body'])) { 
        $parsed_body = \parse_template(
          $schedule['Newsletter']['body'], 
          $schedule['User']
        );
      }

      $schedule['Newsletter']['parsed_body'] = $parsed_body;

      if($schedule['Newsletter']['send_email'] == '1') {
        // generate links
        foreach($products as $i => $product) {
          $products[$i]['Product']['link'] = implode('/', array(
            // fix this 
            $this->settings['site_url'], 
            //'https://chatelet.com',
            'shop',
            'detalle',
            $product['Product']['id'],
            $product['Category']['id'],
            strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product['Product']['name']))) . '?uid='.$schedule['NewsletterScheduleItem']['id']
          ));
        }

        $email = $this->sendEmail($schedule, $products);

        if($email['sent']) {
          $this->NewsletterScheduleItem->save(
            array(
             'id' => $schedule['NewsletterScheduleItem']['id'],
             'status' => 'sent',
             'email_sent' => $schedule['NewsletterScheduleItem']['email_sent']+1,
            )
          );
          $email_sent++;      
        }
      }

      if($schedule['Newsletter']['send_push'] == '1') {
        $pushes = $this->Webpush->find('all', 
          array(
            'conditions' => array(
              'user_id' => $schedule['NewsletterScheduleItem']['user_id']
            )
          )
        );

        foreach($pushes as $push) {
          $push = $this->sendPush($schedule, $push);
          if($push['sent']) {
            $this->NewsletterScheduleItem->save(
              array(
               'id' => $schedule['NewsletterScheduleItem']['id'],
               'status' => 'sent',
               'push_sent' => $schedule['NewsletterScheduleItem']['push_sent']+1,
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

    if(count($schedules)){
      print_r(
        array(
          'date' => implode(' ', 
            array(
              $date,
              implode(':',array($hour,$min))
            )
          ),
          'quota' => $quota,
          'perminute' => $perminute,
          'perday' => $perday,
          'email_sent' => $email_sent,
          'push_sent' => $push_sent,
          'products' => count($products),
          'schedules' => count($schedules)
        )
      );
    }
  }

  public function sendPush($data, $push) {
    if($this->simulate) {
      echo "[push] " . $data['Newsletter']['title'] . '(' .$data['Newsletter']['message'] .'-'.$data['NewsletterList']['name'] .')'. "\n";
      return array(
        'sent' => $this->update,
        'response' => array()
      );
    }

    $fallback_url = implode('/', 
      array(
        $this->settings['site_url'],
        'newsletter',
        $data['NewsletterScheduleItem']['id']
      )
    );

    $payload = array(
      'title' => $data['Newsletter']['title'],
      'body' => $data['Newsletter']['message'] ?? '',
      'icon' => $this->settings['site_url'] . ($this->settings['newsletter_icon'] ? 
        $this->settings['upload_url'] . $this->settings['newsletter_icon'] : 
        '/img/push-logo.png'
      ),
      'badge' => $this->settings['site_url'] . ($this->settings['newsletter_badge'] ? 
        $this->settings['upload_url'] . $this->settings['newsletter_badge'] : 
        '/img/push-badge.png'
      ),
      'data' => array(
        'vibrate' => array(100, 200),
        'additionalData' => array(),
        'url' => $data['Newsletter']['show_cta'] == '1' ? 
          $data['Newsletter']['cta_url'] : 
          $fallback_url
      ),
    );

    $image = \extract_jpeg_url($data['Newsletter']['body']);
    
    if(!empty($image)) {
      $payload['image'] = $image;
    }

    \d("payload",$payload);

    $push = array(
      'subscription' => Subscription::create( 
        json_decode($push['Webpush']['payload'], true) 
      ),
      'payload' => json_encode($payload),
    );

    $auth = array(
      'VAPID' => array(
        'subject' => $this->settings['vapid_subject'],
        'publicKey' => $this->settings['vapid_public_key'],
        'privateKey' => $this->settings['vapid_private_key']
      ),
    );

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
    $config = array(
      'transport' => $this->settings['newsletter_transport'] ?? 'Smtp',
      'from' => array(
        $this->settings['newsletter_username'] => $this->settings['newsletter_name']
      ),
      'host' => $this->settings['newsletter_host'] ?? 'smtp.gmail.com',
      'port' => (int) $this->settings['newsletter_port'] ?? 587,
      'timeout' => (int) $this->settings['newsletter_timeout'] ?? 30,
      'username' => $this->settings['newsletter_username'] ?? '',
      'password' => $this->settings['newsletter_password'] ?? '',
      'charset' => $this->settings['newsletter_charset'] ?? 'utf-8',
      'tls' => $this->settings['newsletter_tls'] == '1',
    );

    $email->config($config);

    $viewVars = array(
      'data' => $data,
      'products' => $products,
      'socials' => $data['Newsletter']['show_social'] ? 
        \parsed_socials($this->settings) : 
        null,
      'site_url' => $this->settings['site_url'],
      'newsletter_text' => $this->settings['newsletter_text_enable'] == '1' ? 
        $this->settings['newsletter_text'] : 
        null,
      'skip_header' => (
        $this->settings['newsletter_show_header'] != '1' || 
        $schedule['Newsletter']['show_header'] != '1'
      ) ?? null,
      'cdn_url' => 'https://chatelet.com.ar/files/uploads/',
      'self_link' => implode('/', 
        array(
          $this->settings['site_url'],
          'newsletter',
          $data['NewsletterScheduleItem']['id']
        )
      )      
    );

    if($this->simulate) {
      $message = $email->template('newsletter', 'default')
        ->emailFormat('html')
        ->viewVars($viewVars)
        ->send(null, true);

      echo "[email] " . $data['User']['email'] . '(' .$data['Newsletter']['title'] .'-'.$data['NewsletterList']['name'] .')'. "\n";

      if($this->showmail) {
        var_dump($message);
      }

      return array(
        'sent' => $this->update
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
