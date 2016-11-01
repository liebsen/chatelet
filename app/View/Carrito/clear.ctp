<?php echo $this->Html->css('clear',array('inline' => false)) ?>
<div class="container">
	<div class="row">
		<div class="col-xs-12 text-center">
			<h1 class="heading">Gracias por tu compra!</h1>
			<p>Tu numero de pedido es: <span class="pink"><?php echo $sale_data['sale_id'] ?></span></p>
			<p>Se te ha enviado un email con este numero a <span class="pink"><?php echo $sale_data['user']['email'] ?></span></p>
			<br />
			<a href="<?php echo $this->Html->url(array('controller'=>'shop','action'=>'index')) ?>" class="link">Continuar</a>
		</div>
	</div>
</div>