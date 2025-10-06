<?php echo $this->Session->flash();?>
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
<div id="headabrigos">
  <div class="img-resp is-main" style="background-image:url(<?php echo Configure::read('uploadUrl').$category['banner_url'] ?>)">
    <!--h1 class="name_shop animated delay3 fadeIn"><?php echo $category['name']; ?></h1-->
  </div>  
</div>
<?php endif ?>

<section id="productOptions" class="animated fadeIn">
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
        echo $this->App->tile($product['Product'], 1, $legends, $category['posnum']);
      } 
    } else {
      foreach ($categories as $category) {
        echo $this->App->tile($category['Category']);
      }
    }
  ?>
            </div>
            <div class="hidden-lg hidden-md visible-xs-* visible-sm-* col-sm-12 col-xs-12 product-categories">
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
                          ), array(
                            'class' => ($category_id === $category['id'] ? 'text-theme' : '')
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
