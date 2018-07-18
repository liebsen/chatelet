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