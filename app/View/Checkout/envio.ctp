<?php 
	$this->set('short_header', 'Checkout');
	echo $this->Session->flash();
	echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
	echo $this->Html->css('bootstrap-datepicker', array('inline' => false));
	echo $this->Html->css('checkout.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
	echo $this->Html->script('shipping.js?v=' . Configure::read('APP_VERSION'),array( 'inline' => false ));
	echo $this->Html->script('carrito-lib.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));	
	echo $this->Html->script('envio.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));	
	echo $this->Html->script('pago.js?v=' . Configure::read('APP_VERSION'),array('inline' => false));
	//echo $this->element('carrito');
?>

<div class="wrapper">
	<div class="container animated fadeIn">
		<div class="content">
			<div class="d-flex flex-column justify-content-start align-items-center gap-1 content">
				<br>
				<h1>Tus datos</h1>
			</div>
		</div>
	</div>
</div>
