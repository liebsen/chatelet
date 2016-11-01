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
					<ul class="bxslider">
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
</div>