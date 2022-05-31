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
		<h3 class="text-success">Envío gratuito // <span>Seleccione una opción de envío</span></h3>
		<?php endif ?>		
		<p class="p">
			<i>
				<small>Para envíos a domicilio ingrese su código postal</small>
			</i>
		</p>
		<div class="form-group is-flex">
			<form id="calulate_shipping" data-url="<?php echo $this->Html->url(array('action'=>'delivery_cost')) ?>">
				<div class="input-group">
				  <input type="text" name="" placeholder="Tu código postal" value="" class="form-control input-cp both input-rounded" data-valid="0" />
				  <div class="input-group-btn">
				    <button class="btn btn-success btn-calculate-shipping" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" type="submit">Calcular</button>
				  </div>
				</div>
			</form>
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
		<p class="p">
			<i>
				<small>Solicite esta opción para evitar cargos de envío</small>
			</i>
		</p>		

		<ul class="generic-select takeaway-options animated zoomInRight">
			<?php foreach ($stores as $store):?>
				<li store="<?php echo $store['Store']['name'];?>"
					store-address="<?php echo $store['Store']['address'];?>"
					onclick="selectStore(this)"><span><?php echo $store['Store']['address'];?></span>, <span class="text-uppercase"><?php echo $store['Store']['name'];?></span></li>
			<?php endforeach;?>
		</ul>
	</div>
</div>

