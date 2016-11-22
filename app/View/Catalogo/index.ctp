<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<?php
  // echo $this->Html->css('w3', array('inline' => false));
	echo $this->Html->css('catalogo', array('inline' => false));
	echo $this->Html->script('catalogo', array('inline' => false));
	/* Slider */
	echo $this->Html->script('box-slider/box-slider-all.jquery.min', array('inline' => false));
	/* Lightbox */
	echo $this->Html->css('lightbox', array('inline' => false));
	echo $this->Html->script('lightbox.min', array('inline' => false));
	echo $this->Session->flash();
?>
  <div id="video">
            <div class="col-md-6">
                <h1>Lookbook</h1>
                <p>Primavera / Verano<br>2017</p>
            </div>
            <div class="col-md-6">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe width="640" height="430" src="<?php echo $page_video."?wmode=transparent" ?>" frameborder="0" wmode="Opaque" allowfullscreen></iframe>
                </div>
            </div>
        </div>
     
       <section id="lookbook">
           <div class="col-md-5">
              <div id="carousel2">
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">
                    <?php 
                      foreach ($lookbook as $key => $value) { 
                          if (empty($value))
                         continue; 
                          $alt_product = $value['LookBook'];
                          $url = $this->Html->url(array(
                                  'controller' => 'catalogo',
                                  'action' => 'index',
                                  $alt_product['img_url']
                              )
                          ); ?>
                          <div class="item <?php echo (!$key) ? 'active' : null ; ?>" >
                            <a href="<?php echo $url  ?>">
                              <img  src="<?php echo Configure::read('imageUrlBase').$value['LookBook']['img_url'] ?>" >
                            </a>    
                           
                          </div>
                  <?php } ?> 
              
                  </div>

                  <!-- Controls -->
                  <a class="left carousel-control" href="#carousel2" role="button" data-slide="prev">
                    <span class="arrow arrow-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#carousel2" role="button" data-slide="next">
                    <span class="arrow arrow-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
              </div>
           </div>
           <div class="col-md-7">
            <h3>Elegí tu look para vivir tu momento.</h3>
              <ul>
                 <?php foreach ($product as $k => $v) : ?> 
                    <?php if (!empty($v)): ?>
                      <li class="lc" style="border-bottom: 2px solid #c2c2c2;margin-bottom: 45px;padding-bottom: 45px;">
                        <div class="row">
                          <div class="col-sm-3">
                            <img  class="img-responsive"   src="<?php echo Configure::read('imageUrlBase').$v['Product']['img_url'] ?>" >
                          </div>
                          <div class="col-sm-9">
                            <span class="price"><?php echo $v['Product']['desc'].' '.$v['Product']['price']; ?></span>
                            <h2><?php echo $v['Product']['name']; ?></h2>
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
                     
                                  <p>Seleccionar talle</p>
                                    <select id="size" name="size">
                                        <option value="">Seleccionar</option>
                                        <?php
                                            foreach ($sizes as $size) {
                                                echo '<option value="'. ucfirst($size['variable']) .'">'. ucfirst($size['variable']) .'</option>';
                                            }
                                        ?>
                                    </select>
                               

                                  
                                    <p>cambiar color</p>
                           
                                    <div class="btn-group inline-block div_color_products" data-toggle="buttons">
                                        <?php  foreach ($colors as $color) {
                                                    echo '<label class="btn" style ="color:gray;    border-radius: 100px;">';
                                                    echo "<small>".$color['alias']."</small>";
                                                    echo '<input type="radio" name="color" code="'.$color['code'].'" alias="'.$color['alias'].'" value="'. $color['variable'] .'">';
                                                    echo '<div class="color-block" style="    border-radius: 100px;background-color: '. $color['variable'] .';"></div>';
                                                echo '</label>';
                                            }
                                        ?>
                                    </div>
                                  <p></p>
                              <a href="#" id="agregar-carro"  class="add">Agregar al carrito</a>
                              <div class="social">
                                <a href="https://www.facebook.com/pages/Ch%C3%A2telet/114842935213442" class="fb"></a>
                                <a href="https://twitter.com/chateletmoda" class="tt"></a>
                                <a href="https://www.instagram.com/chateletmoda/" class="pr"></a>
                              </div>
                          </div>
                        </div>
                       </li>
                    <?php endif ?> 
                  <?php endforeach ?>
              </ul>
           </div>
       </section>

