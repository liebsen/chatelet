<?php echo $this->Html->script('coupon.js?v=' . Configure::read('APP_DIST'),array( 'inline' => false )) ?>
<div class="row is-rounded">
	<h3 class="h3 text-center">Beneficios exclusivos</h3>
	<div class="col-xs-12 shipment-options shipping">
		<hr>
		<h3 id="heading" class="cargo-title">Cupón promocional<span></span></h3>
		<p class="field">
			<i class="coupon-text animated speed">
				<small>Ingrese su cupón de descuento. Beneficio exclusivo para clientas registradas.</small>
			</i>
		</p>
		<div class="form-group is-flex">
			<form id="calulate_coupon" data-url="<?php echo $this->Html->url(array('action'=>'coupon')) ?>">
				<div class="input-group">
				  <input type="text" name="" placeholder="Tu cupón" value="" class="form-control input-coupon both input-rounded" data-valid="0" autocomplete="off" />
				  <div class="input-group-btn">
				    <button class="btn btn-success btn-calculate-coupon" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" type="submit">Calcular</button>
				  </div>
				</div>
				<br>
			</form>
		</div>
		<div class="coupon-info alert alert-success animated hidden">
			<h3 class="coupon-info-title"></h3>
			<p class="coupon-info-info"></p>
		</div>
	</div>
</div>
