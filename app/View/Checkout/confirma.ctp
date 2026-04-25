<?php 
echo $this->Session->flash(); 
$this->set('short_header', 'Checkout');
$this->set('short_header_text', '<i class="gi gi-credit_card mr-1"></i> Volver a pago'); 
$this->set('short_header_link', '/checkout/pago');	

echo $this->Html->css('checkout.css?v=' . $version['ver'], array('inline' => false));
?>
<section id="main" class="has-checkout-steps container animation-fadeIn animation-both delay min-h-101">
	<?php echo $this->element('checkout-steps') ?>

  <div class="wrapper d-flex flex-column justify-content-center align-items-center gap-1">
		<!--div class="header">
			<h1>Registro</h1>			
		</div-->
		<div class="animation-fadeIn delay">
			<div class="is-flex flex-column-sm justify-content-center align-items-start gap-1">
			<div class="card p-4 p-md-5 max-25">
				<div class="card-body">
					<div class="d-flex flex-column justify-content-center align-items-center text-center gap-05">
						<h2 class="text-bolder">Confirma tu compra</h2>
						<p>Todo listo, tu compra es de <span class="price text-sm"><?php echo \price_format($cart_totals['grand_total']) ?></span> y al confirmar
						<?php if($cart_totals['payment_method'] == 'bank') :?>
						  verás en pantalla los datos bancarios para realizar el pago 
						<?php else : ?> 
							te redireccionaremos a Mercado Pago. 
						<?php endif ?>
						</p>
						<?php echo $this->Form->create('confirma_form', array(
							'id' => 'confirma_form',
							'url' => array(
								'controller' => 'checkout', 
								'action' => 'confirma'
							)
						)); ?>
						<input type="hidden" name="confirm" value="1" />
						<?php if($settings['env_staging']):?>
						<input type="hidden" name="simulate" value="0" />
						<input type="hidden" name="simulate_success" value="0" />
						<?php endif ?>
						<div class="d-flex flex-column justify-content-start align-items-center gap-05">
							<input type="submit" class="btn btn-chatelet btn-confirm dark w-100" value="Confirmar compra" />
							<?php if($settings['env_staging']):?>
								<input type="button" class="btn btn-chatelet simulate-success w-100" value="Simular venta exitosa" />
								<input type="button" class="btn btn-chatelet simulate-fail w-100" value="Simular venta fallida" />
								<small>* Solo entorno pruebas</small>
							<?php endif ?>
							<span class="text-sm text-muted"><b>Al finalizar tu compra</b> revisá tu casilla <b><?php echo $user['email']; ?></b></span>
						</div>
						<?php echo $this->Form->end(); ?>	
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">

	$(document).ready(function() {

		<?php if($settings['env_staging']):?>

			/* Payment Simulation */
	  $('.simulate-success').on('click', function(event) {
	  	$('input[name="simulate"]').val(1);
	  	$('input[name="simulate_success"]').val(1);
	  	$('#confirma_form').trigger('submit');
	  })

	  $('.simulate-fail').on('click', function(event) {
	  	$('input[name="simulate"]').val(1);
	  	$('#confirma_form').trigger('submit');
	  })

		<?php endif ?>

	  $('#confirma_form').on('submit', function(event) {
	    event.preventDefault();
	    // const formData = $(this).serialize();
	    const formData = $(this).serializeArray();
	    const btnSubmit = $(this).find('[type="submit"]');
	    const redirect = $(this).find('[name="redirect"]').val();
	    let formObject = {} 

	    formData.map(function(e) {
	    	formObject[e.name] = e.value
	    })

	    formObject.gifts = localStorage.gifts && localStorage.gifts != 'undefined' ? 
	    	JSON.parse(localStorage.gifts) : 
	    		[]

	    btnSubmit.prop('disabled', true)
	    $.ajax({
	      url: $(this).attr('action'),
	      type: 'POST',
	      data: formObject,
	      success: function(res) {
	      	if(res.success) {
	      		$.growl.notice({
	      			title: 'Tu compra fue procesada',
	      			message: res.message,
	      		})      		
	          setTimeout(() => {
	          	// console.log({redirect: res.redirect})
	          	location.href = res.redirect || '/checkout/error'
	          }, 3000)
	      	} else {
	      		$.growl.error({
	      			title: 'Error al confirmar la compra',
	      			message: res.errors,
	      		})      		
	      	}
	      	// btnSubmit.prop('disabled', false)
	      },
	      error: function(xhr, status, error) {
	    		$.growl.error({
	    			title: 'Error al enviar datos',
	    			message: error,
	    		})      	
	        btnSubmit.prop('disabled', false)
	        // Handle errors
	      }
	    });
	  });
	})
</script>
