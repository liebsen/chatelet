<?php echo $this->Html->script('coupon.js',array( 'inline' => false )) ?>
<div class="row is-rounded">
	<h3 class="h3 text-center desktop">¿Tenés cupón de descuento?</h3>
	<h4 class="h4 text-center mobile">Obtenga beneficios exclusivos con nuestro explusivo sistema de beneficios</h4>
	<div class="col-xs-12 shipment-options shipping">
		<hr>
		<h3 id="heading" class="cargo-title">Cupón // <span>Ingresá tu cupón de descuento</span></h3>
		<p class="field">
			<i>
				<small>Ingrese su cupón de descuento</small>
			</i>
		</p>
		<div class="form-group">
			<input type="text" name="" placeholder="ej. CHA10" value="" id="coupon" class="both input-rounded" data-valid="0" data-url="<?php echo $this->Html->url(array('action'=>'coupon')) ?>" />
			&nbsp;
			<span id="loading" class="hide coupon-loading">
				<?php echo $this->Html->image('loader.gif',array('height'=>20)) ?>
			</span>
		</div>
		<div class="form-group">
			<span id="coupon_data_container" class="text-muted">
				<p class="field">
					<span>Costo original:</span>
					$<span id="coupon_orig" class="figure"><?= number_format($total, 2) ?></span>
				</p>
				<p class="field">
					<span>Costo bonificado:</span> 
					$<span id="coupon_bonus" class="figure"><?= number_format($total, 2) ?></span>
				</p>
				<p class="field">
					<span>Beneficio del cupón:</span>
					$<span class="figure" id="coupon_cost">0</span>
				</p>
			</span>
		</div>
		<hr>
	</div>

	<div class="col-xs-12">
		<br />
		<br />
	</div>
</div>

<script>
	/* let user_cp = '<?php echo $user['postal_address'];?>'
	if (user_cp) {
		$('#cp').val(user_cp)
	} */
</script>
