<?php
    echo $this->Html->script('jquery', array('inline' => false));
    echo $this->Html->script('ga', array('inline' => false));
    echo $this->Html->script('cloudzoom', array('inline' => false));
    echo $this->Html->css('cloudzoom', array('inline' => false));
    echo $this->Html->script('jquery.growl', array('inline' => false));
    echo $this->Html->script('detalle', array('inline' => false));

    $images  = array();
    $images_aux = explode(';', $product['gallery']);
    foreach ($images_aux as $key => $value) {
        if(!empty($value))
            $images[]   = Configure::read('imageUrlBase').$value;
    }
    echo $this->Session->flash();
    $colorImages = array();
    $colors = array();
    $sizes = array();
    foreach ($properties as $property) {
        switch ($property['ProductProperty']['type']) {
            case 'color':
                if (!empty($property['ProductProperty']['images'])) {
                    $arrImages = explode(';', $property['ProductProperty']['images']);
                    $colorImages[] = array('alias'=>$property['ProductProperty']['alias'], 'images'=>$arrImages);
                }
                array_push($colors, $property['ProductProperty']);
                break;
            case 'size':
                array_push($sizes, $property['ProductProperty']);
                break;
        }
    }
?>
<script>
    var colorImages = <?=json_encode($colorImages, true)?>;
    window.isGiftCard = <?=(int)$isGiftCard?>;
</script>
<section id="detalle">
    <div class="wrapper">
      <div class="row">
      <?php if(!empty($colorImages)):?>
        <div class="col-md-2">
            <ul id="ul-moreviews">
                <?php if (!empty($colorImages[0]['images'] )): $ppp=0; ?>
                <?php foreach ($colorImages[0]['images'] as $key => $value) : ?>
                   <?php if(!empty($value)): $ppp++;?>
                   <li class="dontResize"><a href="javacript:void(0)"><img  class="demo w3-opacity w3-hover-opacity-off img-responsive"
                    onclick="currentDiv(<?=$ppp;?>)" title="ck_image_<?=$ppp?>"  id="img_01" src="<?=Configure::read('imageUrlBase').'thumb_'.$value?>"></a></li>
                    <?php endif;?>
                <?php endforeach ?>
                    <?php endif;?>
            </ul>
        </div>
        <div class="col-md-5">
             <div class="is-product-photo">
                <?php if (intval($product['discount_label_show']) > 0) :?>
                    <div class="ribbon large bottom-left small"><span><?= $product['discount_label_show'] ?>% OFF</span></div>
                <?php endif ?>
                <?php if ($product['promo'] !== '') :?>
                    <div class="ribbon large"><span><?= $product['promo'] ?></span></div>
                <?php endif ?>
                 <?php if (!empty($colorImages[0]['images'] )): ?>

                <?php foreach ($colorImages[0]['images'] as $k => $v) : ?>
                    <?php if(!empty($v)): ?>
                    <div id="surround">
                        <img class="mySlides cloudzoom img-responsive"  id="mySlides zoom1"   style="" src="<?=Configure::read('imageUrlBase').$v?>" data-cloudzoom='zoomSizeMode:"zoom",autoInside: 600'/>
                    </div>
                    <?php endif;?>
                  <?php endforeach ?>
                    <?php endif;?>
             </div>
        </div>
      <?php else:?>
        <div class="col-md-2 col-sm-5">
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
        </div>
        <div class="col-md-5 col-sm-7"  >
             <div id="surround">
                 <?php if (!empty($img_url)): ?>
                    <img  class="mySlides cloudzoom img-responsive"  id="mySlides zoom1"   style="" src="<?php echo Configure::read('imageUrlBase').$img_url ?>" data-cloudzoom='zoomSizeMode:"zoom",autoInside: 600'/>
                <?php elseif (!empty($images)): ?>

                <?php foreach ($images as $k => $v) : ?>
                    <?php if (!empty($v)): ?>
                     <img  class="mySlides cloudzoom img-responsive"  id="mySlides zoom1"   style="" src="<?php echo $v ?>" data-cloudzoom='zoomSizeMode:"zoom",autoInside: 600'/>
                    <?php endif ?>
                  <?php endforeach ?>
                <?php endif; ?>
             </div>
        </div>
    <?php endif;?>
            <div>
            <div class="col-md-5">
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
                <p class="text-muted"><?php echo $name_categories; ?> Art. <span><?php echo $product['article']; ?></span></p>
                <?php  if(!empty(ceil($product['old_price'])) && ceil($product['price'])!==ceil($product['old_price'])) {
                    echo "Antes "."<span style='color:gray;text-decoration: line-through;' id='price' data-price='". ceil($product['old_price']) ."'>".
                           str_replace(',00','',$this->Number->currency(ceil($product['old_price']), 'ARS', array('places' => 2))). "</span>
                           ahora <div><span class='price'>". str_replace(',00','',$this->Number->currency(ceil($product['price']),'ARS', array('places' => 2)))."</span></div>";
                    }else{
                      echo  "<span id='price' class='price' data-price='".'$'. ceil($product['price']) ."'>".
                            str_replace(',00','',$this->Number->currency(ceil($product['price']), 'ARS', array(
                            'places' => 2))). "</span>";
                 }?>
                <div class="caract">
                <?php if(!empty($product['desc'])):?>
                    <p><?php echo $product['desc']; ?></p>
                <?php endif;?>
                <?php if (!$isGiftCard): ?>
                    <!--h2>Color</h2-->
                    <div class="article-tools animated fadeIn">
                        <div class="field">
                           <div class="btn-group inline-block div_color_products animated fadeIn" data-toggle="buttons">
                                <?php  foreach ($colors as $i => $color) {
                                            $loadColorImages = (!empty($color['images']))?'loadColorImages':'';
                                            $style = (empty($color['images']))?'oldSelectColor':'';
                                            echo '<label class="btn '.$loadColorImages.' '.$style.'" style ="border-radius: 100px;" data-images="'.@$color['images'].'">';
                                            
                                            echo '<input type="radio" name="color" code="'.$color['code'].'" alias="'.$color['alias'].'" value="'. $color['variable'] .'">';
                                            if (!empty($color['images'])) {
                                                $image = explode(';', $color['images']);
                                                foreach ($image as $kk => $vv) {
                                                    if (!empty($vv)) {
                                                        $image[0] = $vv;
                                                        break;
                                                    }
                                                }
                                                echo '<div class="color-option" style="background-image: url('.Configure::read('imageUrlBase').$image[0].')"></div>';
                                            } else {
                                                echo '<div class="color-block" style="padding: 10px; border-radius: 100px;background-color: '. $color['variable'] .';"></div>';
                                            }
                                            echo "<small>".$color['alias']."</small>";
                                        echo '</label>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="field">
                            <div class="p-select">
                                <select id="size" name="size">
                                    <option value="">Talle</option>
                                    <?php
                                        foreach ($sizes as $size) {
                                            echo '<option value="'. ucfirst($size['variable']) .'">Talle '. ucfirst($size['variable']) .'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="marginTop">
                        <a class="table" data-toggle="modal" data-target="#myModal2">Ver tabla de talles</a>
                    </div>
                    <p>
                      <span style="color:#F50081;"> Stock:</span> <span id="stock_container"><i> (Elegí color y talle) </i></span>
                    </p>
                    <?php endif; ?>
                    <div class="row footer-producto">
                        <?php //if($loggedIn){ ?>
                            <div class="row carrito-count has-item-counter active" title="Cantidad de este producto">
                                <div class="col-xs-12 col-sm-4 form-inline">
                                  <div class="form-group">
                                    <div class="input-group carrito-selector">
                                        <div class="input-group-addon input-lg is-clickable" onclick="removeCount()">
                                            <span class="fa fa-minus"></span>
                                        </div>                                    
                                      <input type="text" size="2" class="form-control product-count input-lg text-center" placeholder="Cantidad" value="1">
                                      <div class="input-group-addon input-lg is-clickable" onclick="addCount()">
                                       <span class="fa fa-plus"></span>
                                       </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-xs-12 col-sm-8">
                                    <a href="#" id="agregar-carro" class="add agregar-carro" >Agregar al carrito</a>
                                </div>
                            </div>
                            

                        <?php //}else{ echo $this->Form->end(); ?>

                            <!--a href="#" id="register" data-toggle="modal" class="add" data-target="#particular-login">
                            Agregar a mi carro</a-->

                        <?php //}  ?>
                    </div>
                </div>
              </div>
            </div>
          </div>
       </div>
    </div>
</section>


<section id="productOptions">
    <div class="wrapper">
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

            <div class="col-md-9 product-list posnum-<?= $category['Category']['posnum'] ?>">
                <div class="row">
                    <?php
                    foreach($all_but_me as $alt_product):
                        $alt_product = $alt_product['Product'];
                        $stock = (!empty($alt_product['stock_total']))?(int)$alt_product['stock_total']:0;
                        $alt_product_name =$alt_product['name'];

                        $url = $this->Html->url(array(
                                'controller' => 'shop',
                                'action' => 'detalle',
                                $alt_product['id'],
                                $alt_product['category_id'],
                                strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $alt_product['name']))),

                            )
                        );

                $number_disc = 10;
				if (isset($alt_product['discount_label_show'])){
					$number_disc = (int)@$alt_product['discount_label_show'];
				}
				$discount_flag = (@$alt_product['category_id']!='134' && !empty($number_disc))?'<div class="discount-flag">'.$number_disc.'% OFF</div>':'';
                $promo_ribbon = (!empty($item['promo']))?'<div class="ribbon"><span>'.$item['promo'].'</span></div>':'';


                    if(!$stock){ ?>
                     <div class="col-sm-6 col-md-4 col-lg-3 p-1">
                        <a href="<?php echo $url ?>" >
                            <?php if (!empty(intval($alt_product['discount_label_show']))) :?>
                                <div class="ribbon bottom-left small"><span><?= $alt_product['discount_label_show'] ?>% OFF</span></div>
                            <?php endif ?>
                            <?php if ($alt_product['promo'] !== '') :?>
                                <div class="ribbon"><span><?= $alt_product['promo'] ?></span></div>
                            <?php endif ?>
                            <img src="<?php echo Router::url('/').'images/agotado3.png' ?>" class="out_stock" />
                            <img  class="img-responsive" src="<?php echo Configure::read('imageUrlBase') . $alt_product['img_url'] ?>" alt="">
                            <!--h3 class="article-related-title"><?php echo $alt_product['name'] ?></h3-->
                            <div class="name"><?= $alt_product_name ?></div>
                            <div class="price-list"><?= str_replace(',00','',$this->Number->currency(ceil($alt_product['price']), 'ARS', array('places' => 2))) ?></div>
                        </a>
                    </div>
                    <?php }else{ ?>

                      <div data-id="<?=$alt_product['id']?>" class="col-sm-6 col-md-4 col-lg-3 p-1 add-no-stock">
                        <a href="<?php echo $url ?>">
                            <div class="ribbon-container">
                            <?php if (!empty(intval($alt_product['discount_label_show']))) :?>
                                <div class="ribbon bottom-left small sp1"><span><?= $alt_product['discount_label_show'] ?>% OFF</span></div>
                            <?php endif ?>
                            <?php if ($alt_product['promo'] !== '') :?>
                                <div class="ribbon"><span><?= $alt_product['promo'] ?></span></div>
                            <?php endif ?>
                            <img class="img-responsive" src="<?php echo Configure::read('imageUrlBase') . $alt_product['img_url'] ?>" alt="">
                            </div>
                            <!--h3 class="article-related-title"><?php echo $alt_product['name'] ?></h3-->
                            <div class="name"><?= $alt_product_name ?></div>
                            <div class="price-list"><?= @ceil($alt_product['old_price']) && ceil($alt_product['old_price']) !== ceil($alt_product['price']) ? '<span class="old_price">' .  str_replace(',00','',$this->Number->currency(ceil($alt_product['old_price']), 'ARS', array('places' => 2))). '</span>' : '' ?><?= str_replace(',00','',$this->Number->currency(ceil($alt_product['price']), 'ARS', array('places' => 2))) ?></div>
                        <?php if(count($legends)): ?>
                            <div class="legends">
                                <?php foreach ($legends as $legend): 
                                    $price = $alt_product['price'];
                                    if(!empty($legend['Legend']['interest'])){
                                      $price = round($price * (1 + $legend['Legend']['interest'] / 100));
                                    }
                                    ?>
                                    <span class="text-legend"><?= str_replace([
                                        '{cuotas}','{interes}','{monto}'
                                    ], [
                                        $legend['Legend']['dues'],
                                        $legend['Legend']['interest'],
                                        str_replace(',00','',$this->Number->currency(ceil($price/$legend['Legend']['dues']), 'ARS', array('places' => 2)))
                                        ],$legend['Legend']['title']) ?></span>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                        </a>
                    </div>
                   <?php }endforeach; ?>
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
                <img src="<?=Configure::read('imageUrlBase')?><?=$category['Category']['size']?>" style="max-width:100%" border="0" />
            </div>
        <?php endif; ?>

    </div>
</div><!-- /.modal -->




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
<form action="/chatelet-new/users/login" id="ProductLoginForm" method="post">

              </form>
