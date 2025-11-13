<?php
	echo $this->Session->flash();
	echo $this->Html->css('carrito.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
	echo $this->Html->script('cart.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
	echo $this->element('checkout-params');
	// echo $this->element('checkout-modal');
	$payment_methods = [
		'bank' => 'transferencia',
		'mercadopago' => 'mercado pago',
	];
?>

<section id="main" class="container animated fadeIn delay">
	<?php echo $this->element('title-faq', array('title' => "Carrito")) ?>
	<?php if(!empty($text_shipping_min_price) && !$freeShipping): ?>
	<!--div class="col-md-12 shipping-price-min-alert animated fadeIn">
		<div class="shipping-price-min-text">
			<span><?= $text_shipping_min_price ?></span>
		</div>		
	</div-->
	<?php endif ?>
	<div class="flex-row">
		<!--h3 id="heading" style="margin:10px 0px">Carrito de compras</h3-->
		<?php if (isset($cart) && !empty($cart)) :?>			
		<?php
			echo '<input type="hidden" id="loggedIn" value="'. (string) $loggedIn .'" />';
			echo '<input type="hidden" id="checkout" value="'. $this->Html->url(array('controller' => 'carrito', 'action' => 'envio')) .'" />'
		?>			
		<div class="flex-col">
			<div class="mobile p-3">
			<?php foreach ($sorted as $product) {
				echo "<div class='d-flex justify-content-start align-center gap-1 cart-row carrito-data position-relative' data-json='".json_encode($product)."' product_row>";

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
				echo '<div class="ch-image" style="background-image: url('.Configure::read('uploadUrl').($product['alias_image'] ?: $product['img_url'] ).')"></div>';
				echo '</a>';
			echo '</div>';
			echo '<div class="d-flex justify-content-start align-center flex-column min-w-7">';
			echo '<h5 class="mt-0 mb-1 text-weight-thin">'. $product['name'] . '</h5>';
			if (!empty($product['color_code']) && $product['color_code'] != 'undefined'){
				echo '<span class="text-sm">Color: <span color-code="'.$product['color_code'].'">'. $product['alias'] .'</span></span>';
			}
			if (!empty($product['size']) && $product['size'] != 'undefined'){
				echo '<span class="text-sm">Talle: <span>'. $product['size'] .'</span></span>';
			}

			echo '<span class="text-nowrap mt-2">$ '. \price_format($product['item_price']) .'</span>';				
			echo '<div class="form-inline">
			  <div class="form-group">
			    <div class="input-group carrito-selector mt-2">
			      <div class="input-group-addon input-lg is-clickable btn-change-count">
			       	<span>&ndash;</span>
			      </div>
			      <input type="text" size="2" class="form-control product-count input-lg text-center" placeholder="Cantidad" value="' . $product['count'] . '" original-value="' . $product['count'] . '" />
			      <div class="input-group-addon input-lg is-clickable btn-change-count">
			      	<span>+</span>
			      </div>
			    </div>
			  </div>
			</div>';					
			echo '<label class="form-group mt-1">
				  <input class="giftchecks" type="checkbox" id="giftcheck_' . $product['id'] .  '" data-id="' . $product['id'] .  '"><span class="label-text text-muted text-sm">Es para regalo</span><br><br>
				</label>';

			echo '</div>';
			echo '<button class="corner-pin bg-transparent" onclick="askremoveCart(this)">
							<i class="fa fa-trash-o"></i>
						</button>';					
			echo '</div>';		
			} ?>
			</div>
			<div class="desktop">
				<table class="table w-100">
					<tr>
						<th>ART.</th>
						<th>Talle</th>
						<th>Cant.</th>
						<th>Precio</th>
						<th>Borrar</th>
					</tr>
			<?php if (!isset($cart)) $cart = array();
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


				//echo '<div class="ch-row is-clickable" product_row>';
				echo '<tr class="carrito-data" data-json=\''.json_encode($product).'\' product_row>';
				echo '<td class="pl-0">';
				echo "<div class='d-flex justify-content-start align-items-center gap-1'><div class='cart-img'>";
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
				echo '<div class="ch-image" style="background-image: url('.Configure::read('uploadUrl').($product['alias_image'] ?: $product['img_url'] ).')"></div>';
				echo '</a>';
			echo '</div>';
			echo '<div class="d-flex justify-space-between align-items-start flex-column min-w-7">';
			echo '<div class="d-flex justify-content-start align-center flex-column">';
			echo '<span class="mt-0">'. $product['name'] . '</span>';

			if (!empty($product['color_code']) && $product['color_code'] != 'undefined'){
				echo '<span class="text-sm">Color: <span color-code="'.$product['color_code'].'">'. $product['alias'] .'</span></span>';
			}
			if (!empty($product['size']) && $product['size'] != 'undefined'){
				echo '<span class="text-sm">Talle: <span>'. $product['size'] .'</span></span>';
			}

			echo '</div>';
			echo '<label class="form-group">
				  <input class="giftchecks" type="checkbox" id="giftcheck_' . $product['id'] .  '" data-id="' . $product['id'] .  '"><span class="label-text text-muted text-sm">Es para regalo</span><br><br>
				</label>';

			echo '</div>';
			echo '</td>';
			echo '<td>';
				if (!empty($product['size']) && $product['size'] != 'undefined'){
					echo '<span>'. $product['size'] .'</span>';
				}
			echo '</td>';
			echo '<td>';
			echo '<div class="form-inline">
						  <div class="form-group">
						    <div class="input-group carrito-selector">
						      <div class="input-group-addon input-lg is-clickable btn-change-count">
						       	<span>&ndash;</span>
						      </div>
						      <input type="text" size="2" class="form-control product-count input-lg text-center" placeholder="Cantidad" value="' . $product['count'] . '" original-value="' . $product['count'] . '" />
						      <div class="input-group-addon input-lg is-clickable btn-change-count">
						      	<span>+</span>
						      </div>
						    </div>
						  </div>
						</div>';
				echo '</td>';			
				echo '<td>';	


				echo '<span class="text-nowrap">$ '. \price_format($product['item_price']) .'</span>';
				if (!empty($product['item_old_price'] && abs($product['item_old_price']-$product['item_price']) > 1)){
					echo '<br><span class="old_price text-grey text-sm">$ '. \price_format($product['item_old_price']) .'</span>';
				}					

				echo strlen(@$product['payment_text']) ? 'con ' . @$product['payment_text'] : '';
				echo '</td>';
				
				$row += 1;

				echo '<td>
								<button class="btn bg-transparent" onclick="askremoveCart(this)">
									<i class="fa fa-trash-o"></i>
								</button>
							</td>';
				echo '</tr>';

				/*echo '<div class="carrito-hide-element">
					<div class="form-inline">
					  <div class="form-group">
					    <div class="input-group carrito-selector mt-4">
					      <div class="input-group-addon input-lg is-clickable" onclick="removeCount()">
					       	<span class="fa fa-minus"></span>
					      </div>
					      <input type="text" size="2" class="form-control product-count input-lg text-center" placeholder="Cantidad" value="' . $product['count'] . '" original-value="' . $product['count'] . '" />
					      <div class="input-group-addon input-lg is-clickable" onclick="addCount()">
					      	<span class="fa fa-plus"></span>
					      </div>
					    </div>
					  </div>
					</div>
					<span class="ch-btn-success btn-change-count disable is-clickable">Cambiar</span>
				</div>';*/

			} ?>
					</table>
				</div>

				<?php echo $this->element('shop-disclaimer') ?>
      </div>
			<div class="flex-col gap-1 max-22">
				<!-- fill coupon -->
				<div class="card card-variant">
					<?php echo $this->element('coupon'); ?>
				</div>								  
				<!-- end fill coupon -->
				<?php echo $this->element('resume'); ?>
				<div class="d-flex flex-column justify-content-center align-items-center gap-05 pb-4">
			  <?php if (isset($cart) && !empty($cart)) :?>
			    <a href="/checkout" class="btn btn-chatelet dark w-100">Finalizar compra</a>
			  <?php endif ?>
					<a class="btn btn-continue-shopping btn-chatelet w-100" href="/tienda">Seguir comprando</a>
				</div>
			</div>
			<?php else: ?>
			<div class="container cart-empty text-center">
				<!--div class="icon-huge mt-4">
					<i class="fa fa-shopping-bag fa-x2 text-muted"></i>
				</div-->
				<h3 class="h3 text-center">Tu carrito está vacío</h3>
				<div>Para comprar agrega un producto.<br> Obtén más información <a href="/ayuda/como_comprar" class="text-link">acerca de como comprar</a></div>
			</div>
			<br><br>
			<?php endif;?>
		</div>
	</div>
</section>

<?php echo $this->element('subscribe-box') ?>

<?php if (isset($cart) && !empty($cart)) :?>
<!--div id="carritoItem" class="burst is-fullheight has-item-counter animated">
  <a class="close float-tr">
    <span></span>
    <span></span>
  </a>
  <div class="carousel carousel-carrito" id="carousel">
  	<div class="carousel-inner">
			<div class="carrito-item">
				<div class="ch-block"></div>
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
</div-->
<input type="hidden" id="shipping_price_min" value="<?= $settings['shipping_price_min'] ?>">
<input type="hidden" id="total" value="<?= $total ?>">
<?php endif;?>
<script>
	$(function(){
	<?php if(!empty($cart) && !empty($text_shipping_min_price) && !$freeShipping): ?>
			setTimeout(() => {
				onWarningAlert('Más beneficios','<?= $text_shipping_min_price ?>', 15000)
			}, 15000)		
	<?php endif ?>
		var gifts = carrito.gifts || []
		$(cart_items).each((i,e) => {
			$('#giftcheck_' + e.id).attr('checked', gifts.includes(parseInt(e.id)))
		})
	})
</script>
