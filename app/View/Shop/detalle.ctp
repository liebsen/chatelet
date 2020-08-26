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
window.ec_data = {
  'ecommerce': {
    'detail': {
      'actionField': {'list': 'DetalleProducto'},    // 'detail' actions have an optional list property.
      'products': [{
        'name': '<?php echo @$product['name']; ?>',         // Name or ID is required.
        'id': '<?php echo @$product['id'];?>',
        'price': '<?php echo @$product['discount']; ?>',
        'brand': 'Chatelet',
        'category': '<?php echo @$category['Category']['name']; ?>',
        'variant': ''
       }]
     }
   }
};

window.dataLayer = window.dataLayer || [];
setTimeout(function(){
    window.dataLayer.push(ec_data);
},1000)

    var colorImages = <?=json_encode($colorImages, true)?>;
    window.isGiftCard = <?=(int)$isGiftCard?>;
</script>
<section id="detalle">
    <div class="wrapper">
      <div class="row">
      <?php if(!empty($colorImages)):?>
        <div class="col-md-2 col-sm-5">
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
        <div class="col-md-5 col-sm-7"  >
             <div id="surround">
                 <?php if (!empty($colorImages[0]['images'] )): ?>

                <?php foreach ($colorImages[0]['images'] as $k => $v) : ?>
                    <?php if(!empty($v)): ?>
                    <img  class="mySlides cloudzoom img-responsive"  id="mySlides zoom1"   style="" src="<?=Configure::read('imageUrlBase').$v?>" data-cloudzoom='zoomSizeMode:"zoom",autoInside: 600'/>
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
            <div class="col-md-4">
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
                <h1> <?php echo $product['name'];?> </h1>

                 <p><?php echo $name_categories; ?></p>
                 <p> Art. <span><?php echo $product['article']; ?></span></p>
                <?php  if(!empty($product['discount']) && $product['price']!==$product['discount']) {
                      echo "Antes "."<span style='color:gray;text-decoration: line-through;' id='price' data-price='". $product['price'] ."'>".
                           $this->Number->currency($product['price'], 'USD', array('places' => 2)). "</span>
                           ahora <span   class='price'>".'$'. $product['discount']."</span>";
                    }else{
                      echo  "<span id='price' class='price' data-price='".'$'. $product['price'] ."'>".
                            $this->Number->currency($product['price'], 'USD', array(
                            'places' => 2)). "</span>";
                 }?>

                <div class="caract">
                <?php if(!empty($product['desc'])):?>
                    <p><?php echo $product['desc']; ?></p>
                <?php endif;?>
                <?php if (!$isGiftCard): ?>
                    <h2>Color</h2>

                   <div class="btn-group inline-block div_color_products" data-toggle="buttons">
                        <?php  foreach ($colors as $color) {
                                    $loadColorImages = (!empty($color['images']))?'loadColorImages':'';
                                    $style = (empty($color['images']))?'oldSelectColor':'';
                                    echo '<label class="btn '.$loadColorImages.' '.$style.'" style ="border-radius: 100px;" data-images="'.@$color['images'].'">';
                                    echo "<small>".$color['alias']."</small>";
                                    echo '<input type="radio" name="color" code="'.$color['code'].'" alias="'.$color['alias'].'" value="'. $color['variable'] .'">';
                                    if (!empty($color['images'])) {
                                        $image = explode(';', $color['images']);
                                        foreach ($image as $kk => $vv) {
                                            if (!empty($vv)) {
                                                $image[0] = $vv;
                                                break;
                                            }
                                        }
                                        echo '<img style="max-height: 100px;" src="'.Configure::read('imageUrlBase').'thumb_'.$image[0].'">';
                                    } else {
                                        echo '<div class="color-block" style="padding: 10px; border-radius: 100px;background-color: '. $color['variable'] .';"></div>';
                                    }
                                echo '</label>';
                            }
                        ?>
                    </div>

                   <h2>Talle
                    <select id="size" name="size" style="background-color: white; " >
                        <option value="">Seleccionar</option>
                        <?php
                            foreach ($sizes as $size) {
                                echo '<option value="'. ucfirst($size['variable']) .'">'. ucfirst($size['variable']) .'</option>';
                            }
                        ?>
                    </select>
                    <div class="marginTop">
                    <a class="table" data-toggle="modal" data-target="#myModal2">Ver tabla de talles</a><h4></h4>
                    </div>
                    <p>
                      <span style="color:#F50081;"> Stock:</span> <span id="stock_container"><i> (Seleccione un color y talle) </i></span>
                    </p>
                    <?php endif; ?>
                    <div class="footer-producto" >
                        <?php //if($loggedIn){ ?>

                            <a href="#" id="agregar-carro" class="add agregar-carro" >Agregar al carrito</a>

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
            <div class="col-md-3 col-sm-3">
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

            <div class="col-md-9 col-sm-9">
                <div class="row">
                    <?php
                    foreach($all_but_me as $alt_product):
                        $alt_product = $alt_product['Product'];
                        $stock = (!empty($alt_product['stock_total']))?(int)$alt_product['stock_total']:0;
                        if(!empty($details)){
                            $name = $details;
                        }else{
                            $name = $alt_product['name'];
                        }

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



                    if(!$stock){ ?>
                     <div class="col-md-4 col-sm-6"><?=$discount_flag?>
                        <a href="<?php echo $url ?>" >
                            <img src="<?php echo Router::url('/').'images/agotado3.png' ?>" class="out_stock" />
                            <img  class="img-responsive" src="<?php echo Configure::read('imageUrlBase') . $alt_product['img_url'] ?>" alt="">
                            <span class="hover">
                              <small><?php echo $alt_product['name'] ?></small>
                            </span>
                        </a>
                    </div>
                    <?php }else{ ?>

                      <div data-id="<?=$alt_product['id']?>" class="col-md-4 col-sm-6 add-no-stock"><?=$discount_flag?>

                        <a href="<?php echo $url ?>" >
                            <img  class="img-responsive" src="<?php echo Configure::read('imageUrlBase') . $alt_product['img_url'] ?>" alt="">
                            <span class="hover">
                              <small><?php echo $alt_product['name'] ?></small>
                            </span>
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
