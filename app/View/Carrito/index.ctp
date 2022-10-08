<?php
	echo $this->Html->css('carrito.css?v=' . Configure::read('APP_DIST'), array('inline' => false));
	echo $this->Html->script('carrito.js?v=' . Configure::read('APP_DIST'), array('inline' => false));
	echo $this->Session->flash();
	echo $this->element('checkout-modal');
?>
<div id="main" class="container">
	<div class="row">
		<?php if(!empty($text_shipping_min_price) && !$freeShipping): ?>
		<div class="col-md-12 shipping-price-min-alert animated fadeIn">
			<div class="shipping-price-min-text">
				<span><?= $text_shipping_min_price ?></span>
			</div>		
		</div>
		<?php endif ?>
		<div class="col-md-12" id="siguiente-block">
			<a class="keep-buying cart-btn-green" href="/tienda">Seguir comprando</a>
			<!--a class="keep-buying cart-btn-green" href="/#q:">Seguir comprando</a-->
		</div>
	</div>
	<div class="row">
		<div id="carrito">
			<!--h3 id="heading" style="margin:10px 0px">Carrito de compras</h3-->
			<?php if (isset($carro) && !empty($carro)) :?>			
			<?php
				echo '<input type="hidden" id="loggedIn" value="'. (string) $loggedIn .'" />';
				echo '<input type="hidden" id="checkout" value="'. $this->Html->url(array('controller' => 'carrito', 'action' => 'checkout')) .'" />'
			?>
			<div class="carrito-row">
				<div class="carrito-col">
					<div class="carrito-items">
					<?php if (!isset($carro)) $carro = array();
				  $row = 0;
					$subtotal = 0;
					$total = 0;
					$promosaved = 0;

					foreach ($sorted as $product) {
						$total+= $product['price'];
						if (!isset($product['color'])) $product['color'] = '';
						if (!isset($product['size'])) $product['size'] = '';
		        if (isset($product['discount_label_show'])){
		          $number_disc = (int)@$product['discount_label_show'];
		        }

		        // $discount_flag = (@$product['category_id']!='134' && !empty($number_disc))?'<div class="ribbon bottom-left small"><span>'.$number_disc.'% OFF</span></div>':'';

						$item_url = $this->Html->url(array(
              'controller' => 'shop',
              'action' => 'detalle',
              $product['id'],
              $product['category_id'],
              strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product['name'])))
            ));
						echo '<div class="carrito-item-row is-clickable" product_row>';
						echo '<div class="carrito-remove animated fadeIn delay2" title="Eliminar del carrito">';
						echo $this->Html->link('<span class="glyphicon glyphicon-remove"></span>',
							array(
								'controller' => 'carrito',
								'action' => 'remove',
								$product['id']
							),
							array (
								'class' => 'trash',
								'escape' => false
							)
						);
						echo '</div>';
						echo '<div class="help" title="Modificar este item del carrito"><div><span class="glyphicon glyphicon-edit"></span> <span class="font-system"> modificar</span></div></div>';
						echo '<div class="carrito-item-col cart-img-col">';
						//echo "<div class='clearfix'></div>";
						echo "<div class='cart-img'>";
						if (!empty(intval($product['discount_label_show']))) {
							if (intval($product['price'])) {
								echo '<div class="ribbon bottom-left small"><span>'.$product['discount_label_show'].'% OFF</span></div>';
							} else {
								echo '<div class="ribbon bottom-left small"><span>GRATIS</span></div>';
							}
						}
						if (empty($product['price'])) {
							$promosaved+= (float) $product['old_price'];
						}
						if ($product['promo'] !== '') {							
							$disable = !isset($product['promo_enabled']) ? ' disable' : '';
							echo "<div class='ribbon".$disable."'><span>" . $product['promo'] . "</span></div>";
						}
            echo '<a href="' . $item_url . '">';
						// echo '<img src="'.Configure::read('imageUrlBase').($product['alias_image'] ?: $product['img_url'] ).'" class="thumb" style="display:block;" />';
						echo '<div class="carrito-item-image" style="background-image: url('.Configure::read('imageUrlBase').($product['alias_image'] ?: $product['img_url'] ).')"></div>';
						echo '</a>';
						echo '</div>';
						echo '</div>';
						echo '<div class="carrito-item-col carrito-data" data-json=\''.json_encode($product).'\'>';
						echo '<span class="name is-carrito">'. $product['name'] . '</span>';

						if (!empty($product['alias'])){
							echo '<p class="color">Color: <span class="talle" color-code="'.$product['color_code'].'">'. $product['alias'] .'</span></p>';
						}
						if (!empty($product['size'])){
							echo '<p class="color">Talle: <span class="talle">'. $product['size'] .'</span></p>';
						}
						echo '<p class="color">Cantidad: <span class="talle">'. $product['count'] .'</span></p>';
						echo '<br>';
						echo '<div class="text-right">';
						if (!empty($product['old_price']) && $product['old_price'] != $product['price']){
							echo '<span class="old_price text-grey animated fadeIn delay2">'. str_replace(',00','',$this->Number->currency($product['old_price'], 'ARS', array('places' => 2))) .'</span>';
						}					
						echo '<span class="price animated fadeIn delay">'. str_replace(',00','',$this->Number->currency($product['price'], 'ARS', array('places' => 2))) .'</span>';
						echo '</div>';
						echo '<div class="carrito-hide-element">
							<div class="form-inline">
							  <div class="form-group">
							    <div class="input-group carrito-selector">
							      <div class="input-group-addon input-lg is-clickable" onclick="removeCount()">
							       <span class="fa fa-minus"></span>
							      </div>
							      <input type="text" size="2" class="form-control product-count input-lg text-center" placeholder="Cantidad" value="' . $product['count'] . '" original-value="' . $product['count'] . '">
							      <div class="input-group-addon input-lg is-clickable" onclick="addCount()">
							       <span class="fa fa-plus"></span>
							       </div>
							    </div>
							  </div>
							</div>
							<span class="ch-btn-success btn-change-count disable">Cambiar</span>
						</div>';
						echo '</div>';
						echo '</div>';
						// echo '<hr>';
						$row += 1;
					} ?>
						<div class="animated fadeIn delay2">
							<input type="hidden" id="subtotal_compra" value="<?=floatval($total)?>" />
							<input type="hidden" id="subtotal_envio" value="" />
							<div class="field text-center mb-2 mr-1">
								<label>
								  <input type="checkbox" id="regalo" value="1" /><span class="label-text">Es para regalo</span>
								</label>
							</div>
							<?php if($freeShipping):?>
							<div class="field text-right free-shipping animated speed">
								<div class="price text-success">
									<span class="text-weight-thin">Envío </span>
									<span id="delivery_cp"></span> <span>gratuito</span></div>
							</div>
							<?php else: ?>
							<div class="field text-right delivery-cost hidden animated speed">
								<div class="price text-dark">
									<span class="text-weight-thin">Envía </span>
									<span id="delivery_cp"></span> <span class="cost_delivery">0</span></div>
							</div>
							<?php endif ?>
							<div class="field text-right products-total">
								<div class="price text-dark"><span class="text-weight-thin">Productos </span> <?= str_replace(',00','',$this->Number->currency($total + $promosaved, 'ARS', array('places' => 2))) ?></div>
							</div>
							<div class="field text-right <?= $promosaved ? '' : 'hidden' ?> animated speed">
								<div class="price text-success"><span class="text-weight-thin">Descuento </span><span class="">PROMO</span> <span><?= str_replace(',00','',$this->Number->currency($promosaved, 'ARS', array('places' => 2))) ?></span><!--span>.00</span--></div>
							</div>
							<div class="field text-right coupon-discount hidden animated speed">
								<div class="price text-success"><span class="text-weight-thin">Descuento </span><span class="promo-code"></span> <span class="coupon_bonus">0</span><!--span>.00</span--></div>
							</div>							
							<hr>
							<div class="field text-right">
								<div class="cost_total-container animated speed fadeIn delay">
									<!--hr-->
									<div class="price is-large"><span class="text-weight-thin">Total </span> <span class="cost_total"><?= str_replace(',00','',$this->Number->currency($total, 'ARS', array('places' => 2))) ?></span><!--span>.00</span--></div>
								</div>
							</div>
						</div>
					</div>
					<?php else: ?>
					<div class="container">
						<div class="price text-left">El carrito de compras está vacío.</div><div> Agregá al menos un producto para continuar.</div>
					</div>
					<br><br>
					<?php endif;?>
				</div>
				<div class="carrito-col">
				<?php 
					if (isset($carro) && !empty($carro)) {
						echo $this->element('shipping', array('freeShipping' => $freeShipping, 'carrito_takeaway_text' => $carrito_takeaway_text));
						echo $this->element('coupon', array('total' => $total));
						// echo $this->element('cart-toolbox', array('freeShipping' => $freeShipping, 'total' => $total));
					}					
				?>
				</div>
			</div>
		</div>
	</div>
					
	<?php if (isset($carro) && !empty($carro)) :?>
	<div id="carritoItem" class="menuLayer has-item-counter animated">
	  <a class="close">
	    <span></span>
	    <span></span>
	  </a>
	  <div class="carousel carousel-carrito" id="carousel-example-generic">
	  	<div class="carousel-inner">
				<div class="carrito-item">
					<div class="carrito-item-block"></div>
				</div>
			</div>
			<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="arrow arrow-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="arrow arrow-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
	  </div>
	</div>
	<input type="hidden" id="shipping_price_min" value="<?= $shipping_price_min ?>">
	<input type="hidden" id="total" value="<?= $total ?>">
	<div class="row">
		<div class="col-md-1"></div>
		<div id="siguiente-block" class="col-md-10">
		<a href="javascript:void(0)" class="disabled cart-btn-green cart-go-button" link-to="<?=Router::url('/carrito/checkout',true)?>" id="siguiente">Siguiente</a>
		</div>
		<div class="col-md-1"></div>
	</div>
	<?php endif;?>
	<!--div class="row">
		<div class="col-md-4"></div>
		<div id="instrucciones" class="col-md-4">
			<p id="como-comprar">Como comprar</p>
			<ol id="como-comprar-list">
				<li>Selecciona todos los productos que deseas</li>
				<li>Agregalos al carro de comprar</li>
				<li>Ingresa a tu carro y presiona <strong>SIGUIENTE</strong></li>
			</ol>
			<a id="paypal">
				<?php echo $this->Html->image('mercadopago.png',array('width'=>300)); ?>
			</a>
		</div>
		<div class="col-md-4"></div>
	</div-->
</div>
