<?php

echo $this->Html->script('formValidation.min', array('inline' => false));
echo $this->Html->script('vendor/validation/jquery.validate.min', array('inline' => false));
echo $this->Html->script('bootstrapValidator', array('inline' => false));
echo $this->Html->script('particular-validation', array('inline' => false));

$this->set('short_header', 'Crear cuenta');
$this->set('short_header_text', '← Volver al Iniciar sesión');
$this->set('short_header_link', '/shop/login');

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
<section id="detalle" class="is-flex-center flex-column min-h-100">
  <div class="wrapper container d-flex flex-column justify-content-center align-items-center gap-1">
		<div class="flex-row animated fadeIn">
			<div class="flex-col">
				<div class="d-flex flex-column justify-content-start align-items-center gap-1 content">
					<div class="is-flex justify-content-center align-items-center gap-1 mb-4">
						<p>
							Ingresa tus datos personales para crear una cuenta.
						</p>
						<!--img src="/images/Xo46p1yulnzMHLEBmnsllkEBp.jpg" width="100" /-->
					</div>				
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
						<div class="col-md-4 col-sm-6">
							<!--label class="ml-1" for="email">Email</label-->
							<div class="form-group">
								<?php
									echo '<input type="email" class="form-control" placeholder="Email" title="Email" name="data[User][email]" value="'. $user['email'] .'" />';
								?>
							</div>
							<span class="validation-email"></span>
						</div>
						<div class="col-md-4 col-sm-6">
							<!--label class="ml-1" for="password">Contraseña</label-->
							<div class="form-group">
								<input type="password" placeholder="Contraseña" title="Contraseña" class="form-control" name="data[User][password]" autocomplete="current-password" />
							</div>
							<span class="validation-password"></span>
						</div>
						<div class="col-md-4 col-sm-6">
							<!--label class="ml-1" for="nombre">Nombre</label-->
							<div class="form-group">
								<?php
									echo '<input type="text" class="form-control" placeholder="Nombre" title="Nombre" name="data[User][name]" value="'. $user['name'] .'" />';
								?>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<!--label class="ml-1" for="apellido">Apellido</label-->
							<div class="form-group">
								<?php
									echo '<input type="text" class="form-control" placeholder="Apellidos" title="Apellidos" name="data[User][surname]" value="'. $user['surname'] .'" />';
								?>
							</div>
						</div>

				<?php if($loggedIn):?>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<?php
									echo '<input type="text" class="datepicker form-control" placeholder="Fecha de Nacimiento" title="Fecha de Nacimiento" name="data[User][birthday]" value="'. 
											$this->Time->format($user['birthday'], '%d/%m/%Y')
										.'" />';
								?>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">			
							<?php
								$male = $female = '';
								if ($user['gender'] == 'M') $male = 'selected';
								else if ($user['gender'] == 'F') $female = 'selected';
								echo '<div class="form-group">';
									echo '<select class="selectpicker form-control" title="Sexo" name="data[User][gender]">';
										echo '<option value="">Selecione sexo</option>';
										echo '<option value="M" '.$male.'>Masculino</option>';
										echo '<option value="F" '.$female.'>Femenino</option>';
									echo '</select>';
								echo '</div>';
							?>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<?php
									echo '<input type="text" class="form-control" title="DNI" placeholder="DNI" name="data[User][dni]" value="'. $user['dni'] .'" />';
								?>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<?php
									echo '<input type="tel" class="form-control" title="Telefono" placeholder="Teléfono" name="data[User][telephone]" value="'. $user['telephone'] .'" />';
								?>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<?php
									echo '<input type="tel" class="form-control" placeholder="Teléfono Alt." title="Teléfono Alt." name="data[User][another_telephone]" value="'. $user['another_telephone'] .'" />';
								?>
							</div>
						</div>				
						<div class="col-md-4 col-sm-6">
							<div class="form-group d-flex">
								<input style="" type="text" class="form-control" placeholder="Calle" title="Calle" name="data[User][street]" value="<?= $user['street'] ?>" placeholder="Riobamba" required />
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group d-flex">
								<input min="0" class="form-control" placeholder="Nro." title="Nro." name="data[User][street_n]" type="number" value="<?= $user['street_n'] ?>" required/>
							</div>
						</div>	
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<input style="" min="0" id="floor" class="form-control" title="Piso" placeholder="Piso" name="data[User][floor]" type="number" value="<?= $user['floor'] ?>"/>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<input class="form-control" placeholder="Departamento" title="Departamento" name="data[User][depto]" type="text" value="<?= $user['depto'] ?>"/>
							</div>
						</div>

						<div class="col-md-4 col-sm-6">
						
							<!--label class="ml-1" for="provincia">Provincia</label-->
							<div class="form-group">
								<select id="provincia" class="selectpicker form-control" title="Provincia" name="data[User][province]">
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
						<div class="col-md-4 col-sm-6">
					
							<!--label class="ml-1" for="ciudad">Ciudad</label-->
							<div class="form-group">
								<?php
									echo '<input type="text" id="ciudad" class="form-control" placeholder="Localidad" title="Localidad" name="data[User][city]" value="'. $user['city'] .'" />';
								?>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
						
							<!--label class="ml-1" for="barrio">Barrio</label-->
							<div class="form-group">
								<?php
									 echo '<input type="text" id="barrio" class="form-control" placeholder="Barrio" title="Barrio" name="data[User][neighborhood]" value="'. $user['neighborhood'] .'" />';
								?>
							</div>
						</div>

				<?php endif ?>
						<div class="col-md-4 col-sm-6">
							<!--label class="ml-1" for="codigo-postal">Código Postal</label-->
							<div class="form-group">
								<?php
									echo '<input type="text" id="codigo-postal" placeholder="Código Postal" title="Código Postal" class="form-control" name="data[User][postal_address]" value="'. $user['postal_address'] .'" />';
								?>
							</div>
						</div>
						<div class="col-md-4 col-sm-6">
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
				</div>
			</div>
			<div class="flex-col max-22">
				<div class="card">
					<div class="d-flex flex-column justify-content-center align-items-start gap-05">
						<h3>
							<?php
								if ($loggedIn) echo 'Tus datos en Châtelet';
								else echo 'Crea tu cuenta en Châtelet';
							?>
						</h3>
						<p>
							Crea hoy tu cuenta en <i>Châtelet</i> y accede a mas beneficios.
						</p>

			    	<input type="submit" class="btn btn-chatelet dark w-100" id="enviar-registro" value="<?= !$loggedIn ? 'Crear cuenta en Châtelet' : 'Actualizar mis datos' ?>" />
			    	<div class="modal-buttons"> 
		          <a href="/shop/login">Inicia sesión</a>
		          <a href="/shop/recuperar_acceso">Olvidé mi contraseña</a>
		        </div>
			    </div>
				</div>
				<?php echo $this->Form->end(); ?>			
			</div>
		</div>
	</div>
</section>
