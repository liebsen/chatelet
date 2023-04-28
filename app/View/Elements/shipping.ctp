<?php echo $this->Html->script('shipping.js?v=' . Configure::read('DIST_VERSION'),array( 'inline' => false )) ?>
<?php echo $this->Html->css('oca_front.css?v=' . Configure::read('DIST_VERSION'),array( 'inline' => false )) ?>
<script>window.freeShipping = <?=(int)@$freeShipping?>;</script>
<div class="is-rounded como-queres-recibir-tu-compra">
	<h3>¿Cómo querés recibir tu compra?</h3>
	<div class="shipment-options shipping">
		<?php if(!$freeShipping): ?>
		<h4 id="heading" class="cargo-title">Envío a Domicilio</h4>
		<?php else: ?>
		<h4 class="cargo-title">1. Envío gratuito<span></span></h4>
		<?php endif ?>		
		<p class="p">
			<i>
				<small>Para envíos a domicilio ingresá tu código postal</small>
			</i>
		</p>
		<div class="form-group is-flex-center">
			<form class="w-100" id="calulate_shipping" data-url="<?php echo $this->Html->url(array('action'=>'deliveryCost')) ?>">
				<div class="input-group">
				  <input type="text" name="" placeholder="Tu código postal" value="" class="form-control input-cp input-lg both input-rounded" title="Ingresá tu código postal" data-valid="0" />
				  <div class="input-group-btn">
				    <button class="btn btn-danger btn-input-lg btn-calculate-shipping" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" title="Cotizá el envío a domicilio de tu compra" type="submit">Calcular</button>
				  </div>
				</div>
			</form>
		</div>
		<br>
		<div class="form-group shipping-block hidden">
			<div>
				<h4 class="cargo-title">2. Seleccione tipo de envío</h4>
				<p class="p">
					<i>
						<small>Elegí la empresa de tu confianza para realizar este envío</small>
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
		<hr class="or">
	</div>
	
	<div class="shipment-options takeaway">
		<h4 class="cargo-title">Retiro en Sucursal</h4>
		<p class="p">
			<i>
				<small>Elegí esta opción para evitar cargos de envío. <span class="carrito_takeaway_text"><?= $carrito_takeaway_text ?></span></small>
			</i>
		</p>		

		<ul class="generic-select takeaway-options animated fadeIn">
			<?php foreach ($stores as $store):?>
				<li store="<?php echo $store['Store']['name'];?>"
					store-address="<?php echo $store['Store']['address'];?>"
					onclick="selectStore(this)"><span class="text-uppercase"><?php echo $store['Store']['name'];?></span>, <span><?php echo $store['Store']['address'];?></span></li>
			<?php endforeach;?>
		</ul>
	</div>
</div>

