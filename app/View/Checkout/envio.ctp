<?php 
echo $this->Session->flash();

$this->set('short_header', 'Checkout');
$this->set('short_header_text', '← Volver a registro');
$this->set('short_header_link', '/checkout');

echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
echo $this->Html->css('bootstrap-datepicker', array('inline' => false));
echo $this->Html->css('checkout.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->script('shipping.js?v=' . Configure::read('APP_VERSION'),array( 'inline' => false ));
echo $this->Html->script('cart.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));	
echo $this->Html->script('envio.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->element('checkout-params');
?>
<section id="main" class="has-checkout-steps container animated fadeIn delay min-h-101">
	<?php echo $this->element('checkout-steps') ?>
	<?php echo $this->element('title-faq', array('title' => "Método de entrega")) ?>
	<div class="flex-row">
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
							<div class="d-flex justify-content-start align-items-center gap-05">
						  	<div class="position-relative input-cp-container">
						  		<input type="text" name="" placeholder="Tu código postal" value="<?php echo $cart_totals['coupon'] ?>" class="form-control input-cp both" title="Ingresá tu código postal" data-valid="0" />
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
			  	<p class="mt-2 text-sm"><span>Elegí esta opción para evitar cargos de envío. <span class="carrito_takeaway_text"><?= $settings['carrito_takeaway_text'] ?></span></span></p>
				  <div class="cargo-blocks takeaway-block">
						<ul class="generic-select takeaway-options">
							<?php foreach ($stores as $store):?>
								<li store="<?php echo $store['Store']['name'];?>"
									store-address="<?php echo $store['Store']['address'];?>"
									onclick="selectStore(this)"><span class="text-uppercase"><?php echo $store['Store']['name'];?></span>, <span><?php echo $store['Store']['address'];?></span></li>
							<?php endforeach;?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="flex-col gap-1 max-22">
			<?php echo $this->element('resume') ?>
			<div class="d-flex flex-column justify-content-center align-items-center gap-05 pb-4">
		  <?php if (isset($cart) && !empty($cart)) :?>
		    <a href="<?=Router::url('/checkout/pago',true)?>" class="btn btn-chatelet btn-pagos dark w-100">Continuar compra</a>
		  <?php endif ?>
				<a class="btn keep-buying btn-chatelet w-100" href="/tienda">Seguir comprando</a>
			</div>			
		</div>
	</div>
</div>
