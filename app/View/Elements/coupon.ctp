<?php 
	echo $this->Html->script('coupon.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
?>
 	<div class="calc-coupon' d-flex flex-column justify-content-center align-items-start">
 			<h5>¿Tenés un cupón de descuento?</h5>
 			<div class="d-flex justify-content-center align-items-center gap-05 w-100">
 		  	<input type="text" id="coupon_name" name="coupon" placeholder="Código de cupón" value="" class="form-control input-coupon both" title="Ingresá el código de tu cupón" data-valid="0" autocomplete="off" />
    	<button id="btn-calculate-coupon" class="btn btn-calculate-coupon btn-chatelet dark" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" title="Aplicá este cupón a tu compra" type="button" onclick="submitCoupon()">Aplicar</button>
		</div>
	</div>