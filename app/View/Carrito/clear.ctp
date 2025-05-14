<?php echo $this->Html->css('clear',array('inline' => false)) ?>
<?php 
	$productos = [];
	foreach ($sale_data['products'] as $item) {
		$description = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $item['description'])));
		$parts = explode('-----',$description);
		$codigo = '';
		$producto = '';
		$variant = '';

		foreach ($parts as $part) {
			preg_match('/codigo-(.*)/', $part, $matches, PREG_OFFSET_CAPTURE);
			if ($matches[1]) {
				$codigo = $matches[1][0];
			}
			preg_match('/producto-(.*)/', $part, $matches, PREG_OFFSET_CAPTURE);
			if ($matches[1]) {
				$producto = $matches[1][0];
			}
			preg_match('/color-(.*)/', $part, $matches, PREG_OFFSET_CAPTURE);
			if ($matches[1]) {
				$variant = $matches[1][0];
			}
		}

		array_push($productos, (object) [
      'name' => $codigo,     // Name or ID is required.
      'id' => $item['product_id'],
      'price' => $item['precio_vendido'],
      'brand' => $producto,
      'variant'=> $variant,
      'quantity' => 1
		]);
	}
?>
<div class="container">
	<div class="row">
		<div class="col-xs-12 text-center"><br /><br /><br />
			<h1 class="heading">Gracias por tu compra!</h1>
			<p>Tu n&uacute;mero de pedido es: <span class="pink"><?php echo $sale_data['sale_id'] ?></span></p>
			<p>Se te ha enviado un email con este n&uacute;mero a <span class="pink"><?php echo $sale_data['user']['email'] ?></span></p>
			<br />
			<a href="<?php echo $this->Html->url(array('controller'=>'shop','action'=>'index')) ?>" class="link">Continuar</a><br /><br /><br />
		</div>
	</div>
</div>
<!-- Google Code for Venta Online Conversion Page -->
<script type="text/javascript">
<?php if(!$failed):?>
	localStorage.removeItem('carrito')
	fbq('track', 'Purchase', {value: <?php echo $sale_data['total'] ?>, currency: 'ARS'});
	gtag('event', 'purchase', {
	  "transaction_id": '<?php echo $sale_data['sale_id'] ?>',
	  "affiliation": 'Online Store',
	  "value": <?php echo $sale_data['total'] ?>,
	  "currency": "ARS",
	  "tax": 0,
	  "shipping": 0,
	  "items": <?php echo json_encode($productos, JSON_PRETTY_PRINT);?>
	})
	<? endif ?>

	/* dataLayer.push({
	  'ecommerce': {
	    'purchase': {
	      'actionField': {
	        'id': '<?php echo $sale_data['sale_id'] ?>',
	        'affiliation': 'Online Store',
	        'revenue': '<?php echo $sale_data['total'] ?>',
	        'tax':'21',
	        'shipping': '1'
	      },
	      'products': <?php echo json_encode($productos, JSON_PRETTY_PRINT);?>
	    }
	  }
	}) */
</script>

