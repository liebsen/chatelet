<?php
	echo $this->Html->script('elevatezoom-master/jquery.elevatezoom', array('inline' => false));

	echo $this->Html->css('jquery.bxslider', array('inline' => false));
	echo $this->Html->script('jquery.bxslider', array('inline' => false));
	echo $this->Html->css('product', array('inline' => false));
	echo $this->Html->script('product', array('inline' => false));
	/* Lightbox */
	echo $this->Html->css('lightbox', array('inline' => false));
	echo $this->Html->script('lightbox.min', array('inline' => false));
	
	echo $this->Session->flash();
?>

        <div id="headabrigos">
            <h1> <?php echo $name_categories; ?> </h1>
        </div>

        <!--  <section id="filters">
            <div class="wrapper">
              <div class="row">
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
            </div>
        </section>-->

        <section id="productOptions">
            <div class="wrapper">
                <div class="row">
                    <div class="col-sm-3">
                        <nav>
                            <ul>
                                <?php  
				                    foreach ($categories as $category) {
				                        $category = $category['Category'];
				                        echo '<li>';
				                        echo $this->Html->link(
				                            $category['name'], 
				                            array(
				                                'controller' => 'shop',
				                                'action' => 'product',
				                                intval($category['id'])
				                            )
				                        );
				                        echo '</li>';
				                    }
				                   ?>
                            </ul>
                        </nav>
                    </div>

                    <div class="col-sm-9">
                      
					<?php
						function createSection($item, $ctrl, $isProduct = false) {
							$stock = (!empty($item['stock']))?1:0;
							$content = '<img class="img-responsive"  src="'. Configure::read('imageUrlBase') . $item['img_url'] .'" />'.
								'<span class="hover">'.
									'<small>'. $item['name'] .'</small>'.
								'</span>';
							$url = array(
								'controller' => 'shop',
								intval($item['id'])
							);

							if (!empty($item['category_id'])) {
								$url[] = intval($item['category_id']);
							}

							if ($isProduct) {
								$url['action'] = 'detalle';
							} else {
								$url['action'] = 'index';
							}

 							/*if(!$stock && $isProduct){
									echo $ctrl->Html->link(
										'<img src="'.Router::url('/').'images/agotado3.png" class="out_stock" />',
										$url,
										array('escape' => false)
									);
                            }*/
								
	                       echo '<div class="col-md-4 col-sm-6"> '.
								 $ctrl->Html->link(
									$content,
									$url,
									array('escape' => false)
								). '</div>';
							
						}

						if (isset($products)) {
							foreach ($products as $product) {
								createSection($product['Product'], $this, true);
							}
						} else {
							foreach ($categories as $category) {
								createSection($category['Category'], $this);
							}
						}
					?>
       
		      
		
                    </div>
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

