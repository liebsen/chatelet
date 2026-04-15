<?php

class NewsletterController extends AppController {
	public $uses = array(
		'Analytic',
		'Search',
		'Stat',
		'Product', 
		'User',
		'NewsletterScheduleItem',
		'Newsletter',
		'NewsletterSchedule',
		'NewsletterList',
		'NewsletterProduct',
		'NewsletterUser'
	);

	public $helpers = array(
		'Number', 
		'App', 
		'Html'
	);
	
	// public $components = array('SQL', 'RequestHandler');
	public $components = array(
		'RequestHandler'
	);

	public function beforeFilter() {
  	parent::beforeFilter();
  	$this->layout = 'Emails/html/default';
	}

	public function index() {
		$id = @$this->request->params['id'] ?? 0;
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

    // check if needs redirect
    if($newsletter['Newsletter']['cta_url']) {
			$newsletter['Newsletter']['clicks'] = $newsletter['Newsletter']['clicks'] + 1;
			$this->NewsletterScheduleItem->save($newsletter);
    	header('Location: ' . $newsletter['Newsletter']['cta_url']);
    	return false;
    }

    if(!empty($newsletter['NewsletterProduct'])) {
      $products = array_column($newsletter, 'Product');
    }

    if(!empty($newsletter['Newsletter']['body'])) { 
      $parsed_body = \parse_template(
        $newsletter['Newsletter']['body'], array(
          'name' => $newsletter['User']['name'],
          'surname' => $newsletter['User']['surname'],
          'birthday' => $newsletter['User']['birthday'],
          'email' => $newsletter['User']['email'],
          'phone' => $newsletter['User']['telephone'],
          'address' => implode(' ', 
            array_filter(
              array_values(
                $newsletter['User']['street'],            
                $newsletter['User']['street_n'],            
                $newsletter['User']['floor'],            
                $newsletter['User']['depto'],
                '( ' . implode(' ', 
                  array_filter(
                    array_values(
                      $newsletter['User']['postal_address'],
                      $newsletter['User']['neighborhood'],
                      $newsletter['User']['city'],
                      $newsletter['User']['provice'],
                      $newsletter['User']['country']
                    )
                  )
                )
              )
            )
          )
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

	public function template($id) {
    $newsletter = $this->Newsletter->find('first', 
    	array(
	    	'recursive' => -1,
	      'joins' => array(
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
	            'User.id' => 1
	          )
	        )
	      ),
	      'fields' => array(
	        'Newsletter.id, Newsletter.title, Newsletter.body, Newsletter.show_price, Newsletter.show_social, Newsletter.send_email, Newsletter.send_push, User.name, User.surname, User.email, User.birthday, User.address, User.dni'
	      ),
	      'conditions' => array( 
	        'Newsletter.id' => $id, 
	      )
	    )
    );

    if(!empty($newsletter['NewsletterProduct'])) {
      $products = array_column($newsletter, 'Product');
    }

    if(!empty($newsletter['Newsletter']['body'])) { 
      $parsed_body = \parse_template(
        $newsletter['Newsletter']['body'], array(
          'name' => $newsletter['User']['name'],
          'surname' => $newsletter['User']['surname'],
          'birthday' => $newsletter['User']['birthday'],
          'email' => $newsletter['User']['email'],
          'phone' => $newsletter['User']['telephone'],
          'address' => implode(' ', 
            array_filter(
              array_values(
                $newsletter['User']['street'],            
                $newsletter['User']['street_n'],            
                $newsletter['User']['floor'],            
                $newsletter['User']['depto'],
                '( ' . implode(' ', 
                  array_filter(
                    array_values(
                      $newsletter['User']['postal_address'],
                      $newsletter['User']['neighborhood'],
                      $newsletter['User']['city'],
                      $newsletter['User']['provice'],
                      $newsletter['User']['country']
                    )
                  )
                )
              )
            )
          )
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
          $newsletter['Newsletter']['id']
        )
      )      
    );


    foreach($viewVars as $i => $var) {
    	$this->set($i, $var);
    }

		$this->render('/Emails/html/newsletter');
	}

	public function fix_stats() {
		echo '<pre>';
		$options = array(
			/*'conditions' => array(
				'Analytic.cart IS NOT NULL',
				'Analytic.user_id IS NOT NULL',
			),*/
			'limit' => $_GET['limit'] ?? 1,
			'offset' => $_GET['offset'] ?? 0,
			'order' => array(
				'Analytic.id ASC'
			)
		);
		$items = $this->Analytic->find('all', $options);
				var_dump($options);

		$saves = array();
		$db = $this->Stat->getDataSource();
		foreach($items as $item) {
			$context = null;

			if(!empty($item['Analytic']['cart'])) {
				$context = array(
					'page' => $item['Analytic']['page'],
					'cart' => json_decode($item['Analytic']['cart']),
					'cart_totals' => json_decode($item['Analytic']['cart_totals']),
				);
			}

			$save = array(
				'user_id' => !empty($item['Analytic']['user_id']) ? $item['Analytic']['user_id'] : 1,
				'tag' => str_replace('_','-',$item['Analytic']['tag']),
				'context' => json_encode($context),
				'created' => $item['Analytic']['created'],
			);

			array_push($saves, $save);
		}
		var_dump(count($saves));
		if(count($saves)) {
			$db->rawQuery('SET FOREIGN_KEY_CHECKS = 0;');
			$this->Stat->saveMany($saves);
			$db->rawQuery('SET FOREIGN_KEY_CHECKS = 1;');
		}
	}	

	public function fix_search() {
		echo '<pre>';
		$options = array(
			/*'conditions' => array(
				'Analytic.cart IS NOT NULL',
				'Analytic.user_id IS NOT NULL',
			),*/
			'limit' => $_GET['limit'] ?? 1,
			'offset' => $_GET['offset'] ?? 0,
			'order' => array(
				'Search.id ASC'
			)
		);
		$items = $this->Search->find('all', $options);
				var_dump($options);

		$saves = array();
		$db = $this->Stat->getDataSource();
		foreach($items as $item) {
			$context = null;

			if(!empty($item['Search']['name'])) {
				$context = array(
					'page' => $item['Search']['referer'],
					'result_count' => json_decode($item['Analytic']['cart']),
					'query' => $item['Search']['name'],
				);
			}

			$save = array(
				'user_id' => !empty($item['Search']['user_id']) ? $item['Search']['user_id'] : 1,
				'tag' => 'page-search',
				'context' => json_encode($context),
				'created' => $item['Search']['created'],
			);

			array_push($saves, $save);
		}
		var_dump(count($saves));
		if(count($saves)) {
			$db->rawQuery('SET FOREIGN_KEY_CHECKS = 0;');
			$this->Stat->saveMany($saves);
			$db->rawQuery('SET FOREIGN_KEY_CHECKS = 1;');
		}
	}		

	public function fix_search_null() {
		echo '<pre>';
		$options = array(
			'conditions' => array(
				'Stat.tag' => 'page-search',
				//'Stat.context IS NULL',
				//'Stat.context' => 'NULL',
				// 'Stat.id' => array('220168','220169'),
			),
			'limit' => $_GET['limit'] ?? 1,
			'offset' => $_GET['offset'] ?? 0,
			'order' => array(
				'Stat.id ASC'
			)
		);

		$items = $this->Stat->find('all', $options);
				var_dump(count($items));
				\d("count",count($items));

		$saves = array();
		$db = $this->Stat->getDataSource();
		foreach($items as $item) {
			if($item['Stat']['context'] == 'null') {
				array_push($saves, $item);
			}
			
		}
		var_dump(count($saves));
		if(count($saves)) {
			$db->rawQuery('SET FOREIGN_KEY_CHECKS = 0;');
			$this->Stat->deleteMany($saves);
			$db->rawQuery('SET FOREIGN_KEY_CHECKS = 1;');
		}
	}		
}
