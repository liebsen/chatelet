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

        <section id="filters">
            <div class="wrapper">
              <!--  <div class="row">
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


<!--

<div id="main" class="container">
	<?php 
		echo $this->Html->link('Volver', array('controller' => 'shop', 'action' => 'index'), array('class' => 'heading')); 
	?>


	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-5">
					<?php 
						$images 	= array();
						$images[]	= $product['img_url'];
						$gallery 	= explode(';', $product['gallery']);
						foreach ( $gallery as $key => $image) {
							$images[] = $image;
						}
					?>
					<!--
					<a href="<?php echo $this->webroot . 'files/uploads/' . $product['img_url']; ?>" data-lightbox="slider">
						<img class="img-responsive" src="<?php echo $this->webroot . 'files/uploads/' . $product['img_url']; ?>" />
					</a>
					-->
	<!--				<ul class="bxslider">
						<?php foreach ($images as $key => $value): ?>
							<?php if (!empty($value)): ?>
								<li style="margin-left:-40px;"><img style="width:100%;" elevate-zoom src="<?php echo $this->webroot . 'files/uploads/' . $value; ?>" /></li>
							<?php endif ?>
						<?php endforeach ?>
					</ul>
					<div class="thumbs">
							<h4 class="text-center">Otras opciones</h4>
							<?php 
								foreach($all_but_me as $alt_product):
									$alt_product = $alt_product['Product'];
									$url = $this->Html->url(array(
											'controller' => 'shop',
											'action' => 'product',
											$alt_product['id'],
											$alt_product['category_id']
										)
									);
							?>
							<a href="<?php echo $url ?>" title="<?php echo $alt_product['name'] ?>">
								<img class="thumb" src="<?php echo $this->webroot . 'files/uploads/' . $alt_product['img_url'] ?>" alt="">
							</a>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-md-7">
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
					<h3 id="name">
						<?php echo $product['name']; ?>
					</h3>
					<p class="small">
						Art. <span id="article"><?php echo $product['article']; ?></span>
						<?php  
							$image_detail = $this->webroot . 'img/talles.jpg';
							if(!empty($category['Category']['size'])){
								
								$image_detail = $this->webroot . 'files/uploads/' . $category['Category']
								['size'];

								echo '<img class="info-icon" src='.$this->webroot.'img/info-icon.png 		alt="Info" data-image='.$image_detail.'"';
										
							}
						?>
						
					</p>
					<?php echo "
					<div>
					<span style='color:red;font-size:20px'>". $product['desc']."</span>
					<h2 id='price' data-price='". $product['price'] ."'>".
					$this->Number->currency($product['price'], 'USD', array(
								'places' => 0
							)). "</div>"; ?>
					
					<p class="inline-block">Color:</p>
						<div class="btn-group inline-block div_color_products" data-toggle="buttons">
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

								foreach ($colors as $color) {
										echo '<label class="btn">';
										echo "<small>".$color['alias']."</small>";
										echo '<input type="radio" name="color" code="'.$color['code'].'" alias="'.$color['alias'].'" value="'. $color['variable'] .'">';
										/*echo '<div class="color-block" style="background-color: '. $color['variable'] .';"></div>';*/
									echo '</label>';
								}
							?>
						</div>
					<p>
						Talle: 
						<select id="size" name="size">
							<option value="">Seleccionar</option>
							<?php
								foreach ($sizes as $size) {
									echo '<option value="'. ucfirst($size['variable']) .'">'. ucfirst($size['variable']) .'</option>';
								}
							?>
						</select>
					</p>
					<p>
						Stock: <span id="stock_container"><i> (Seleccione un color y talle) </i></span>
					</p>
					<div class="footer-producto">
						<a href="#" id="agregar-carro" disabled>Agregar a mi carro</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br />
	<br />
	<br />
	<br />
</div>-->