<?xml version="1.0" encoding="UTF-8"?>
<products>
	<?php foreach ($products as $key => $product): ?>
    <product>
        <id><?= $product['Product']['article'] ?></id>
        <title><?= $product['Product']['name'] ?></title>
        <description><?= $product['Product']['desc'] ?></description>
        <link>https://chatelet.com.ar/tienda/producto/<?= $product['Product']['id'] ?>/<?= $product['Product']['category_id'] ?></link>
        <image_link><?= $settings['site_url'].$settings['upload_url'].$product['Product']['img_url'] ?></image_link>
        <price currency="ARS"><?= $product['Product']['price'] ?></price>
        <availability><?= $product['Product']['stock_total'] ? 'in' : 'out of' ?> stock</availability>
        <category>Tienda / <?= $product['Category']['category'] ?></category>
        <condition>new</condition>
        <brand>Tienda Châtelet</brand>
    </product>
   <?php endforeach ?>
</products>

