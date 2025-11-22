<?php 

echo $this->Session->flash();

$this->set('short_header', 'Checkout');
$this->set('short_header_text', '← Volver al carrito'); 
$this->set('short_header_link', '/carrito');

echo $this->Html->css('checkout.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
echo $this->Html->script('cart.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));	
echo $this->Html->script('envio.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->script('shipping-validation.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->element('checkout-params');

?>

<section id="main" class="has-checkout-steps container animated fadeIn delay min-h-101">
	<?php echo $this->element('checkout-steps') ?>
	<?php echo $this->element('title-faq', array('title' => "Método de entrega")) ?>
	<div class="flex-row w-100">
		<?php echo $this->Form->create('envio_form', array(
			'id' => 'envio_form',
			'url' => array(
				'controller' => 'checkout', 
				'action' => 'envio'
			)
		)); ?>		
		<input type="hidden" name="ajax" value="1" />
		<input type="hidden" name="redirect" value="/checkout/pago" />
		<input type="hidden" name="shipping" value=""/>
		<input type="hidden" name="cargo" value=""/>
		<input type="hidden" name="store" value=""/>
		<input type="hidden" name="store_address" value=""/>
		<input type="hidden" name="postal_address" value="<?= $cart_totals['postal_address'] ?>"/>
		<div class="flex-col">
			<ul class="nav nav-tabs nav-dark">
			  <li class="active"><a href="#envio" data-toggle="tab"><span>Envío a domicilio</span></a></li>
			  <li><a href="#retiro" data-toggle="tab"><span>Retiro en local GRATIS</span></a></li>
			</ul>
			<div class="tab-content">
			  <div class="tab-pane active" id="envio">
			  	<p class="mt-2 text-sm text-muted">
			  		<span>Ingresá tu código postal</span>
			  	</p>
				  <div class="d-flex flex-column justify-content-center align-items-start gap-1 cargo-blocks shipment-block">
						<div class="d-flex justify-content-start align-items-center gap-05 w-100">
					  	<div class="position-relative input-status flex-1">
					  		<input type="text" name="" placeholder="Tu código postal" class="form-control input-cp both" title="Ingresá tu código postal" data-valid="0" />
					  	</div>
				    	<button class="btn btn-chatelet dark btn-input-lg btn-calculate-shipping" data-loading-text="Espere..." title="Cotizá el envío a domicilio de tu compra">Aplicar</button>
						</div>
						<div class="form-group shipping-block mt-2 w-100 hidden">
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
			<div class="checkout-continue row is-flex-center d-none">
				<div class="col-md-6">
					<span class="text-sm text-muted">* Al hacer click en Continuar estas aceptando nuestros <a href="/shop/terminos"> Términos y Condiciones</a>
					</span>
				</div>
				<div class="col-md-6">
		    	<input type="submit" class="btn btn-chatelet dark w-100" value="Continuar" />
					<!--a class="btn btn-continue-shopping btn-chatelet w-100" href="/tienda">Seguir comprando</a-->
				</div>
			</div>
			<?php echo $this->Form->end(); ?>	
			<hr>					
		</div>
		<div class="flex-col">
			<?php echo $this->element('resume', array('show_list' => true)) ?>
		</div>
	</div>
</div>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA80jEAk4PzzCEBDXc8prj7LCB1Q3U3g_o&v=3.exp&language=es"></script>

<script type="text/javascript">
	function initMap(option) {
		const store = $(option).attr('store')
		const store_lng = $(option).attr('store-lng')
		const store_lat = $(option).attr('store-lat')
		const store_address = $(option).attr('store-address')

		$('.store').text(store)
		$('.store-address').text(store_address)

	  var latlng = new google.maps.LatLng(store_lat, store_lng);  
	  var myOptions = {
	    zoom: 15,
	    center: latlng,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  };

	  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	  var marker = new google.maps.Marker({
	  	position:latlng, 
	  	map:map,
	  	title:store + ' ' + store_address
	  });
	}

	$(document).ready(function() {
    $('#envio_form').on('submit', function(event) {
      event.preventDefault();
      const formData = $(this).serialize();
      const btnSubmit = $(this).find('[type="submit"]');
      const redirect = $(this).find('[name="redirect"]').val();
      btnSubmit.prop('disabled', true)
      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function(res) {
        	if(res.success) {
        		// onSuccessAlert('Success', res.message)
            // $('#responseContainer').html(res.message);
            setTimeout(() => {
            	location.href = redirect || location.href
            }, 100)
        	} else {
        		onWarningAlert('Error al enviar datos', res.errors)
        		// $('#responseContainer').html(res.errors);
        	}
        	btnSubmit.prop('disabled', false)
        },
        error: function(xhr, status, error) {
          console.error("Error al enviar datos: " + status + " - " + error);
          btnSubmit.prop('disabled', false)
          // Handle errors
        }
      });
    });
	})

</script>

<style>
	#map_canvas {
		min-height: 400px;
		width: 100%;
	}
</style>