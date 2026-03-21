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
  );

  private $settings = [];
  
  public function main() {

    $this->settings = $this->loadSettings();
    $curr_date = date('Y-m-d');
    $curr_hour = date('H'); 
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
        'NewsletterUser.id, NewsletterUser.user_id, Newsletter.title, Newsletter.body, Newsletter.show_prices, Newsletter.show_follow, NewsletterSchedule.send_email, NewsletterSchedule.send_push, User.name, User.surname, User.email'
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
      // parse email
      $newsletter['Newsletter']['body'] = !empty($newsletter['Newsletter']['body']) ? 
        \parse_template($newsletter['Newsletter']['body'], array(
          'name' => str_replace("\n",'',$newsletter['User']['name']),
          'surname' => str_replace("\n",'',$newsletter['User']['surname']),
          'birthday' => str_replace("\n",'',$newsletter['User']['birthday']),
          //'total' => str_replace(',00','',number_format($cart_totals['grand_total'], 0, ',', '.'))
        )
      ) : $newsletter['Newsletter']['body'];

      if($newsletter['NewsletterSchedule']['send_email'] == '1') {
        $email = $this->sendEmail($newsletter);

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
    /* $email_data = array(
      'id_user' => 1,
      'receiver_email' => $email,
      'name' =>  'Prueba',
    ); */

    /*foreach($data as $i => $newsletter) {
      $reponse[$i] = $this->sendEmail($newsletter);
    }*/

    print_r(array(
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
          'title' => strip_tags($data['Newsletter']['title']),
          'body' => strip_tags($data['Newsletter']['body']),
          'icon' => $this->settings['site_url'] . '/img/logo.png',
          'data' => array(
            'vibrate' => array(100, 200),
            'additionalData' => array(),
            'url' => \site_url() . '/newsletters/' . $newsletter['NewsletterSchedule']['id'],
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

    var_dump("title", $data['Newsletter']['title']);
    var_dump("body",$data['Newsletter']['body']);
    $email->to($data['User']['email']);
    $email->subject($data['Newsletter']['title']);
    $email->template('newsletter', 'default');
    $email->emailFormat('html');
    $email->config('default');
    $email->viewVars(array(
      'data' => $data
    ));

    if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1'){
      //CakeLog::write('debug', '[email title]:'. json_encode($data['Newsletter']['title']));   
      //CakeLog::write('debug', '[email body]:'. json_encode($email->message('html')));   
      $sent = true;
    } else {
      $sent = $email->send();
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
