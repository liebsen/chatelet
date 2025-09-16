<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
<channel>
<title>Tienda Châtelet</title>
<link>https://chatelet.com.ar</link>
<description>Nueva colección, nuevos comienzos.</description>
<?php foreach ($products as $key => $product): ?>
<item>
  <g:id><?= $product['Product']['id'] ?>-<?= $product['Product']['article'] ?></g:id>
  <g:title><?= $product['Product']['name'] ?></g:title>
  <g:description><?= $product['Product']['desc'] ?></g:description>
  <g:link>https://chatelet.com.ar/tienda/producto/<?= $product['Product']['id'] ?>/<?= $product['Product']['category_id'] ?></g:link>
  <g:image_link><?= Configure::read('siteUrl').Configure::read('uploadUrl').$product['Product']['img_url'] ?></g:image_link>
  <g:price><?= $product['Product']['price'] ?> ARS</g:price>
  <g:availability><?= $product['Product']['stock_total'] ? 'in' : 'out of' ?> stock</g:availability>
  <g:google_product_category>Tienda / <?= $product['Category']['category'] ?></g:google_product_category>
  <g:condition>new</g:condition>
  <g:brand>Châtelet</g:brand>
</item>
<?php endforeach ?>
</channel>
</rss>

