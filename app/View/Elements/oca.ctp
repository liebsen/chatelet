<?php echo $this->Html->script('oca.js?avoidcache=24',array( 'inline' => false )) ?>
<?php echo $this->Html->css('oca_front',array( 'inline' => false )) ?>
<script>window.freeShipping = <?=(int)@$freeShipping?>;</script>
<div class="row is-rounded">
	<h3 class="h3 text-center desktop">¿Cómo desea recibir su compra?</h3>
	<h4 class="h4 text-center mobile">¿Cómo desea recibir su compra?</h4>
	<div class="col-xs-12 shipment-options shipping">
		<hr>
		<h3 id="heading" class="cargo-title">Costo de Envio // <span>Oca</span></h3>
		<p style="margin:10px 0px">
			<i>
				<small>Para envíos a domicilio ingrese su código postal</small>
			</i>
		</p>
		<div class="form-group">
			<input type="text" name="" placeholder="ej. 1425" value="" id="cp" class="both input-rounded" data-valid="0" data-url="<?php echo $this->Html->url(array('action'=>'delivery_cost')) ?>" />
			&nbsp;
			<span id="loading" class="hide">
				<?php echo $this->Html->image('loader.gif',array('height'=>20)) ?>
			</span>
		</div>
		<div class="form-group">
			<span id="cost_container" class="text-muted">
				<span>Costo de envío:</span> <span class="figure">$<span id="cost">0</span>.00</span> <span id="free_delivery"></span>
			</span>
		</div>
		<hr>
	</div>
	<div class="col-xs-12 shipment-options takeaway">
		<h3 id="heading" class="cargo-title">Retiro en Sucursal // <span>Sin cargo de envío</span></h3>
		<p style="margin:10px 0px">
			<i>
				<small>Solicite esta opción para evitar cargos de envío</small>
			</i>
		</p>		

		<ul class="generic-select takeaway-options">
			<?php foreach ($stores as $store):?>
				<li store="<?php echo $store['Store']['name'];?>"
					store-address="<?php echo $store['Store']['address'];?>"
					onclick="selectStore(this)"><?php echo $store['Store']['name'];?> <?php echo $store['Store']['address'];?></li>
			<?php endforeach;?>
		</ul>
	</div>

	<div class="col-xs-12">
		<br />
		<br />
	</div>
</div>

<script>
	let user_cp = '<?php echo $user['postal_address'];?>'
	if (user_cp) {
		$('#cp').val(user_cp)
	}
</script>
