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
				<div class="input-group">
					<span class="text-muted">Obtenga beneficios exclusivos <a href="#" id="register" class="open-Modal" data-toggle="modal" data-dismiss="modal"  data-target="#particular-modal">registrándose</a> en nuestra tienda</span>
				</div>
			</form>

			<!--input type="text" name="" placeholder="ej. CHA10" value="" class="input-coupon both input-rounded" data-valid="0" data-url="<?php echo $this->Html->url(array('action'=>'coupon')) ?>" autocomplete="off" />
			&nbsp;
			<span id="loading" class="hide coupon-loading spinner-container animated">
        <svg class="spinner-input" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
          <rect class="spinner__rect" x="0" y="0" width="100" height="100" fill="none"></rect>
          <circle class="spinner__circle" cx="50" cy="50" r="40" stroke="#4f804f" fill="none" stroke-width="8" stroke-linecap="round">
          </circle>
        </svg>
			</span-->
		</div>
		<div class="coupon-info alert alert-success animated hidden">
			<h3 class="coupon-info-title"></h3>
			<p class="coupon-info-info"></p>
		</div>
		<!--div class="form-group">
			<span id="coupon_data_container" class="text-muted">
				<p class="field">
					<span>Costo original:</span>
					$<span id="coupon_orig" class="figure"><?= number_format($total, 2, ',', '.') ?></span>
				</p>
				<div class="processed-coupon-data animated speed hidden">
					<p class="field">
						<span>Costo bonificado:</span> 
						$<span id="coupon_bonus" class="figure"><?= number_format($total, 2, ',', '.') ?></span>
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
