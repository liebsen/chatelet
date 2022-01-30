<?php echo $this->Html->script('coupon.js',array( 'inline' => false )) ?>
<div class="row is-rounded is-success">
	<h3 class="h3 text-center desktop">Cupón de descuento</h3>
	<h4 class="h4 text-center mobile">Cupón de descuento</h4>
	<div class="col-xs-12 shipment-options shipping">
		<hr>
		<h3 id="heading" class="cargo-title">Cupón // <span>Ingresá tu cupón de descuento</span></h3>
		<p class="field">
			<i>
				<small>Obtenga beneficios exclusivos con nuestro explusivo sistema de beneficios. Ingrese su cupón de descuento</small>
			</i>
		</p>
		<div class="form-group">
			<input type="text" name="" placeholder="ej. CHA10" value="" id="coupon" class="both input-rounded" data-valid="0" data-url="<?php echo $this->Html->url(array('action'=>'coupon')) ?>" autocomplete="off" />
			&nbsp;
			<span id="loading" class="hide coupon-loading">
        <svg class="spinner-input" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
          <rect class="spinner__rect" x="0" y="0" width="100" height="100" fill="none"></rect>
          <circle class="spinner__circle" cx="50" cy="50" r="40" stroke="#f41c80" fill="none" stroke-width="8" stroke-linecap="round">
          </circle>
        </svg>
			</span>
		</div>
		<!--div class="form-group">
			<span id="coupon_data_container" class="text-muted">
				<p class="field">
					<span>Costo original:</span>
					$<span id="coupon_orig" class="figure"><?= number_format($total, 2) ?></span>
				</p>
				<div class="processed-coupon-data animated speed hidden">
					<p class="field">
						<span>Costo bonificado:</span> 
						$<span id="coupon_bonus" class="figure"><?= number_format($total, 2) ?></span>
					</p>
					<p class="field">
						<span>Beneficio del cupón:</span>
						$<span class="figure" id="coupon_cost">0</span>
					</p>
				</div>
			</span>
		</div-->
	</div>
</div>

<script>
	/* let user_cp = '<?php echo $user['postal_address'];?>'
	if (user_cp) {
		$('#cp').val(user_cp)
	} */
</script>
