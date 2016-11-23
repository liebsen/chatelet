<?php
    echo $this->Html->css('w3', array('inline' => false));
    echo $this->Html->css('product', array('inline' => false));

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
                             <a href="#"><img  class="mySlides" style="width:80%;" src="<?php echo $v ?>" ></a>
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
                                <h1>High Collar Coat</h1>
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

                                  
                                    <h4>cambiar color</h4>
                           
                                    <div class="btn-group inline-block div_color_products" data-toggle="buttons">
                                        <?php  foreach ($colors as $color) {
                                                    echo '<label class="btn" style ="    border-radius: 100px;">';
                                                    echo '<input type="radio" name="color" code="'.$color['code'].'" alias="'.$color['alias'].'" value="'. $color['variable'] .'">';
                                                    echo '<div class="color-block" style="    border-radius: 100px;background-color: '. $color['variable'] .';"></div>';
                                                echo '</label>';
                                            }
                                        ?>
                                    </div>
                       
                            <a href="#" id="agregar-carro" class="add" disabled>Agregar a mi carro</a>
                                

                            <div class="social">
                                <a href="https://twitter.com/chateletmoda" class="fb"></a>
                                <a href="https://www.facebook.com/pages/Ch%C3%A2telet/114842935213442" class="tt"></a>
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
                        <a href="<?php echo router::url(array('controller' => 'shop', 'action' => 'index',
                                         intval($category_id))) ?>" class="btBig">
                           <span>volver <br>
                           al SHOP</span>
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