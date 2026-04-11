<?php
App::import('Controller', 'Facebook');
App::uses('CakeText', 'Utility');
App::uses('Security', 'Utility');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class ApiController extends AppController {
	public $helpers = array('Text');
	public $components = array("RequestHandler");

	public function beforeFilter() {
  	parent::beforeFilter();
  	$this->autoRender = false;

  	header("Content-Type: application/json");
    $this->Auth->allow('subscriptions');
	}
	
	public function sucursales() {
    $this->RequestHandler->respondAs('application/json');
		$this->loadModel('Store');
		$stores = $this->Store->find('all',array('order'=>array('Store.name ASC')));
		return json_encode($stores);
	}

	//get , http://www.chatelet.com.ar/api/subscriptions
  public function subscribe(){
    $this->loadModel('Webpush'); 

    if($this->Auth->user('id') && $this->request->is('post')){
      CakeLog::write('debug', 'webpush(user_id):'.json_encode($this->Auth->user('id')));
      CakeLog::write('debug', 'webpush(data):'.json_encode($this->request->data));
      $this->Webpush->save(
        array(
          'user_id' => $this->Auth->user('id'),
          'payload' => json_encode($this->request->data),
        )
      );

      return json_encode(
        array(
          'success' => true, 
          'message', 'Gracias por suscribirte'
        )
      );
    }

    return json_encode(
      array(
        'success' => false, 
        'message', 'No se pudo suscribir al usuario'
      )
    );
  }

  public function ckupload(){
    $func_number = $_GET['CKEditorFuncNum'] ;
    $folder = 'newsletters';
    $url = '';
    $message = '';
    if (isset($_FILES['upload']) && $_FILES['upload']['size']) {
      $url = $this->saveFile($_FILES['upload'], false, 0, $folder);
    }
    $full = $this->settings['site_url'] . $this->settings['upload_url'] . $folder . '/' . $url;
    echo "<script type='text/javascript'> window.parent.CKEDITOR.tools.callFunction($func_number, '$full', '$message')</script>";
  }

  public function search_products(){
    $this->autoRender = false;
    $this->RequestHandler->respondAs('application/json');

    $this->loadModel('Product');
    $this->loadModel('Search');
    $this->loadModel('Legend');

    // legends
    $legends_map = $this->Legend->find('all', [
      'conditions' => ['enabled' => 1],
      'order' => ['Legend.dues ASC']
    ]);

    $q = $this->request->data['q'];
    $p = $this->request->data['p'] ? intval($this->request->data['p']) : 0;
    $s = $this->request->data['s'] ? intval($this->request->data['s']) : 10;
    //$query = $this->Product->query("SELECT count(*)  as count FROM products WHERE products.name LIKE '%$q%' OR products.desc LIKE '%$q%'")[0];
    $data = $this->Product->find('all',[
      'conditions' => [
        'or' => [
          'Product.name LIKE' => "%$q%",
          'Product.desc LIKE' => "%$q%",
          'Product.promo' => "$q",
        ],
        'visible' => 1,
        'stock_total > ' => 0
      ],
      'order' => ['Product.promo DESC'],
      'limit' => $s,
      'offset' => $s * $p
    ]);

    $results = [];

    foreach($data as $item) {
      $row = $item['Product'];
      $price = ceil($row['price']);
      $discount = ceil($row['discount']);
      $old_price = null;
      $number_ribbon = 0;
      $mp_price = 0;
      $bank_price = 0;
      $discounts = [];
      $legends = [];

      // dues
      for ($i=0; $i<count($legends_map); $i++) {
        $legend = $legends_map[$i];
        $interest = (float) $legend['Legend']['interest'];
        $min_sale = (float) $legend['Legend']['min_sale'];
        //$formatted_price = str_replace(',00','',$this->Number->currency(ceil($price/$legend['Legend']['dues']), 'ARS', array('places' => 2)));

        $monto = $price;

        if(!empty($interest)){
          $monto = round($price * (1 + $interest / 100));
        }
        
        if($price >= $min_sale) {
          //$status = intval($legend['Legend']['interest']) ? 'warning' : 'info';
          //$str.= "<span class='badge badge-{$status}'>". $legend['Legend']['dues'] ." cuotas</span>";
          $legends[]= (object) [
            'price' => ceil($monto / $legend['Legend']['dues']),
            'text' => @str_replace(['{cuotas}','{interes}', '{monto}'], [$legend['Legend']['dues'], $legend['Legend']['interest'],''],$legend['Legend']['title'])
          ];
        }
      }

      if(!empty($row['bank_discount'])){
        $legends[]= (object) [
          'price' => ceil(round($price * (1 - (float) $row['bank_discount'] / 100))),
          'text' => 'transferencia',
          'discount' => @$row['bank_discount']
        ];
      }

      if(!empty($row['mp_discount'])){
        $legends[]= (object) [
          'price' => ceil(round($price * (1 - (float) $row['mp_discount'] / 100))),
          'text' => 'mercadopago',
          'discount' => @$row['mp_discount']
        ];
      }

      if (isset($discount) && abs($discount-$price) > 1) {
        $old_price = $price;
        $price = $discount;
      }

      if(!empty(@$row['discount_label_show'])) {
        $number_ribbon = $row['discount_label_show'];
      }

      if(!empty(@$row['mp_discount'])) {
        $number_ribbon = $row['mp_discount'];
        $mp_price = \price_format(ceil(round($price * (1 - (float) $row['mp_discount'] / 100))), true);
      }

      if(!empty(@$row['bank_discount'])) {
        $number_ribbon = $row['bank_discount'];
        $bank_price = \price_format(ceil(round($price * (1 - (float) $row['bank_discount'] / 100))), true);
      }

      $result = [
        'id' => $row['id'],
        'price' => \price_format($price, true),
        'category_id' => $row['category_id'],
        'name' => $row['name'],
        'desc' => $row['desc'],
        'promo' => $row['promo'],
        'legends' => $legends,
        'mp_discount' => $row['mp_discount'],
        'bank_discount' => $row['bank_discount'],
        'number_ribbon' => intval($number_ribbon),
        'slug' => str_replace(' ','-',strtolower($row['desc'])),
        'img_url' => $settings['upload_url'] . $row['img_url']
      ];

      if(!empty($mp_price)){
        $result['mp_price'] = \price_format($mp_price, true);
      }
      if(!empty($bank_price)){
        $result['bank_price'] = \price_format($bank_price, true);
      }
      if(!empty($old_price)){
        $result['old_price'] = \price_format($old_price, true);
      }

      $results[]= $result;
    }

    return json_encode([
      'results' => $results,
      //'query' => $query
    ]);

    // save search
    $search = [];
    $search['name'] = $q;
    $search['user_id'] = $this->Auth->user('id') ?: 0;
    $search['created'] = date('Y-m-d H:i:s');
    $search['referer'] = $_SERVER['HTTP_REFERER'];
    $search['page'] = $p+1;
    $search['results'] = count($results);

    $this->Search->save($search);
    exit();   
  }
  
  public function subscriptions(){
    $this->loadModel('Subscription'); 
    $result = array();
    if (!empty($this->request->is('get'))) {
      $Subscriptions = $this->Subscriptions->find('all',array('order'=>array('Subscriptions.id DESC')));

      if(!empty($Subscriptions)){  
        foreach($Subscriptions as &$item){
          $result[] = $item['Subscriptions'];
        }

        header('200, SUBSCRIPTIONS_UNSUCCESSFUL');
        return(json_encode($result));   
      } else {
        header('409, SUBSCRIPTIONS_UNSUCCESSFUL');
        die(json_encode(array(
          "detail"=>"Subscriptions queried unsuccessfully",
          "code"=>"SUBSCRIPTIONS_UNSUCCESSFUL"
        )));  
      }
    }
  }

  public function emails(){
    if(empty($this->Auth->user('id'))) {
      return json_encode(
        array(
          'status' => "error", 
          'errors' => "El usuario está sin autentificar"
        )
      );
    }

    if(empty($this->Auth->user->isAdmin())) {
      return json_encode(
        array(
          'status' => "error", 
          'errors' => "El usuario no es administrador"
        )
      );
    }

    $this->loadModel('Email'); 
    $result = array();
    // if (!empty($this->request->is('get'))) {
    $Emails = $this->Email->find('all',array('order'=>array('Email.id DESC')));
    if(!empty($Emails)){  
      foreach($Emails as &$item){
        $result[] = $item['Subscriptions'];
      }
    }
    return(json_encode($result));
  }

  public function stats(){
    $this->autoRender = false;
    $this->loadModel('Analytic');
    $data = $this->request->data;
    $cart = $this->Session->read('cart') ?? 0;
    $cart_totals = $this->Session->read('cart_totals') ?? 0;
    $page = $data['page'] ?? '/';
    $tag = $data['tag'] ?? 'page-exit';
    $user_id = $this->Auth->user('id') ?? 0;
    $product_id = !empty($data['product_id']) ? intval($data['product_id']) :  0;

    // save entry
    $entry = array(
      'tag' => $tag,
      'user_id' => $user_id,
      'product_id' => $product_id,
      'page' => $page
    );

    // $analytic['created'] = date('Y-m-d H:i:s');
    if(!empty($cart)){
      $entry['cart'] = json_encode($cart);
    }

    if(!empty($cart_totals)){
      $entry['cart_totals'] = json_encode($cart_totals);
    }

    CakeLog::write('debug', "analytics:".json_encode($data));

    $this->Analytic->save($entry);   
    exit(); 
  }
}
