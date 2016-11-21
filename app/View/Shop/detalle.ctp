
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.js"></script>


<?php
    echo $this->Html->script('elevatezoom-master/jquery.elevatezoom', array('inline' => false));
    echo $this->Html->css('jquery.bxslider', array('inline' => false));
    echo $this->Html->script('jquery.bxslider', array('inline' => false));
    echo $this->Html->css('w3', array('inline' => false));
    echo $this->Html->css('product', array('inline' => false));

        /* Lightbox */
    echo $this->Html->css('lightbox', array('inline' => false));
    echo $this->Html->script('lightbox.min', array('inline' => false));

    $images  = array();
    $images_aux = explode(';', $product['gallery']);
    foreach ($images_aux as $key => $value) {
        if(!empty($value))
            $images[]   = Configure::read('imageUrlBase').$value;
    }
    echo $this->Session->flash();
?>  

        <section id="detalle"> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-2 col-sm-5">
                        <ul>
                           <?php foreach ($images as $key => $value) : ?>
                            <?php if (!empty($value)): ?>
                             <li><a href="#"><img  class="demo w3-opacity w3-hover-opacity-off" 
                             onclick="currentDiv(<?php $key = $key + 1; echo $key ?>)" style="width:40%;" src="<?php echo $value ?>" ></a></li>
                            <?php endif ?> 
                          <?php endforeach ?>
                        </ul>
                    </div>
                    <div class="col-md-5 col-sm-7">
                        <?php foreach ($images as $k => $v) : ?> 
                            <?php if (!empty($v)): ?>
                             <a href="#" ><img  class="mySlides" elevate-zoom style="width:80%;" src="<?php echo $v ?>" ></a>
                             </a>
                            <?php endif ?> 
                          <?php endforeach ?>
                    </div>

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
                                <h1><?php echo $product['name']; ?></h1>
                                 <p><?php echo $name_categories; ?></p>

                                <?php echo "
                                
                                <span style='color:gray;'>". $product['desc']."</span>
                                <span id='price' class='price' data-price='". $product['price'] ."'>".
                                $this->Number->currency($product['price'], 'USD', array(
                                            'places' => 0
                                        )). "</span>"; ?>
                                
                            <div class="caract">
                            <h3>Características</h3>
                            <p><?php echo $product['name']; ?></p>
                             <?php
                                            $colors = array();
                                            $sizes = array();
                                            foreach ($properties as $property) {
                                                switch ($property['ProductProperty']['type']) {
                                                    case 'color':
                                                        array_push($colors, $property['ProductProperty']);
                                                        break;
                                                    case 'size':
                                                        array_push($sizes, $property['ProductProperty']);
                                                        break;
                                                }
                                            }

                                        ?>

                                  <h3>Seleccionar talle</h3>
                                    <select id="size" name="size">
                                        <option value="">Seleccionar</option>
                                        <?php
                                            foreach ($sizes as $size) {
                                                echo '<option value="'. ucfirst($size['variable']) .'">'. ucfirst($size['variable']) .'</option>';
                                            }
                                        ?>
                                    </select>
                                    <a class="table" data-toggle="modal" data-target="#myModal2">Ver tabla de talles</a>
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
                                                        <td>50/11/XXL</td>
                                                        <td>52/12/XXL</td>
                                                        <td>54/13/XXXL</td>
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

                                  
                                    <h4>cambiar color</h4>
                           
                                    <div class="btn-group inline-block div_color_products" data-toggle="buttons">
                                        <?php  foreach ($colors as $color) {
                                                    echo '<label class="btn" style ="    border-radius: 100px;">';
                                                    echo "<small>".$color['alias']."</small>";
                                                    echo '<input type="radio" name="color" code="'.$color['code'].'" alias="'.$color['alias'].'" value="'. $color['variable'] .'">';
                                                    echo '<div class="color-block" style="    border-radius: 100px;background-color: '. $color['variable'] .';"></div>';
                                                echo '</label>';
                                            }
                                        ?>
                                    </div>



                       
                            <a href="#" id="agregar-carro" class="add" disabled>Agregar a mi carro</a>
                                
                         
                            <div class="social">
                                <a href="https://www.facebook.com/pages/Ch%C3%A2telet/114842935213442" class="fb"></a>
                                <a href="https://twitter.com/chateletmoda" class="tt"></a>
                                <a href="https://www.instagram.com/chateletmoda/" class="pr"></a>
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
                        <a href="<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($category_id))) ?>" class="btBig">
                            <?php echo $name_categories; ?><br>
                            <span>Ver todos</span>
                        </a>
                    </div>

                    <div class="col-md-9 col-sm-9">
                        <div class="row">
                            <?php foreach($all_but_me as $alt_product):
								$alt_product = $alt_product['Product'];
								$url = $this->Html->url(array(
										'controller' => 'shop',
										'action' => 'detalle',
										$alt_product['id'],
										$alt_product['category_id']
									)
								);
							?>
							<div class="col-md-4 col-sm-6">
								<a href="<?php echo $url ?>" >
									<img  class="img-responsive" src="<?php echo Configure::read('imageUrlBase') . $alt_product['img_url'] ?>" alt="">
									<span class="hover"> 
	                                  <small><?php echo $alt_product['name'] ?></small>
									</span>
								</a>
                            </div>
      				       <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>


       <section id="suscribe">
            <div class="wrapper">
                <div class="col-md-6">Suscribite y conocé las <strong>novedades</strong></div>
                <div class="col-md-6">
                    <form>
                        <input type="text" placeholder="Ingresá tu email">
                        <input type="submit" value="ok">
                    </form>
                </div>
            </div>
        </section>



<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
     dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
  }
  x[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " w3-opacity-off";
}
</script>

<script type="text/javascript">
//initiate the plugin and pass the id of the div containing gallery images
$('#zoom_03').ezPlus({
    gallery: 'gallery_01', cursor: 'pointer', galleryActiveClass: 'active',
    imageCrossfade: true, loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'
});

//pass the images to Fancybox
$('#zoom_03').bind('click', function (e) {
    var ez = $('#zoom_03').data('ezPlus');
    $.fancyboxPlus(ez.getGalleryList());
    return false;
});

</script>