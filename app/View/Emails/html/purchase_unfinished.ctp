Hola, <?php echo $data['name'] ?>, 
<br /><br />
Tenés una compra incompleta:
<?php foreach ($cart as $item): ?>
<code><?php echo $item['count'] ?> - <?php echo $item['name'] ?> </code>
<?php endforeach ?>
<code>Total: <?php echo $grand_total ?> </code>
<br />
Para completar tu compra seguí este enlace:
<br>
<a href="<?php echo $checkout_link ?>">Finalizar compra</a>
