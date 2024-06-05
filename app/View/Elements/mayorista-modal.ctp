<?php
	echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
	echo $this->Html->script('mayorista-validation', array('inline' => false));
?>
<div class="modal fade" id="mayorista-modal" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="modal-title">Mi Cuenta // <span class="grey">Registro de Usuario</span></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-8">
						<?php 
							echo $this->Form->create(null, array(
									'url' => array('controller' => 'users', 'action' => 'register'),
									'id' => 'mayoristaForm'
								)
							); 
						?>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email"  class="form-control" name="data[User][email]" />
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" name="data[User][password]" />
						</div>
						<div class="form-group">
							<label for="nombre">Nombre</label>
							<input type="text" class="form-control" name="data[User][name]" />
						</div>
						<div class="form-group">
							<label for="apellido">Apellido</label>
							<input type="text" class="form-control" name="data[User][surname]" />
						</div>
						<div class="form-group">
							<label for="nacimiento">Fecha de Nacimiento</label>
							<input type="text" class="datepicker form-control" name="data[User][birthday]" />
						</div>
						<div class="form-group">
							<label for="sexo">Sexo</label>
							<select class="selectpicker form-control" name="data[User][gender]">
								<option>No especificado</option>
								<option value="M">Masculino</option>
								<option value="F">Femenino</option>
							</select>
						</div>
						<div class="form-group">
							<label for="dni">DNI</label>
							<input type="text" class="form-control" name="data[User][dni]" />
						</div>
						<div class="form-group">
							<label>Newsletter</label>
							Si <input type="radio" name="data[User][newsletter]" value="1" checked="checked" /> - 
							No <input type="radio" name="data[User][newsletter]" value="0" />
						</div>
						<div class="form-group">
							<label for="tel">Telefono</label>
							<input type="tel" id="tel" class="form-control" name="data[User][telephone]" />
						</div>
						<div class="form-group">
							<label for="another-tel">Otro telefono</label>
							<input type="tel" id="another-tel" class="form-control" name="data[User][another_telephone]" />
						</div>
						<div class="form-group">
							<label for="direccion">Direccion</label>
							<input type="text" id="direccion" class="form-control" name="data[User][address]" />
						</div>
						<div class="form-group">
							<label for="provincia">Provincia</label>
							<select id="provincia" class="selectpicker form-control" name="data[User][province]">
								<option>Seleccionar provincia</option>
								<option value="Capital Federal">Capital Federal</option>
								<option value="Buenos Aires">Buenos Aires</option>
								<option value="Catamarca">Catamarca</option>
								<option value="Chaco">Chaco</option>
								<option value="Chubut">Chubut</option>
								<option value="Cordoba">Córdoba</option>
								<option value="Corrientes">Corrientes</option>
								<option value="Entre Rios">Entre Ríos</option>
								<option value="Formosa">Formosa</option>
								<option value="Jujuy">Jujuy</option>
								<option value="La Pampa">La Pampa</option>
								<option value="La Rioja">La Rioja</option>
								<option value="Mendoza">Mendoza</option>
								<option value="Misiones">Misiones</option>
								<option value="Neuquen">Neuquén</option>
								<option value="Rio Negro">Río Negro</option>
								<option value="Salta">Salta</option>
								<option value="San Juan">San Juan</option>
								<option value="San Luis">San Luis</option>
								<option value="Santa Cruz">Santa Cruz</option>
								<option value="Santa Fe">Santa Fe</option>
								<option value="Sgo. del Estero">Santiago del Estero</option>
								<option value="Tierra del Fuego">Tierra del Fuego</option>
								<option value="Tucuman">Tucumán</option>
							</select>
						</div>
						<div class="form-group">
							<label for="ciudad">Ciudad</label>
							<input type="text" id="ciudad" class="form-control" name="data[User][city]" />
						</div>
						<div class="form-group">
							<label for="barrio">Barrio</label>
							<input type="text" id="barrio" class="form-control" name="data[User][neighborhood]" />
						</div>
						<div class="form-group">
							<label for="codigo-postal">Código Postal</label>
							<input type="text" id="codigo-postal" class="form-control" name="data[User][postal_address]" />
						</div>
						<input type="submit" id="enviar-registro" value="Actualizar mis datos" />
						<?php echo $this->Form->end(); ?>
					</div>
					<div class="col-md-2"></div>
				</div>
			</div>
		</div>
	</div>
</div>