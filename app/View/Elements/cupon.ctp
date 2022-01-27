<?php echo $this->Html->script('coupon.js',array( 'inline' => false )) ?>
<div class="row is-rounded">
	<h3 class="h3 text-center desktop">¿Tenés cupón de descuento?</h3>
	<h4 class="h4 text-center mobile">¿Tenés cupón de descuento?</h4>
	<div class="col-xs-12 shipment-options shipping">
		<hr>
		<h3 id="heading" class="cargo-title">Cupón // <span>Ingresá tu cupón de descuento</span></h3>
		<p style="margin:10px 0px">
			<i>
				<small>Ingresá tu cupón de descuento</small>
			</i>
		</p>
		<div class="form-group">
			<input type="text" name="" placeholder="ej. CHA10" value="" id="coupon" class="both input-rounded" data-valid="0" data-url="<?php echo $this->Html->url(array('action'=>'check_coupon')) ?>" />
			&nbsp;
			<span id="loading" class="hide coupon-loading">
				<?php echo $this->Html->image('loader.gif',array('height'=>20)) ?>
			</span>
		</div>
		<div class="form-group">
			<span id="cost_container" class="text-muted">
				<span>Beneficio de cupón:</span> <strong>$<span id="cost">0</span>.00</strong> <span id="free_delivery"></span>
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
