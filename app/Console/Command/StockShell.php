<?php

App::uses('CakeEmail', 'Network/Email');

require __DIR__ . '/../../functions.php';

class StockShell extends AppShell {
  public $uses = array(
    'Setting', 
    'User', 
    'Product', 
    'Sale', 
    'SaleProduct'
  );

  private $response = array();
  private $total = 0;
  private $items = array();
  public function main() {
    $this->SQL = $this->Components->load('SQL');
    $this->loadModel('StockCount');
    $this->loadModel('Product');
    $all_stock = $this->SQL->general_stock();
    if (!empty($all_stock)){
      foreach ($all_stock as $row){
        $record = [];
        // echo "------\n".json_encode($row,true);
        $article_id = substr($row['cod_articulo'],0,strpos($row['cod_articulo'],'.'));
        //echo "article_id: ".$article_id;
        $existArticle = $this->Product->findByArticle($article_id);
        if (!empty($existArticle)){
          // CakeLog::write('debug',"exists article_id: ".json_encode($article_id));
          if ($row['cod_articulo'] === $article_id.'.0000'){
            $replaceNames = false;
            // update article name
            if ($replaceNames){
              $details_name = $this->SQL->product_name_by_article($article_id);
              CakeLog::write('debug',"die_general_stock(details): ".json_encode($details_name));
            }
              // update article stock
            if($replaceNames){
              $this->Product->updateAll(
                array(
                  'Product.stock_total' => (int)$row['cantidad'],
                  'Product.name' => "'". (string)@$row['nombre'] ."'",
                  //'Product.desc' => "'". (string)@$details_name['Descripcion'] ."'"
                ),
                array('Product.article' => $article_id)
              );
            }else{
              $this->Product->updateAll(
                array(
                  'Product.stock_total' => (int)$row['cantidad'],
                  'Product.desc' => "'". (string)@$row['Descripcion'] ."'"
                  //'Product.name' => "'". (string)@$details_name['nombre'] ."'"
                ),
                array('Product.article' => $article_id)
              );
            }
            echo "article_id updated: ".$article_id;
            CakeLog::write('debug',"Detail(updated): ".json_encode($article_id));
          }
          //
          $exists = $this->StockCount->findByCodArticulo($row['cod_articulo']);
          if (!empty($exists)){
            $record['id'] = $exists['StockCount']['id'];
          }else{
            $this->StockCount->create();
          }
          $record['article_id'] = $article_id;
          $record['cod_articulo'] = $row['cod_articulo'];
          $record['stock'] = (int)$row['cantidad'];
          //$record['desc'] = (string)$row['Descripcion'];
          CakeLog::write('debug',"Saving: ".json_encode($record));
          // $success = $this->StockCount->save($record);
          if (!$success){
            echo "\r\nFailed to save";
          }
        }else{
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
