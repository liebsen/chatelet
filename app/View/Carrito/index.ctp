<?php
	echo $this->Html->css('carrito.css?v=' . Configure::read('APP_DIST'), array('inline' => false));
	echo $this->Html->script('carrito.js?v=' . Configure::read('APP_DIST'), array('inline' => false));
	echo $this->Session->flash();
	echo $this->element('checkout-modal');
?>
<div id="main" class="container">
	<div class="row">
		<div class="col-md-12" id="siguiente-block">
			<a class="keep-buying cart-btn-green" href="/tienda">Seguir comprando</a>
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

					foreach ($carro as $product) {
						$total += $product['price'];
						if (!isset($product['color'])) $product['color'] = '';
						if (!isset($product['size'])) $product['size'] = '';
						$url = $this->Html->url(array(
              'controller' => 'shop',
              'action' => 'detalle',
              $product['id'],
              $product['category_id'],
              strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product['name'])))
            ));
						echo '<div class="carrito-item-row" product_row>';
							echo '<div class="carrito-item-col cart-img-col">';
							//echo "<div class='clearfix'></div>";
								echo "<div class='cart-img'>";
								if ($product['promo'] !== '' && isset($product['old_price'])) {
									$promosaved+= (float) $product['old_price'] - $product['price'];
									echo "<div class='ribbon small'><span>" . $product['promo'] . "</span></div>";
								}
                echo '<a href="' . $url . '">';
								echo '<img src="'.Configure::read('imageUrlBase').($product['alias_image'] ?: $product['img_url'] ).'" class="thumb" style="display:block;" />';
								echo '</a>';
							echo '</div>';
							echo '</div>';
							echo '<div class="carrito-item-col">';
							echo '<span class="name">'. $product['name'] . '</span>';
							if (!empty($product['alias'])){
								echo '<p class="color">Color: <span class="talle">'. $product['alias'] .'</span></p>';
							}
							if (!empty($product['size'])){

								echo '<p>Talle: <span class="talle">'. $product['size'] .'</span></p>';
							}
							echo $this->Html->link('<span class="glyphicon glyphicon-trash"></span>',
								array(
									'controller' => 'carrito',
									'action' => 'remove',
									$row
								),
								array (
									'class' => 'trash',
									'escape' => false
								)
							);

							echo '<br>';
							if (!empty($product['old_price'])){
								echo '<div class="old_price text-grey">'. $this->Number->currency($product['old_price'], 'ARS', array('places' => 2)) .'</div>';
							}					
							echo '<div class="price' . (!empty($product['old_price']) ? ' text-theme' : '' ) . '">'. $this->Number->currency($product['price'], 'ARS', array('places' => 2)) .'</div>';
						echo '</div>';
						echo '</div>';
						echo '<hr>';
						$row += 1;
					} ?>
						<input type="hidden" id="subtotal_compra" value="<?=floatval($total)?>" />
						<input type="hidden" id="subtotal_envio" value="" />
						<div class="field text-right mb-2">
							<input type="checkbox" id="ticket_cambio" value="1" /> <label for="ticket_cambio">Es para regalo</label>
						</div>
						<?php if($freeShipping):?>
						<div class="field text-right free-shipping animated speed">
							<div class="price text-theme">
								<span class="text-weight-thin">Envío </span>
								<span id="delivery_cp"></span> <span>gratuito</span></div>
						</div>
						<?php else: ?>
						<div class="field text-right delivery-cost hidden animated speed">
							<div class="price text-dark">
								<span class="text-weight-thin">Envío </span>
								<span id="delivery_cp"></span> $<span class="cost_delivery">0</span><span>.00</span></div>
						</div>
						<?php endif ?>
						<div class="field text-right products-total">
							<div class="price text-dark"><span class="text-weight-thin">Productos </span> <?= $this->Number->currency($total, 'ARS', array('places' => 2)) ?></div>
						</div>
						<div class="field text-right coupon-discount hidden animated speed">
							<div class="price text-theme"><span class="text-weight-thin">Descuento </span><span class="promo-code"></span> $<span class="coupon_bonus">0</span><!--span>.00</span--></div>
						</div>
						<?php if($promosaved):?>
						<div class="field text-right animated speed slideInUp">
							<div class="price text-theme">
								<span class="text-weight-thin">Ahorro promo </span>
								$<span class=""><?= \price_format($promosaved) ?></span>
							</div>
						</div>
						<?php endif ?>
						<hr>
						<div class="field text-right">
							<div class="cost_total-container animated speed fadeIn delay">
								<!--hr-->
								<div class="price"><span class="text-weight-thin">Total </span> $<span class="cost_total"><?= \price_format($total) ?></span><!--span>.00</span--></div>
							</div>
						</div>
						<div class="mobile">
							<hr>
						</div>
					</div>
					<?php else: ?>
					<div class="price text-left">El carrito de compras está vacío.</div><div> Intente agregar productos para comprar.</div>
					<br><br>
					<?php endif;?>
				</div>
				<div class="carrito-col">
				<?php 
					if (isset($carro) && !empty($carro)) {
						echo $this->element('shipping', array('freeShipping' => $freeShipping));
						echo $this->element('coupon', array('total' => $total));
						// echo $this->element('cart-toolbox', array('freeShipping' => $freeShipping, 'total' => $total));
					}					
				?>
				</div>
			</div>
		</div>
	</div>
					
	<?php if (isset($carro) && !empty($carro)) :?>
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
