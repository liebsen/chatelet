	<h5 class="text-uppercase">
		<i class="fa fa-user-o"></i>
		Envío a domicilio
  </h5>
  <span class="">Asegurate de verificar y actualizar tus datos correctos para que tu compra llegue a tu domicilio antes y mejor</span>
	<input type="hidden" name="shipping" value=""/>
	<input type="hidden" name="coupon" value=""/>
	<input type="hidden" name="cargo" value=""/>
	<input type="hidden" name="store" value=""/>
	<input type="hidden" name="postal_address" value="<?= $this->Session->read('cp') ?>"/>
	<input type="hidden" name="store_address" value=""/>
	<input type="hidden" name="gifts" value=""/>
	<div class="row">
		<div class="col-md-6 pr-0-d">
			<label for="nombre">Nombre</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Nombre" title="Nombre" id="nombre" name="name" value="<?= (!empty($userData['User']['name']))?$userData['User']['name']:''; ?>" required>
			</div>
		</div>
		<div class="col-md-6">
			<label for="apellido">Apellido</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Apellidos" title="Apellidos" id="apellido" name="surname" value="<?= (!empty($userData['User']['surname']))?$userData['User']['surname']:''; ?>" required>
			</div>
		</div>
		<div class="col-md-12">
			<label for="dni">Email</label>
			<div class="form-group">
				<input type="number" class="form-control" placeholder="DNI" title="DNI" id="dni" name="dni" value="<?= (!empty($userData['User']['dni']))? str_replace('.', '', $userData['User']['dni']):''; ?>" required>
			</div>
		</div>
		<div class="col-md-12">
			<label for="email">Email</label>
			<div class="form-group">
				<input type="email" class="form-control" placeholder="Email" title="Email" id="email" name="email" value="<?= (!empty($userData['User']['email']))?$userData['User']['email']:''; ?>" required>
			</div>
		</div>
		<div class="col-md-12">
			<label for="Telefono">Teléfono</label>
			<div class="form-group">
				<input type="tel" class="form-control" id="Telefono" placeholder="Teléfono" title="Teléfono" id="telefono" name="telephone" value="<?= (!empty($userData['User']['telephone']))?$userData['User']['telephone']:''; ?>" required>
			</div>
		</div>
		<div class="col-md-6 pr-0-d">
			<label for="Provincia">Provincia</label>
			<div class="form-group">
				<select class="form-control" title="Provincia" id="Provincia" name="provincia" autocomplete="off">
					<option value="">Seleccione una Provincia</option>
					<?php foreach ($provincias as $key => $value): ?>
						<option value="<?php echo $value['provincia']; ?>"<?= isset($userData['User']) && strtoupper($value['provincia']) == strtoupper($userData['User']['province']) ? '  selected' : ''?>><?php echo ucfirst($value['provincia']) ?></option>
					<?php endforeach ?>
				</select>
			</div>
		</div>
		<div class="col-md-6">
			<label for="direccion">Localidad</label>
			<div class="form-group">
				<input type="text" class="form-control" title="Localidad" id="Localidad" placeholder="Localidad" name="localidad" value="<?= isset($userData['User']) ? $userData['User']['city'] : '' ?>" required>
			</div>
		</div>
		<div class="col-md-6 pr-0-d">
			<label for="Calle">Calle</label>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Calle" id="Calle" title="Calle" id="calle" name="street" value="<?= @$userData['User']['street'] ?>" required>
			</div>
		</div>
		<div class="col-md-6">
			<label for="Nro">Nro.</label>
			<div class="form-group">
				<input min="0" class="form-control" placeholder="Nro." id="Nro" title="Nro." name="street_n" type="number" value="<?= @$userData['User']['street_n'] ?>"/>
			</div>
		</div>
		<div class="col-md-6 pr-0-d">
			<label for="direccion">Piso</label>
			<div class="form-group">
				<input min="0" class="form-control" placeholder="Piso" title="Piso" name="floor" type="number" value="<?=(!empty($userData['User']['floor']))?$userData['User']['floor']:''; ?>"/>
			</div>
		</div>
		<div class="col-md-6">
			<label for="Depto">Depto</label>
			<div class="form-group">
				<input title="Depto" class="form-control" id="Depto" placeholder="Depto" name="depto" type="text" value="<?= (!empty($userData['User']['depto']))?$userData['User']['depto']:''; ?>"/>
			</div>
		</div>
	</div>
