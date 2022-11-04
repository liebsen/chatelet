<?php echo $this->Session->flash();
?>
<script>
function updateSrcTo(obj){
  obj.src = $(obj).attr('url-copy');
  obj.onerror = false;
}
</script>
<style>
.verifying-stock {
  position: absolute;
  text-align:center;
  width: 100%;
  z-index:1000;
  font-size: 13px;padding:8px;
  background: rgba(255,255,255,0.5);
  color: #999;
}
.desc-prod {
  text-align: center;
  font-weight: normal;
  text-transform: uppercase;
  color: #333;
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
  font-size: 16px;

  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 3; /* number of lines to show */
  line-height: 1.4;        /* fallback */
  max-height: 3;       /* fallback */
}
.desc-cont {
  height: 114px;
  overflow: hidden;
}

.old-price {
  color: #999;
  font-size:1.25rem;
}
.midscore{
  text-decoration:line-through;
}
</style>

<div id="headabrigos" >
  <h1 class="name_shop"><?php echo $name_categories; ?></h1>
  <div class="img-resp" style="background-image:url(<?php echo Configure::read('imageUrlBase').$image_prodshop ?>)"></div>  
</div>

<section id="productOptions">
    <div class="container-fluid">
        <div class="row">
            <div class="hidden-xs hidden-sm col-sm-3">
                <nav>
                    <ul>
                        <?php
                    foreach ($categories as $category) {
                        $category = $category['Category'];
                        $slug =  str_replace(' ','-',strtolower($category['name']));
                        if (strpos($slug, 'trajes')!==false){
                          $slug = 'trajes-de-bano';
                        }
                        echo '<li>';
                        echo $this->Html->link(
                            $category['name'],
                            array(
                                'controller' => 'tienda',
                                'action' => 'productos',
                                $slug
                            )
                        );
                        echo '</li>';
                    }
                   ?>
                    </ul>
                </nav>
            </div>

            <div class="col-sm-9">

  <?php
    function createSection($item, $ctrl, $isProduct = false) {
      $stock = (!empty($item['stock_total']))?(int)$item['stock_total']:0;
      $number_disc = 0;
      
      if (isset($item['discount_label_show'])){
        $number_disc = (int)@$item['discount_label_show'];
      }

      $discount_flag = (@$item['category_id']!='134' && !empty($number_disc))?'<div class="ribbon bottom-left small sp1"><span>'.$number_disc.'% OFF</span></div>':'';
      $promo_ribbon = (!empty($item['promo']))?'<div class="ribbon sp1"><span>'.$item['promo'].'</span></div>':'';
      $content = $discount_flag . $promo_ribbon;

      if (empty($item['with_thumb'])){
        $content.= '<img class="img-responsive contain-xs"  src="'. Configure::read('imageUrlBase') . $item['img_url'] .'" />';
      }else{
        $content.= '<img class="img-responsive contain-xs"  src="'. Configure::read('imageUrlBase') . 'thumb_'.$item['img_url'] .'" url-copy="'.Configure::read('imageUrlBase') . $item['img_url'].'" onError=updateSrcTo(this) />';
      }

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
        $priceStr = '';
        $item_name = \title_fontsize($item['name']);

        if (!empty($item['price'])){
          $priceStr = '$'. \price_format($item['price']);
          if (!empty(@$item['old_price']) && price_format($item['price']) !== price_format($item['old_price'])){
            $priceStr = '<span class="old_price">$'.\price_format($item['old_price']).'</span>' . $priceStr;
          }
        }
      } else {
        $url['action'] = 'productos';
      }

      if(!$stock && $isProduct){
        echo '<div class="col-sm-6 col-md-4 col-lg-3">'.
             '<img src="'.Router::url('/').'images/agotado3.png" class="out_stock" />'.
             $ctrl->Html->link(
          $content,
            $url,
          array('escape' => false)
        ).
        '<div class="desc-cont">'.
        '<div class="desc-prod">'.
          '<small>'. $item['desc'] .'</small>'.
        '</div>'.
        '<div class="name">'.$item_name.'</div>' . 
        '<div class="price text-theme">'. str_replace(',00','',$this->Number->currency($priceStr, 'ARS', array('places' => 2))) .'</div>
        </div></div>';
      } else {
      // list of products.
       
        $number_disc = 10;
        /*
        $desc_30 = ['I9141', 'I8508','I8601','I9020','I9064','I9024','I9023','I9175','I9030','I9034','I9055','I9062','I9026','I9049','I9059','I9140','I9519','I9115','I9119','I9516','I9099','I9162','I9145','I9134','I9131','I9018','I9102','I9122','I9010','I9117','I9124'];
        if (in_array(strtoupper((string)@$item['article']), $desc_30,false)) {
          $number_disc = 30;
        }
        $desc_20 = ['I0044', 'I7624', 'I0069', 'I0115', 'I0052', 'I0020', 'I0022', 'I0004', 'I0038', 'I0065', 'I0074', 'I0082','I8034','I8074','I0013','I0002','I0003','I0005','I0008','I0009','I0011','I0012','I0014','I0016','I0017','I0018','I0023','I0024','I0027','I0028','I0029','I0030','I0032','I0033','I0034','I0035','I0037','I0039','I0041','I0042','I0043','I0045','I0046','I0049','I0055','I0056','I0058','I0059','I0060','I0070','I0075','I7625','I0084','I0089','I0099','I0104','I0105','I0107'];
        if (in_array(strtoupper((string)@$item['article']), $desc_20,false)) {
          $number_disc = 20;
        }

        if (in_array(strtoupper((string)@$item['article']), array('I0117','I0116'),false)) {
          $number_disc = 0;
        }
        */

        echo '<div data-id="'.$item["id"].'" class="col-sm-6 col-md-4 col-lg-3 add-no-stock">'. 
           $ctrl->Html->link(
            $content,
            $url,
            array('escape' => false)
          ). '<div class="name">'.$item_name.'</div><div class="price text-theme">'.$priceStr.'</div><span style="display:none">'.@$item['article'].'</span>
          </div>';
      }
    }

    if (isset($products)) {
      foreach ($products as $product) {
        createSection($product['Product'], $this, true);
      }
    } else {
      foreach ($categories as $category) {
        createSection($category['Category'], $this);
      }
    }
  ?>



            </div>
            <div class="hidden-lg hidden-md visible-xs-* visible-sm-* col-sm-3 col-xs-12">
                <nav>
                    <ul>
                        <?php
                            foreach ($categories as $category) {
                                $category = $category['Category'];
                                $slug =  str_replace(' ',
                                '-',strtolower($category['name']));
                        if (strpos($slug, 'trajes')!==false){
                          $slug = 'trajes-de-bano';
                        }
                                echo '<li>';
                                echo $this->Html->link(
                                    $category['name'],
                                    array(
                                        'controller' => 'tienda',
                                        'action' => 'productos',
                                        $slug
                                    )
                                );
                                echo '</li>';
                            }
                           ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>

<section id="infoShop">
    <div class="wrapper">
        <div class="row">
            <div class="col-md-4 bx1">
                Las prendas que estan en el Shop como principal en cada rubro, no estan a la venta.
            </div>
            <div class="col-md-4 bx2 blr">
                Los cambios se realizan dentro de los 30 días de efectuada la compra en cualquiera de las sucursales presentando el ticket correspondiente.
            </div>
            <div class="col-md-4 bx3">
                Las prendas deben estar sin uso y con la etiqueta de código de barras correspondiente adherida.
            </div>
        </div>
    </div>
</section>
<script>
window.baseUrl = "<?=Router::url('/',true)?>";
// check stock
function checkStock(i){
  var item = $(product_list[i]);
  var product_id = $(item).data('id') || $(item).attr('data-id');
  var $html = '<img src="' + baseUrl + 'images/agotado3.png" class="out_stock" />';

   $.ajax({
        type: "GET",
        url: baseUrl + 'shop/check_stock/' + product_id,
        processData: false,
        contentType: false,
        cache: false,
        success: function(stock){
          if (stock=='empty'){
            $(item).prepend($html);
          }else{
            console.log(product_id + ' in stock')
          }
          $(item).find('.verifying-stock').remove();
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
   });
}
window.product_list = new Array()
fbq('trackCustom', 'ViewCategory', {
  id: '<?php echo $category_id;?>',
  name: '<?php echo $name_categories;?>'
})

dataLayer.push({
  'ecommerce': {
    'detail': {
      'actionField': {'list': '<?php echo $name_categories;?>'}
    }
  }
})

</script>
