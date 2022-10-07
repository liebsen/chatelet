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
				echo $this->Html->link('Volver al carrito', array(
					'controller' => 'carrito',
					'action' => 'index'
				), array(
					'class' => 'cart-btn-green',
					'escape' => false
				));
			?>
		</div>
		<div class="col-12 mt-4 cargo-shipment hide">
			<div class="card">
			  <div class="card-body">
			    <h5 class="card-title">
			    	<i class="fa fa-truck"></i>
			    	Envía <span class="shipping text-uppercase"></span> </h5>
			    <h6>
			    	$<span class="shipping_price"></span>			    	
			    </h6>
			  <?php if($loggedIn): ?>
			    <p class="card-text"><?= $userData['User']['street'] ?: $userData['User']['address'] ?> <?= $userData['User']['street'] ? $userData['User']['street_n'] : '' ?>, <?= $userData['User']['city'] ?> <?= $userData['User']['province'] ?> (<?= $this->Session->read('cp') ?>)</p>
			  <?php endif ?>
			    <a href="/carrito" class="card-link">Modificar</a>
			    <span class="card-link is-clickable" onclick="toggleform()" class="card-link">Modificar dirección</span>
			  </div>
			</div>
		</div>
		<div class="col-12 mt-4 cargo-takeaway hide">
			<div class="card">
			  <div class="card-body">
			    <h5 class="card-title">
			    	<i class="fa fa-building-o"></i>
			    	Retiro en sucursal
			    </h5>
			    <p class="card-text">
			    	<span class="store"></span>
			    	<span class="store_address"></span>			    	
			    </p>
			    <p class="card-text">
			    	<?= $data['carrito_takeaway_text'] ?>
			    </p>
			    <a href="/carrito" class="card-link">Modificar</a>
			  </div>
			</div>
		</div>
	<?php if($loggedIn): ?>
		<div class="col-12 mt-4">
			<div class="card">
			  <div class="card-body">
			    <h5 class="card-title">
			    	<i class="fa fa-user"></i>
			    	<?= $userData['User']['name'] ?> <?= $userData['User']['surname'] ?>
			    </h5>
			    <h6>DNI <?= $userData['User']['dni'] ?></h6>
			    <p class="card-text"><?= $userData['User']['email'] ?></p>
			    <span class="card-link is-clickable" onclick="toggleform()" class="card-link">Modificar</span>
			  </div>
			</div>
		</div>
	<?php endif ?>
		<div class="col-12 checkoutform-container<?= !empty($userData['User']['id']) ? ' hide' : '' ?>">
			<form role="form" method="post" id="checkoutform" action="<?php echo $this->Html->url(array(
						'controller' => 'carrito',
						'action' => 'sale'
					)) ?>">
				<div class="row form-container is-rounded">
					<h3 class="">Ingresá tus datos para finalizar la compra</h3>
						<input type="hidden" name="shipping" value=""/>
						<input type="hidden" name="coupon" value=""/>
						<input type="hidden" name="cargo" value=""/>
						<input type="hidden" name="store" value=""/>
						<input type="hidden" name="postal_address" value="<?= $this->Session->read('cp') ?>"/>
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
							<select class="form-control" name="provincia" autocomplete="off">
								<option value=""></option>
								<?php foreach ($provincias as $key => $value): ?>
									<option value="<?php echo $value['provincia']; ?>"<?= strtoupper($value['provincia']) == strtoupper($userData['User']['province']) ? '  selected' : ''?>><?php echo ucfirst($value['provincia']) ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="form-group">
							<label for="direccion">Localidad</label>
							<input type="text" class="form-control" name="localidad" value="<?= $userData['User']['city'] ?>" required>
						</div>
						<span class="clearfix"></span>
						<div class="form-group">
							<label for="direccion">Calle y Número</label>
							<input style="width:75%;float:left;" type="text" class="form-control" placeholder="Riobamba" id="calle" name="street" value="<?= (!empty($userData['User']['street']))?$userData['User']['street']:''; ?>" required>
							<input style="margin-left:1%;width:24%;float:left;" min="0" class="form-control" placeholder="1234" name="street_n" type="number" value="<?=(!empty($userData['User']['street_n']))?$userData['User']['street_n']:''; ?>" required/>
						</div>
						<span class="clearfix"></span>
						<div class="form-group">
							<label for="direccion">Piso y Departamento</label>
							<input style="margin-right:1%;width:49%;float:left;" min="0" class="form-control" placeholder="1,2,3..." name="floor" type="number" value="<?=(!empty($userData['User']['floor']))?$userData['User']['floor']:''; ?>"/>
							<input style="margin-left:1%;width:49%;float:left;" class="form-control" placeholder="A,B,C..." name="depto" type="text" value="<?= (!empty($userData['User']['depto']))?$userData['User']['depto']:''; ?>"/>
						</div>
						<span class="clearfix"></span>
					</div>
				</div>
				<div class="col-12 mt-4">
					<div class="card">
					  <div class="card-body">
					    <h5 class="card-title">
					    	<i class="fa fa-credit-card"></i>
					    	¿Cómo querés pagar tu compra?
					    </h5>
					    <h6>Seleccioná un método de pago</h6>
					    <div class="row payment-method">
					    	<div class="col-sm-6 text-center">
					    		<input type="radio" class="" id="enabled_1" name="payment_method" value="mercadopago" required />
				          <label for="enabled_1" class="d-inline">
				          	<span class="h4">Online</span><br>
				          	<p class="mt-2">Pagá a través de Mercadopago online con débito, crédito o rapipago</p>
				        	</label>				          
				        </div>
				        <div class="col-sm-6 text-center">				          
				          <input type="radio" class="" id="enabled_0" name="payment_method" value="bank" required />
				          <label for="enabled_0" class="d-inline">
				          	<span class="h4">Manual</span><br>
				          	<p class="mt-2">Pagá a través de transferencia bancaria con online banking</p>
				          </label>
				        </div>
			        </div>
					  </div>
					</div>
				</div>
				<div class="col-12 mt-4 center">
					<label class="form-group">
					  <input type="checkbox" id="regalo" name="regalo"><span class="label-text">Es para regalo</span><br><br>
					</label>
				</div>
				<div class="col-12 mt-3 center">
					<input type="submit" onclick="$('.checkoutform-container').removeClass('hide')" class="cart-btn-green" value="Finalizar compra" />
				</div>
			</form>
		</div>
	</div>
</div>
<script>
function toggleform() {
	console.log('toggleform')
	$('.checkoutform-container').toggleClass('hide')
}

$(function(){

<?php if(!$loggedIn):?>	
	$('#particular-login').modal('show')
<?php endif;?>
	var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
	$(`.cargo-${carrito.cargo}`).removeClass('hide')
	$('#regalo').prop('checked', carrito.regalo)
	//$('.store-address').text([carrito.store, carrito.store_address].join(', '))
	//$('.shipping-text').text([carrito.shipping, carrito.shipping_price].join(', '))
	Object.keys(carrito).forEach(key => {
		if ($(`.${key}`).length) {
			$(`.${key}`).text(carrito[key])
		}
		if ($('#checkoutform').find(`input[name='${key}']`).length) {
			$('#checkoutform').find(`input[name='${key}']`).val(carrito[key])
		}
	})
	$('#checkoutform').submit(function () {
		localStorage.removeItem('carrito')
		return true
	})
})
</script>
