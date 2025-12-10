<?php

class NewsletterShell extends AppShell {
   public $uses = array('User', 'Newsletter','NewsletterUser', 'CakeEmail');
   public function main() {

      $data = $this->Newsletter->find('all', array(
       'joins' => array(
        array(
          'table' => 'newsletter_users',
          'alias' => 'NewsletterUser',
          'type' => 'LEFT',
          'conditions' => array( 'NewsletterUser.newsletter_id = Newsletter.id' )
        ),
        array(
          'table' => 'users',
          'alias' => 'User',
          'type' => 'LEFT',
          'conditions' => array( 'NewsletterUser.user_id = User.id' )
        )
       ),
      'fields' => array('Newsletter.*, User.name, User.surname, User.email'),
         'conditions' => array( 
            'Newsletter.status' => "waiting", 
            'Newsletter.enabled' => 1
            // 'Newsletter.exec_now' => 1 
         ),
         //'order' => array( 'Product.price ASC' )
      ));


      /* $email_data = array(
        'id_user' => 1,
        'receiver_email' => $email,
        'name' =>  'Prueba',
      ); */

      $reponse = array();

      foreach($data as $i => $newsletter) {
         $reponse[$i] = $this->sendEmail($newsletter);
      }

      return json_encode(array(
         'reponse' => $response
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
