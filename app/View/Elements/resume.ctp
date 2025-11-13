	<div class="d-flex flex-column justify-content-center align-items-start gap-05">
		<h5 class="text-uppercase">Resumen</h5>
		<?php if(!empty($show_list)) : ?>
		<?php foreach ($sorted as $product) {
			echo "<div class='d-flex justify-content-start align-center gap-1 cart-row carrito-data position-relative' data-json='".json_encode($product)."' product_row>";

			echo "<div class='cart-img'>";
			if (!empty($product['number_ribbon'])) {
				echo '<div class="ribbon small"><span>'.$product['number_ribbon'].'% OFF</span></div>';
			}
			if (empty($product['price'])) {
				$promosaved+= (float) $product['old_price'];
			}
			if ($product['promo'] !== '') {							
				$disable = !isset($product['promo_enabled']) ? ' disable' : '';
				echo "<div class='ribbon".$disable."'><span>" . $product['promo'] . "</span></div>";
			}
      echo '<a href="' . $this->Html->url(array(
          'controller' => 'shop',
          'action' => 'detalle',
          $product['id'],
          $product['category_id'],
          strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product['name'])))
        )) . '">';
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
		echo '</div>';
		echo '</div>';		
		} ?>
		<?php endif ?>	
		<!--pre><?php var_dump($cart_totals); ?></pre-->
		<input type="hidden" id="subtotal_compra" value="<?=floatval($total)?>" />
		<input type="hidden" id="subtotal_envio" value="" />
		<div class="w-100">
		<?php if (!empty($cart_totals['discount'])) : ?>
			<div class="summary-item">
				<span class="text-weight-thin">Descuento </span>
				<span>$ <?= \price_format($cart_totals['discount']) ?></span><!--span>.00</span-->
			</div>
		<?php endif ?>
			<div class="summary-item">
				<span class="text-weight-thin">Subtotal </span>
				<span class="cost_total">$ <?= \price_format($cart_totals['total_products']) ?></span>
			</div>
		<?php if (!empty($cart_totals['coupon_benefits'])) : ?>
			<div class="summary-item coupon-discount">
				<span class="text-weight-thin text-success">Cupón </span>
				<span class="text-success">
					<span class="promo-code"></span>- $ <?= \price_format($cart_totals['coupon_benefits']) ?>
				</span>
			</div>
		<?php endif ?>	
			<div class="summary-item">
				<span class="text-weight-bold">Total </span> 
				<span class="calc_total text-weight-bold">$ <?= \price_format($cart_totals['total_products'] - $cart_totals['coupon_benefits'] + $cart_totals['delivery_cost']) ?></span><!--span>.00</span-->
			</div>
			<hr class="mt-1">

			<!--hr>
			<div class="summary-item">
				<span class="text-sm text-theme">Pagando con <?= strtolower($payment_methods[$config['payment_method']]) ?></span>
			</div-->
		<?php if(!empty($text_shipping_min_price) || !empty($freeShipping)) :?>
		<?php endif ?>
		<?php if(!empty($text_shipping_min_price)) :?>
			<div class="summary-item">
				<span class="text-sm text-success"><?php echo $text_shipping_min_price ?></span>
			</div>
		<?php endif ?>
		<?php if(!empty($freeShipping)) :?>
			<div class="summary-item">
				<span class="text-sm text-success">Envío <b>GRATIS</b></span>
			</div>
		<?php endif ?>
		</div>
	</div>

	<style>
		.resume-totals {
			margin-top: 1rem;
		}
		.summary-item {
			width: 100%;
			display: flex;
			justify-content: space-between;
			align-items: center;
			grid-gap: 0-5rem;
		}

		.paying-with {
			display: none;
		}

	</style>