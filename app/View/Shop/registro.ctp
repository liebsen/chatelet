<?php

echo $this->Html->script('formValidation.min', array('inline' => false));
echo $this->Html->script('vendor/validation/jquery.validate.min', array('inline' => false));
echo $this->Html->script('bootstrapValidator', array('inline' => false));
echo $this->Html->script('particular-validation', array('inline' => false));
echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
echo $this->Html->css('bootstrapValidator.min');
echo $this->Html->css('bootstrap-datepicker');

$this->set('short_header', $loggedIn ? 'Actualizar mi cuenta' : 'Crear mi cuenta');
$this->set('short_header_text', '← Volver a mi cuenta');
$this->set('short_header_link', '/shop/cuenta');

if (!$loggedIn) {
	$userData = array(
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
				<?php 
					echo $this->Form->create(null, array(
							'url' => array('controller' => 'users', 'action' => 'register'),
							'id' => 'registro_form',
							'class' => 'w-100'
						)
					);
					//if ($loggedIn) {
						// echo '<input type="hidden" name="data[User][id]" value="'. $userData['id'] .'" />';
					// }
				?>
				<input type="hidden" name="redirect" value="<?= $_GET['redirect'] ?? '' ?>" />
				<input type="hidden" name="ajax" value="1" />
			  	<div class="d-flex justify-content-center align-items-center gap-1">
			  		<img src="/images/isologo.png" width="60"/> 
					<h5 class="text-uppercase">
						<?php echo $loggedIn ? 'Actualizar mi cuenta' : 'Crear mi cuenta' ?>
					</h5>			
				</div>
				<p>
					Ingresa tus datos personales para crear una cuenta.
				</p>
				<div class="d-flex flex-column justify-content-start align-items-center gap-1 content">
					<div class="row cols-fix w-100">
						<div class="col-md-6">
							<label for="email">Email</label>
							<div class="form-group">
								<?php
									echo '<input type="email" class="form-control" placeholder="patrodriguez@gmail.com" title="Email" name="data[User][email]" value="'. $userData['email'] .'" />';
								?>
							</div>
							<span class="validation-email"></span>
						</div>
						<div class="col-md-6">
							<label>Newsletter</label>
							<div class="form-group justify-content-center align-items-center p-3">
								<?php
									$subscribed = $unsubscribed = '';
									if ($userData['newsletter'] == '1') $subscribed = 'checked="checked"';
									else if ($userData['newsletter'] == '0') $unsubscribed = 'checked="checked"';
									echo '<label class="d-inline" for="si">Sí</label> <input type="radio" id="si" name="data[User][newsletter]" value="1" '.$subscribed.' /> - '; 
									echo '<label class="d-inline" for="no">No</label> <input type="radio" id="no" name="data[User][newsletter]" value="0" '.$unsubscribed.' />';
								?>
							</div>
						</div>
						<div class="col-md-6">
							<label for="nombre">Nombre</label>
							<div class="form-group">
								<?php
									echo '<input type="text" class="form-control" placeholder="Patricia" title="Nombre" name="data[User][name]" value="'. $userData['name'] .'" />';
								?>
							</div>
						</div>
						<div class="col-md-6">
							<label for="apellido">Apellido</label>
							<div class="form-group">
								<?php
									echo '<input type="text" class="form-control" placeholder="Rodríguez" title="Apellidos" name="data[User][surname]" value="'. $userData['surname'] .'" />';
								?>
							</div>
						</div>
				<?php if($loggedIn):?>
						<div class="col-md-6">
							<label for="FechaNac">Tu fecha de nacimiento</label>
							<div class="form-group">
								<?php
									echo '<input type="text" class="datepicker form-control" id="birthday" placeholder="10/10/1980" title="Fecha de Nacimiento" name="data[User][birthday]" value="'. 
											$this->Time->format($userData['birthday'], '%d/%m/%Y')
										.'" />';
								?>
							</div>
						</div>
						<div class="col-md-6">								
							<label for="Sexo">Tu género</label>
							<div class="form-group">
								<select class="selectpicker form-control" id="Sexo" title="Sexo" name="data[User][gender]">
									<option value="">Selecione sexo</option>
									<option value="M"<?php echo $userData['gender'] == 'M' ? ' selected' : '' ?>>Masculino</option>
									<option value="F"<?php echo $userData['gender'] == 'F' ? ' selected' : '' ?>>Femenino</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<label for="DNI">DNI</label>
							<div class="form-group">
								<?php
									echo '<input type="text" class="form-control" id="DNI" title="DNI" placeholder="25222555" name="data[User][dni]" value="'. $userData['dni'] .'" />';
								?>
							</div>
						</div>
						<div class="col-md-6">
							<label for="Telefono">Teléfono</label>			
							<div class="form-group">
								<?php
									echo '<input type="tel" class="form-control" id="Telefono" title="Telefono" placeholder="011 4703 8888" name="data[User][telephone]" value="'. $userData['telephone'] .'" />';
								?>
							</div>
						</div>
						<div class="col-md-6">
							<label for="TelefonoAlt">Teléfono Alt.</label>
							<div class="form-group">
								<?php
									echo '<input type="tel" class="form-control" id="TelefonoAlt" placeholder="011 4703 8888" title="Teléfono Alt." name="data[User][another_telephone]" value="'. $userData['another_telephone'] .'" />';
								?>
							</div>
						</div>				
						<div class="col-md-6">
							<label for="Calle">Calle</label>
							<div class="form-group">
								<input style="" type="text" class="form-control" id="Calle" title="Calle" name="data[User][street]" value="<?= $userData['street'] ?>" placeholder="San Martín" required />
							</div>
						</div>
						<div class="col-md-6">
							<label for="Nro">Nro.</label>
							<div class="form-group">
								<input min="0" class="form-control" placeholder="Nro." id="Nro" title="5500" name="data[User][street_n]" type="number" value="<?= $userData['street_n'] ?>" required/>
							</div>
						</div>	
						<div class="col-md-6">
							<label for="Piso">Piso</label>
							<div class="form-group">
								<input style="" min="0" id="floor" class="form-control" id="Piso" title="1" placeholder="Piso" name="data[User][floor]" type="number" value="<?= $userData['floor'] ?>"/>
							</div>
						</div>
						<div class="col-md-6">
							<label for="Depto">Depto.</label>
							<div class="form-group">
								<input class="form-control" placeholder="Departamento" id="Depto" title="B" name="data[User][depto]" type="text" value="<?= $userData['depto'] ?>"/>
							</div>
						</div>

						<div class="col-md-6">
							<label for="province">Provincia</label>
							<div class="form-group">
								<select class="selectpicker form-control" id="province" title="province" name="data[User][province]">
									<?php
										if (empty($userData['province'])) {
											echo '<option value="">Seleccionar provincia</option>';
										} else {
											echo '<option value="'. $userData['province'] .'" selected>'. $userData['province'] .'</option>';
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
						<div class="col-md-6">
							<label for="ciudad">Ciudad</label>
							<div class="form-group">
								<?php
									echo '<input type="text" id="ciudad" class="form-control" placeholder="Morón" name="data[User][city]" value="'. $userData['city'] .'" />';
								?>
							</div>
						</div>
						<div class="col-md-6">
							<label for="barrio">Barrio</label>
							<div class="form-group">
								<?php
									 echo '<input type="text" id="barrio" class="form-control" placeholder="Barrio" name="data[User][neighborhood]" value="'. $userData['neighborhood'] .'" />';
								?>
							</div>
						</div>
					<?php else : ?>
						<div class="col-md-6">
							<label for="password">Contraseña</label>
							<div class="form-group">
								<input type="password" placeholder="********" class="form-control" name="data[User][password]" autocomplete="current-password" />
							</div>
							<span class="validation-password"></span>
						</div>
				<?php endif ?>
						<div class="col-md-6">
							<label for="codigo-postal">Código Postal</label>
							<div class="form-group">
								<?php
									echo '<input type="text" id="codigo-postal" placeholder="1430" class="form-control" name="data[User][postal_address]" value="'. $userData['postal_address'] .'" />';
								?>
							</div>
						</div>

					</div>
				</div>
				<hr>
				<div class="row is-flex-center">
					<div class="col-md-6">
						<span class="text-sm text-muted">* Al hacer click en Continuar estas aceptando nuestros <a href="/shop/terminos"> Términos y Condiciones</a>
						</span>
					</div>
					<div class="col-md-6">
			    	<input type="submit" class="btn btn-chatelet dark w-100" id="enviar-registroenviar-registro" value="<?= !$loggedIn ? 'Crear mi cuenta' : 'Actualizar' ?>" />
					</div>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
			<div class="flex-col desktop">
				<div class="card bg-transparent">
					<div class="card-body">
						<h3>
							<?php if ($loggedIn) : ?>
								Tus datos en Châtelet
							<?php else :?>
								Accede a más beneficios
							<?php endif ?>
						</h3>
						<p>
							<?php if ($loggedIn) : ?>
								Tu cuenta fue registrada <?php echo date('d M Y', strtotime($userData['created'])) ?>
							<?php else :?>
								Crea hoy tu cuenta en <i>Châtelet</i> y accede a mas beneficios.
							<?php endif ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<style type="text/css">
	.cols-fix .col-md-6 {
		min-height: 6rem;
	}
</style>
<script type="text/javascript">
	$(function(){
		var timeout = 0
    $('#registro_form').submit(function(e) {
    	e.preventDefault();
    	clearTimeout(timeout)
    	timeout = setTimeout(() => {
        if($("#registro_form").data('bootstrapValidator').isValid()){
            var me = $(this),
            data = me.serialize(),
            url = me.attr('action');
            $.post(url, data)
                .success(function(response) {
                    if (!response.success) {
                        if(response.errors!=undefined){
                            if(response.errors.email!=undefined){
                                $(".validation-email").html(response.errors.email[0]);
                                $("#email").parent().removeClass('has-success');
                                $("#email").parent().addClass('has-error');
                            }
                            if(response.errors.password!=undefined){
                                $(".validation-password").html(response.errors.password[0]);
                                $("#password").parent().removeClass('has-success');
                                $("#password").parent().addClass('has-error');
                            }
                        }
                        $.growl.error({
                            title: 'Error al registrar usuario',
                            message: response.message
                        });

                        $('input[type="submit"]').prop('disabled',false)
                        return false;
                    } else {
                        $.growl.notice({
                            title: 'OK',
                            message: 'Tus datos se han actualizado'
                        });

                        const redirect = $('input[name="redirect"]').val()
                        if(redirect) {
                        	setTimeout(() => {
                        		location.href = redirect
                        	}, 1000)
                        }
                        // me[0].reset();
                        // me.parents('#registro_form').modal('hide');
                        // location.reload();
                    }
                })
                .fail(function() {
                    $.growl.error({
                        title: 'Error al registrar usuario(2)',
                        message: 'Por favor verifica los datos introducidos e intenta de nuevo'
                    });
                });

            return false;
        }
      }, 100)
    });
    // $("#registro_form").bootstrapValidator('validate');		
	})
</script>