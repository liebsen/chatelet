<?php
	echo $this->Html->css('carrito', array('inline' => false));
	echo $this->Html->script('carrito', array('inline' => false));

	echo $this->Session->flash();
	echo $this->element('checkout-modal');
?>
<div id="main" class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div id="carrito" class="col-md-8">
			<a class="keep-buying" href="/tienda">Seguir comprando</a>
			<h3 id="heading" style="margin:10px 0px">Carrito de compras // <span class="grey">Proceso de compra</span></h3>
			<?php
				echo '<input type="hidden" id="loggedIn" value="'. (string) $loggedIn .'" />';
				echo '<input type="hidden" id="checkout" value="'. $this->Html->url(array('controller' => 'carrito', 'action' => 'checkout')) .'" />'
			?>
			<table class="table">
				<thead>
					<tr>
						<th>Producto</th>
						<th>Detalle</th>
						<th></th>
						<th>Precio Total</th>
					</tr>
				</thead>
				<tbody>
					<?php
					    $row = 0;
						$subtotal = 0;
						$total = 0;
						if (!isset($carro)) $carro = array();
						foreach ($carro as $product) {

							if (!empty($product['discount']) && (float)@$product['discount']>0) {
                                $product['price'] = $product['discount'];
                            }
							$total += $product['price'];
							if (!isset($product['color'])) $product['color'] = '';
							if (!isset($product['size'])) $product['size'] = '';
							echo '<tr product_row>';
								echo '<td>';
									echo '<span class="name">'. $product['name'] .'</span>';
									echo "<div class='clearfix'></div>";
									echo '<img style="margin-top:10px;" src="'.Configure::read('imageUrlBase').$product['img_url'].'" class="thumb" style="display:block;" />';
								echo '</td>';
								echo '<td>';
								if (!empty($product['alias'])){
									echo '<p class="color">Color: <span class="color-block">'. $product['alias'] .'</span></p>';
								}
								if (!empty($product['size'])){

									echo '<p>Talle: <span class="talle">'. $product['size'] .'</span></p>';
								}
								echo '</td>';
								echo '<td>';
									echo $this->Html->link('<span class="glyphicon glyphicon-trash"></span>',
										array(
											'controller' => 'carrito',
											'action' => 'remove',
											$row
										),
										array ('class' => 'trash', 'escape' => false)
									);
								echo '</td>';
								echo '<td>';
									echo '<span class="price">'. $this->Number->currency($product['price'], 'USD', array('places' => 2)) .'</span>';
								echo '</td>';
							echo '</tr>';
							$row += 1;
						}

					?>
				</tbody>
			</table>
			<div class="price">Subtotal: <?php echo $this->Number->currency($total, 'USD', array('places' => 2)); ?></div>
			<input type="hidden" id="subtotal_compra" value="<?=floatval($total)?>" />
			<?php echo $this->element('oca') ?>
		</div>
		<div class="col-md-2"></div>
	</div>
	<div class="row">
		<div class="col-md-2"></div>
		<div id="siguiente-block" class="col-md-8">
		<a href="javascript:void(0)" class="disabled" link-to="<?=Router::url('/carrito/checkout',true)?>" id="siguiente">Siguiente</a>
		</div>
		<div class="col-md-2"></div>
	</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div id="instrucciones" class="col-md-4">
			<p id="como-comprar">Como comprar</p>
			<ol id="como-comprar-list">
				<li>Selecciona todos los productos que deseas</li>
				<li>Agregalos al carro de comprar</li>
				<li>Ingresa a tu carro y presiona <strong>SIGUIENTE</strong></li>
			</ol>
			<a id="paypal">
				<?php echo $this->Html->image('mercadopago.png',array('width'=>300)); ?>
			</a>
		</div>
		<div class="col-md-4"></div>
	</div>
</div>
