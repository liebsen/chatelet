<?php
	echo $this->Html->css('shop', array('inline' => false));
	echo $this->Session->flash();
?>
        <div id="headshop" style="background-image: url(<?php echo Configure::read('imageUrlBase').$image_prodshop ?>) no-repeat center center;">
            <h1>Shop</h1>
        </div>
          
        <section id="filters">
            <div class="wrapper">
               <!-- <div class="row">
                    <div class="col-md-4 colors">
                        <h3>Color</h3>
                        <a href="#" class="color celeste"></a>
                        <a href="#" class="color rosa"></a>
                        <a href="#" class="color grisclaro"></a>
                        <a href="#" class="color marron"></a>
                        <a href="#" class="color grisoscuro"></a>
                        <a href="#" class="color verde"></a>
                        <a href="#" class="color azul"></a>
                    </div>
                    <div class="col-md-4 size">
                        <h3>Talle</h3>
                        <a href="#">45</a>
                        <a href="#">44</a>
                        <a href="#">46</a>
                        <a href="#">48</a>
                        <a href="#">50</a>
                        <a href="#">52</a>
                        <a href="#">54</a>
                        <a href="#">56</a>
                    </div>
                    <div class="col-md-4 prices">
                        <h3>Precio</h3>
                        <label><span class="active"><i></i></span><input type="radio" name="price" checked="checked"> $150 - $400</label>
                        <label><span><i></i></span><input type="radio" name="price"> $400 - $700</label>
                        <label><span><i></i></span><input type="radio" name="price"> + $700</label>
                    </div>
                </div>-->
            </div>
        </section>
       
        <section id="listShop">
            <div class="wrapper">  
                <div class="row">
                <?php //pr($categories);die;// foreach ($categories as $category) : ?>
                    <div class="col-md-6">
                        <div class="row"> 
                            <div class="col-sm-5">
                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[0]['Category']['id']))) ?> class="pd1">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[0]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                       <?php echo $categories[0]['Category']['name']?><br>
                                        
                                    </span>
                                </a>

                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[1]['Category']['id']))) ?> class="pd1">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[1]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[1]['Category']['name']?><br><br>
                                        
                                    </span>
                                </a>

                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[2]['Category']['id']))) ?> class="pd4">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[2]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[2]['Category']['name']?><br><br>
                                       
                                    </span>
                                </a>
                            </div>
                            <div class="col-sm-7">
                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[3]['Category']['id']))) ?> class="pd2">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[3]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[3]['Category']['name']?><br><br>
                                        
                                    </span>
                                </a>

                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[4]['Category']['id']))) ?> class="pd2">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[4]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[4]['Category']['name']?><br><br>
                                        
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-5">
                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[5]['Category']['id']))) ?> class="pd3">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[5]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[5]['Category']['name']?><br><br>
                                        
                                    </span>
                                </a>

                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[6]['Category']['id']))) ?> class="pd3">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[6]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[6]['Category']['name']?><br><br>
                                        
                                    </span>
                                </a>
                            </div>
                            <div class="col-sm-7">
                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[7]['Category']['id']))) ?> class="pd4">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[7]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[7]['Category']['name']?><br><br>
                                        
                                    </span>
                                </a>
                            </div><br clear="all">

                            <div class="col-sm-7">
                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[8]['Category']['id']))) ?> class="pd4">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[8]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[8]['Category']['name']?><br><br>
                                        
                                    </span>
                                </a>
                            </div>
                            <div class="col-sm-5">
                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[9]['Category']['id']))) ?> class="pd2">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[9]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[9]['Category']['name']?><br><br>
                                        
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                  <?php //endforeach; ?>  
                </div>
            </div>
        </section>

        <section id="infoShop">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-4 bx1">
                        Las prendas que estan en el Shop como principal en cada rubro, no estan a la venta.
                    </div>
                    <div class="col-md-4 bx2 blr">
                        Los cambios se realizan dentro de los 30 días de efectuada la compra en cualquiera de las sucursales presentando el ticket correspondiente. 
                    </div>
                    <div class="col-md-4 bx3">
                        Las prendas deben estar sin uso y con la etiqueta de código de barras correspondiente adherida.
                    </div>
                </div>
            </div>
        </section>
