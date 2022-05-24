<?php echo $this->Html->script('shipping.js?v=' . Configure::read('APP_DIST'),array( 'inline' => false )) ?>
<?php echo $this->Html->css('oca_front.css?v=' . Configure::read('APP_DIST'),array( 'inline' => false )) ?>
<script>window.freeShipping = <?=(int)@$freeShipping?>;</script>
<div class="row is-rounded">
	<h3 class="h3 text-center">¿Cómo desea recibir su compra?</h3>
	<div class="col-xs-12 shipment-options shipping">
		<hr>
		<?php if(!$freeShipping): ?>
		<h3 id="heading" class="cargo-title">Costo de Envío</h3>
		<?php else: ?>
		<h3 class="text-success">Envío gratuito // <span>Oca</span></h3>
		<?php endif ?>		
		<p class="p">
			<i>
				<small>Para envíos a domicilio ingrese su código postal</small>
			</i>
		</p>
		<div class="form-group is-flex">
			<input type="text" name="" placeholder="ej. 1400" value="" class="input-cp both input-rounded" data-valid="0" data-url="<?php echo $this->Html->url(array('action'=>'delivery_cost')) ?>" />
			&nbsp;
			<span id="loading" class="hide shipping-loading spinner-container animated">
        <svg class="spinner-input" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
          <rect class="spinner__rect" x="0" y="0" width="100" height="100" fill="none"></rect>
          <circle class="spinner__circle" cx="50" cy="50" r="40" stroke="#4f804f" fill="none" stroke-width="8" stroke-linecap="round">
          </circle>
        </svg>				
			</span>
		</div>
		<div class="form-group shipping-block hidden">
			<div>
					<p class="p">
						<i>
							<small>Seleccione la empresa de logística de su confianza para realizar este envío</small>
						</i>
					</p>
			</div>
			<div class="slot">
			</div>
		</div>
		<!--div class="form-group">
			<span id="cost_container" class="text-muted">
				<span>Costo de envío:</span> <span class="figure">$<span id="cost_delivery">0</span>.00</span> <span id="free_delivery"></span>
			</span>
		</div-->
		<hr>
	</div>
	
	<div class="col-xs-12 shipment-options takeaway">
		<h3 id="heading" class="cargo-title">Retiro en Sucursal</h3>
		<p style="margin:10px 0px">
			<i>
				<small>Solicite esta opción para evitar cargos de envío</small>
			</i>
		</p>		

		<ul class="generic-select takeaway-options animated zoomInRight">
			<?php foreach ($stores as $store):?>
				<li store="<?php echo $store['Store']['name'];?>"
					store-address="<?php echo $store['Store']['address'];?>"
					onclick="selectStore(this)"><span class="text-uppercase"><?php echo $store['Store']['name'];?></span>, <?php echo $store['Store']['address'];?></li>
			<?php endforeach;?>
		</ul>
	</div>

</div>

<script>
	let user_cp = '<?php echo $user['postal_address'];?>'
	let last_cp = localStorage.getItem('lastcp') || false
	let cp = last_cp
	var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
	if (!cp) {
		cp = user_cp
	}
	console.log(carrito.cargo)
	if (carrito.cargo === 'shipment') {
		$('.input-cp').val(cp)
	}
	localStorage.setItem('lastcp', cp)
</script>
