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
</script>
<section id="detalle"> 
    <div class="wrapper">
      <div class="row">
      <?php if(!empty($colorImages)):?>
        <div class="col-md-2 col-sm-5">
            <ul id="ul-moreviews">
                <?php foreach ($colorImages[0]['images'] as $key => $value) : ?>
                   <li><a href="#"><img  class="demo w3-opacity w3-hover-opacity-off img-responsive" 
                    onclick="currentDiv(<?=$key + 1?>)"  id="img_01" src="<?=Configure::read('imageUrlBase').'thumb_'.$value?>"></a></li>
                <?php endforeach ?>
            </ul>
        </div>
        <div class="col-md-5 col-sm-7"  >
             <div id="surround">
                <?php foreach ($colorImages[0]['images'] as $k => $v) : ?> 
                    <img  class="mySlides cloudzoom img-responsive"  id="mySlides zoom1"   style="width:70%;" src="<?=Configure::read('imageUrlBase').$v?>" cloudzoom='zoomSizeMode:"image",autoInside: 600'/> 
                  <?php endforeach ?>
             </div>
        </div>
      <?php else:?>  
        <div class="col-md-2 col-sm-5">
            <ul id="ul-moreviews">
                <?php foreach ($images as $key => $value) : ?>
                 <?php if (!empty($value)): ?>
                   <li><a href="#"><img  class="demo w3-opacity w3-hover-opacity-off img-responsive" 
                    onclick="currentDiv(<?php $key = $key + 1; echo $key ?>)"  id="img_01" style="width:40%;" src="<?php echo $value ?> " ></a></li>
                 <?php endif ?> 
                <?php endforeach ?>
            </ul>
        </div>
        <div class="col-md-5 col-sm-7"  >
             <div id="surround">
                <?php foreach ($images as $k => $v) : ?> 
                    <?php if (!empty($v)): ?>
                     <!--a href="#" ><img  class="mySlides"  id="mySlides"  src="<?php echo $v ?>" data-zoom-image="<?php echo $v ?>"/></a-->
                     <img  class="mySlides cloudzoom img-responsive"  id="mySlides zoom1"   style="width:70%;" src="<?php echo $v ?>" cloudzoom='zoomSizeMode:"image",autoInside: 600'/>
                    <?php endif ?> 
                  <?php endforeach ?>
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
                <?php  if(!empty($product['discount'])) {
                      echo "Antes "."<span style='color:gray;text-decoration: line-through;' id='price' data-price='". $product['price'] ."'>".
                           $this->Number->currency($product['price'], 'USD', array('places' => 0)). "</span>
                           ahora <span   class='price'>".'$'. $product['discount']."</span>"; 
                    }else{
                      echo  "<span id='price' class='price' data-price='".'$'. $product['price'] ."'>".
                            $this->Number->currency($product['price'], 'USD', array(
                            'places' => 0)). "</span>";
                 }?>
                        
                <div class="caract">
                <?php if(!empty($product['desc'])):?>
                    <p><?php echo $product['desc']; ?></p>
                <?php endif;?>
                    <h2>Color</h2>
                       
                   <div class="btn-group inline-block div_color_products" data-toggle="buttons">
                        <?php  foreach ($colors as $color) {
                                    $loadColorImages = (!empty($color['images']))?'loadColorImages':'';
                                    echo '<label class="btn '.$loadColorImages.'" style ="    border-radius: 100px;" data-images="'.$color['images'].'">';
                                    echo "<small>".$color['alias']."</small>";
                                    echo '<input type="radio" name="color" code="'.$color['code'].'" alias="'.$color['alias'].'" value="'. $color['variable'] .'">';
                                    if (!empty($color['images'])) {
                                        $image = explode(';', $color['images']);
                                        echo '<img src="'.Configure::read('imageUrlBase').'thumb_'.$image[0].'">';
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
                    <a class="table" data-toggle="modal" data-target="#myModal2">Ver tabla de talles</a>
                    
                    <p>
                      <span style="color:#F50081;"> Stock:</span> <span id="stock_container"><i> (Seleccione un color y talle) </i></span>
                    </p>

                    <div class="footer-producto" >
                        <?php //if($loggedIn){ ?>

                            <a href="#" id="agregar-carro" class="add" >Agregar a mi carro</a>

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
                <a href="<?php echo router::url(array('controller' => 'shop', 'action' => 'index',
                                 intval($category_id))) ?>" class="btBig">
                  volver <br>
                   al  <span>SHOP</span>
                </a>
            </div>

            <div class="col-md-9 col-sm-9">
                <div class="row">
                    <?php 
                    foreach($all_but_me as $alt_product):
                        $alt_product = $alt_product['Product'];
                        $stock = (!empty($alt_product['stock']))?1:0; 
                        if(!empty($details)){
                            $name = $details;
                        }else{
                            $name = $alt_product['name'];
                        }
                        
                        $url = $this->Html->url(array(
                                'controller' => 'shop',
                                'action' => 'detalle',
                                $alt_product['id'],
                                $alt_product['category_id']
                            )
                        );
                    if(!$stock){ ?>
                     <div class="col-md-4 col-sm-6">
                        <a href="<?php echo $url ?>" >   
                            <img src="<?php echo Router::url('/').'images/agotado3.png' ?>" class="out_stock" />
                            <img  class="img-responsive" src="<?php echo Configure::read('imageUrlBase') . $alt_product['img_url'] ?>" alt="">
                            <span class="hover"> 
                              <small><?php echo $alt_product['name'] ?></small>
                            </span>
                        </a>
                    </div>
                    <?php }else{ ?>

                      <div data-id="<?=$alt_product['id']?>" class="col-md-4 col-sm-6 add-no-stock">
                        <div class="verifying-stock">Consultando stock...</div>
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

        <div class="table">
            <h1>Tabla de conversión de talles</h1>
            <p>Utilíza la tabla como guía.</p>

            <table class="table">
                <tr>
                    <td>Talle</td>
                    <td>42/07/S</td>
                    <td>44/08/M</td>
                    <td>46/09/L</td>
                    <td>48/10/XL</td>
                    <td>50/12/XXL</td>
                    <td>52/13/XXL</td>
                    <td>54/14/XXXL</td>
                </tr>
                <tr>
                    <td>Busto</td>
                    <td>92</td>
                    <td>96</td>
                    <td>100</td>
                    <td>104</td>
                    <td>108</td>
                    <td>112</td>
                    <td>116</td>
                </tr>
                <tr>
                    <td>Cintura</td>
                    <td>68</td>
                    <td>72</td>
                    <td>76</td>
                    <td>80</td>
                    <td>84</td>
                    <td>88</td>
                    <td>92</td>
                </tr>
                <tr>
                    <td>Cadera</td>
                    <td>96</td>
                    <td>100</td>
                    <td>104</td>
                    <td>108</td>
                    <td>112</td>
                    <td>116</td>
                    <td>120</td>
                </tr>
            </table>
        </div>
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
    $('.add-no-stock').each(function(i,item){
        product_list[i] = item;
        setTimeout(function(){
            checkStock(i);
        }, 500*i);
    })
})
</script>
<form action="/chatelet-new/users/login" id="ProductLoginForm" method="post">

              </form>