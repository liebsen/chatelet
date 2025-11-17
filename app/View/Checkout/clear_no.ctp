<?php 
echo $this->Session->flash();

echo $this->Html->css('clear',array('inline' => false));

$this->set('short_header', 'Checkout');
$this->set('short_header_text', '← Volver al carrito'); 
$this->set('short_header_link', '/carrito');
?>

<section id="main" class="is-flex-center fadeIn delay min-h-101 bg-light">
	<div class="container cart-empty text-center">
		<!--div class="icon-huge mt-4">
			<i class="fa fa-shopping-bag fa-x2 text-muted"></i>
		</div-->
		<h3 class="h3 text-center">No hemos podido procesar el pago</h3>
		<div>Contactanos para revisar tu intento de compra.<br> <a href="/ayuda/como_comprar" class="text-link">acerca de como comprar</a></div>
	</div>
</section>

