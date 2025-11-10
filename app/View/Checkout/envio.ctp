<?php 
echo $this->Session->flash();

$this->set('short_header', 'Checkout');
$this->set('short_header_text', '← Volver al carrito - ');
$this->set('short_header_link', '/carrito');

echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
echo $this->Html->css('bootstrap-datepicker', array('inline' => false));
echo $this->Html->css('checkout.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->script('shipping.js?v=' . Configure::read('APP_VERSION'),array( 'inline' => false ));
echo $this->Html->script('cart.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));	
echo $this->Html->script('envio.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->element('checkout-params');
?>
<section id="main" class="d-flex flex-column justify-content-start align-items-center has-checkout-steps min-h-101">
	<?php echo $this->element('checkout-steps') ?>
	<div class="row w-100">
		<?php echo $this->element('title-faq', array('title' => "Método de entrega")) ?>
	</div>
	<div class="flex-row w-100">
		<div class="flex-col">
			<ul class="nav nav-tabs nav-dark">
			   <li class="active"><a href="#envio" data-toggle="tab">Envío a domicilio</a></li>
			   <li><a href="#retiro" data-toggle="tab">Retiro en local GRATIS</a></li>
			</ul>

			<div class="tab-content">
			  <div class="tab-pane active" id="envio">
				  <div class="cargo-blocks shipment-block">
						<div>
							<span class="text-sm">Ingresá tu código postal</span>
						</div>				  	
						<form class="w-100" id="calulate_shipping" data-url="<?php echo $this->Html->url(array('action'=>'deliveryCost')) ?>">
							<div class="d-flex justify-content-center align-items-center gap-05">
						  	<div class="position-relative input-cp-container">
						  		<input type="text" name="" placeholder="Tu código postal" value="" class="form-control input-cp both" title="Ingresá tu código postal" data-valid="0" />
						  	</div>
					    	<button class="btn btn-chatelet dark btn-input-lg btn-calculate-shipping" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" title="Cotizá el envío a domicilio de tu compra" type="submit">Calcular</button>
							</div>
						</form>
						<div class="form-group shipping-block hidden">
							<div>
								<span class="text-sm">Elegí la empresa de tu confianza para realizar este envío</span>
							</div>
							<div class="slot">
							</div>
						</div>
					</div> 
			  </div>
			  <div class="tab-pane" id="retiro">

				</div>
			</div>
		</div>
		<div class="flex-col gap-1 max-22">
			<div class="card card-variant">
				<?php echo $this->element('resume') ?>
			</div>
		</div>
	</div>
</div>
