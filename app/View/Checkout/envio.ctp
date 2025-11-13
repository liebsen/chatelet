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
			  	<p class="mt-2 text-sm text-muted">
			  		<span>Ingresá tu código postal</span>
			  	</p>
				  <div class="d-flex flex-column justify-content-center align-items-start gap-1 cargo-blocks shipment-block">
						<form class="w-100" id="calulate_shipping" data-url="<?php echo $this->Html->url(array('action'=>'deliveryCost')) ?>">
							<div class="d-flex justify-content-start align-items-center gap-05 w-100">
						  	<div class="position-relative input-cp-container flex-1">
						  		<input type="text" name="" placeholder="Tu código postal" value="<?php echo $cart_totals['coupon'] ?>" class="form-control input-cp both" title="Ingresá tu código postal" data-valid="0" />
						  	</div>
					    	<button class="btn btn-chatelet dark btn-input-lg btn-calculate-shipping" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" title="Cotizá el envío a domicilio de tu compra" type="submit">Aplicar</button>
							</div>
						</form>
						<div class="form-group shipping-block w-100 hidden">
							<span class="d-block text-muted">Elegí la empresa de tu confianza para realizar este envío</span>
							<div class="slot">
							</div>
							<hr>
							<?php echo $this->element('shipping-person') ?>
						</div>
					</div> 
			  </div>
			  <div class="tab-pane" id="retiro">
			  	<p class="mt-2 text-sm text-muted">
			  		<span>Elegí esta opción para evitar cargos de envío</span>
			  	</p>
				  <div class="cargo-blocks takeaway-block">
						<span class="d-block text-muted">Elegí la sucursal para pasar a retirar tu compra</span>	
						<ul class="generic-select takeaway-options">
							<?php foreach ($stores as $store):?>
								<li store="<?php echo $store['Store']['name'];?>"
									store-address="<?php echo $store['Store']['address'];?>" 
									store-lat="<?php echo $store['Store']['lat'];?>" 
									store-lng="<?php echo $store['Store']['lng'];?>" 
									onclick="selectStore(this)"><span class="text-uppercase"><?php echo $store['Store']['name'];?></span>, <span><?php echo $store['Store']['address'];?></span></li>
							<?php endforeach;?>
						</ul>
					</div>
					<div class="d-flex flex-column justify-content-center align-items-start gap-05">
						<div id="map_canvas"></div>
						<span class="text-sm text-muted">
							<span><?php echo $settings['carrito_takeaway_text'] ?></span><br>
							Seleccionaste retirar en <span class="store"></span> ubicado en <span class="store-address"></span>
						</span>
					</div>
				</div>
			</div>
			<hr>
			<div class="row is-flex-center">
				<div class="col-md-6">
					<span class="text-sm text-muted">* Al hacer click en Continuar estas aceptando estos <a href="/shop/terminos"> Términos y Condiciones</a>
					</span>
				</div>
				<div class="col-md-6">
		    	<a href="<?=Router::url('/checkout/pago',true)?>" class="btn btn-chatelet btn-pagos dark w-100">Continuar</a>
					<!--a class="btn btn-continue-shopping btn-chatelet w-100" href="/tienda">Seguir comprando</a-->
				</div>
			</div>
			<hr>					
		</div>
		<div class="flex-col gap-1 max-22">
			<?php echo $this->element('resume', array('show_list' => true)) ?>
		</div>
	</div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA80jEAk4PzzCEBDXc8prj7LCB1Q3U3g_o&v=3.exp&sensor=true&language=es"></script>

<script type="text/javascript">

function initMap(cart) {
	$('.store').text(cart.store)
	$('.store-address').text(cart.store_address)

  var latlng = new google.maps.LatLng(cart.store_lat, cart.store_lng);  
  var myOptions = {
    zoom: 15,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  var marker = new google.maps.Marker({position:latlng,map:map,title:cart.store + ' ' + cart.store_address});
}

</script>

<style>
	#map_canvas {
		min-height: 400px;
		width: 100%;
	}
</style>