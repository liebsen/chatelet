<?php 

$this->set('short_header', 'Checkout');
$this->set('short_header_text', '← Volver a la tienda'); 
$this->set('short_header_link', '/shop');

echo $this->Html->css('clear',array('inline' => false));

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

<section id="main" class="is-flex-center fadeIn delay min-h-101 bg-light">
	<div class="container cart-empty text-center">
		<!--div class="icon-huge mt-4">
			<i class="fa fa-shopping-bag fa-x2 text-muted"></i>
		</div-->
		<h3 class="h3 text-center">¡Gracias por tu compra!</h3>
		<div>
			<p>Tu número de pedido es: <span class="pink"><?php echo $sale_data['sale_id'] ?></span></p>
			<p>Se te ha enviado un email con este n&uacute;mero a <span class="pink"><?php echo $sale_data['user']['email'] ?></span></p>
			<br />
			<a href="<?php echo $this->Html->url(array('controller'=>'shop','action'=>'index')) ?>" class="link">Continuar</a>
		</div>
	</div>
</section>

<!-- Google Code for Venta Online Conversion Page -->
<script type="text/javascript">
	localStorage.removeItem('cart')
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

