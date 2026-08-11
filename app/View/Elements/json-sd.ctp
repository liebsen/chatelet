<?php if(!empty($schema)):?>
	<script type="application/ld+json">
		<?php echo json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
	</script>
<?php endif ?>
