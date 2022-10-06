<script>
const carrito = <?php echo json_encode($this->Session->read('Carro'), JSON_PRETTY_PRINT);?>
</script>
<?php
	echo $this->Html->css('checkout', array('inline' => false));
	echo $this->Session->flash();
	echo $this->Html->script('checkout_sale',array('inline' => false));
?>
<div id="main" class="container">
	<div class="row d-flex justify-content-center w-mobile">
		<div class="col-12 center">
			<?php
				echo $this->Html->link('<span class="fa fa-chevron-left"></span> Volver', array(
					'controller' => 'carrito',
					'action' => 'index'
				), array(
					'class' => 'cart-btn-green',
					'escape' => false
				));
			?>
		</div>
		<div class="col-12 mt-2 cargo-shipment hide">
			<div class="card">
			  <div class="card-body">
			    <h5 class="card-title">Envío a domicilio</h5>
			    <h6 class="shipping-text"></h6>
			  <?php if($loggedIn): ?>
			    <p class="card-text"><?= $userData['User']['address'] ?>, <?= $userData['User']['city'] ?> <?= $userData['User']['province'] ?> (<?= $this->Session->read('cp') ?>)</p>
			  <?php endif ?>
			    <a href="/carrito" class="card-link">Modificar</a>
			  </div>
			</div>
		</div>
		<div class="col-12 mt-2 cargo-takeaway hide">
			<div class="card">
			  <div class="card-body">
			    <h5 class="card-title">Retiro en sucursal</h5>
			    <p class="card-text store-address"></p>
			    <a href="/carrito" class="card-link">Modificar</a>
			  </div>
			</div>
		</div>
	<?php if($loggedIn): ?>
		<div class="col-12 mt-2">
			<div class="card">
			  <div class="card-body">
			    <h5 class="card-title"><?= $userData['User']['name'] ?> <?= $userData['User']['surname'] ?></h5>
			    <h6><?= $userData['User']['dni'] ?></h6>
			    <p class="card-text"><?= $userData['User']['email'] ?></p>
			    <a href="/carrito" class="card-link">Modificar</a>
			  </div>
			</div>
		</div>
	<?php endif ?>
		<div class="col-12<?= !empty($userData['User']['id']) ? ' hide' : '' ?>">
			<form role="form" method="post" id="checkout-form" action="<?php echo $this->Html->url(array(
						'controller' => 'carrito',
						'action' => 'sale'
					)) ?>">
				<div class="form-container is-rounded">
					<h3 class="h3 text-center">Ingresá tus datos para finalizar la compra</h3>
					<hr>
						<input type="hidden" name="shipping" value=""/>
						<input type="hidden" name="coupon" value=""/>
						<input type="hidden" name="cargo" value=""/>
						<input type="hidden" name="store" value=""/>
						<input type="hidden" name="store_address" value=""/>

						<div class="form-group">
							<label for="nombre">Nombre</label>
							<input type="text" class="form-control" id="nombre" name="name" value="<?= (!empty($userData['User']['name']))?$userData['User']['name']:''; ?>" required>
						</div>
						<div class="form-group">
							<label for="apellido">Apellido</label>
							<input type="text" class="form-control" id="apellido" name="surname" value="<?= (!empty($userData['User']['surname']))?$userData['User']['surname']:''; ?>" required>
						</div>
						<div class="form-group">
							<label for="dni">DNI</label>
							<input type="number" class="form-control" id="dni" name="dni" value="<?= (!empty($userData['User']['dni']))? str_replace('.', '', $userData['User']['dni']):''; ?>" required>
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" class="form-control" id="email" name="email" value="<?= (!empty($userData['User']['email']))?$userData['User']['email']:''; ?>" required>
						</div>
						<div class="form-group">
							<label for="telefono">Teléfono</label>
							<input type="tel" class="form-control" id="telefono" name="telephone" value="<?= (!empty($userData['User']['telephone']))?$userData['User']['telephone']:''; ?>" required>
						</div>
						<div class="form-group">
							<label for="direccion">Provincia</label>
							<select class="form-control" name="provincia" required data-url="<?php echo Router::url(array('action'=>'getLocalidadProvincia'),true) ?>">
								<option value=""></option>
								<?php foreach ($provincias as $key => $value): ?>
									<option data-id="<?php echo $value['id'] ?>" value="<?php echo $value['provincia']; ?>"><?php echo ucfirst($value['provincia']) ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="form-group">
							<label for="direccion">Localidad</label>
							<select class="form-control" name="localidad" required>
								<option></option>
							</select>
						</div>
						<span class="clearfix"></span>
						<div class="form-group">
							<label for="direccion">Calle y Número</label>
							<input style="width:75%;float:left;" type="text" class="form-control" placeholder="Riobamba" id="calle" name="street" value="<?= (!empty($userData['User']['street']))?$userData['User']['street']:''; ?>" required>
							<input style="margin-left:1%;width:24%;float:left;" min="0" class="form-control" placeholder="1234" name="street_n" type="number" value="<?=(!empty($userData['User']['street_n']))?$userData['User']['street_n']:''; ?>" required/>
						</div>
						<span class="clearfix"></span>
						<div class="form-group">
							<label for="direccion">Nº de Piso y Departamento</label>
							<input style="margin-right:1%;width:49%;float:left;" min="0" class="form-control" placeholder="1,2,3..." name="floor" type="number" value="<?=(!empty($userData['User']['floor']))?$userData['User']['floor']:''; ?>"/>
							<input style="margin-left:1%;width:49%;float:left;" class="form-control" placeholder="A,B,C..." name="depto" type="text" value="<?= (!empty($userData['User']['depto']))?$userData['User']['depto']:''; ?>"/>
						</div>
						<span class="clearfix"></span>
					</div>
				</div>
				<div class="col-12 center">
					<label class="form-group">
					  <input type="checkbox" id="regalo" name="regalo"><span class="label-text">Es para regalo</span>
					</label>
				</div>
				<div class="col-12 center">
					<input type="submit" class="cart-btn-green" value="Finalizar compra" />
				</div>
			</form>
		</div>
	</div>
</div>
<script>
$(function(){
<?php if(!$loggedIn):?>	
	$('#particular-login').modal('show')
<?php endif;?>
	var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
	$(`.cargo-${carrito.cargo}`).removeClass('hide')
	$('#regalo').prop('checked', carrito.regalo)
	$('.store-address').text([carrito.store, carrito.store_address].join(', '))
	$('.shipping-text').text([carrito.shipping, carrito.shipping_price].join(', '))
	Object.keys(carrito).forEach(key => {
		$('#checkout-form').find(`input[name='${key}']`).val(carrito[key])
	})
	$('#checkout-form').submit(function () {
		localStorage.removeItem('carrito')
		return true
	})
})
</script>
