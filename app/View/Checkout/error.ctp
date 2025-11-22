<?php echo $this->Html->css('clear',array('inline' => false)) ?>
<div class="container">
	<div class="row">
		<div class="col-xs-12 text-center"><br /><br /><br />
			<h1 class="heading">No hemos podido procesar el pago</h1>
			<p>Contactanos para revisar tu intento de compra. </p>
			<br />
			<a href="<?php echo $this->Html->url(array('controller'=>'shop','action'=>'index')) ?>" class="link">Volver a la página</a><br /><br /><br />
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
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/853044157/?label=swosCM7lunIQvdfhlgM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
