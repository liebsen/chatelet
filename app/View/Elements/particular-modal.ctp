<?php
	echo $this->Html->script('/bootstrap/js/datepicker', array('inline' => false));
	echo $this->Html->script('locales/bootstrap-datepicker.es.js', array('inline' => false));
	echo $this->Html->script('formValidation.min', array('inline' => false));
	echo $this->Html->script('vendor/validation/jquery.validate.min', array('inline' => false));
	echo $this->Html->script('bootstrapValidator', array('inline' => false));
	echo $this->Html->script('particular-validation', array('inline' => false));
	
	if (!$loggedIn) {
		$user = array(
			'email' => '',
			'name' => '',
			'surname' => '',
			'birthday' => '',
			'gender' => '',
			'dni' => '',
			'newsletter' => '',
			'telephone' => '',
			'another_telephone' => '',
			'address' => '',
			'street' => '',
			'street_n' => '',
			'floor' => '',
			'depto' => '',
			'province' => '',
			'city' => '',
			'neighborhood' => '',
			'postal_address' => ''
		);
	}
?>
<div class="modal fade" id="particular-modal" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title" id="modal-title">
					<?php
						if ($loggedIn) echo 'Mi Cuenta';
						else echo 'Registro de Usuario';
					?>
				</h3>
			</div>
			<div class="modal-body">
				<?php 
					echo $this->Form->create(null, array(
							'url' => array('controller' => 'users', 'action' => 'register'),
							'id' => 'particularForm'
						)
					);
					if ($loggedIn) {
						echo '<input type="hidden" name="data[User][id]" value="'. $user['id'] .'" />';
					}
				?>
				<div class="row">
					<div class="col">
							<label for="email">Email</label>
							<div class="form-group">
								<?php
									echo '<input type="email" id="email" class="form-control " name="data[User][email]" value="'. $user['email'] .'" />';
								?>
							</div>
							<span class="validation-email"></span>
							<label for="password">Contraseña</label>
							<div class="form-group">
								<input type="password" id="password" class="form-control" name="data[User][password]" />
							</div>
							<span class="validation-password"></span>
							<label for="nombre">Nombre</label>
							<div class="form-group">
								<?php
									echo '<input type="text" id="nombre" class="form-control" name="data[User][name]" value="'. $user['name'] .'" />';
								?>
							</div>
						
							<label for="apellido">Apellido</label>
							<div class="form-group">
								<?php
									echo '<input type="text" id="apellido" class="form-control" name="data[User][surname]" value="'. $user['surname'] .'" />';
								?>
							</div>
						
							<label for="nacimiento">Fecha de Nacimiento (dd/mm/aaaa) </label>
							<div class="form-group">
								<?php
									echo '<input type="text" id="birthday" class="datepicker form-control" name="data[User][birthday]" value="'. 
											$this->Time->format($user['birthday'], '%d/%m/%Y')
										.'" />';
								?>
							</div>
				
							<label for="sexo">Sexo</label>
							<?php
								$male = $female = '';
								if ($user['gender'] == 'M') $male = 'selected';
								else if ($user['gender'] == 'F') $female = 'selected';
								echo '<div class="form-group">';
									echo '<select id="sexo" class="selectpicker form-control" name="data[User][gender]">';
										echo '<option value="">No especificado</option>';
										echo '<option value="M" '.$male.'>Masculino</option>';
										echo '<option value="F" '.$female.'>Femenino</option>';
									echo '</select>';
								echo '</div>';
							?>
						
							<label for="dni">DNI</label>
							<div class="form-group">
								<?php
									echo '<input type="text" id="dni" class="form-control" name="data[User][dni]" value="'. $user['dni'] .'" />';
								?>
							</div>
				
							<label>Newsletter</label>
							<div class="form-group">
								<?php
									$subscribed = $unsubscribed = '';
									if ($user['newsletter'] == '1') $subscribed = 'checked="checked"';
									else if ($user['newsletter'] == '0') $unsubscribed = 'checked="checked"';
									echo 'Si <input type="radio" name="data[User][newsletter]" value="1" '.$subscribed.' /> - '; 
									echo 'No <input type="radio" name="data[User][newsletter]" value="0" '.$unsubscribed.' />';
								?>
							</div>
						
							<label for="tel">Telefono</label>
							<div class="form-group">
								<?php
									echo '<input type="tel" id="tel" class="form-control" name="data[User][telephone]" value="'. $user['telephone'] .'" />';
								?>
							</div>
					
							<label for="another-tel">Otro telefono</label>
							<div class="form-group">
								<?php
									echo '<input type="tel" id="another-tel" class="form-control" name="data[User][another_telephone]" value="'. $user['another_telephone'] .'" />';
								?>
							</div>
							<label for="direccion">Calle y Número</label>
							<div class="form-group">
								<input style="width:75%;float:left;" type="text" id="direccion" class="form-control" name="data[User][street]" value="<?= $user['street'] ?>" required />
								<input style="margin-left:1%;width:24%;float:left;" min="0" class="form-control" placeholder="1234" name="data[User][street_n]" type="number" value="<?= $user['street_n'] ?>" required/>
							</div>

							<label for="direccion">Piso y Departamento</label>
							<div class="form-group">
								<input style="margin-right:1%;width:49%;float:left;" min="0" class="form-control" placeholder="1,2,3..." name="data[User][floor]" type="number" value="<?= $user['floor'] ?>"/>
								<input style="margin-left:1%;width:49%;float:left;" class="form-control" placeholder="A,B,C..." name="data[User][depto]" type="text" value="<?= $user['depto'] ?>"/>
							</div>
						
							<label for="provincia">Provincia</label>
							<div class="form-group">
								<select id="provincia" class="selectpicker form-control" name="data[User][province]">
									<?php
										if (empty($user['province'])) {
											echo '<option value="">Seleccionar provincia</option>';
										} else {
											echo '<option value="'. $user['province'] .'" selected>'. $user['province'] .'</option>';
										}
									?>
									
									<option value="Ciudad Autonoma de Buenos Aires">Ciudad Autonoma de Buenos Aires</option>
									<option value="Buenos Aires">Buenos Aires</option>
									<option value="Catamarca">Catamarca</option>
									<option value="Chaco">Chaco</option>
									<option value="Chubut">Chubut</option>
									<option value="Cordoba">Cordoba</option>
									<option value="Corrientes">Corrientes</option>
									<option value="Entre Rios">Entre Rios</option>
									<option value="Formosa">Formosa</option>
									<option value="Jujuy">Jujuy</option>
									<option value="La Pampa">La Pampa</option>
									<option value="La Rioja">La Rioja</option>
									<option value="Mendoza">Mendoza</option>
									<option value="Misiones">Misiones</option>
									<option value="Neuquen">Neuquen</option>
									<option value="Rio Negro">Rio Negro</option>
									<option value="Salta">Salta</option>
									<option value="San Juan">San Juan</option>
									<option value="San Luis">San Luis</option>
									<option value="Santa Cruz">Santa Cruz</option>
									<option value="Santa Fe">Santa Fe</option>
									<option value="Santiago del Estero">Santiago del Estero</option>
									<option value="Tierra del Fuego">Tierra del Fuego</option>
									<option value="Tucuman">Tucuman</option>
								</select>
							</div>
					
							<label for="ciudad">Ciudad</label>
							<div class="form-group">
								<?php
									echo '<input type="text" id="ciudad" class="form-control" name="data[User][city]" value="'. $user['city'] .'" />';
								?>
							</div>
						
							<label for="barrio">Barrio</label>
							<div class="form-group">
								<?php
									 echo '<input type="text" id="barrio" class="form-control" name="data[User][neighborhood]" value="'. $user['neighborhood'] .'" />';
								?>
							</div>
						
							<label for="codigo-postal">Codigo Postal</label>
							<div class="form-group">
								<?php
									echo '<input type="text" id="codigo-postal" class="form-control" name="data[User][postal_address]" value="'. $user['postal_address'] .'" />';
								?>
							</div>
						
					</div>
				</div>
				<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-8">
			     		<input type="submit" id="enviar-registro" value="Enviar" />
					</div>
					<div class="col-md-2"></div>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
				
			
		
	
