<?php echo $this->Html->css('clear',array('inline' => false)) ?>
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
/* <![CDATA[ */
console.log('sale_data', <?php echo json_encode($sale_data); ?>);
var google_conversion_id = 853044157;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "swosCM7lunIQvdfhlgM";
var google_remarketing_only = false;
/* ]]> */

setTimeout(function(){
	console.log('save ecommerce:');
	ga('ecommerce:addTransaction', {
	  'id': '<?php echo $sale_data['sale_id'] ?>',                     // Transaction ID. Required.
	  'affiliation': 'Chatelet',   // Affiliation or store name.
	  'revenue': '<?php echo $sale_data['total'] ?>',               // Grand Total.
	  'shipping': '1',                  // Shipping.
	  'tax': '0'                     // Tax.
	});

	// items

	<?php if (!empty($sale_data['items'])): $index=1000; foreach ($sale_data['items'] as $item): $index++;
	$slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $item['title'])));
	?>
	ga('ecommerce:addItem', {
	  'id': '<?=$index?>',                     // Transaction ID. Required.
	  'name': '<?=$item["title"]?>',    // Product name. Required.
	  'sku': '<?=$slug?>',                 // SKU/code.
	  'category': 'Todos',         // Category or variation.
	  'price': '<?=$item["unit_price"]?>',                 // Unit price.
	  'quantity': '1'                   // Quantity.
	});
	<?php endforeach; endif; ?>

	ga('ecommerce:send');

},3000);
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/853044157/?label=swosCM7lunIQvdfhlgM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
