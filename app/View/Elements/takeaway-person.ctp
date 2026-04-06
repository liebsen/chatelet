<?php 
echo $this->Html->css('bootstrapValidator.min');
echo $this->Html->css('bootstrap-datepicker', array('inline' => false));
echo $this->Html->script('vendor/validation/jquery.validate.min', array('inline' => false));
echo $this->Html->script('bootstrapValidator', array('inline' => false));
?>
	<input type="hidden" name="customer[email]" value="<?= @$userData['User']['email'] ?>" />
	<h5 class="text-uppercase">
		<i class="fa fa-user-o"></i>
		Retira en sucursal
  </h5>
  <span class="">Por favor indica tus datos personales para que te podamos reconocer cuando retires tu producto.</span>
	<div class="row">
		<div class="col-md-6 pr-0-d">
			<label for="nombre">Nombre</label>
			<div class="form-group">
				<input type="text" maxlength="20" class="form-control" placeholder="Nombre" title="Nombre" id="nombre" name="customer[name]" value="<?= (!empty($userData['User']['name']))?$userData['User']['name']:''; ?>" data-attr="required" required>
				<span class="help-block"></span>
			</div>
		</div>
		<div class="col-md-6">
			<label for="apellido">Apellido</label>
			<div class="form-group">
				<input type="text" maxlength="20" class="form-control" placeholder="Apellidos" title="Apellidos" id="apellido" name="customer[surname]" value="<?= (!empty($userData['User']['surname']))?$userData['User']['surname']:''; ?>" data-attr="required" required>
				<span class="help-block"></span>
			</div>
		</div>
		<div class="col-md-6 pr-0-d">
			<label for="dni">DNI</label>
			<div class="form-group">
				<input type="number" maxlength="12" class="form-control" placeholder="DNI" title="DNI" id="dni" name="customer[dni]" value="<?= (!empty($userData['User']['dni']))? str_replace('.', '', $userData['User']['dni']):''; ?>" data-attr="required" required>
				<span class="help-block"></span>
			</div>
		</div>
		<div class="col-md-6">
			<label for="Telefono">Teléfono</label>
			<div class="form-group">
				<input type="tel" maxlength="20" class="form-control" id="Telefono" placeholder="Teléfono" title="Teléfono" id="telefono" name="customer[telephone]" value="<?= (!empty($userData['User']['telephone']))?$userData['User']['telephone']:''; ?>" data-attr="required" required>
			</div>
		</div>	
	</div>
