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

	public function schedule() {
		$this->autoRender = false;

		$id = @$this->request->params['id'] ?? 0;
		$products = array();
		$parsed_body = '';
		$filter_type = '';
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
        'NewsletterScheduleItem.id, NewsletterScheduleItem.user_id, Newsletter.id, Newsletter.title, Newsletter.body, Newsletter.show_price, Newsletter.show_text, Newsletter.show_social,Newsletter.show_header,Newsletter.show_cta, Newsletter.cta_text, Newsletter.cta_url, NewsletterList.name, NewsletterList.filter, Newsletter.send_email, Newsletter.send_push, User.name, User.surname, User.email, User.birthday, User.telephone, User.address, User.postal_address, User.neighborhood, User.city, User.province, User.country'
      ),
      'conditions' => array( 
        'NewsletterScheduleItem.id' => $id, 
        'NewsletterSchedule.enabled' => 1,
        'NewsletterList.enabled' => 1
       )
      )
    );

		$this->addClick($id, $this->request->query['click_origin']);

  	$filter = json_decode($newsletter['NewsletterList']['filter']);
  	$filter_type = $filter->filter->type ?? null;

  	if ($filter_type == 'carts') {
      $items = $this->Stat->find('all',array(
        'conditions' => array(
          'Stat.tag' => 'page-exit',
          'Stat.user_id' => $newsletter['NewsletterScheduleItem']['user_id'],
          'JSON_EXTRACT(context, "$.cart") IS NOT NULL',
        ),
        'fields' => array('Stat.created, Stat.context'),
        'order' => array('Stat.id DESC'),
        'limit' => 1, // last cart only
      ));

      if(count($items)) {
	      $context = json_decode($items[0]['Stat']['context'],true);
	      #recreate cart from stats
	      $this->Session->write('cart', $context['cart']);	
	      $this->Session->write('cart_totals', $context['cart_totals']);	
	    	header('Location: ' . '/carrito');
	    	return false;
	    }
  	}
    elseif($newsletter['Newsletter']['show_cta'] == '1' && strlen($newsletter['Newsletter']['cta_url'])) {
			$newsletter['Newsletter']['clicks'] = $newsletter['Newsletter']['clicks'] + 1;
			$this->NewsletterScheduleItem->save($newsletter);
    	header('Location: ' . $newsletter['Newsletter']['cta_url']);
    	return false;
    }

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
        'NewsletterProduct.newsletter_id' => $newsletter['Newsletter']['id']
      )
    ));

    if(!empty($newsletter['Newsletter']['body'])) { 
      $parsed_body = \parse_template(
        $newsletter['Newsletter']['body'], 
        $newsletter['User']
      );
    }

    $newsletter['Newsletter']['parsed_body'] = $parsed_body;
    $newsletter['NewsletterList']['filter_type'] = $filter_type;

    foreach($products as $i => $product) {
      $products[$i]['Product']['link'] = implode('/', array(
        // fix this 
        $this->settings['site_url'], 
        //'https://chatelet.com',
        'shop',
        'detalle',
        $product['Product']['id'],
        $product['Category']['id'],
        strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product['Product']['name'])))
      ));
    }

    $viewVars = array(
      'data' => $newsletter,
      'products' => $products,
      'socials' => $newsletter['Newsletter']['show_social'] == '1' ? \parsed_socials($this->settings) : null,
      'site_url' => $this->settings['site_url'],
      'newsletter_text' => $this->settings['newsletter_text_enable'] == '1' ? 
        $this->settings['newsletter_text'] : 
        null,
      'skip_header' => (
      	$this->settings['newsletter_show_header'] != '1' || 
      	$newsletter['Newsletter']['show_header'] != '1'
      ) ?? null,
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
	          'table' => 'products',
	          'alias' => 'Product',
	          'type' => 'LEFT',
	          'conditions' => array( 
	            'NewsletterProduct.product_id = Product.id',
	            'Product.id IS NOT NULL'
	          )
	        ),
	        array(
	          'table' => 'users',
	          'alias' => 'User',
	          'type' => 'LEFT',
	          'conditions' => array( 
	            'User.id' => $this->Auth->user('id') ?? 1
	          )
	        )
	      ),
	      'fields' => array(
	        'Newsletter.id, Newsletter.title, Newsletter.body, Newsletter.show_price, Newsletter.show_text, Newsletter.show_social, Newsletter.show_header,Newsletter.show_cta, Newsletter.cta_text, Newsletter.cta_url, Newsletter.send_email, Newsletter.send_push, NewsletterProduct.id, Product.id, Product.name, Product.desc, User.id, User.name, User.surname, User.email, User.telephone, User.birthday, User.address, User.dni, User.address, User.postal_address, User.neighborhood, User.city, User.province, User.country'
	      ),
	      'conditions' => array( 
	        'Newsletter.id' => $id, 
	      )
	    )
    );

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
        'NewsletterProduct.newsletter_id' => $newsletter['Newsletter']['id']
      )
    ));

    if(!empty($newsletter['Newsletter']['body'])) { 
      $parsed_body = \parse_template(
        $newsletter['Newsletter']['body'], 
        $newsletter['User']
      );
    }

    $newsletter['Newsletter']['parsed_body'] = $parsed_body;

    foreach($products as $i => $product) {
      $products[$i]['Product']['link'] = implode('/', array(
        // fix this 
        $this->settings['site_url'], 
        //'https://chatelet.com',
        'shop',
        'detalle',
        $product['Product']['id'],
        $product['Category']['id'],
        strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product['Product']['name'])))
      ));
    }

    $viewVars = array(
      'data' => $newsletter,
      'products' => $products,
      'skip_header' => (
      	$this->settings['newsletter_show_header'] != '1' || 
      	$newsletter['Newsletter']['show_header'] != '1'
      ) ?? null,
      'socials' => (
      	$this->settings['newsletter_show_social'] == '1' && 
      	$newsletter['Newsletter']['show_social'] == '1'
      ) ? 
      \parsed_socials($this->settings) : 
      null,
      'site_url' => $this->settings['site_url'],
      'newsletter_text' => $this->settings['newsletter_text_enable'] == '1' ? 
        $this->settings['newsletter_text'] : 
        null,
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
