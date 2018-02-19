
<?php
  echo $this->Html->css('w3', array('inline' => false));
  
	echo $this->Html->script('catalogo', array('inline' => false));
  echo $this->Html->script('catalogo2', array('inline' => false));
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
                <p><?php echo $catalog_first_line; ?><br><?php echo $catalog_second_line; ?></p>
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
                   <!-- Controls -->
                  <a class="left carousel-control" href="#carousel2" role="button" data-slide="prev">
                    <span class="arrow arrow-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#carousel2" role="button" data-slide="next">
                    <span class="arrow arrow-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">
                    <?php 
                     
                      foreach ($lookbook as $key => $value):
                          if (empty($value))
                            continue; 
                          $alt_product = $value['LookBook'];
                          $img = str_replace([".jpg", ".JPG"], "", $alt_product['img_url']);
                          $url = $this->Html->url(array(
                                  'controller' => 'catalogo',
                                  'action' => 'index',
                                  $img
                              )
                          ); ?>
                        
                            <div class="item <?php if(empty($this->params['pass'][0]) && !$key){echo 'active';} 
                            elseif(!empty($this->params['pass'][0]) && $img==$this->params['pass'][0]){ echo 'active';}?>"
                            data-img="<?=$img?>">
                             
                              <img id="img_padding" style="cursor:pointer;" onclick="javascript:window.location.href='<?php echo $url  ?>';" 
                               src="<?php echo Configure::read('imageUrlBase').$value['LookBook']['img_url'] ?>" >
                               
                           
                          </div>
                          
                  <?php endforeach; ?> 
                  </div>
             </div>
           </div>
           
           <?php if(!empty($product)){ ?>   
           <div class="col-md-7">
            <h3>Elegí tu look para vivir tu momento.</h3> 
              <ul> 
                 <?php foreach ($product as $k => $v) : ?> 
                    <?php if (!empty($v)): ?>
                       <?php
                          echo $this->Form->create(null, array(
                              'url' => array(
                                  'controller' => 'carrito',
                                  'action' => 'add'
                              ),  
                              'id' => 'productForm',
                              'data-url' => Router::url(array( 'controller' => 'shop','action' => 'stock' )),
                              'data-article' => $v['Product']['article']
                          ));
                      ?>
                      <li class="lc" style="border-bottom: 2px solid #c2c2c2;margin-bottom: 45px;padding-bottom: 45px;">
                        <div class="row">
                          <div class="col-sm-3">
                            <img  class="img-responsive"   src="<?php echo Configure::read('imageUrlBase').$v['Product']['img_url'] ?>" >
                          </div>
                          <div class="col-sm-9">
                              <span class="hidden" id="product_id"><?php echo $v['Product']['id']; ?></span>
                              <h2><?php echo $v['Product']['name']; ?></h2>
                                <p>Art. <span><?php echo $v['Product']['article']; ?></span></p>  
                                <p><span><?php echo $v['Product']['desc']; ?></span></p>  
                                <p> <?php  if(!empty($v['Product']['discount'])) {
                                      echo "Antes "."<span style='color:gray;text-decoration: line-through;' id='price' data-price='". $v['Product']['price'] ."'>".
                                           $this->Number->currency($v['Product']['price'], 'USD', array('places' => 0)). "</span>
                                           ahora <span      style='padding: 3px;float: none;'' class='price'>".'$'. $v['Product']['discount']."</span>"; 
                                    }else{
                                      echo  "<span id='price' class='price' data-price='". $v['Product']['price'] ."'>".
                                            $this->Number->currency($v['Product']['price'], 'USD', array(
                                            'places' => 0)). "</span>";
                                 }?>
                                <?php  $colors = array();
                                      $sizes = array();     
                                      foreach ($properties_all as $property) { 
                                          if($property['ProductProperty']['product_id'] == $v['Product']['id']){ 
                                          switch ($property['ProductProperty']['type']) {
                                              case 'color':
                                              array_push($colors, $property['ProductProperty']);
                                              break;
                                              case 'size':
                                              array_push($sizes, $property['ProductProperty']);
                                              break; 
                                          }
                                        }
                                      }
                                ?>
                                <h2>Color</h2>
                                  <div class="btn-group inline-block div_color_products" data-toggle="buttons">
                                      <?php  foreach ($colors as $color) {
                                                  echo '<label class="btn" style ="    border-radius: 100px;">';
                                                  echo "<small>".$color['alias']."</small>";
                                                  echo '<input type="radio" name="color" code="'.$color['code'].'" alias="'.$color['alias'].'" value="'. $color['variable'] .'">';
                                                  echo '<div class="color-block" style="padding: 10px; border-radius: 100px;background-color: '. $color['variable'] .';"></div>';
                                              echo '</label>';
                                          }
                                      ?>
                                  </div>
                                 <h4></h4>                    
                                 <h2>Talle
                                  <select id="size" name="size" style="background-color: white; " >
                                      <option value="">Seleccionar</option>
                                      <?php
                                          foreach ($sizes as $size) {
                                              echo '<option value="'. ucfirst($size['variable']) .'">'. ucfirst($size['variable']) .'</option>';
                                          }
                                      ?>
                                  </select>
                                 <a class="table" data-toggle="modal" data-target="#myModal2">Ver tabla de talles</a><h4></h4> 
                        
                             <p> <span style="color:#F50081;">Stock:</span> <span id="stock_container" ><i> (Seleccione un color y talle) </i></span></p>
                              <div class="footer-producto">
                                 <a href="#" id="agregar-carro" class="add agregar-carro" >Agregar a mi carro</a>
                              </div>
                            <?php echo $this->Form->end(); ?>
                             
                          </div>
                        </div>
                      </li>

                    <?php endif ?> 
                  <?php endforeach ?>
              </ul>
           </div>
           <?php } ?>
      </section>
<div class="modal fade" tabindex="-1" id="myModal2" role="dialog">
    <div class="content">
        <a class="close" data-dismiss="modal">
            <span></span>
            <span></span>
        </a>
  <?php if (!empty($talle_img)): ?>
    <div align="center" class="centered">
        <img style="max-width:100%;" src="<?=Configure::read('imageUrlBase')?><?=$talle_img?>" border="0" />
    </div>
  <?php else: ?>
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
      <?php endif; ?>
    </div>
</div>





