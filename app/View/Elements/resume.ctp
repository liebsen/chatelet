	<div class="d-flex flex-column justify-content-center align-items-start gap-05">
		<h5>Resumen de tu compra</h5>
		<pre><?php var_dump($cart_totals); ?></pre>

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
				<span class="text-weight-thin">Cupón </span>
				<span>
					<span class="promo-code"></span> $ <?= \price_format($cart_totals['coupon_benefits']) ?>
				</span>
			</div>
		<?php endif ?>						
			<div class="summary-item text-weight-bold">
				<span class="">Total </span> 
				<span class="calc_total">$ <?= \price_format($cart_totals['total']) ?></span><!--span>.00</span-->
			</div>
			<hr>
			<div class="summary-item">
				<span class="text-sm text-theme">Pagando con <?= strtolower($payment_methods[$config['payment_method']]) ?></span>
			</div>
		<?php if(!empty($text_shipping_min_price)) :?>
			<div class="summary-item">
				<span class="text-sm text-success"><?php echo $text_shipping_min_price ?></span>
			</div>
		<?php endif ?>
		<?php if(!empty($freeShipping)) :?>
			<div class="summary-item">
				<span class="text-sm text-success">Envío GRATIS</span>
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