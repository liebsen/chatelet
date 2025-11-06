	<div class="d-flex flex-column justify-content-center align-items-start gap-1">
		<h6>Resumen de tu compra</h6>
		<input type="hidden" id="subtotal_compra" value="<?=floatval($total)?>" />
		<input type="hidden" id="subtotal_envio" value="" />
		<div class="w-100">
		<?php if($total + $promosaved != $total): ?>
			<div class="summary-item products-total">
				<div class="text-dark"><span class="text-weight-thin">Productos </span> $ <?= \price_format($total + $promosaved) ?></div>
			</div>
		<?php endif ?>
			<div class="summary-item <?= $promosaved ? '' : 'hidden' ?>">
				<span class="text-weight-thin">Descuento </span>
				<!--span class="">PROMO</span--> 
				<span>$ <?= \price_format($promosaved) ?></span><!--span>.00</span-->
			</div>
			<div class="summary-item">
				<span class="text-weight-thin">Subtotal </span>
				<span class="cost_total">$ <?= \price_format($total + $promosaved) ?></span>
			</div>							
			<div class="summary-item coupon-discount">
				<span class="text-weight-thin">Cupón </span>
				<span>
					<span class="promo-code"></span> $ <span class="coupon_bonus">0</span>
					<!--span>.00</span-->
				</span>
			</div>							
			<div class="summary-item text-weight-bold">
				<span class="">Total </span> 
				<span class="calc_total">$ <?= \price_format($total) ?></span><!--span>.00</span-->
			</div>
			<span class="text-theme paying-with">Pagando con <?= strtolower($payment_methods[$config['payment_method']]) ?></span>
		</div>
	</div>