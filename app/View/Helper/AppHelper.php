<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper {

  var $helpers = array('Html', 'Number');  // include the HTML helper

  /**
  * @param string $query, This is the search query you will pass from the view
  */
  function tile($item, $isProduct = false, $legends) {
    $str = '';
    $stock = (!empty($item['stock_total']))?(int)$item['stock_total']:0;
    $number_ribbon = 0;
    
    if (isset($item['discount_label_show'])){
      $number_ribbon = (int) @$item['discount_label_show'];
    }
    if (isset($item['mp_discount']) && $item['mp_discount'] > $number_ribbon){
      $number_ribbon = (int) @$item['mp_discount'];
    }
    if (isset($item['bank_discount']) && $item['bank_discount'] > $number_ribbon){
      $number_ribbon = (int) @$item['bank_discount'];
    }

    $discount_flag = (@$item['category_id']!='134' && !empty($number_ribbon))?'<div class="ribbon bottom-left small sp1"><span>'.$number_ribbon.'% OFF</span></div>':'';
    $promo_ribbon = (!empty($item['promo']))?'<div class="ribbon sp1"><span>'.$item['promo'].'</span></div>':'';
    $content= '<div class="ribbon-container">';
    $content.= $discount_flag . $promo_ribbon;

    if (empty($item['with_thumb'])){
      $content.= '<img class="img-responsive contain-xs"  src="'. Configure::read('imageUrlBase') . $item['img_url'] .'" />';
    }else{
      $content.= '<img class="img-responsive contain-xs"  src="'. Configure::read('imageUrlBase') . 'thumb_'.$item['img_url'] .'" url-copy="'.Configure::read('imageUrlBase') . $item['img_url'].'" onError=updateSrcTo(this) />';
    }
    $content.= '</div>';

    if ($isProduct){
       $content.='<span class="hide">'. '<small>'. $item['desc'] .'</small>'. '</span>';
    }
    $url = array(
      'controller' => 'tienda',
      intval($item['id'])
    );

    if (!empty($item['category_id'])) {
      $url[] = ($item['category_id']);
      $url[] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $item['name'])));

    }

    if ($isProduct) {
      $url['action'] = 'producto';
    } else {
      $url['action'] = 'productos';
    }

    $item_name = $item['name'];
    $priceStr = '';
    $priceStr.= self::show_prices_dues($legends, $item);

    if(!$stock && $isProduct){
      $content.= '<div class="desc-cont">'.
        '<div class="desc-prod">'.
          '<small>'. $item['desc'] .'</small>'.
        '</div>'.
        '<div class="name">'.$item_name.'</div>' . 
        '<div class="price-list">'. $priceStr .'</div>
        </div>
      </div>';
      $str = '<div class="col-sm-6 col-md-4 col-lg-3 p-1">'.
        '<img src="'.Router::url('/').'images/agotado3.png" class="out_stock" />'.
        $this->Html->link(
        $content,
        $url,
        array('escape' => false)
      );
    } else {
    // list of products.
     
      $number_ribbon = 10;
      /*
      $desc_30 = ['I9141', 'I8508','I8601','I9020','I9064','I9024','I9023','I9175','I9030','I9034','I9055','I9062','I9026','I9049','I9059','I9140','I9519','I9115','I9119','I9516','I9099','I9162','I9145','I9134','I9131','I9018','I9102','I9122','I9010','I9117','I9124'];
      if (in_array(strtoupper((string)@$item['article']), $desc_30,false)) {
        $number_ribbon = 30;
      }
      $desc_20 = ['I0044', 'I7624', 'I0069', 'I0115', 'I0052', 'I0020', 'I0022', 'I0004', 'I0038', 'I0065', 'I0074', 'I0082','I8034','I8074','I0013','I0002','I0003','I0005','I0008','I0009','I0011','I0012','I0014','I0016','I0017','I0018','I0023','I0024','I0027','I0028','I0029','I0030','I0032','I0033','I0034','I0035','I0037','I0039','I0041','I0042','I0043','I0045','I0046','I0049','I0055','I0056','I0058','I0059','I0060','I0070','I0075','I7625','I0084','I0089','I0099','I0104','I0105','I0107'];
      if (in_array(strtoupper((string)@$item['article']), $desc_20,false)) {
        $number_ribbon = 20;
      }

      if (in_array(strtoupper((string)@$item['article']), array('I0117','I0116'),false)) {
        $number_ribbon = 0;
      }
      */

      $str = '<div data-id="'.$item["id"].'" class="col-sm-6 col-md-4 col-lg-3 p-1 add-no-stock">'. 
         $this->Html->link(
          $content. '<div class="name">'.$item_name.'</div><div class="price-list">'.$priceStr.'</div><span style="display:none">'.@$item['article'].'</span></div>',
          $url,
          array('escape' => false)
        );
    }
    return $str;
  }

  function show_prices_dues($legends, $item, $noprice = false){
    $price = (float) @$item['price'];
    $old_price = (float) @$item['old_price'];
    $str = '';

    if(empty($price)) {
      $price = $old_price;
    }

    // price
    if(!$noprice) {
      if(!empty($item['old_price']) && abs($price-$old_price) === 0) {
        $str.= '<span class="old_price"> $ '.\price_format($old_price) . '</span>';
      }
      $str.= '<span class="price_strong"> $ ' . \price_format($price) . '</span>';
    }

    //$str.='<div class="legends-spacer"></div>';
    // discounts
    $str.='<div class="legends-container"><div class="legends' . ($noprice ? ' legends-left' : '') . '">';
    if(@$item['bank_discount']){
      $str.= "<span class='text-legend full-w'><span>-".@$item['bank_discount']."%</span> <span class='text-success price_strong'> $ " .\price_format(ceil(round($price * (1 - (float) $item['bank_discount'] / 100))))." </span><span class='text-sm'>con transferencia</span></span>";
    }
    if($item['mp_discount']){
      $str.= "<span class='text-legend full-w'><span>-".@$item['mp_discount']."%</span><span class='text-success price_strong'> $ " .\price_format(ceil(round($price * (1 - (float) $item['mp_discount'] / 100))))." </span><span class='text-sm'>con mercadopago</span></span>";
    }

    // dues
    for ($i=0; $i<count($legends); $i++) {
      $legend = $legends[$i];
      $interest = (float) $legend['Legend']['interest'];
      $min_sale = (float) $legend['Legend']['min_sale'];
      //$formatted_price = str_replace(',00','',$this->Number->currency(ceil($price/$legend['Legend']['dues']), 'ARS', array('places' => 2)));

      $wprice = $price;

      if(!empty($interest)){
        $wprice = round($price * (1 + $interest / 100));
      }
      
      if($price >= $min_sale) {
        //$status = intval($legend['Legend']['interest']) ? 'warning' : 'info';
        //$str.= "<span class='badge badge-{$status}'>". $legend['Legend']['dues'] ." cuotas</span>";
        $str.= '<span class="text-legend">' . @str_replace(['{cuotas}','{interes}','{monto}'], [
          $legend['Legend']['dues'],
          $legend['Legend']['interest'],
          '<span class="text-success price_strong"> $ ' . \price_format(ceil((!empty($interest) ? round($wprice * (1 + (float) $legend['Legend']['interest'] / 100)) : $wprice)/$legend['Legend']['dues'])) . '</span>'
        ],
        $legend['Legend']['title']) . '</span>';
      }
    }
    $str.= '</div></div>';
    return $str;
  }

  /*
  function parse_legend_table($legends, $price){
    $price = (float) $price;
    $str = '';
    $str.="<table class='table table-condensed table-sm table-striped text-muted'>";
    $str.="<thead class='thead-dark'><tr>
      <th class='text-center'>Cuotas</th>
      <th class='text-center'>Monto</th>
      <th class='text-center'>Interés</th>
    </tr></thead><tbody>";
    foreach ($legends as $legend) {
      $dues = $legend['Legend']['dues'];
      $interest = (float) $legend['Legend']['interest'];
      $min_sale = (float) $legend['Legend']['min_sale'];
      $formatted_price = str_replace(',00','',$this->Number->currency(ceil($price/$legend['Legend']['dues']), 'ARS', array('places' => 2)));

      if(!empty($interest)){
        $price = round($price * (1 + $interest / 100));
      }
      $interest_icon = $interest ? 'check' : 'times';
      if($price >= $min_sale) {
        $str.= "<tr>
          <td class='text-center'>{$dues}</td>
          <td class='text-center'>{$formatted_price}</td>
          <td class='text-center'><i class='fa fa-{$interest_icon}'></i></td>
        </tr>";
      }
    }
    $str.= "</tbody></table>";
    return $str;
  }*/
}
