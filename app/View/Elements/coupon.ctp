<?php 
	echo $this->Html->script('coupon.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
?>
 	<div class="calc-coupon' d-flex flex-column justify-content-center align-items-start">
 			<h5>¿Tenés un cupón de descuento?</h5>
 			<div class="d-flex justify-content-center align-items-center gap-05 w-100">
 				<div class="input-status input-coupon-status position-relative flex-1<?php echo !empty($cart_totals['coupon']) && !empty($cart_totals['coupon_benefits']) ? ' ok' : '' ?>">
 		  		<input type="text" id="coupon_name" name="coupon" placeholder="Código de cupón" class="form-control both input-coupon" title="Ingresá el código de tu cupón" value="<?php echo $cart_totals['coupon'] ?>" data-valid="0" autocomplete="off" />
 		  	</div>
    		<button id="btn-calculate-coupon" class="btn btn-calculate-coupon btn-chatelet dark" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" title="Aplicá este cupón a tu compra" type="button" onclick="submitCoupon()">Aplicar</button>
		</div>
	</div>