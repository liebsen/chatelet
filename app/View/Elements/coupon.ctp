<?php echo $this->Html->script('coupon.js?v=' . Configure::read('APP_DIST'),array( 'inline' => false )) ?>
<div class="is-rounded beneficios-exclusivos">
	<h3>Beneficios exclusivos</h3>
	<div class="shipment-options shipping">
		<h4 id="heading" class="cargo-title">Cupón promocional<span></span></h4>
		<p class="field">
			<i class="coupon-text animated speed">
				<small>Ingresá tu cupón de descuento. Beneficio exclusivo para clientas registradas.</small>
			</i>
		</p>
		<div class="form-group is-flex-center">
			<form class="w-100" id="calculate_coupon" data-url="<?php echo $this->Html->url(array('action'=>'coupon')) ?>">
				<div class="input-group">
				  <input type="text" name="" placeholder="Tu cupón" value="" class="form-control input-coupon input-lg both input-rounded" title="Ingresá el código de tu cupón" data-valid="0" autocomplete="off" />
				  <div class="input-group-btn">
				    <button class="btn btn-success btn-input-lg btn-calculate-coupon" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" title="Aplicá este cupón a tu compra" type="submit">Calcular</button>
				  </div>
				</div>
				<br>
			</form>
		</div>
		<div class="coupon-info alert alert-success animated hidden">
			<h3>
				<i class="fa fa-tags"></i> 
				<span class="coupon-info-title"></span>
			</h3>
			<p class="coupon-info-info"></p>
		</div>
	</div>
</div>
