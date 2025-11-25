<?php 
echo $this->Session->flash();

$this->set('short_header', 'Checkout');
$this->set('short_header_text', '← Volver al carrito'); 
$this->set('short_header_link', '/carrito');

echo $this->Html->css('checkout.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->script('cart.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));	
echo $this->Html->script('pago.js?v=' . Configure::read('APP_VERSION'),array('inline' => false));
echo $this->element('checkout-params');

$filter_legends = $this->App->filter_legends($legends, $cart_totals['grand_total']);
?>
<div id="dues_message" class="container">
	<h3>Vamos a redirigirte a la pasarela de pagos<h3>
	<h4>Asegurate de seleccionar <span class="dues-message-dues"></span> cuotas en MercadoPago</h4>
	<hr>
	<div>
		<button type="button" onclick="$('#submitform').click()" class="btn btn-chatelet" href="" class="mp-link">Entendido, continuar a MercadoPago</button>
	</div>
	<hr>
	<span class="text-sm">❤️ ¡Muchas gracias!</span>
</div>

<section id="main" class="has-checkout-steps container animated fadeIn delay min-h-101">
	<?php echo $this->element('checkout-steps') ?>
	<?php echo $this->element('title-faq', array('title' => "Información de pago")) ?>
	<?php echo $this->Form->create('pago_form', array(
		'id' => 'pago_form',
		'url' => array(
			'controller' => 'checkout', 
			'action' => 'pago'
		)
	)); ?>
		<input type="hidden" name="ajax" value="1" />
		<input type="hidden" name="redirect" value="/checkout/confirma" />	
		<input type="hidden" name="payment_dues" value="1" />	
		<div class="flex-row pt-4">
			<div class="flex-col gap-05">
				<span class="text-muted">¿Cómo querés pagar tu compra? Seleccioná un método de pago para realizar esta compra</span>
				<!--div>
		    	<span class="text-sm">Total a pagar <span class="calc_total"></span>.  Seleccioná un método de pago para realizar esta compra</span>
		    </div-->
		    <div class="d-flex justify-content-start align-items-center card-row payment_method w-100">
		    	<label for="mercadopago" class="is-clickable w-100 select-payment-option bronco-select<?= !@$cart_totals['payment_method'] || @$cart_totals['payment_method'] === 'mercadopago' ? ' is-selected': '' ?>">
		    		<div class="d-flex justify-content-start align-items-center gap-1 w-100">
		    			<input type="radio" id="mercadopago" name="payment_method" value="mercadopago" required <?= !@$cart_totals['payment_method'] || @$cart_totals['payment_method'] === 'mercadopago' ?  'checked': '' ?>/>
	        		<div class="d-flex flex-column justify-content-center align-items-start gap-05">
		          	<h4 class="mb-0 mt-2">Mercado Pago</h4>
		          	<span class="text-sm">Pagá con débito, crédito o rapipago a través de Mercadopago</span>
		         	</div>
	          </div>
	      	</label>
        	<div class="dues-block d-none">
					<?php if(count($filter_legends)) : ?>
						<div class="payment-dues">
					    <span class="text-sm">¿Querés financiar tu compra? Seleccioná la cantidad de cuotas en que te gustaría realizar esta compra</span>
					    <ul class="generic-select">
					    <?php foreach($filter_legends as $legend): ?>
				    		<li 
				    			data-json='<?= @json_encode($legend['Legend']) ?>' 
				    			class="dues-select-option <?= $legend['Legend']['dues'] == 1 ? 'selected' : 'secondary' ?>"
				    		>
				    			<span class="text-uppercase"><?= @$legend['Legend']['dues'] ?> cuota<?= @$legend['Legend']['dues'] > 1 ? 's' : '' ?> de <?=\price_format(ceil($cart_totals['grand_total'] * (((float) $legend['Legend']['interest'] / 100) + 1 ) / (int) $legend['Legend']['dues']))?></span>
				    		</li>
		        	<?php endforeach ?>
			        </ul>
						</div>
						<hr>
					<?php endif ?>					          		
        	</div>
	      <?php if($settings['bank_enable']): ?>
	        <label for="bank" class="is-clickable w-100 select-payment-option bronco-select<?= @$cart_totals['payment_method'] === 'bank' ? ' is-selected': '' ?>">
	        	<div class="d-flex  justify-content-start align-items-center gap-1">
	          	<input type="radio" class="" id="bank" name="payment_method" value="bank" required  <?= @$cart_totals['payment_method'] === 'bank' ?  'checked': '' ?>/>
	        		<div class="d-flex flex-column justify-content-center align-items-start gap-05">
	          		<h4 class="mb-0 mt-2">Transferencia</h4>
		          	<span class="text-sm">Pagá a través de transferencia bancaria con tu home banking</span>
	          	</div>
	          </div>
	        </label>
	       <?php endif ?>
	      </div>
				<hr>
				<div class="row is-flex-center">
					<div class="col-md-6">
						<span class="text-sm text-muted">* Al hacer click en Continuar estas aceptando nuestros <a href="/shop/terminos"> Términos y Condiciones</a>
						</span>
					</div>
					<div class="col-md-6">
			    	<button type="button" id="submitcheckoutbutton" class="btn btn-chatelet dark btn-continue w-100">Continuar</button>
				  	<input type="submit" id="submitform" class="hidden-force" />
					</div>
				</div>
				<hr>					
		  </div>
			<div class="flex-col gap-1">
				<?php echo $this->element('resume', array('show_list' => true)) ?>
			</div>
		</div>
	</form>
</section>

<script type="text/javascript">

$(document).ready(function() {
  $('#pago_form').on('submit', function(event) {
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

      		// onSuccessAlert('Success', res.message)
          // $('#responseContainer').html(res.message);
          setTimeout(() => {
          	location.href = redirect || location.href
          }, 100)
      	} else {
      		$.growl.error({
      			title: 'Error al enviar datos',
      			message: res.errors,
      		})
      		// $('#responseContainer').html(res.errors);
      	}
      	btnSubmit.prop('disabled', false)
      },
      error: function(xhr, status, error) {
      		$.growl.error({
      			title: 'Error al enviar datos (2)',
      			message: error,
      		})

        // console.error("Error al enviar datos: " + status + " - " + error);
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
