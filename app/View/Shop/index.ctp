<?php
	echo $this->Session->flash();
?>

        <style type="text/css">
          .img-cover {
            object-fit: cover;
						object-position: top center;
            width:100%;
          }

        </style>
        <div id="headshop"  >
         <h1 class="name_shop">Shop</h1>
         <img class="img_resp" src="<?php echo Configure::read('imageUrlBase').$image_bannershop ?>"  img-responsive>

        </div>

        <section id="filters">
            <div class="wrapper">
            </div>
        </section>

        <section id="listShop">
            <div class="wrapper">
                <div class="row">
                     <div class="col-xs-12">
                        <div class="row">
                                <?php if(!empty($categories[0])){ ?>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($categories[0]['Category']['name'])))); ?>" class="pd1">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[0]['Category']['img_url']?> class="img-responsive img-cover">
                                    <span class="hover hidden-force">
                                       <?php echo $categories[0]['Category']['name']?><br>

                                    </span>
                                <?php if (@$_GET['testing']=='1' || false && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106 && strtolower($categories[0]['Category']['name'])!='liquidacion'){ echo '<div class="discount-flag">20% OFF</div>'; } ?></a>
                                </div>
                                <?php } ?>

                                <?php if(!empty($categories[1])){ ?>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($categories[1]['Category']['name'])))); ?>" class="pd1">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[1]['Category']['img_url']?> class="img-responsive img-cover">
                                    <span class="hover hidden-force">
                                         <?php echo $categories[1]['Category']['name']?><br><br>

                                    </span>
                                <?php if (@$_GET['testing']=='1' || false && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106 && strtolower($categories[1]['Category']['name'])!='liquidacion'){ echo '<div class="discount-flag">20% OFF</div>'; } ?></a>
                                </div>
                                <?php } ?>

                                <?php if(!empty($categories[2])){ ?>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($categories[2]['Category']['name'])))); ?>" class="pd4">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[2]['Category']['img_url']?> class="img-responsive img-cover">
                                    <span class="hover hidden-force">
                                         <?php echo $categories[2]['Category']['name']?><br><br>

                                    </span>
                                <?php if (@$_GET['testing']=='1' || false && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106 && strtolower($categories[2]['Category']['name'])!='liquidacion'){ echo '<div class="discount-flag">20% OFF</div>'; } ?></a>
                                </div>
                                <?php } ?>




                                <?php if(!empty($categories[3])){ ?>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($categories[3]['Category']['name'])))); ?>" class="pd2">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[3]['Category']['img_url']?> class="img-responsive img-cover">
                                    <span class="hover hidden-force">
                                         <?php echo $categories[3]['Category']['name']?><br><br>

                                    </span>
                                <?php if (@$_GET['testing']=='1' || false && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106 && strtolower($categories[3]['Category']['name'])!='liquidacion'){ echo '<div class="discount-flag">20% OFF</div>'; } ?></a>
                                </div>
                                <?php } ?>

                                 <?php if(!empty($categories[4])){ ?>
                                 <div class="col-xs-12 col-sm-6 col-md-4">
                                <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($categories[4]['Category']['name'])))); ?>" class="pd2">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[4]['Category']['img_url']?> class="img-responsive img-cover">
                                    <span class="hover hidden-force">
                                         <?php echo $categories[4]['Category']['name']?><br><br>

                                    </span>
                                <?php if (@$_GET['testing']=='1' || false && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106 && strtolower($categories[4]['Category']['name'])!='liquidacion'){ echo '<div class="discount-flag">20% OFF</div>'; } ?></a>
                                </div>
                                <?php } ?>


                                <?php if(!empty($categories[11])){ ?>
                                <div class="col-xs-12 col-sm-6 col-md-4">

                                    <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($categories[11]['Category']['name'])))); ?>" class="pd2">
                                        <img src=<?php echo Configure::read('imageUrlBase').$categories[11]['Category']['img_url']?> class="img-responsive img-cover">
                                        <span class="hover hidden-force">
                                             <?php echo $categories[11]['Category']['name']?><br><br>

                                        </span>
                                    <?php if (@$_GET['testing']=='1' || false && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106 && strtolower($categories[11]['Category']['name'])!='liquidacion'){ echo '<div class="discount-flag">20% OFF</div>'; } ?></a>
                                  </div>
                                <?php } ?>

                                 <?php if(!empty($categories[10])){ ?>
                                 <div class="col-xs-12 col-sm-6 col-md-4">
                                    <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($categories[10]['Category']['name'])))); ?>" class="pd2">
                                        <img src=<?php echo Configure::read('imageUrlBase').$categories[10]['Category']['img_url']?> class="img-responsive img-cover">
                                        <span class="hover hidden-force">
                                             <?php echo $categories[10]['Category']['name']?><br><br>

                                        </span>
                                    <?php if (@$_GET['testing']=='1' || false && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106 && strtolower($categories[10]['Category']['name'])!='liquidacion'){ echo '<div class="discount-flag">20% OFF</div>'; } ?></a>
                                    </div>
                                <?php } ?>

                                <?php if(!empty($categories[5])){ ?>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($categories[5]['Category']['name'])))); ?>" class="pd3">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[5]['Category']['img_url']?> class="img-responsive img-cover">
                                    <span class="hover hidden-force">
                                         <?php echo $categories[5]['Category']['name']?><br><br>

                                    </span>
                                <?php if (@$_GET['testing']=='1' || false && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106 && strtolower($categories[5]['Category']['name'])!='liquidacion'){ echo '<div class="discount-flag">20% OFF</div>'; } ?></a>
                                </div>
                                <?php } ?>

                                <?php if(!empty($categories[6])){ ?>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($categories[6]['Category']['name'])))); ?>" class="pd3">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[6]['Category']['img_url']?> class="img-responsive img-cover">
                                    <span class="hover hidden-force">
                                         <?php echo $categories[6]['Category']['name']?><br><br>

                                    </span>
                                <?php if (@$_GET['testing']=='1' || false && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106 && strtolower($categories[6]['Category']['name'])!='liquidacion'){ echo '<div class="discount-flag">20% OFF</div>'; } ?></a>
                                </div>
                                <?php } ?>

                                 <?php if(!empty($categories[12])){ ?>
                                 <div class="col-xs-12 col-sm-6 col-md-4">
                                    <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($categories[12]['Category']['name'])))); ?>" class="pd2">
                                        <img src=<?php echo Configure::read('imageUrlBase').$categories[12]['Category']['img_url']?> class="img-responsive img-cover">
                                        <span class="hover hidden-force">
                                             <?php echo $categories[12]['Category']['name']?><br><br>

                                        </span>
                                    <?php if (@$_GET['testing']=='1' || false && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106 && strtolower($categories[12]['Category']['name'])!='liquidacion'){ echo '<div class="discount-flag">20% OFF</div>'; } ?></a>
                                    </div>
                                <?php } ?>


                                  <?php if(!empty($categories[8])){ ?>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($categories[8]['Category']['name'])))); ?>" class="pd4">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[8]['Category']['img_url']?> class="img-responsive img-cover">
                                    <span class="hover hidden-force">
                                         <?php echo $categories[8]['Category']['name']?><br><br>

                                    </span>
                                <?php if (@$_GET['testing']=='1' || false && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106 && strtolower($categories[8]['Category']['name'])!='liquidacion'){ echo '<div class="discount-flag">20% OFF</div>'; } ?></a>
                                </div>
                                <?php } ?>
                                <?php if(!empty($categories[7])){ ?>
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($categories[7]['Category']['name'])))); ?>" class="pd4">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[7]['Category']['img_url']?> class="img-responsive img-cover">
                                    <span class="hover hidden-force">
                                         <?php echo $categories[7]['Category']['name']?><br><br>

                                    </span>
                                <?php if (@$_GET['testing']=='1' || false && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106 && strtolower($categories[7]['Category']['name'])!='liquidacion'){ echo '<div class="discount-flag">20% OFF</div>'; } ?></a>
                                </div>
                                <?php } ?>

                                <?php if(!empty($categories[13])){ ?>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                    <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($categories[13]['Category']['name'])))); ?>" class="pd2">
                                        <img src=<?php echo Configure::read('imageUrlBase').$categories[13]['Category']['img_url']?> class="img-responsive img-cover">
                                        <span class="hover hidden-force">
                                             <?php echo $categories[13]['Category']['name']?><br><br>

                                        </span>
                                    <?php if (@$_GET['testing']=='1' || false && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106 && strtolower($categories[13]['Category']['name'])!='liquidacion'){ echo '<div class="discount-flag">20% OFF</div>'; } ?></a>
                                    </div>
                                <?php } ?>

                                <?php if(!empty($categories[9])){ ?>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                    <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower('trajes-de-bano')))); ?>" class="pd2 pdlast">
                                        <img src=<?php echo Configure::read('imageUrlBase').$categories[9]['Category']['img_url']?> class="img-responsive img-cover">
                                        <span class="hover hidden-force">
                                             <?php echo $categories[9]['Category']['name']?><br><br>

                                        </span>
                                    <?php if (@$_GET['testing']=='1' || false && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106 && strtolower($categories[9]['Category']['name'])!='liquidacion'){ echo '<div class="discount-flag">20% OFF</div>'; } ?></a>
                                    </div>
                                <?php } ?>


                            <?php if(!empty($categories[14])){ ?>
                            <div class="col-xs-12 col-sm-6 col-md-4"><a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($categories[14]['Category']['name'])))); ?>" class="pd2">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[14]['Category']['img_url']?> class="img-responsive img-cover">
                                    <span class="hover hidden-force">
                                         <?php echo $categories[14]['Category']['name']?><br><br>

                                    </span>
                                <?php if (@$_GET['testing']=='1' || false && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106 && strtolower($categories[14]['Category']['name'])!='liquidacion'){ echo '<div class="discount-flag">20% OFF</div>'; } ?></a>
															</div>

                            <?php } ?>

			<?php if(!empty($categories[16])){ ?>
                            <div class="col-xs-12 col-sm-6 col-md-4"><a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('  ',' '),array('n','-'),
                                strtolower($categories[16]['Category']['name'])))); ?>" class="pd2">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[16]['Category']['img_url']?> class="img-responsive img-cover">
                                    <span class="hover hidden-force">
                                         <?php echo $categories[16]['Category']['name']?><br><br>

                                    </span>
                                <?php if (@$_GET['testing']=='1' || false && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106 && strtolower($categories[16]['Category']['name'])!='liquidacion'){ echo '<div class="discount-flag">20% OFF</div>'; } ?></a>
															</div>

                            <?php } ?>

                            <?php if(!empty($categories[15])){ ?>
                            <div class="col-xs-12 col-sm-6 col-md-4"><a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),
				strtolower($categories[15]['Category']['name'])))); ?>" class="pd2">
                                    <img src=<?php echo Configure::read('imageUrlBase').$categories[15]['Category']['img_url']?> class="img-responsive img-cover">
                                    <span class="hover hidden-force">
                                         <?php echo $categories[15]['Category']['name']?><br><br>

                                    </span>
                                <?php if (@$_GET['testing']=='1' || false && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106 && strtolower($categories[15]['Category']['name'])!='liquidacion'){ echo '<div class="discount-flag">20% OFF</div>'; } ?></a>
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
