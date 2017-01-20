<?php
	echo $this->Session->flash();
?>    
       
        
        <div id="headshop"  >
         <h1 class="name_shop">Shop</h1>
         <img class="img_resp"src="<?php echo Configure::read('imageUrlBase').$image_bannershop ?>"  img-responsive>
            
        </div>
          
        <section id="filters">
            <div class="wrapper">
            </div>
        </section>
       
        <section id="listShop">
            <div class="wrapper">  
                <div class="row">
                     <div class="col-md-6">
                        <div class="row"> 
                            <div class="col-sm-5">
                                <?php if(!empty($categories[0])){ ?>
                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[0]['Category']['id']))) ?> class="pd1">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[0]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                       <?php echo $categories[0]['Category']['name']?><br>
                                        
                                    </span>
                                </a>
                                <?php } ?>

                                <?php if(!empty($categories[1])){ ?>
                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[1]['Category']['id']))) ?> class="pd1">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[1]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[1]['Category']['name']?><br><br>
                                        
                                    </span>
                                </a>
                                <?php } ?>
                               
                                <?php if(!empty($categories[2])){ ?>
                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[2]['Category']['id']))) ?> class="pd4">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[2]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[2]['Category']['name']?><br><br>
                                       
                                    </span>
                                </a>
                                <?php } ?>

                              

                            </div>
                            <div class="col-sm-7">
                                <?php if(!empty($categories[3])){ ?>
                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[3]['Category']['id']))) ?> class="pd2">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[3]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[3]['Category']['name']?><br><br>
                                        
                                    </span>
                                </a>
                                <?php } ?>

                                 <?php if(!empty($categories[4])){ ?>
                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[4]['Category']['id']))) ?> class="pd2">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[4]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[4]['Category']['name']?><br><br>
                                        
                                    </span>
                                </a>
                                <?php } ?>


                                <?php if(!empty($categories[11])){ ?>
                                    <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                             intval($categories[11]['Category']['id']))) ?> class="pd2">
                                        <img src=<?php echo Configure::read('imageUrlBase').$categories[11]['Category']['img_url']?> class="img-responsive">
                                        <span class="hover">
                                             <?php echo $categories[11]['Category']['name']?><br><br>
                                            
                                        </span>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-5">
                                 <?php if(!empty($categories[10])){ ?>
                                    <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                             intval($categories[10]['Category']['id']))) ?> class="pd2">
                                        <img src=<?php echo Configure::read('imageUrlBase').$categories[10]['Category']['img_url']?> class="img-responsive">
                                        <span class="hover">
                                             <?php echo $categories[10]['Category']['name']?><br><br>
                                            
                                        </span>
                                    </a>
                                <?php } ?>

                                <?php if(!empty($categories[5])){ ?>
                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[5]['Category']['id']))) ?> class="pd3">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[5]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[5]['Category']['name']?><br><br>
                                        
                                    </span>
                                </a>
                                <?php } ?>

                                <?php if(!empty($categories[6])){ ?>
                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[6]['Category']['id']))) ?> class="pd3">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[6]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[6]['Category']['name']?><br><br>
                                        
                                    </span>
                                </a>
                                <?php } ?>

                                 <?php if(!empty($categories[12])){ ?>
                                    <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                             intval($categories[12]['Category']['id']))) ?> class="pd2">
                                        <img src=<?php echo Configure::read('imageUrlBase').$categories[12]['Category']['img_url']?> class="img-responsive">
                                        <span class="hover">
                                             <?php echo $categories[12]['Category']['name']?><br><br>
                                            
                                        </span>
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="col-sm-7">
                                  <?php if(!empty($categories[8])){ ?>
                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[8]['Category']['id']))) ?> class="pd4">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[8]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[8]['Category']['name']?><br><br>
                                        
                                    </span>
                                </a>
                                <?php } ?>
                                <?php if(!empty($categories[7])){ ?>
                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[7]['Category']['id']))) ?> class="pd4">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[7]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[7]['Category']['name']?><br><br>
                                        
                                    </span>
                                </a>
                                <?php } ?>

                                <?php if(!empty($categories[13])){ ?>
                                    <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                             intval($categories[13]['Category']['id']))) ?> class="pd2">
                                        <img src=<?php echo Configure::read('imageUrlBase').$categories[13]['Category']['img_url']?> class="img-responsive">
                                        <span class="hover">
                                             <?php echo $categories[13]['Category']['name']?><br><br>
                                            
                                        </span>
                                    </a>
                                <?php } ?>

                                <?php if(!empty($categories[9])){ ?>
                                    <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                             intval($categories[9]['Category']['id']))) ?> class="pd2">
                                        <img src=<?php echo Configure::read('imageUrlBase').$categories[9]['Category']['img_url']?> class="img-responsive">
                                        <span class="hover">
                                             <?php echo $categories[9]['Category']['name']?><br><br>
                                            
                                        </span>
                                    </a>
                                <?php } ?>
                            </div><br clear="all">

                            <div class="col-sm-7">
                             

                                
                            </div>
                            <?php if(!empty($categories[14])){ ?>
                            <div class="col-sm-5">
                                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'product',
                                         intval($categories[14]['Category']['id']))) ?> class="pd2">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[14]['Category']['img_url']?> class="img-responsive">
                                    <span class="hover">
                                         <?php echo $categories[14]['Category']['name']?><br><br>
                                        
                                    </span>
                                </a>
                            </div>
                            <?php } ?>
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
