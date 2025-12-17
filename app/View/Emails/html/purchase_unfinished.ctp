Hola, <?php echo $data['nombre'] ?> 
<br /><br />
Tenés una compra incompleta con los siguiente productos:<br />
<?php foreach ($data['items'] as $item): ?>
<code>· <?php echo $item['Product']['name'] ?> </code><br />
<?php endforeach ?>
Por un total de $ <?php echo $data['value'] ?>. Para completar tu compra seguí este enlace:<br />
<a style="text-transform: uppercase; text-decoration: none; width: 100%; padding: 12px 16px; background-color: navy; border-radius: 8px; color: #fff;" href="<?php echo $data['checkout_link'] ?>">Finalizar compra</a><br /><br />
<a href="<?php echo $data['checkout_link'] ?>"><?php echo $data['checkout_link'] ?></a>

