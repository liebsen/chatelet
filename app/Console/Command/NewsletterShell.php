<?php

class NewsletterShell extends AppShell {
   public $uses = array(
    'User', 
    'Newsletter',
    'NewsletterUser',
    'NewsletterSchedule', 
    'NewsletterProduct',
    'CakeEmail'
  );
  
  public function main() {

    $curr_date = date('Y-m-d');
    $curr_hour = date('H'); 

    $data = $this->NewsletterUser->find('all', array(
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
          'table' => 'users',
          'alias' => 'User',
          'type' => 'LEFT',
          'conditions' => array( 'NewsletterUser.user_id = User.id' )
        )
       ),
      'fields' => array(
        'NewsletterUser.*, User.name, User.surname, User.email'
      ),
      'conditions' => array( 
        'NewsletterUser.status' => "waiting", 
        'NewsletterSchedule.enabled' => 1,
        'NewsletterSchedule.schedule_date' => $curr_date,
        'NewsletterSchedule.schedule_hour' => $curr_hour,
        // 'Newsletter.exec_now' => 1 
       ),
       'order' => array( 'NewsletterUser.created ASC' )
      )
    );

    /* $email_data = array(
      'id_user' => 1,
      'receiver_email' => $email,
      'name' =>  'Prueba',
    ); */

    $response = array();

    /*foreach($data as $i => $newsletter) {
      $reponse[$i] = $this->sendEmail($newsletter);
    }*/

    print_r(array(
      'reponse' => $response,
      'count' => count($data)
    ));
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
      $this->Newsletter->save(array(
         'id' => $data['Newsletter']['id'],
         'status' => 'sent'
      ));      
      return true;
    }

    $sent = $email->send();

    if($sent) {
      $this->Newsletter->save(array(
         'id' => $data['Newsletter']['id'],
         'status' => 'sent'
      ));
    }

    return 1;
    
    // return array('sent' => $sent);
  }   
}
