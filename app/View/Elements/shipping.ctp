<?php echo $this->Html->script('shipping.js?v=' . Configure::read('APP_VERSION'),array( 'inline' => false )) ?>
<?php echo $this->Html->css('oca_front.css?v=' . Configure::read('APP_VERSION'),array( 'inline' => false )) ?>
<div class="card como-queres-recibir-tu-compra">
	<div class="card-body">
		<h5 class="card-title"><!--i class="fa fa-truck"></i--> ¿Cómo querés recibir tu compra?</h5>
		<div class="shipment-options shipping">
			<?php if(!$freeShipping): ?>
			<h4 id="heading" class="cargo-title">Envío a domicilio</h4>
			<?php else: ?>
			<h4 class="cargo-title">Envío gratuito<span></span></h4>
			<?php endif ?>		
			<p class="p">
				<i>
					<small>Para envíos a domicilio ingresá tu código postal</small>
				</i>
			</p>
			<form class="w-100" id="calulate_shipping" data-url="<?php echo $this->Html->url(array('action'=>'deliveryCost')) ?>">
				<div  class="d-flex justify-content-center align-items-center gap-05">
			  	<input type="text" name="" placeholder="Tu código postal" value="" class="form-control input-cp both" title="Ingresá tu código postal" data-valid="0" />
		    	<button class="btn btn-outline-danger btn-input-lg btn-calculate-shipping" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" title="Cotizá el envío a domicilio de tu compra" type="submit">Calcular</button>
				</div>
			</form>
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
			<div class="divider-with-text">
			  <span>O</span>
			</div>		
		</div>
		
		<div class="shipment-options takeaway">
			<h4 class="cargo-title">Retiro en sucursal</h4>
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
</div>

