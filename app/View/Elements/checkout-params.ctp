<script>
	window.freeShipping = <?=(int)@$freeShipping?>;
	const shipping_price = '<?= @$settings['shipping_price_min'] ?>';
	const cart_totals = <?php echo json_encode($cart_totals, JSON_PRETTY_PRINT);?>;
	let cart_items = <?php echo json_encode($cart, JSON_PRETTY_PRINT);?>;
	const bank = {
		enable: <?= isset($settings['bank_enable']) ? $settings['bank_enable'] : 0 ?>,
		discount_enable: <?= isset($settings['bank_discount_enable']) ? $settings['bank_discount_enable'] : 0 ?>,
		discount: <?= isset($settings['bank_discount']) ? $settings['bank_discount'] : 0 ?>
	}
</script>
