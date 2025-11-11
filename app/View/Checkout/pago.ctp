<?php 
echo $this->Session->flash();

$this->set('short_header', 'Checkout');
$this->set('short_header_text', '← Volver al carrito - ');
$this->set('short_header_link', '/carrito');

echo $this->Html->css('checkout.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->script('cart.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));	
echo $this->Html->script('pago.js?v=' . Configure::read('APP_VERSION'),array('inline' => false));
echo $this->element('checkout-params');
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

	<form role="form" method="post" id="checkoutform" autocomplete="off" onkeydown="return event.key != 'Enter';" action="<?php echo $this->Html->url(array(
				'controller' => 'carrito',
				'action' => 'sale'
			)) ?>">

		<div class="flex-row">
			<div class="flex-col">
				<div>
					<span class="text-sm">¿Cómo querés pagar tu compra?</span>
				</div>						
				<!--div>
		    	<span class="text-sm">Total a pagar <span class="calc_total"></span>.  Seleccioná un método de pago para realizar esta compra</span>
		    </div-->
		    <div class="row card-row gap-05 payment_method pl-3 pr-3">
		    	<label for="mercadopago" class="col-xs-12 is-clickable select-payment-option option-rounded<?= !@$config['payment_method'] || @$config['payment_method'] === 'mercadopago' ? ' is-selected': '' ?>">
		    		<div class="d-flex justify-content-start align-items-center gap-05">
		    			<input type="radio" id="mercadopago" name="payment_method" value="mercadopago" required <?= !@$config['payment_method'] || @$config['payment_method'] === 'mercadopago' ?  'checked': '' ?>/>
	          	<span class="h5">Mercado Pago</span>
	          </div>
	        	<p class="mt-2 text-sm">Pagá con débito, crédito o rapipago a través de Mercadopago</p>
	        	<div class="dues-block d-none">
						<?php if(count($legends) && $this->App->show_legends($legends)): ?>
							<div class="payment-dues">
						    <p class="text-sm">¿Querés financiar tu compra? Seleccioná la cantidad de cuotas en que te gustaría realizar esta compra</p>
						    <ul class="generic-select">
						    <?php foreach($legends as $legend): ?>
						    	<?php if($total >= @$legend['Legend']['min_sale']):?>
						    		<li data-json='<?= @json_encode($legend['Legend']) ?>' class="dues-select-option <?= $legend['Legend']['dues'] == 1 ? 'selected' : 'secondary' ?>"><span class="text-uppercase">
						    			<?= @$legend['Legend']['dues'] ?> cuota<?= @$legend['Legend']['dues'] > 1 ? 's' : '' ?> de <?='$ ' . \price_format(ceil($total * (((float) $legend['Legend']['interest'] / 100) + 1 ) / (int) $legend['Legend']['dues']))?></span></li>
				        	<?php endif ?>
			        	<?php endforeach ?>
				        </ul>
							</div>						
						<?php endif ?>					          		
	        	</div>
	      	</label>				          
	      <?php if($data['bank_enable']): ?>
	        <label for="bank" class="col-xs-12 is-clickable select-payment-option option-rounded<?= @$config['payment_method'] === 'bank' ? ' is-selected': '' ?>">
	        	<div class="d-flex justify-content-start align-items-center gap-05">
		          <input type="radio" class="" id="bank" name="payment_method" value="bank" required  <?= @$config['payment_method'] === 'bank' ?  'checked': '' ?>/>
	          	<span class="h5">Transferencia</span>
	          </div>
	        	<p class="mt-2 text-sm">Pagá a través de transferencia bancaria con tu home banking</p>
	        </label>
	       <?php endif ?>
	      </div>
		  </div>
			<div class="flex-col gap-1 max-22">
				<?php echo $this->element('resume') ?>
				<div class="d-flex flex-column justify-content-center align-items-center gap-05 pb-4">
			  <?php if (isset($cart) && !empty($cart)) :?>
			  	<button type="button" id="submitcheckoutbutton" class="btn btn-chatelet dark btn-continue w-100">Continuar</button>
			  	<input type="submit" id="submitform" class="hidden-force" />
			  <?php endif ?>
					<a class="btn keep-buying btn-chatelet w-100" href="/tienda">Seguir comprando</a>
				</div>			
			</div>
		</div>
	</form>
</section>

<script>

$(function(){
	<?php if(!$loggedIn):?>	
	setTimeout(() => {
		$('#particular-login').modal('show')
	}, 1000)
	<?php endif;?>
	var carrito = JSON.parse(localStorage.getItem('cart')) || {}
	setTimeout(() => {
		$('#<?= @$config['payment_method'] ?: 'mercadopago'?>').click()
	}, 100)
	if(carrito.gifts && carrito.gifts.length) {
		$('#gifts').val(carrito.gifts.join(','))
	}
})
</script>
