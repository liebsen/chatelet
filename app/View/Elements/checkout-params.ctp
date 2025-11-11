<script>
	window.freeShipping = <?=(int)@$freeShipping?>;
	const shipping_price = '<?= @$shipping_price_min ?>';
	const cart_totals = <?php echo json_encode($cart_totals, JSON_PRETTY_PRINT);?>;
	let cart_items = <?php echo json_encode($cart, JSON_PRETTY_PRINT);?>;
	const bank = {
		enable: <?= isset($data['bank_enable']) ? $data['bank_enable'] : 0 ?>,
		discount_enable: <?= isset($data['bank_discount_enable']) ? $data['bank_discount_enable'] : 0 ?>,
		discount: <?= isset($data['bank_discount']) ? $data['bank_discount'] : 0 ?>
	}
</script>
