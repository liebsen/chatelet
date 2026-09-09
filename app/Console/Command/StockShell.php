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
    'Sale', 
    'SaleProduct',
    'StockCount'
  );

  private $response = array();
  private $total = 0;
  private $items = array();
  
  public function main() {
    $collection = new ComponentCollection();
    $this->SQL = $collection->load('SQL');
    $all_stock = $this->SQL->general_stock();
    $prod_saved = array();
    if (!empty($all_stock)){
      foreach ($all_stock as $row){
        $record = [];
        $article_id = substr($row['cod_articulo'],0,strpos($row['cod_articulo'],'.'));
        $existArticle = $this->Product->findByArticle($article_id);
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
            echo "saved:".$article_id;
            $prod_saved[]= $article_id;
          }
          $exists = $this->StockCount->findByCodArticulo($row['cod_articulo']);
          if (!empty($exists)){
            $record['id'] = $exists['StockCount']['id'];
          } else {
            $this->StockCount->create();
          }
          $record['article_id'] = $article_id;
          $record['cod_articulo'] = $row['cod_articulo'];
          $record['stock'] = (int)$row['cantidad'];
          var_dump("here saves", $record);
          // $success = $this->StockCount->save($record);
          if (!$success){
            echo "\r\nFailed to save";
          }
        } else {
          //  echo "\r\nArticle {$article_id} not needed";
        }
      }
    }else{
      echo "\r\nGeneral stock response is empty.";
    }
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
