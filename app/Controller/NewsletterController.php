<?php

class NewsletterController extends AppController {
	public $uses = array(
		'Product', 
		'User',
		'NewsletterScheduleItem',
		'Newsletter',
		'NewsletterSchedule',
		'NewsletterList',
		'NewsletterProduct',
		'NewsletterUser'
	);

	public $helpers = array('Number', 'App', 'Html');
	// public $components = array('SQL', 'RequestHandler');
	public $components = array('RequestHandler');

	public function beforeFilter() {
  	parent::beforeFilter();
  	$this->layout = 'Emails/html/default';
	}
	public function index() {
		$id = @$this->request->params['id']??0;
		$products = array();
		$parsed_body = '';
    $newsletter = $this->NewsletterScheduleItem->find('first', array(
    	'recursive' => -1,
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
        'NewsletterScheduleItem.id, NewsletterScheduleItem.user_id, Newsletter.id, Newsletter.title, Newsletter.body, Newsletter.show_price, Newsletter.show_social, NewsletterList.name, Newsletter.send_email, Newsletter.send_push, User.name, User.surname, User.email, User.birthday'
      ),
      'conditions' => array( 
        'NewsletterScheduleItem.id' => $id, 
        'NewsletterSchedule.enabled' => 1,
        'NewsletterList.enabled' => 1
       )
      )
    );

    if(!empty($newsletter['NewsletterProduct'])) {
      $products = array_column($newsletter, 'Product');
    }

    if(!empty($newsletter['Newsletter']['body'])) { 
      $parsed_body = \parse_template(
        $newsletter['Newsletter']['body'], array(
          'name' => str_replace("\n",'',$newsletter['User']['name']),
          'surname' => str_replace("\n",'',$newsletter['User']['surname']),
          'birthday' => str_replace("\n",'',$newsletter['User']['birthday']),
        )
      );
    }

    $newsletter['Newsletter']['parsed_body'] = $parsed_body;

    $viewVars = array(
      'data' => $newsletter,
      'products' => $products,
      'socials' => $newsletter['Newsletter']['show_social'] ? \parsed_socials($this->settings) : null,
      'site_url' => $this->settings['site_url'],
      'newsletter_text' => $this->settings['newsletter_text'],
      'skip_header' => !$this->settings['newsletter_show_header'] ?? null,
      'cdn_url' => 'https://chatelet.com.ar/files/uploads/',
      'self_link' => implode('/', 
        array(
          $this->settings['site_url'],
          'newsletter',
          $newsletter['NewsletterScheduleItem']['id']
        )
      )      
    );

    foreach($viewVars as $i => $var) {
    	$this->set($i, $var);
    }

		$this->render('/Emails/html/newsletter');
	}
}
