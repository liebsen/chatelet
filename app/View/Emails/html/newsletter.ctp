<?php echo $data['Newsletter']['body'] ?>
<?php if(!empty($products)): ?>
<?php foreach($products as $product): ?>
  <!-- Main Card Container -->
  <div style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 5px; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); overflow: hidden;">
    <!-- Product Image Section -->
    <a href="<?=$site_url?>" style="text-decoration: none;">
       <img src="<?=$cdn_url?><?=$product['Product']['img_url']?>" alt="<?= $product['Product']['name'] ?>" style="width: 100%; height: auto; display: block;">
    </a>
    <!-- Product Details Section -->
    <div style="padding: 16px; text-align: center;">
      <h3 style="margin: 0 0 10px 0; font-size: 20px; color: #333333;"><?= $product['Product']['name'] ?></h3>
      <p style="margin: 0 0 10px 0; font-size: 20px; color: #666666;"><?= $product['Category']['name'] ?></p>
      <p style="margin: 0 0 15px 0; font-size: 16px; color: #666666;"><?= $product['Product']['desc'] ?></p>
<?php if($data['Newsletter']['show_prices'] == '1'): ?>
	<p style="font-size: 24px; font-weight: bold; color: #000000; margin: 0 0 15px 0;"><?= \price_format($product['Product']['price']) ?></p>
<?php endif ?>
<?php if(!empty($product['Product']['mp_discount'])): ?>
	<p style="margin: 0 0 15px 0; font-size: 14px; color: #666666;"><?=$product['Product']['mp_discount']?>%OFF Mercado pago</p>
<?php endif ?>
<?php if(!empty($product['Product']['bank_discount'])): ?>
	<p style="margin: 0 0 15px 0; font-size: 14px; color: #666666;"><?=$product['Product']['bank_discount']?>%OFF Transferencia</p>
<?php endif ?>
	    <!-- Call to Action Button -->
	    <a href="<?=$product['Product']['link']?>" style="background-color: #007bff; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">
	        Ver en la tienda
	    </a>
	  </div>
	</div>
<?php endforeach ?>
<?php endif ?>
