<?php

require __DIR__ . '/../../functions.php';

App::uses('CakeEmail', 'Network/Email');
App::uses('ComponentCollection', 'Controller');
App::uses('SQL', 'Controller/Component');

class StockShell extends AppShell {
  public $uses = array(
    'Setting', 
    'Stat',
    'User', 
    'Product', 
    'ProductProperty', 
    'Sale', 
    'SaleProduct',
    'StockCount'
  );

  private $response = array();
  private $total = 0;
  private $items = array();

  public function getOptionParser() {
    $parser = parent::getOptionParser(); 
    $parser->addOption('include', array(
      'short' => 's',
      'help' => 'Specify product ids',
      'default' => 'all'
    ));
    return $parser;
  }

  public function main() {
  	$include = $this->params['include']; 
  
		if(is_numeric($include)) {
			return $this->stock_product($include);
		}

		return $this->stock_all();
  }

  private function stock_product($prod_id){
  	echo "\r\n stock_product " . $prod_id;
  	$collection = new ComponentCollection();
		$this->SQL = $collection->load('SQL');
		$prod = $this->Product->findById($prod_id);
		$save_updated = array();

		if(empty($prod)) {
			return json_encode(
				array(
					'status' => "error", 
					'message' => 'No se encontró el producto' 
				)
			);
		}
		echo "\r\n stock_product (1)";
		$sizes = $this->ProductProperty->find('all', 
			array(
				'conditions' => array(
					'product_id' => $prod_id,
					'type' => 'size'
				)
			)
		);
		echo "\r\n stock_product (2)";

		$colors = $this->ProductProperty->find('all', 
			array(
				'conditions' => array(
					'product_id' => $prod_id,
					'type' => 'color'
				)
			)
		);

		$article = $prod['Product']['article'];
		$variations = array();
		$save_failed = array();
		echo "\r\n stock_product (3)";
		foreach($sizes as $size) {
			echo "\r\n stock_product (4)". $size['ProductProperty']['variable'];
			foreach($colors as $color) {

				$cod_articulo = $article.'.'.$size['ProductProperty']['variable'].$color['ProductProperty']['code'];

			  $stock = $this->SQL->product_stock(
			  	$article,
			  	$size['ProductProperty']['variable'],
			  	$color['ProductProperty']['code'],
			  	$this->settings['list_code'],
			  	$this->settings['stock_min']
			  );

	      $exists = $this->StockCount->findByCodArticulo($cod_articulo);
	      $record = array();

	      if (!empty($exists)){
	        $record['id'] = $exists['StockCount']['id'];
	      } else {
	        $this->StockCount->create();
	      }

	      $record['article_id'] = $article;
	      $record['cod_articulo'] = $cod_articulo;
	      $record['stock'] = $stock;
	      $success = $this->StockCount->save($record);
	      if (!$success){
	      	$save_failed[] = $cod_articulo;
	      } else {
	      	$save_updated[] = $cod_articulo;
	      }
		  }
		}

		$message = 'Stock actualizado. Variantes: ' . count($save_updated) . '. Errores: ' . count($save_failed);		

		echo json_encode(
			array(
				'status' => "success", 
				'save_updated' => $save_updated,
				'save_failed' => $save_failed,
				'message' => $message
			)
		);
		
		$this->_stop();	
  }

  private function stock_all(){
  	echo "\n stock_all";
    $collection = new ComponentCollection();
    $this->SQL = $collection->load('SQL');
    $all_stock = $this->SQL->general_stock();
    //$prod_saved = array();
    //$prod_all = array();
    //$prod_ignore = array();
    if (!empty($all_stock)){
      foreach ($all_stock as $row){
        $record = [];
        $article_id = substr($row['cod_articulo'],0,strpos($row['cod_articulo'],'.'));
        $existArticle = $this->Product->findByArticle($article_id);
        //$prod_all[]= $article_id;
        if (!empty($existArticle)){
          if ($row['cod_articulo'] === $article_id.'.0000'){
            $replaceNames = false;
            // update article name
            if ($replaceNames){
              $details_name = $this->SQL->product_name_by_article($article_id);
            }
           	// update article stock
            if($replaceNames){
              $this->Product->updateAll(
                array(
                  'Product.stock_total' => (int)$row['cantidad'],
                  'Product.name' => "'". (string)@$row['nombre'] ."'",
                ),
                array('Product.article' => $article_id)
              );
            }else{
              $this->Product->updateAll(
                array(
                  'Product.stock_total' => (int)$row['cantidad'],
                  'Product.desc' => "'". (string)@$row['Descripcion'] ."'"
                ),
                array('Product.article' => $article_id)
              );
            }
            echo "\r\n" . $row['cod_articulo'] . " (updated)";
            //$prod_saved[]= $article_id;
          }
          $exists = $this->StockCount->findByCodArticulo($row['cod_articulo']);
          if (!empty($exists)){
            $record['id'] = $exists['StockCount']['id'];
          } else {
            $this->StockCount->create();
          }

          $stock = (int) $row['cantidad'];
          $record['article_id'] = $article_id;
          $record['cod_articulo'] = $row['cod_articulo'];
          $record['stock'] = $stock;
          $success = $this->StockCount->save($record);
          
          if (!$success){
            echo "\r\nFailed to save";
          } else {
          	echo "\r\n" . $row['cod_articulo'] . " (stock) " . $stock;	
          }
        } else {
        	//$prod_ignore[]= $article_id;
        	echo "\r\n" . $row['cod_articulo'] . " (ignored)";
          //  echo "\r\nArticle {$article_id} not needed";
        }
      }
    } else {
      echo "\r\nGeneral stock response is empty.";
    }

    return true;
  }

  public function load_settings(){
    $tags = [];        
    $settings = $this->Setting->find('all');
    $path = Router::url(null, false);
    foreach($settings as $setting) {
      $id = $setting['Setting']['id'];
      $value = $setting['Setting']['value'];
      $data[$id] = $value;
    }
    return $data;
  }
}
