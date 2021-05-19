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
		<h5 class="h5 text-center">Ingrese sus datos para finalizar la compra</h5>
		<hr>
		<form role="form" method="post" id="checkout-form" action="<?php echo $this->Html->url(array(
					'controller' => 'carrito',
					'action' => 'sale'
				)) ?>">
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
			<div class="form-group">
			<?php if ($_GET['cargo'] === 'shipment'):?>
				<label for="codigo_postal">Código Postal</label>
				<?php
					$cp = $this->Session->read('cp');
					echo '<input readonly="readonly" type="text" class="form-control" id="codigo_postal" name="postal_address" value="'. $cp .'" required>';
				?>
			<?php endif;?>
			<?php if ($_GET['cargo'] === 'takeaway'):?>
				<input type="hidden" name="cargo" value="<?php echo $_GET['cargo'];?>"/>
				<input type="hidden" name="store" value="<?php echo $_GET['store'];?>"/>
				<input type="hidden" name="store_address" value="<?php echo $_GET['store_address'];?>"/>
				<hr>
				<div class="form-group">
					<label>Retiro en sucursal</label>
					<p class="text-success"><?php echo $_GET['store'];?>, <?php echo $_GET['store_address'];?></p>
				</div>
			<?php endif;?>
			</div>
			<div class="form-group">
				<hr>
				<input type="checkbox" id="ticket_regalo" name="ticket_regalo"<?php echo $_GET['ticket'] ? ' checked' : ''; ?>>
				<label for="ticket_regalo">Es para regalo</label>
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
<?php if(!$loggedIn):?>
<script>
$(function(){
$('#particular-login').modal('show');
});
</script>
<?php endif;?>