<?php

echo $this->Html->script('formValidation.min', array('inline' => false));
// echo $this->Html->script('vendor/validation/jquery.validate.min', array('inline' => false));
// echo $this->Html->script('bootstrapValidator', array('inline' => false));
// echo $this->Html->script('particular-validation', array('inline' => false));
echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
echo $this->Html->css('bootstrapValidator.min');
echo $this->Html->css('bootstrap-datepicker');

$this->set('short_header', $loggedIn ? 'Actualizar mi cuenta' : 'Registrarme');
$this->set('short_header_text', '<i class="gi gi-woman mr-1"></i> Volver a mi cuenta');
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

<style type="text/css">
	@media(max-width: 992px){
		.flex-col .col-md-6 {
			padding: 0!important;
		}
	}
</style>
<section id="detalle" class="is-flex-center flex-column min-h-101">
	<div class="wrapper container-flex d-flex flex-column justify-content-center align-items-center m-auto">
		<div class="flex-row animation-fadeIn">
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
				<div class="d-flex flex-column justify-content-start align-items-center gap-1 content">
					<div class="row w-100">
						<div class="col-md-12">
							<h3 class="mt-0">
								<i class="gi gi-woman"></i> <?php echo $loggedIn ? 'Actualizar mi cuenta' : 'Registrarme' ?>
							</h3>
							<p>
							 Ingresa tus datos personales para crear una cuenta. Luego genera tu contraseña y te recomendamos que nunca la reveles a nadie.
							</p>
						</div>
					</div>
					<div class="row cols-fix w-100 animation-fadeIn">
						<div class="col-md-6">
							<label class="text-muted" for="nombre">Nombre</label>
							<div class="form-group">
								<?php
									echo '<input type="text" class="form-control" placeholder="Patricia" title="Nombre" name="data[User][name]" value="'. $userData['name'] .'" required />';
								?>
							</div>
						</div>
						<div class="col-md-6">
							<label class="text-muted" for="apellido">Apellido</label>
							<div class="form-group">
								<?php
									echo '<input type="text" class="form-control" placeholder="Rodríguez" title="Apellidos" name="data[User][surname]" value="'. $userData['surname'] .'" required />';
								?>
							</div>
						</div>
						<div class="col-md-6">
							<label class="text-muted" for="email">Email</label>
							<div class="form-group">
								<?php
									echo '<input type="email" id="email" class="form-control" placeholder="patriciarodriguez@gmail.com" title="Email" name="data[User][email]" value="'. $userData['email'] .'" required />';
								?>
							</div>
							<span class="validation-email"></span>
						</div>
					<?php if(!$loggedIn):?>						
						<div class="col-md-6">
							<label class="text-muted" for="password">Confirme Email</label>
							<div class="form-group position-relative">
								<input type="email" placeholder="patriciarodriguez@gmail.com" class="form-control" id="email2" name="data[User][email2]" autocomplete="off" />
							</div>
							<span class="validation-password"></span>
						</div>
					<?php endif ?>					
						<div class="col-md-6">
							<label class="text-muted" for="Telefono">Teléfono</label>			
							<div class="form-group">
								<?php
									echo '<input type="tel" class="form-control" id="Telefono" title="Telefono" placeholder="011 4703 8888" name="data[User][telephone]" value="'. $userData['telephone'] .'" required />';
								?>
							</div>
						</div>
				<?php if($loggedIn):?>
						<div class="col-md-6">
							<label class="text-muted" for="FechaNac">Tu fecha de nacimiento</label>
							<div class="form-group">
								<?php
									echo '<input type="text" class="datepicker form-control" id="birthday" placeholder="10/10/1980" title="Fecha de Nacimiento" name="data[User][birthday]" value="'. 
											$this->Time->format($userData['birthday'] ?? '02-02-1990', '%d/%m/%Y')
										.'" required />';
								?>
							</div>
						</div>
						<div class="col-md-6">								
							<label class="text-muted" for="Sexo">Tu género</label>
							<div class="form-group">
								<select class="selectpicker form-control" id="Sexo" title="Sexo" name="data[User][gender]" required>
									<option value="">Selecione sexo</option>
									<option value="M"<?php echo $userData['gender'] == 'M' ? ' selected' : '' ?>>Masculino</option>
									<option value="F"<?php echo $userData['gender'] == 'F' ? ' selected' : '' ?>>Femenino</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<label class="text-muted" for="DNI">DNI</label>
							<div class="form-group">
								<?php
									echo '<input type="text" class="form-control" id="DNI" title="DNI" placeholder="25222555" name="data[User][dni]" value="'. $userData['dni'] .'" required />';
								?>
							</div>
						</div>
						<div class="col-md-6">
							<label class="text-muted" for="codigo-postal">Código Postal</label>
							<div class="form-group">
								<?php
									echo '<input type="text" id="codigo-postal" placeholder="1430" class="form-control" name="data[User][postal_address]" value="'. $userData['postal_address'] .'" />';
								?>
							</div>

						</div>
						<div class="col-md-6">
							<label class="text-muted" for="TelefonoAlt">Teléfono Alt.</label>
							<div class="form-group">
								<?php
									echo '<input type="tel" class="form-control" id="TelefonoAlt" placeholder="011 4703 8888" title="Teléfono Alt." name="data[User][another_telephone]" value="'. $userData['another_telephone'] .'" />';
								?>
							</div>
						</div>				
						<div class="col-md-6">
							<label class="text-muted" for="Calle">Calle</label>
							<div class="form-group">
								<input style="" type="text" class="form-control" id="Calle" title="Calle" name="data[User][street]" value="<?= $userData['street'] ?>" placeholder="San Martín" />
							</div>
						</div>
						<div class="col-md-6">
							<label class="text-muted" for="Nro">Nro.</label>
							<div class="form-group">
								<input min="0" class="form-control" placeholder="Nro." id="Nro" title="5500" name="data[User][street_n]" type="number" value="<?= $userData['street_n'] ?>"/>
							</div>
						</div>	
						<div class="col-md-6">
							<label class="text-muted" for="Piso">Piso</label>
							<div class="form-group">
								<input style="" min="0" id="floor" class="form-control" id="Piso" title="1" placeholder="Piso" name="data[User][floor]" type="number" value="<?= $userData['floor'] ?>"/>
							</div>
						</div>
						<div class="col-md-6">
							<label class="text-muted" for="Depto">Depto.</label>
							<div class="form-group">
								<input class="form-control" placeholder="Departamento" id="Depto" title="B" name="data[User][depto]" type="text" value="<?= $userData['depto'] ?>"/>
							</div>
						</div>

						<div class="col-md-6">
							<label class="text-muted" for="province">Provincia</label>
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
							<label class="text-muted" for="ciudad">Ciudad</label>
							<div class="form-group">
								<?php
									echo '<input type="text" id="ciudad" class="form-control" placeholder="Morón" name="data[User][city]" value="'. $userData['city'] .'" />';
								?>
							</div>
						</div>
						<div class="col-md-6">
							<label class="text-muted" for="barrio">Barrio</label>
							<div class="form-group">
								<?php
									 echo '<input type="text" id="barrio" class="form-control" placeholder="Barrio" name="data[User][neighborhood]" value="'. $userData['neighborhood'] .'" />';
								?>
							</div>
						</div>
					<?php else : ?>
						<div class="col-md-6">
							<label class="text-muted" for="password">Contraseña</label>
							<div class="form-group position-relative">
								<input type="password" placeholder="********" class="form-control" id="password" name="data[User][password]" autocomplete="off" />
								<i class="form-pass-icon fa fa-eye-slash is-clickable" data-target="#password"></i>
							</div>
							<span class="validation-password"></span>
						</div>
						<div class="col-md-6">
							<label class="text-muted" for="password">Confirme Contraseña</label>
							<div class="form-group position-relative">
								<input type="password" placeholder="********" class="form-control" id="password2" name="data[User][password2]" autocomplete="off" />
								<i class="form-pass-icon fa fa-eye-slash is-clickable" data-target="#password2"  ></i>
							</div>
							<span class="validation-password"></span>
						</div>
				<?php endif ?>
						<div class="col-md-12">
							<div class="controls flex-1">
								<label class="control-label text-muted" for="toggle">Deseo suscribirme al Newsletter</label>
								<input type="checkbox" name="data[User][newsletter]" value="1" id="toggle" class="toggle-checkbox"<?= $userData['newsletter'] || empty($userData['newsletter']) == '1' ? ' checked' : '' ?>>
								<label for="toggle" class="toggle-label"></label>
								<?php
									/*$subscribed = $unsubscribed = '';
									if ($userData['newsletter'] == '1') $subscribed = 'checked';
									else if ($userData['newsletter'] == '0') $unsubscribed = 'checked';
									if($subscribed=='') $subscribed = 'checked';
										echo '<label class="text-muted" for="si"><input type="radio" id="si" name="data[User][newsletter]" value="1" '.$subscribed.' /><span>Sí</span></label> '; 
									echo '<label class="text-muted" for="no"><input type="radio" id="no" name="data[User][newsletter]" value="0" '.$unsubscribed.' /><span>No</span></label>';*/
								?>
							</div>
							<small class="">Suscríbete hoy a nuestra plataforma y te seleccionaremos para ofertas especiales y eventos exclusivos, por email y a tu teléfono.</small>
						</div>
					</div>
				</div>
				<hr>
				<div class="row is-flex-center accept-terms pl-4 pr-4">
					<div class="col-md-6">
						<span class="text-sm">* Al hacer click en Continuar estas aceptando nuestros <a href="/shop/terminos"> Términos y Condiciones</a>
						</span>
					</div>
					<div class="col-md-6">
			    	<input type="submit" class="btn btn-chatelet dark w-100" id="enviar-registroenviar-registro" value="<?= !$loggedIn ? 'Registrarme' : 'Actualizar' ?>" />
					</div>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
			<div class="flex-col desktop">
				<div class="card">
					<div class="card-body bg-transparent">
						<h3 class="mt-0"><i class="gi gi-magic"></i>
							<?php if ($loggedIn) : ?>
								Tus datos en Châtelet
							<?php else :?>
								Accede a más beneficios
							<?php endif ?>
						</h3>
						<?php if ($loggedIn) : ?>
							Tu cuenta fue registrada <?php echo date('d M Y', strtotime($userData['created'])) ?>
						<?php else :?>
							Crea hoy tu cuenta en <i>Châtelet</i> y accede a mas beneficios.
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<footer>
	<?php echo $this->element('signature') ?>
</footer>

<script type="text/javascript">
$(function(){
	var timeout = 0
	$('input[type="submit"]').prop('disabled', false)
    $('#registro_form').submit(function(e) {
    	e.preventDefault();
    	if($('#email2').length){
	    	if($('#email').val().trim() != $('#email2').val().trim()) {
	    		return onWarningAlert('Error de validación', 'Los emails no coinciden. Asegúrate de que sean el mismo en ambos campos')
	    	}
	    }
    	if($('#password').length){
    		const pw_length = 6
    		const password = $('#password').val().trim()
    		const password2 = $('#password2').val().trim()

    		if(password.length < pw_length) {
    			$('#password').focus()
    			return onWarningAlert('Error de validación', 'Ingresa una contraseña de al menos 6 letras, simbolos y/o números')
    		}

	    	if(password != password2) {
	    		$('#password2').focus()
	    		return onWarningAlert('Error de validación', 'Las contraseñas no coinciden. Asegúrate de que sean la misma en ambos campos')
	    	}
	    }
    	$('input[type="submit"]').prop('disabled', true)
    	// const formData = new FormData(e.target);
    	clearTimeout(timeout)
    	timeout = setTimeout(() => {
        var me = $(this),
        data = me.serialize(),
        url = me.attr('action');
        $.post(url, data).success(function(response) {
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
                title: 'Bienvenida',
                message: 'Tu cuenta está lista'
            });

            const redirect = $('input[name="redirect"]').val() || '/shop'
        	setTimeout(() => {
        		location.href = redirect
        	}, 1000)
          }
        })
        .fail(function() {
      		$('input[type="submit"]').prop('disabled', false)
          $.growl.error({
              title: 'Error al registrar usuario',
              message: 'Por favor verifica los datos introducidos e intenta de nuevo'
          });
        });
      }, 500)
      return false;
    });
    // $("#registro_form").bootstrapValidator('validate');		
})
</script>