<?php
    echo $this->Html->script('jquery', array('inline' => false));
    echo $this->Html->script('ga', array('inline' => false));
    echo $this->Html->script('cloudzoom', array('inline' => false));
    echo $this->Html->css('cloudzoom', array('inline' => false));
    echo $this->Html->script('jquery.growl', array('inline' => false));

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
                             onclick="currentDiv(<?php $key = $key + 1; echo $key ?>)"  id="img_01" style="width:40%;" src="<?php echo $value ?>" ></a></li>
                            <?php endif ?> 
                          <?php endforeach ?>
                        </ul>
                    </div>
                    <div class="col-md-5 col-sm-7"  >
                     <div id="surround">
                        <?php foreach ($images as $k => $v) : ?> 
                            <?php if (!empty($v)): ?>
                             <!--a href="#" ><img  class="mySlides"  id="mySlides"  src="<?php echo $v ?>" data-zoom-image="<?php echo $v ?>"/></a-->
                             <img  class="mySlides cloudzoom"  id="mySlides zoom1"   style="width:70%;" src="<?php echo $v ?>" cloudzoom='zoomSizeMode:"image",autoInside: 600'/>
                            <?php endif ?> 
                          <?php endforeach ?>
                     </div>
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
                                <h1>
                                 <?php
                                    if(!empty($details)){
                                        echo $details;
                                    }else{
                                        echo $product['name'];
                                    }
                                ?>
                                </h1>

                                 <p><?php echo $name_categories; ?></p>
                                 <p> Art. <span><?php echo $product['article']; ?></span></p>
                                <?php echo "
                                
                                <span style='color:gray;'>". $product['desc']."</span>
                                <span id='price' class='price' data-price='". $product['price'] ."'>".
                                $this->Number->currency($product['price'], 'USD', array(
                                            'places' => 0
                                        )). "</span>"; ?>
                                
                            <div class="caract">
                            
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

                                  <h2>Talle
                                    <select id="size" name="size">
                                        <option value="">Seleccionar</option>
                                        <?php
                                            foreach ($sizes as $size) {
                                                echo '<option value="'. ucfirst($size['variable']) .'">'. ucfirst($size['variable']) .'</option>';
                                            }
                                        ?>
                                    </select>
                                    <a class="table" data-toggle="modal" data-target="#myModal2">Ver tabla de talles</a>
                                    
                                    <h4>
                                    <h2>Color</h2>
                           
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
//$(".mySlides").elevateZoom();
    CloudZoom.quickStart();

</script>
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