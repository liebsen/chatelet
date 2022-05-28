<script>
const carrito = <?php echo json_encode($this->Session->read('Carro'), JSON_PRETTY_PRINT);?>
</script>
<?php
	echo $this->Html->css('checkout', array('inline' => false));
	echo $this->Session->flash();
	echo $this->Html->script('checkout_sale',array('inline' => false));
?>
<div id="main" class="container">
	<div class="col-md-4 center">
		<?php
			echo $this->Html->link('Volver', array(
				'controller' => 'carrito',
				'action' => 'index'
			), array(
				'class' => 'volver'
			));
		?>
	</div>
	<div class="col-md-4 form-container is-rounded">
		<h3 class="h3 text-center">Ingrese sus datos para finalizar la compra</h3>
		<hr>
		<form role="form" method="post" id="checkout-form" action="<?php echo $this->Html->url(array(
					'controller' => 'carrito',
					'action' => 'sale'
				)) ?>">
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
				<input type="number" class="form-control" id="dni" name="dni" value="<?= (!empty($userData['User']['dni']))?$userData['User']['dni']:''; ?>" required>
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
			<div class="form-group">
				<label for="direccion">Calle y Número</label>
				<span class="clearfix"></span>
				<input style="width:75%;float:left;" type="text" class="form-control" placeholder="Riobamba" id="calle" name="street" value="<?= (!empty($userData['User']['street']))?$userData['User']['street']:''; ?>" required>
				<input style="margin-left:1%;width:24%;float:left;" min="0" class="form-control" placeholder="1234" name="street_n" type="number" value="<?=(!empty($userData['User']['street_n']))?$userData['User']['street_n']:''; ?>" required/>
			</div>
			<div class="form-group">
				<label for="direccion">Nº de Piso y Departamento</label>
				<span class="clearfix"></span>
				<input style="margin-right:1%;width:49%;float:left;" min="0" class="form-control" placeholder="1,2,3..." name="floor" type="number" value="<?=(!empty($userData['User']['floor']))?$userData['User']['floor']:''; ?>"/>
				<input style="margin-left:1%;width:49%;float:left;" class="form-control" placeholder="A,B,C..." name="depto" type="text" value="<?= (!empty($userData['User']['depto']))?$userData['User']['depto']:''; ?>"/>
			</div>
			<span class="clearfix"></span>
			<div class="form-group cargo-shipment is-hidden">
				<label for="codigo_postal">Código Postal</label>
				<?php
					$cp = $this->Session->read('cp');
					echo '<input readonly="readonly" type="text" class="form-control" id="codigo_postal" name="postal_address" value="'. $cp .'" required>';
				?>
			</div>
			<div class="form-group cargo-takeaway is-hidden">
				<hr>
				<div class="form-group">
					<label>Retiro en sucursal</label>
					<p class="text-success store-address"></p>
				</div>
			</div>
			<div class="form-group">
				<hr>
				<input type="checkbox" id="regalo" name="regalo">
				<label for="regalo">Es para regalo</label>
			</div>
			<div class="form-group hide">
				<label for="pais">Envío</label>
				<select id="pais" name="country-to-send" class="form-control">
					<option value="nacional" selected>Nacional</option>
					<option value="internacional">Internacional</option>
				</select>
			</div>
			<input type="submit" class="siguiente" value="Finalizar compra" />
		</form>
	</div>
	<div class="col-md-4"></div>
</div>
<script>
$(function(){
<?php if(!$loggedIn):?>	
	$('#particular-login').modal('show')
<?php endif;?>
	var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
	$(`.cargo-${carrito.cargo}`).removeClass('is-hidden')
	$('#regalo').prop('checked', carrito.regalo)
	$('.store-address').text([carrito.store, carrito.store_address].join(', '))
	Object.keys(carrito).forEach(key => {
		console.log(key, carrito[key])
		$('#checkout-form').find(`input[name='${key}']`).val(carrito[key])
	})
	$('#checkout-form').submit(function () {
		localStorage.removeItem('carrito')
		return true
	})
})
</script>
