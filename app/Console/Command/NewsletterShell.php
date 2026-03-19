<?php

App::uses('CakeEmail', 'Network/Email');

require __DIR__ . '/../../functions.php';
require __DIR__ . '/../../Vendor/web-push/vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class NewsletterShell extends AppShell {
   public $uses = array(
    'User', 
    'Setting', 
    'Webpush', 
    'Newsletter',
    'NewsletterUser',
    'NewsletterSchedule', 
    'NewsletterProduct',
    'CakeEmail'
  );

  private $settings = [];
  
  public function main() {

    $this->settings = $this->loadSettings();
    $curr_date = date('Y-m-d');
    $curr_hour = date('H'); 

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
        'Newsletter.title, Newsletter.body, Newsletter.show_prices, Newsletter.show_follow, NewsletterSchedule.send_email, NewsletterSchedule.send_push, User.name, User.surname, User.email'
      ),
      'conditions' => array( 
        //'NewsletterUser.status' => "waiting", 
        'NewsletterSchedule.enabled' => 1,
        'NewsletterSchedule.schedule_date' => $curr_date,
        'NewsletterSchedule.schedule_hour' => $curr_hour,
       ),
       'order' => array( 'NewsletterUser.created ASC' ),
       'group' => array( 'NewsletterUser.id' ),
      )
    );


    foreach($newsletters as $newsletter) {

    }
    /* $email_data = array(
      'id_user' => 1,
      'receiver_email' => $email,
      'name' =>  'Prueba',
    ); */

    /*foreach($data as $i => $newsletter) {
      $reponse[$i] = $this->sendEmail($newsletter);
    }*/

    print_r(array(
      'newsletters' => $newsletters,
      'count' => count($newsletters)
    ));
  }

  public function sendPush($sale) {
    $push = array(
      'subscription' => Subscription::create(
        array(
          'endpoint' => 'https://fcm.googleapis.com/fcm/send/djRg_IDPtSs:APA91bFwYCC73F4X3cXELK...',
          'keys' => array(
            'auth' => 'SPB_NNfRw...',
            'p256dh' => 'BP-WMuJdP7buopSb_HrNX...'
          )
        )
      ),
      'payload' => json_encode(
        array(
          'title' => "Hello",
          'body' => "How are you?",
          'icon' => "https://cdn-icons-png.flaticon.com/512/3884/3884851.png",
          'data' => array(
            'vibrate' => array(100, 200),
            'additionalData' => array(),
            'url' => "https://google.com",
          ),
        )
      ),
    );

    $auth = [
      'VAPID' => [
        'subject' => 'support@chatelet.com.ar', // can be a mailto: or your website address
        'publicKey' => 'BFrp-TvkuqCeNsytRt...', // (recommended) uncompressed public key P-256 encoded in Base64-URL
        'privateKey' => '9BvI1aN1CR4w4iceMS...', // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL
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

    if ($is_success) {
      echo "Push was sent";
    } else {
      echo "Push was not sent. Error message: " . $response;
    }    
  }

  public function sendEmail($data) {
    CakeLog::write('debug', 'sendEmail:'.json_encode(array(
      'data' => $data,
      'subject' => $subject,
      'template' => $template,
      'remote_addr' => $_SERVER['REMOTE_ADDR'],
    )));

    $email = new CakeEmail();
    // $email->transport('Debug');
    $email->from(array(
        'info@chatelet.com' => 'Châtelet'
    ));
    //pr($data);die;
    $email->to($data['User']['email']);
    $email->subject($data['Newsletter']['title']);
    $email->template('test_email', 'default');
    $email->emailFormat('html');
    $email->config('default');
    $email->viewVars(array(
      'data' => $data
    ));

    if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' || empty($data['receiver_email'])){
      // CakeLog::write('debug', 'email:'. json_encode($email->message('html')));
      $this->Newsletter->save(
        array(
         'id' => $data['Newsletter']['id'],
         'status' => 'sent'
        )
      );      
      return true;
    }

    $sent = $email->send();

    if($sent) {
      $this->Newsletter->save(
        array(
         'id' => $data['Newsletter']['id'],
         'status' => 'sent'
        )
      );
    }

    return 1;
    
    // return array('sent' => $sent);
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
