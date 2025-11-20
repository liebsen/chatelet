<?php


/*echo '<pre>';
var_dump($user);
die();
*/
echo $this->Html->script('formValidation.min', array('inline' => false));
echo $this->Html->script('vendor/validation/jquery.validate.min', array('inline' => false));
echo $this->Html->script('bootstrapValidator', array('inline' => false));
echo $this->Html->script('particular-validation', array('inline' => false));
echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
echo $this->Html->css('bootstrapValidator.min');
echo $this->Html->css('bootstrap-datepicker');

$this->set('short_header', $loggedIn ? 'Editar mi cuenta' : 'Crear mi cuenta');
$this->set('short_header_text', '← Volver a mi cuenta');
$this->set('short_header_link', '/shop/cuenta');

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
<section id="detalle" class="is-flex-center flex-column min-h-101">
  <div class="wrapper container d-flex flex-column justify-content-center align-items-center gap-1">
		<div class="flex-row animated fadeIn">
			<div class="flex-col">
				<h5 class="text-uppercase">
				<?php if ($loggedIn) : ?>
					Editar mi cuenta
				<?php else :?>
					Crear mi cuenta
				<?php endif ?>
				</h5>
				<p>
					Ingresa tus datos personales para crear una cuenta.
				</p>
				<div class="d-flex flex-column justify-content-start align-items-center gap-1 content">
					<?php 
						echo $this->Form->create(null, array(
								'url' => array('controller' => 'users', 'action' => 'register'),
								'id' => 'registro_form',
								'class' => 'w-100'
							)
						);
						if ($loggedIn) {
							echo '<input type="hidden" name="data[User][id]" value="'. $user['id'] .'" />';
						}
					?>
					<div class="row">
						<div class="col-md-6 pr-0-d">
							<label for="email">Email</label>
							<div class="form-group">
								<?php
									echo '<input type="email" class="form-control" placeholder="Email" title="Email" name="data[User][email]" value="'. $user['email'] .'" />';
								?>
							</div>
							<span class="validation-email"></span>
						</div>
						<div class="col-md-6">
							<label for="password">Contraseña</label>
							<div class="form-group">
								<input type="password" placeholder="Contraseña" title="Contraseña" class="form-control" name="data[User][password]" autocomplete="current-password" />
							</div>
							<span class="validation-password"></span>
						</div>
						<div class="col-md-6 pr-0-d">
							<label for="nombre">Nombre</label>
							<div class="form-group">
								<?php
									echo '<input type="text" class="form-control" placeholder="Nombre" title="Nombre" name="data[User][name]" value="'. $user['name'] .'" />';
								?>
							</div>
						</div>
						<div class="col-md-6">
							<label for="apellido">Apellido</label>
							<div class="form-group">
								<?php
									echo '<input type="text" class="form-control" placeholder="Apellidos" title="Apellidos" name="data[User][surname]" value="'. $user['surname'] .'" />';
								?>
							</div>
						</div>
				<?php if($loggedIn):?>
						<div class="col-md-6 pr-0-d">
							<label for="FechaNac">Tu fecha de nacimiento</label>
							<div class="form-group">
								<?php
									echo '<input type="text" class="datepicker form-control" id="FechaNac" placeholder="Fecha de Nacimiento" title="Fecha de Nacimiento" name="data[User][birthday]" value="'. 
											$this->Time->format($user['birthday'], '%d/%m/%Y')
										.'" />';
								?>
							</div>
						</div>
						<div class="col-md-6">								
							<label for="Sexo">Tu género</label>
							<div class="form-group">
								<select class="selectpicker form-control" id="Sexo" title="Sexo" name="data[User][gender]">
									<option value="">Selecione sexo</option>
									<option value="M"<?php echo $user['gender'] == 'M' ? ' selected' : '' ?>>Masculino</option>
									<option value="F"<?php echo $user['gender'] == 'F' ? ' selected' : '' ?>>Femenino</option>
								</select>
							</div>
						</div>
						<div class="col-md-6 pr-0-d">
							<label for="DNI">DNI</label>
							<div class="form-group">
								<?php
									echo '<input type="text" class="form-control" id="DNI" title="DNI" placeholder="DNI" name="data[User][dni]" value="'. $user['dni'] .'" />';
								?>
							</div>
						</div>
						<div class="col-md-6">
							<label for="Telefono">Teléfono</label>			
							<div class="form-group">
								<?php
									echo '<input type="tel" class="form-control" id="Telefono" title="Telefono" placeholder="Teléfono" name="data[User][telephone]" value="'. $user['telephone'] .'" />';
								?>
							</div>
						</div>
						<div class="col-md-6 pr-0-d">
							<label for="TelefonoAlt">Teléfono Alt.</label>
							<div class="form-group">
								<?php
									echo '<input type="tel" class="form-control" id="TelefonoAlt" placeholder="Teléfono Alt." title="Teléfono Alt." name="data[User][another_telephone]" value="'. $user['another_telephone'] .'" />';
								?>
							</div>
						</div>				
						<div class="col-md-6">
							<label for="Calle">Calle</label>
							<div class="form-group">
								<input style="" type="text" class="form-control" id="Calle" placeholder="Calle" title="Calle" name="data[User][street]" value="<?= $user['street'] ?>" placeholder="Riobamba" required />
							</div>
						</div>
						<div class="col-md-6 pr-0-d">
							<label for="Nro">Nro.</label>
							<div class="form-group">
								<input min="0" class="form-control" placeholder="Nro." id="Nro" title="Nro." name="data[User][street_n]" type="number" value="<?= $user['street_n'] ?>" required/>
							</div>
						</div>	
						<div class="col-md-6">
							<label for="Piso">Piso</label>
							<div class="form-group">
								<input style="" min="0" id="floor" class="form-control" id="Piso" title="Piso" placeholder="Piso" name="data[User][floor]" type="number" value="<?= $user['floor'] ?>"/>
							</div>
						</div>
						<div class="col-md-6 pr-0-d">
							<label for="Depto">Depto.</label>
							<div class="form-group">
								<input class="form-control" placeholder="Departamento" id="Depto" title="Departamento" name="data[User][depto]" type="text" value="<?= $user['depto'] ?>"/>
							</div>
						</div>

						<div class="col-md-6">
							<label for="Provincia">Provincia</label>
							<div class="form-group">
								<select id="provincia" class="selectpicker form-control" id="Provincia" title="Provincia" name="data[User][province]">
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
						<div class="col-md-6 pr-0-d">
							<label for="ciudad">Ciudad</label>
							<div class="form-group">
								<?php
									echo '<input type="text" id="ciudad" class="form-control" placeholder="Localidad" title="Localidad" name="data[User][city]" value="'. $user['city'] .'" />';
								?>
							</div>
						</div>
						<div class="col-md-6">
							<label for="barrio">Barrio</label>
							<div class="form-group">
								<?php
									 echo '<input type="text" id="barrio" class="form-control" placeholder="Barrio" title="Barrio" name="data[User][neighborhood]" value="'. $user['neighborhood'] .'" />';
								?>
							</div>
						</div>
				<?php endif ?>
						<div class="col-md-6 pr-0-d">
							<label for="codigo-postal">Código Postal</label>
							<div class="form-group">
								<?php
									echo '<input type="text" id="codigo-postal" placeholder="Código Postal" title="Código Postal" class="form-control" name="data[User][postal_address]" value="'. $user['postal_address'] .'" />';
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
					<?php echo $this->Form->end(); ?>
				</div>
				<hr>
				<div class="row is-flex-center">
					<div class="col-md-6">
						<span class="text-sm text-muted">* Al hacer click en Continuar estas aceptando nuestros <a href="/shop/terminos"> Términos y Condiciones</a>
						</span>
					</div>
					<div class="col-md-6">
			    	<input type="submit" class="btn btn-chatelet dark w-100" id="enviar-registro" value="<?= !$loggedIn ? 'Crear mi cuenta' : 'Actualizar' ?>" />
					</div>
				</div>
			</div>
			<div class="flex-col max-22 desktop">
				<div class="d-flex flex-column justify-content-center align-items-start gap-05">
					<h3>
						<?php if ($loggedIn) : ?>
							Tus datos en Châtelet
						<?php else :?>
							Crea tu cuenta en Châtelet
						<?php endif ?>
					</h3>
					<p>
						<?php if ($loggedIn) : ?>
							Tu cuenta fue registrada en <?php echo $user['created'] ?>
						<?php else :?>
							Crea hoy tu cuenta en <i>Châtelet</i> y accede a mas beneficios.
						<?php endif ?>
					</p>
				</div>	
			</div>
		</div>
	</div>
</section>
