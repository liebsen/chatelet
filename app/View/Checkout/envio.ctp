<?php 
echo $this->Session->flash();

$this->set('short_header', 'Checkout');
$this->set('short_header_text', '← Volver al carrito - ');
$this->set('short_header_link', '/carrito');

echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
echo $this->Html->css('bootstrap-datepicker', array('inline' => false));
echo $this->Html->css('checkout.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->script('shipping.js?v=' . Configure::read('APP_VERSION'),array( 'inline' => false ));
echo $this->Html->script('carrito-lib.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));	
echo $this->Html->script('envio.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));	
?>
<section id="detalle" class="is-flex-center flex-column has-checkout-steps min-h-101">
	<?php echo $this->element('checkout-steps') ?>
  <div class="wrapper d-flex flex-column justify-content-center align-items-center gap-1">
		<!--div class="header">
			<h1>Método de envío</h1>			
		</div-->
		<div class="container p-3 animated fadeIn delay">
		<div class="max-22 p-3 animated fadeIn delay">
			<?php echo $this->element('shipping') ?>
		</div>
	</div>
</div>
