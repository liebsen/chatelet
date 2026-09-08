<?php 
echo $this->Session->flash();
$this->Html->script('vendor/jquery.touchSwipe.min', array('block' => 'script'));
$this->Html->script('carousel-swipe.js?v='.$version['ver'], array('block' => 'script'));?>
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
<?php if(!empty($category['banner_url'])): ?>
	<?php if(!empty($category['text_style']->font_family)):?>
<script type="text/javascript">loadFont('<?=$category['text_style']->font_family?>');</script>
<?php endif ?>
<div id="headabrigos">
  <div class="img-resp is-main posnum-<?=$category['posnum'] ?? 'auto' ?>" style="background-image:url(<?php echo $settings['upload_url'].$category['banner_url'] ?>)">
      <div class="category-image alignnum-<?=$category['alignnum'] ?? '0' ?> p-3 w-100">  
      	<?php if($category['show_text'] == '1'):?>
        <span class="p-1 text-catalog" style="color: <?=$category['text_style']->color ?? 'white'?>">
        	<?php if($category['show_name'] == '1'):?>
          <span class="text-uppercase"><?=$category['name']?></span>
          <?php endif ?>
          <span class="p-1 p-catalog text-stroke" style="font-size: <?=$category['text_style']->font_size ?? '12'?>px; font-weight: <?=$category['text_style']->font_weight ?? '300'?>;font-family: <?=$category['text_style']->font_family ?? 'inherit'?>; -webkit-text-stroke: <?=$category['text_style']->shadow_width ?? '0'?>px <?=$category['text_style']->shadow_color ?? 'transparent'?>;"><?=$category['text']?></span>
        </span>
      	<?php endif ?>
      </div>  	
    <!--h1 class="name_shop delay2 animation-pullUp animation-both"><?php echo $category['name']; ?></h1-->
  </div>  
</div>
<?php endif ?>

<section id="productOptions">
    <div class="wrapper">
        <div class="row">
            <div class="hidden-xs hidden-sm col-sm-3">
                <nav>
                    <ul>
                        <?php
                    foreach ($categories as $cat) {
                        $cat = $cat['Category'];
                        $slug =  str_replace(' ','-',strtolower($cat['name']));
                        if (strpos($slug, 'trajes')!==false){
                          $slug = 'trajes-de-bano';
                        }
                        echo '<li>';
                        echo $this->Html->link(
                            $cat['name'],
                            array(
                                'controller' => 'tienda',
                                'action' => 'productos',
                                $slug
                            ), array(
                              'class' => ($category_id === $cat['id'] ? 'text-theme current' : '')
                            )
                        );
                        echo '</li>';
                    }
                   ?>
                    </ul>
                </nav>
            </div>
            <div class="col-md-9 product-list posnum-<?= @$category['posnum'] ?>">
  <?php
    if (isset($products)) {
      foreach ($products as $product) {
        echo $this->App->tile($product['Product'], $settings, 1, $legends, $category);
      } 
    } else {
      foreach ($categories as $category) {
        echo $this->App->tile($category, $settings);
      }
    }
  ?>
            </div>
            <div class="hidden-lg hidden-md visible-xs-* visible-sm-* col-sm-12 col-xs-12 product-categories">
                <nav>
                    <ul>
                        <?php
                            foreach ($categories as $category) {
                                $category = $category;
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
                          ), array(
                            'class' => ($category_id === $category['id'] ? 'active' : '')
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
        <div class="row bxc">
            <div class="col-md-4 bx1">
                <p>
                Los envíos por compra online tienen una demora de 7 a 10 días hábiles.
              </p>
            </div>
            <div class="col-md-4 bx2 blr">
              <p>
                Los cambios se realizan dentro de los 30 días de efectuada la compra en cualquiera de las sucursales presentando el ticket correspondiente.
              </p>
            </div>
            <div class="col-md-4 bx3">
              <p>
                Las prendas deben estar sin uso y con la etiqueta de código de barras correspondiente adherida.
              </p>
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
  id: '<?= $category_id ?>',
  name: '<?= $category['name'] ?>'
})

dataLayer.push({
  'ecommerce': {
    'detail': {
      'actionField': {'list': '<?= $category['name'] ?>'}
    }
  }
})

</script>
