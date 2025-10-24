<?php
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
					<div class="col-md-6">
						<!--label class="ml-1" for="email">Email</label-->
						<div class="form-group">
							<?php
								echo '<input type="email" class="form-control" placeholder="Email" name="data[User][email]" value="'. $user['email'] .'" />';
							?>
						</div>
						<span class="validation-email"></span>
					</div>
					<div class="col-md-6">
						<!--label class="ml-1" for="password">Contraseña</label-->
						<div class="form-group">
							<input type="password" placeholder="********" class="form-control" name="data[User][password]" autocomplete="current-password" />
						</div>
						<span class="validation-password"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<!--label class="ml-1" for="nombre">Nombre</label-->
						<div class="form-group">
							<?php
								echo '<input type="text" class="form-control" placeholder="Nombre" name="data[User][name]" value="'. $user['name'] .'" />';
							?>
						</div>
					</div>
					<div class="col-md-6">
						<!--label class="ml-1" for="apellido">Apellido</label-->
						<div class="form-group">
							<?php
								echo '<input type="text" class="form-control" placeholder="Apellido" name="data[User][surname]" value="'. $user['surname'] .'" />';
							?>
						</div>
					</div>
				</div>
				<div class="row">					
					<div class="col-md-6">
						<div class="form-group">
							<?php
								echo '<input type="text" class="datepicker form-control" placeholder="Fecha de Nacimiento" name="data[User][birthday]" value="'. 
										$this->Time->format($user['birthday'], '%d/%m/%Y')
									.'" />';
							?>
						</div>
					</div>
					<div class="col-md-6">			
						<?php
							$male = $female = '';
							if ($user['gender'] == 'M') $male = 'selected';
							else if ($user['gender'] == 'F') $female = 'selected';
							echo '<div class="form-group">';
								echo '<select class="selectpicker form-control" name="data[User][gender]">';
									echo '<option value="">Selecione sexo</option>';
									echo '<option value="M" '.$male.'>Masculino</option>';
									echo '<option value="F" '.$female.'>Femenino</option>';
								echo '</select>';
							echo '</div>';
						?>
					</div>
				</div>
				<div class="row">					
					<div class="col-md-6">
						<div class="form-group">
							<?php
								echo '<input type="text" class="form-control" placeholder="DNI." name="data[User][dni]" value="'. $user['dni'] .'" />';
							?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<?php
								echo '<input type="tel" class="form-control" placeholder="Teléfono" name="data[User][telephone]" value="'. $user['telephone'] .'" />';
							?>
						</div>
					</div>
				</div>
				<div class="row">					
					<div class="col-md-6">
						<div class="form-group d-flex">
							<input style="" type="text" class="form-control" placeholder="Calle" name="data[User][street]" value="<?= $user['street'] ?>" placeholder="Riobamba" required />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group d-flex">
							<input min="0" class="form-control" placeholder="Nro." name="data[User][street_n]" type="number" value="<?= $user['street_n'] ?>" required/>
						</div>
					</div>					
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<?php
								echo '<input type="tel" class="form-control" placeholder="Teléfono Alt." name="data[User][another_telephone]" value="'. $user['another_telephone'] .'" />';
							?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input style="" min="0" id="floor" class="form-control" placeholder="Piso" name="data[User][floor]" type="number" value="<?= $user['floor'] ?>"/>
						</div>
					</div>
				</div>
				<div class="row">					
					<div class="col-md-6">
						<div class="form-group">
							<input class="form-control" placeholder="Departamento" name="data[User][depto]" type="text" value="<?= $user['depto'] ?>"/>
						</div>
					</div>

					<div class="col-md-6">
					
						<!--label class="ml-1" for="provincia">Provincia</label-->
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
					</div>
				</div>
				<div class="row">					
					<div class="col-md-6">
				
						<!--label class="ml-1" for="ciudad">Ciudad</label-->
						<div class="form-group">
							<?php
								echo '<input type="text" id="ciudad" class="form-control" placeholder="Localidad" name="data[User][city]" value="'. $user['city'] .'" />';
							?>
						</div>
					</div>
					<div class="col-md-6">
					
						<!--label class="ml-1" for="barrio">Barrio</label-->
						<div class="form-group">
							<?php
								 echo '<input type="text" id="barrio" class="form-control" placeholder="Barrio" name="data[User][neighborhood]" value="'. $user['neighborhood'] .'" />';
							?>
						</div>
					</div>

				</div>
				<div class="row">					
					<div class="col-md-6">
						<!--label class="ml-1" for="codigo-postal">Código Postal</label-->
						<div class="form-group">
							<?php
								echo '<input type="text" id="codigo-postal" placeholder="Código Postal" class="form-control" name="data[User][postal_address]" value="'. $user['postal_address'] .'" />';
							?>
						</div>
					</div>
					<div class="col-md-6">
						<label>Newsletter</label>
						<div class="form-group justify-content-center align-items-center p-3">
							<?php
								$subscribed = $unsubscribed = '';
								if ($user['newsletter'] == '1') $subscribed = 'checked="checked"';
								else if ($user['newsletter'] == '0') $unsubscribed = 'checked="checked"';
								echo '<label class="d-inline" for="si">Sí</label> <input type="radio" id="si" name="data[User][newsletter]" value="1" '.$subscribed.' /> - '; 
								echo '<label class="d-inline" for="no">No</label> <input type="radio" id="no" name="data[User][newsletter]" value="0" '.$unsubscribed.' />';
							?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
			    	<input type="submit" id="enviar-registro" value="Actualizar mis datos" />
            <div class="modal-buttons">                  
              <a href="#" id="forgot-password" data-toggle="modal" data-dismiss="modal"  data-target="#particular-password">Olvidé mi contraseña</a>
              <a href="#" data-toggle="modal" data-dismiss="modal" data-target="#particular-login">Inicia sesión para continuar</a>
            </div>			    	
			    </div>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
				
			
		
	
