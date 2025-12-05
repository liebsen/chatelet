<script type="text/javascript">
<?php 
	$filtered = [];
	$private = [
	  'mercadopago_client_secret', 
	  'mercadopago_client_id', 
	  'google_analytics_code', 
	  'facebook_pixel_id',
	  'oca_nro_cuenta',
	  'oca_psw',
	  'oca_usr',
	];

	foreach($settings as $key => $item) {
	  if (!in_array($key, $private)) {
	    $filtered[$key] = is_numeric($item) ? (float) $item : $item;
	  }
	}
?>

const settings = <?php echo json_encode($filtered, JSON_PRETTY_PRINT);?>;
let freeShipping = <?php echo (int)@$freeShipping?>;
let cart_totals = <?php echo json_encode($cart_totals, JSON_PRETTY_PRINT);?>;
let cart_items = <?php echo json_encode($cart, JSON_PRETTY_PRINT);?>;
</script>
