<?php 
echo $this->Session->flash(); 
$this->set('short_header', 'Checkout');
$this->set('short_header_text', '← Volver a pago'); 
$this->set('short_header_link', '/checkout/pago');	

echo $this->Html->css('checkout.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
?>
<section id="main" class="has-checkout-steps container animated fadeIn delay min-h-101">
	<?php echo $this->element('checkout-steps') ?>

  <div class="wrapper d-flex flex-column justify-content-center align-items-center gap-1">
		<!--div class="header">
			<h1>Registro</h1>			
		</div-->
		<div class="animated fadeIn delay">
			<div class="is-flex flex-column-sm justify-content-center align-items-start gap-1">
			<div class="card p-4 p-md-5 max-25">
				<div class="card-body">
					<div class="d-flex flex-column justify-content-center align-items-center text-center gap-05">
						<h2 class="text-bolder">Confirma tu compra</h2>
						<p>Todo listo <?php echo $user['name'] ?? 'Invitada'; ?>! Solo falta confirmar. <br>Tu compra es de <?php echo \price_format($cart_totals['grand_total']) ?></p>
						<?php echo $this->Form->create('confirma_form', array(
							'id' => 'confirma_form',
							'url' => array(
								'controller' => 'checkout', 
								'action' => 'confirma'
							)
						)); ?>
						<input type="hidden" name="confirm" value="1" />							
						<div class="d-flex flex-column justify-content-start align-items-center gap-05">
							<input type="submit" class="btn btn-chatelet btn-confirm dark w-100" value="Confirmar compra" />
							<span class="text-sm text-muted"><b>Al finalizar el proceso</b> revisa tu cuenta en <b><?php echo $user['email']; ?></b></span>
						</div>
						<?php echo $this->Form->end(); ?>	
					</div>
					<!--script>
						setTimeout(function(){
							location.href = '/checkout/envio'
						}, 3000)
					</script-->
				</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	$(document).ready(function() {
	  $('#confirma_form').on('submit', function(event) {
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
	      		$.growl.notice({
	      			title: 'OK',
	      			message: res.message,
	      		})      		
	          setTimeout(() => {
	          	console.log({redirect: res.redirect})
	          	// location.href = redirect || location.href
	          }, 3000)
	      	} else {
	      		$.growl.error({
	      			title: 'Error al enviar datos (2)',
	      			message: res.errors,
	      		})      		
	      	}
	      	btnSubmit.prop('disabled', false)
	      },
	      error: function(xhr, status, error) {
	    		$.growl.error({
	    			title: 'Error al enviar datos (2)',
	    			message: error,
	    		})      	
	        btnSubmit.prop('disabled', false)
	        // Handle errors
	      }
	    });
	  });
		setTimeout(() => {
			const payment_method = localStorage.getItem('payment_method')  || 'mercadopago'
			$('#'+payment_method).click()
		}, 100)
		if(carrito.gifts && carrito.gifts.length) {
			$('#gifts').val(carrito.gifts.join(','))
		}
	})
</script>
