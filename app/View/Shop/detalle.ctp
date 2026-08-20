<?php

echo $this->Html->script('product.js?v=' . $version['ver'], array('inline' => false));
echo $this->Html->script('detalle.js?v=' . $version['ver'], array('inline' => false));

if($cloudzoom) {
  echo $this->Html->script('wow.min');
  echo $this->Html->script('cloudzoom.js?v=' . $version['ver'], array('inline' => false));
  echo $this->Html->css('cloudzoom.css?v=' . $version['ver'], array('inline' => false));
}

/*
galleryFade:!0,
galleryHoverDelay:200,
permaZoom:!1,
zoomWidth:0,
zoomHeight:0,
lensWidth:0,
lensHeight:0,
hoverIntentDelay:0,
autoInside:0,
disableOnScreenWidth:0,
touchStartDelay:0,
*/

echo $this->Session->flash();
?>
<script>
  var itemData = <?=json_encode($product, JSON_PRETTY_PRINT)?>;
  var colorImages = <?=json_encode($colorImages, JSON_PRETTY_PRINT)?>;
  window.isGiftCard = <?=(int)$isGiftCard?>;
</script>
<section id="main">
  <div class="wrapper">
    <div class="container">
      <div class="row">
      <?php if(!empty($colorImages)):?>
        <div class="col-md-6 p-0 d-flex flex-md-column flex-md-center justify-content-end align-items-start bg-light">
          <div class="p-0">
            <ul id="ul-moreviews" class="m-0">
            <?php if (!empty($colorImages[0]['images']) && count(array_filter($colorImages[0]['images'])) > 1): $ppp=0; ?>
            <?php foreach ($colorImages[0]['images'] as $key => $value) : ?>
            <?php if(!empty($value)): $ppp++;?>
              <li class="dontResize"><a href="#"><img class="demo w3-opacity w3-hover-opacity-off img-responsive"
                onclick="currentDiv(<?=$ppp;?>)" title="ck_image_<?=$ppp?>"  id="img_01" src="<?=$settings['upload_url'].'thumb_'.$value?>"></a></li>
            <?php endif;?>
            <?php endforeach ?>
            <?php endif;?>
            </ul>
          </div>        
          <div class="is-product-photo"><?php 
            $number_ribbon = 0;
            $ribbon_style = '';        
            if (!empty($product['old_price']) && round($product['old_price']) != round($product['price'])){
              $number_ribbon = round((1 - $product['price'] / $product['old_price']) * 100);
            }
            if (!empty($product['discount_label_show'])){
              $number_ribbon = (int)@$product['discount_label_show'];
            }
            if (!empty($product['mp_discount']) && $product['mp_discount'] > $number_ribbon){
              $number_ribbon = (int) @$product['mp_discount'];
            }
            if(!empty($product['ribbon_color'])) {
              $ribbon_style = ' style="background-color:'.$product['ribbon_color'].'"';
            }          
            if (!empty($product['bank_discount']) && $product['bank_discount'] > $number_ribbon){
              $number_ribbon = (int) @$product['bank_discount'];
            } 

            ?>

            <?php if ($number_ribbon) :?>
                <div class="ribbon large top-left small"><span<?php echo $ribbon_style ?>><?= $number_ribbon ?>% OFF</span></div>
            <?php endif ?>
            <?php if ($product['promo'] !== '') :?>
                <div class="ribbon large"><span><?= $product['promo'] ?></span></div>
            <?php endif ?>
            <?php if (!empty($colorImages[0]['images'] )): ?>
            <?php foreach ($colorImages[0]['images'] as $k => $v) : ?>
              <?php if(!empty($v)): ?>
              <div id="surround">
                <img class="mySlides cloudzoom img-responsive" id="mySlides zoom1" style="" src="<?=$settings['upload_url'].$v?>" data-cloudzoom='<?php echo $cloudzoom ? $cloudzoomdata : '' ?>'/>
              </div>
              <?php endif;?>
            <?php endforeach ?>
            <?php endif;?>
          </div>
        </div>
      <?php else:?>
        <div class="col-md-6 d-flex justify-content-end align-items-center">
          <ul id="ul-moreviews">
            <?php if (!empty($images)): $pkey=0;?>
            <?php foreach ($images as $key => $value) : ?>
             <?php if (!empty($value)): $pkey++;?>
               <li><a href="javacript:void(0)"><img  class="demo w3-opacity w3-hover-opacity-off img-responsive"
                onclick="currentDiv(<?php $key = $key + 1; echo $pkey ?>)"  id="img_01" title="image<?=$pkey?>" style="" src="<?php echo $value ?> " ></a></li>
             <?php endif ?>
            <?php endforeach ?>
             <?php endif ?>
          </ul>
          <div id="surround">
           <?php if (!empty($img_url)): ?>
              <img class="mySlides cloudzoom img-responsive"  id="mySlides zoom1" src="<?php echo $settings['upload_url'].$img_url ?>" data-cloudzoom='<?php echo $cloudzoomdata ?>'/>
          <?php elseif (!empty($images)): ?>

          <?php foreach ($images as $k => $v) : ?>
              <?php if (!empty($v)): ?>
               <img class="mySlides cloudzoom img-responsive"  id="mySlides zoom1" src="<?php echo $v ?>" data-cloudzoom='<?php echo $cloudzoomdata ?>'/>
              <?php endif ?>
            <?php endforeach ?>
          <?php endif; ?>
          </div>
        </div>
    <?php endif;?>
        <div class="col-md-6 max-40">
         <?php
            echo $this->Form->create(null, array(
                'url' => array(
                    'controller' => 'carrito',
                    'action' => 'add'
                ),
                'id' => 'productForm',
                'data-url' => Router::url(array( 'action' => 'stock' )),
                'data-article' => $product['article']
            ));
        ?>
          <span class="hidden" id="product_id"><?php echo $product['id']; ?></span>
          <h1><?php echo $product['name'];?></h1>
          <p class="mb-4"><i class="gi gi-tag text-chatelet mr-1"></i> <?php echo $name_categories; ?> Art. <span class="prod-article"><?php echo $product['article']; ?></span></p>
          <div class="d-flex justify-content-start align-items-center gap-05">
          <?php  
          
          $orig_price = @$product['price'];
          $price = @$product['price'];
          $old_price = @$product['old_price'];

          if(!empty(@$product['discount']) && abs(@$product['discount']-@$product['price']) > 0) {
            $old_price = @$price;
            $price = @$product['discount'];
          }
          ?>
          </div>
          <div class="d-contents tags-start mt-1 mb-4">
            <?= $this->App->show_prices_dues($legends, $settings, $product, $category['Category'], true) ?>
          </div>
          <div class="caract">
          <?php if(!empty($product['desc'])):?>
              <p><?php echo $product['desc']; ?></p>
          <?php endif;?>
          <?php if (!$isGiftCard): ?>
              <!--h2>Color</h2-->
              <div class="card-border">
                <div class="animation-fadeIn animation-both w-100">
                  <div class="article-tools pt-4">
                    <!--div class="color-options d-flex justify-content-start align-items-start gap-15" data-toggle="buttons"-->
                    <div class="color-options d-flex justify-content-start align-items-center w-100" data-toggle="buttons">
                      <?php
                          $show_names_only = count($colors) < 2;
                          foreach ($colors as $i => $color) {
                              $loadColorImages = (!empty($color['images']))?'loadColorImages':'';
                              $single = $show_names_only?'single':'';
                              $style = (empty($color['images']))?'oldSelectColor':'';
                              echo '<label class="btn btn-option '.$loadColorImages.' '.$single. ' '.($i == 0 ? 'active' : '').'" data-images="'.@$color['images'].'">';
                              echo '<input type="radio" name="color" code="'.$color['code'].'" alias="'.$color['alias'].'" value="'. $color['variable'] . '"' . ($i == 0 ? ' checked' : '') . '>';
                              //if (!empty($color['images']) && !$show_names_only) {
                              if (!$show_names_only) {
                                  $image = explode(';', $color['images']);
                                  foreach ($image as $kk => $vv) {
                                      if (!empty($vv)) {
                                          $image[0] = $vv;
                                          break;
                                      }
                                  }
                                  echo '<div class="color-option color-img" style="background-image: url('.$settings['upload_url'].(strlen($image[0])?$image[0]:'default.jpg').')"></div>';
                              } else {
                                // echo '<div class="color-option" style="background-color: '. $color['variable'] .';"></div>';
                              }
                              echo "<small class='color-option color-text text-bolder'>".$color['alias']."</small>";
                              echo '</label>';
                          }
                      ?>
                    </div>
                    <div class="size-options row" data-toggle="buttons">
                    <!--div class="size-options d-flex justify-content-start align-items-start gap-1 pt-2" data-toggle="buttons"-->
                      <!--option value="">Talle</option-->
                      <?php
                          foreach ($sizes as $i => $size) {
                            echo '<label class="btn btn-option">';
                            echo '<input type="radio" name="size" value="'. $size['variable'] .'">';
                            echo "<small class='color-text text-bolder'>".ucfirst($size['label'])."</small>";
                            echo '</label>';
                              // echo '<option value="'. ucfirst($size['variable']) .'">Talle '. ucfirst($size['variable']) .'</option>';
                          }
                      ?>                    
                    </div>
                  </div>
                  <p class="pt-3 stock-block">
                    <span class="text-muted">Stock</span>
                    <span id="stock_container">
                      <span class="text-theme text-bolder">(Elegí color y talle)</span>
                    </span>
                  </p>
                  <div>
                    <a class="table" data-toggle="modal" data-target="#myModal2">Ver tabla de talles</a>
                  </div>
                </div>
              </div>
              <?php endif; ?>
              <div class="animation-fadeIn animation-both delay2 w-100">
                <div class="d-flex flex-column justify-content-center align-items-center footer-producto gap-05">
                  <div class="row carrito-count has-item-counter active w-100" title="Cantidad de este producto">
                    <div class="col-xs-12 form-inline p-0">
                      <div class="form-group">
                        <div class="input-group carrito-selector">
                            <div class="input-group-addon input-lg is-clickable" onclick="removeCount()">
                                <span>&ndash;</span>
                            </div>                                    
                          <input type="text" size="2" class="form-control product-count input-lg text-center" placeholder="Cantidad" value="1">
                          <div class="input-group-addon input-lg is-clickable" onclick="addCount()">
                           <span>+</span>
                           </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex flex-column justify-content-center align-items-center gap-05 w-100">
                    <a href="#" id="comprar" class="btn btn-chatelet dark buy agregar-carro min-w-20">Comprar</a>
                    <a href="#" id="agregar-carro" class="btn btn-chatelet dark add agregar-carro min-w-20">Agregar al carrito</a>
                    <?php if(!empty($cart)):?>
                    <a href="/carrito" class="btn btn-chatelet min-w-20">Ir al carrito</a>
                    <?php endif ?>
                  </div>                        
                </div>
              </div>
            </div>
          </div>
          <?php echo $this->Form->end(); ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="productOptions">
  <div class="wrapper">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
        <?php
            $slug =  str_replace(' ','-',strtolower($category['Category']['name']));
              if (strpos($slug, 'trajes')!==false){
                $slug = 'trajes-de-bano';
              }

        ?>
            <a href="<?php echo router::url(array('controller' => 'tienda', 'action' => 'productos',
                             $slug)) ?>" class="btBig">
              volver <br>
               al  <span>SHOP</span>
            </a>
        </div>

        <div class="col-md-9 product-list posnum-<?=@$category['Category']['posnum'] ?>">
          <div class="row">
              <?php
				      foreach ($all_but_me as $product) {
				        echo $this->App->tile($product['Product'], $settings, 1, $legends, $category);
				      } 
				      ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" tabindex="-1" id="myModal2" role="dialog">
    <div class="content">
        <a class="close" data-dismiss="modal">
            <span></span>
            <span></span>
        </a>

        <?php if (empty($category['Category']['size'])): ?>
        <div class="table">
            <img src="/talles.jpg" style="max-width: 100%;max-height:100%;height:auto:width:100%" />    
            </div>
        <?php else: ?>
            <div align="center" class="centered">
                <img src="<?=$settings['upload_url']?><?=$category['Category']['size']?>" style="max-width:100%" border="0" />
            </div>
        <?php endif; ?>

    </div>
</div><!-- /.modal -->
<style>
	#main .price_strong {
		font-size: 1.5rem;
	}
	.verifying-stock {
	  position: absolute;
	  text-align:center;
	  width: 100%;
	  z-index:1000;
	  font-size: 13px;padding:8px;
	  background: rgba(255,255,255,0.5);
	  color: #999;
	}
</style>
<style>
div.cloudzoom-black {
    display: none !important;
}
div.cloudzoom-black:nth-child(3) {
    display: none !important;
}
div.cloudzoom-black:nth-child(2) {
    display: none !important;
}
</style>

<script>
/* @Analytics: detail */
fbq('track', 'ViewContent')
gtag('event', 'view_item', {
  "items": [
    {
      'id': '<?php echo $product['id'];?>',
      'name': '<?php echo $product['article'];?>',
      "list_name": "Product detail",
      'brand': '<?php echo $product['name'];?>',
      'category': '<?php echo $category['Category']['name'];?>',
      "list_position": 1,
      "quantity": 1,
      'price': '<?php echo $product['discount'];?>'
    }
  ]
})
</script>


<script>
window.baseUrl = "<?=Router::url('/',true)?>";

$(function(){
	var carouselInterval = 0
	var carouselTimeout = 2000
	$('#productOptions .carousel').each(function(i,e){
		$(e).hover(function(){
			const that = $(this)
			carouselInterval = setInterval(function(){
				that.carousel('next');	
			}, carouselTimeout)
		  $(this).carousel('next');
		},function(){
			clearInterval(carouselInterval)
		});
	})
})

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
window.product_list = new Array();
$(function(){
  /*
    $('.add-no-stock').each(function(i,item){
        product_list[i] = item;
        setTimeout(function(){
            checkStock(i);
        }, 500*i);
    })
    */
})
</script>
