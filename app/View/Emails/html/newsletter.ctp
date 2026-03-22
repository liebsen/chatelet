<?php echo $data['Newsletter']['body'] ?>
<?php if(!empty($products)): ?>
<?php foreach($products as $product): ?>
<a href="<?=$product['Product']['link']?>">
	<div style="display: flex; align-content: flex-start; justify-content: center; grid-gap: 10px; background-color: #e7e7e7; padding: 10px; color: #333; border-radius: 10px; margin-bottom: 5px">
		<img src="<?=$site_url?>/files/upload/<?=$product['Product']['img_url']?>" width="80">
		<div style="display: flex; align-content: center; justify-content: flex-start; grid-gap: 5px; flex-direction: column;">
			<span style="font-size: 14px; font-weight: 500; color: #c5c5c5"><?= $product['Category']['name'] ?></span>
			<span style="font-size: 18px; font-weight: 800;"><?= $product['Product']['name'] ?></span>
			<span style="font-size: 14px; font-weight: 300;"><?= $product['Product']['desc'] ?></span>
<?php if($data['Newsletter']['show_prices'] == '1'): ?>
			<span style="font-size: 18px; font-weight: 800;">$ <?= $product['Product']['price'] ?></span>
<?php endif ?>
<?php if(!empty($product['Product']['mp_discount'])): ?>
			<span style="font-size: 14px; font-weight: 800;"><?=$product['Product']['mp_discount']?>%OFF Mercado pago</span>
<?php endif ?>
<?php if(!empty($product['Product']['bank_discount'])): ?>
			<span style="font-size: 14px; font-weight: 800;"><?=$product['Product']['bank_discount']?>%OFF Transferencia</span>
<?php endif ?>
		</div>
	</div>
</a>
<?php endforeach ?>
<?php endif ?>
