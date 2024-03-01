<?php
	echo $this->Session->flash();
	echo $this->Html->css('carrito.css?v=' . Configure::read('DIST_VERSION'), array('inline' => false));
	echo $this->Html->script('carrito-lib.js?v=' . Configure::read('DIST_VERSION'), array('inline' => false));
	echo $this->Html->script('carrito.js?v=' . Configure::read('DIST_VERSION'), array('inline' => false));
	echo $this->element('checkout-modal');
	$payment_methods = [
		'bank' => 'transferencia',
		'mercadopago' => 'mercado pago',
	];
?>
<script>
	var shipping_price = '<?= @$shipping_price ?>';
	var carrito_config = <?php echo json_encode($config, JSON_PRETTY_PRINT);?>;
	var carrito_items = <?php echo json_encode($carro, JSON_PRETTY_PRINT);?>;
	var bank = {
		enable: <?= isset($data['bank_enable']) ? $data['bank_enable'] : 0 ?>,
		discount_enable: <?= isset($data['bank_discount_enable']) ? $data['bank_discount_enable'] : 0 ?>,
		discount: <?= isset($data['bank_discount']) ? $data['bank_discount'] : 0 ?>
	}
</script>

<div id="main" class="container">
	<div class="row">
		<?php if(!empty($text_shipping_min_price) && !$freeShipping): ?>
		<!--div class="col-md-12 shipping-price-min-alert animated fadeIn">
			<div class="shipping-price-min-text">
				<span><?= $text_shipping_min_price ?></span>
			</div>		
		</div-->
		<?php endif ?>
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
						echo '<div class="help" title="Modificar este item del carrito"><div><span class="glyphicon glyphicon-edit"></span> <span class="font-system"> Modificar</span></div></div>';
						echo '<div class="carrito-item-col cart-img-col">';
						//echo "<div class='clearfix'></div>";
						echo "<div class='cart-img'>";
						if (!empty($product['number_ribbon'])) {
							echo '<div class="ribbon bottom-left small"><span>'.$product['number_ribbon'].'% OFF</span></div>';
						}
						if (empty($product['price'])) {
							$promosaved+= (float) $product['old_price'];
						}
						if ($product['promo'] !== '') {							
							$disable = !isset($product['promo_enabled']) ? ' disable' : '';
							echo "<div class='ribbon".$disable."'><span>" . $product['promo'] . "</span></div>";
						}
            echo '<a href="' . $item_url . '">';
						// echo '<img src="'.Configure::read('uploadUrl').($product['alias_image'] ?: $product['img_url'] ).'" class="thumb" style="display:block;" />';
						echo '<div class="carrito-item-image" style="background-image: url('.Configure::read('uploadUrl').($product['alias_image'] ?: $product['img_url'] ).')"></div>';
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

						/*if(!empty($product['mp_discount']) || !empty($product['bank_discount'])) {
							echo '<div class="d-flex gap-05 mb-05">';
							if(!empty($product['mp_discount'])) {
								echo '<span class="badge badge-success"><i class="fa fa-credit-card"></i> '. 
									$product['mp_discount'] .'%</span>';
							}
							if(!empty($product['bank_discount'])) {
								echo '<span class="badge badge-success"><i class="fa fa-bank"></i> '. 
									$product['bank_discount'] .'%</span>';
							}
							echo '</div>';
						}*/
						echo '<div class="text-right">';
						if (!empty($product['old_price'] && abs($product['old_price']-$product['price']) > 1)){
							echo '<span class="old_price text-grey animated fadeIn delay2">$ '. \price_format($product['old_price']) .'</span>';
						}					
						echo '<span class="price animated fadeIn delay">$ '. \price_format($product['price']) .'</span>';
						echo strlen(@$product['payment_text']) ? 'con ' . @$product['payment_text'] : '';
						echo '</div>';
						echo '<div class="carrito-hide-element">
							<label class="form-group mt-4">
							  <input class="giftchecks" type="checkbox" id="' . $product['id'] .  '"><span class="label-text text-muted">Es para regalo</span><br><br>
							</label>						
							<div class="form-inline">
							  <div class="form-group">
							    <div class="input-group carrito-selector mt-4">
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
						<div class="resume-totals animated fadeIn delay2">
							<input type="hidden" id="subtotal_compra" value="<?=floatval($total)?>" />
							<input type="hidden" id="subtotal_envio" value="" />
							<div class="summary-item text-right">
								<div class="price text-muted">Resumen de tu compra</div>								
							</div>
							<hr>
							<div class="summary-item text-right products-total">
								<div class="price text-dark"><span class="text-weight-thin">Productos </span> $ <?= \price_format($total + $promosaved) ?></div>
							</div>
							<?php if($freeShipping):?>
							<div class="summary-item text-right free-shipping animated speed">
								<div class="price text-success">
									<span class="text-weight-thin">Envío </span>
									<span id="delivery_cp"></span> <span>gratuito</span></div>
							</div>
							<?php else: ?>
							<div class="summary-item text-right delivery-cost hidden animated speed">
								<div class="price text-dark">
									<span class="text-weight-thin">Envía </span>
									<span id="delivery_cp"></span> $ <span class="cost_delivery">0</span></div>
							</div>
							<?php endif ?>
							<div class="summary-item text-right <?= $promosaved ? '' : 'hidden' ?> animated speed">
								<div class="price text-success"><span class="text-weight-thin">Descuento </span><span class="">PROMO</span> <span>$ <?= \price_format($promosaved) ?></span><!--span>.00</span--></div>
							</div>
							<div class="summary-item text-right coupon-discount hidden animated speed">
								<div class="price text-success"><span class="text-weight-thin">Descuento </span><span class="promo-code"></span> <span class="coupon_bonus">0</span><!--span>.00</span--></div>
							</div>							
							<hr>
							<div class="summary-item text-right">
								<div class="cost_total-container animated speed fadeIn delay5">
									<!--hr-->
									<div class="price is-large">
										<span class="text-weight-thin">Total </span> 
										<span class="cost_total">$ <?= \price_format($total) ?></span><!--span>.00</span-->
									</div>
									<small>Pagando con <?= strtoupper($payment_methods[$config['payment_method']]) ?></small>
								</div>								
							</div>
							<div class="form-inline">
								<h3 class="mt-1">Es para regalo</h3>
							  <div class="form-group">
							    <div class="input-group carrito-selector mt-4">
							      <div class="input-group-addon input-lg is-clickable">
							       <span class="fa fa-minus"></span>
							      </div>
							      <input type="text" name="giftcount" size="2" class="form-control gift-count input-lg text-center" placeholder="Cantidad" value="0" original-value="0">
							      <div class="input-group-addon input-lg is-clickable">
							       <span class="fa fa-plus"></span>
							       </div>
							    </div>
							  </div>
							</div>							
						</div>
					</div>
					<?php else: ?>
					<div class="container cart-empty text-center">
						<div class="icon-huge mt-4">
							<i class="fa fa-warning text-danger"></i>
						</div>
						<h3 class="h3 text-center">Tu carrito de compras está vacío</h3>
						<div>Para comprar agrega un producto. Obtén más información <a href="/ayuda/como_comprar" class="text-primary">acerca de como comprar</a></div>
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
			<div class="button-group-fixed-bottom d-flex justify-content-center align-items-center gap-1 mb-1">
				<?php if (!isset($carro)): ?>
					<a href="#" class="btn action-search cart-btn-green">Buscar</a>
				<?php endif ?>
				<a class="btn keep-buying cart-btn-green" href="/tienda">Seguir comprando</a>
			  <?php if (isset($carro) && !empty($carro)) :?>
			    <a href="javascript:void(0)" class="btn cart-btn-green cart-go-button btn-success" link-to="<?=Router::url('/carrito/checkout',true)?>" id="siguiente">Siguiente</a>
			  <?php endif ?>
			</div>
		</div>
	</div>
					
	<?php if (isset($carro) && !empty($carro)) :?>
	<div id="carritoItem" class="menuLayer is-fullheight has-item-counter animated">
	  <a class="close float-tr">
	    <span></span>
	    <span></span>
	  </a>
	  <div class="carousel carousel-carrito" id="carousel">
	  	<div class="carousel-inner">
				<div class="carrito-item">
					<div class="carrito-item-block"></div>
				</div>
			</div>
			<a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
        <span class="arrow arrow-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
        <span class="arrow arrow-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
	  </div>
	</div>
	<input type="hidden" id="shipping_price_min" value="<?= $shipping_price_min ?>">
	<input type="hidden" id="total" value="<?= $total ?>">
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

<?php if(!empty($text_shipping_min_price) && !$freeShipping): ?>
<script>
	$(function(){
		setTimeout(() => {
			onSuccessAlert('<i class="fa fa-magic"></i> Más beneficios','<?= $text_shipping_min_price ?>', 15000)
		}, 15000)		
	})
</script>
<?php endif ?>
