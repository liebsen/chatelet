<?php echo $this->Html->script('shipping.js?v=' . Configure::read('APP_VERSION'),array( 'inline' => false )) ?>
<div class="card como-queres-recibir-tu-compra">
	<div class="card-body">
		<h5 class="card-title">
			¿Cómo querés recibir tu compra?
		</h5>
		<span class="">Selecciona un método de entrega para tu compra. Actualmente contamos con <?= count($stores) ?> puntos de entrega.</span>
		<div class="row card-row gap-05 shipment-options shipping pl-3 pr-3">
	  	<label for="shipment" class="col-xs-12 is-clickable select-cargo-option option-rounded">
	  		<input type="radio" id="shipment" name="cargo" value="shipment" required />
      	<span class="h5"><?= $freeShipping ? 'Envío gratuito' : 'Envío a domicilio' ?></span><br>
      	<p class="mt-2 text-small">Para envíos a domicilio ingresá tu código postal</p>
			  <div class="cargo-blocks shipment-block animated d-none">
				  <div class="d-flex justify-content-center align-items-start flex-column gap-1">
						<form class="w-100" id="calulate_shipping" data-url="<?php echo $this->Html->url(array('action'=>'deliveryCost')) ?>">
							<div class="d-flex justify-content-center align-items-center gap-05">
						  	<div class="position-relative input-cp-container">
						  		<input type="text" name="" placeholder="Tu código postal" value="" class="form-control input-cp both" title="Ingresá tu código postal" data-valid="0" />
						  	</div>
					    	<button class="btn btn-outline-danger btn-input-lg btn-calculate-shipping" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" title="Cotizá el envío a domicilio de tu compra" type="submit">Calcular</button>
							</div>
						</form>
						<div class="form-group shipping-block hidden">
							<div>
								<!--span class="h5">Seleccione tipo de envío</span><br-->
								<span class="text-small">Elegí la empresa de tu confianza para realizar este envío</span>
							</div>
							<div class="slot">
							</div>
						</div>
					</div>
				</div>      	
	  	</label>

	  	<label for="takeaway" class="col-xs-12 is-clickable select-cargo-option option-rounded shipment-options takeaway">
	  		<input type="radio" id="takeaway" name="cargo" value="takeaway" required />
      	<span class="h5">Retiro en sucursal</span><br>
      	<p class="mt-2 text-small"><span>Elegí esta opción para evitar cargos de envío. <span class="carrito_takeaway_text"><?= $carrito_takeaway_text ?></span></span></p>
			  <div class="cargo-blocks takeaway-block animated d-none">
					<ul class="generic-select takeaway-options">
						<?php foreach ($stores as $store):?>
							<li store="<?php echo $store['Store']['name'];?>"
								store-address="<?php echo $store['Store']['address'];?>"
								onclick="selectStore(this)"><span class="text-uppercase"><?php echo $store['Store']['name'];?></span>, <span><?php echo $store['Store']['address'];?></span></li>
						<?php endforeach;?>
					</ul>
				</div>
	  	</label>
	  </div>
	</div>
</div>

