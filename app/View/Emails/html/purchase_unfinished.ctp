Hola, <?php echo $data['name'] ?> 
<br /><br />
Tenés una compra incompleta.<br />
<?php foreach ($data['cart'] as $item): ?>
<code><?php echo $item['count'] ?> - <?php echo $item['name'] ?> </code><br />
<?php endforeach ?>
<code>Total: <?php echo $data['grand_total'] ?> </code><br />
Para completar tu compra seguí este enlace:<br /><br />
<a style="text-transform: uppercase; text-decoration: none; width: 100%; padding: 12px 16px; background-color: #888; border-radius: 8px; color: #fff;" href="<?php echo $data['checkout_link'] ?>">Finalizar compra</a><br /><br />
<a href="<?php echo $data['checkout_link'] ?>"><?php echo $data['checkout_link'] ?></a>

