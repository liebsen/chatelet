<?php
echo $this->Session->flash();
$this->set('short_header', 'Iniciar sesión');
$this->set('short_header_text', '← Volver a la tienda');
$this->set('short_header_link', '/shop');
$this->set('short_header_classname', 'btn_continue_shopping');

echo $this->Html->css('bootstrapValidator.min');
echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
echo $this->Html->script('formValidation.min', array('inline' => false));
echo $this->Html->script('vendor/validation/jquery.validate.min', array('inline' => false));
echo $this->Html->script('bootstrapValidator', array('inline' => false)); 
echo $this->Html->script('particular-validation', array('inline' => false));
?>
<section id="detalle" class="is-flex-center min-h-101">
  <div class="wrapper container d-flex flex-column justify-content-center align-items-center gap-1 m-auto max-30">
		<h2 class="text-uppercase">
			<?php echo 'Inicia sesión para continuar'; ?>
		</h2>			
		<p>
			Inicia sesión en Châtelet con tus credenciales. Ingresá tu email y contraseña para continuar.<br> Si no tienes una cuenta presiona <b>Crear mi cuenta</b>.
		</p>
		<div class="max-22 w-100">
			<div class="is-flex justify-content-center align-items-center gap-1 mb-4">
				<!--img src="/images/v8WrVxzTlKt7ZEEgkSt2shf41.jpg" width="100" /-->
			</div>
			<?php 
				echo $this->Form->create(null, array(
						'url' => array('controller' => 'users', 'action' => 'login'),
						'id' => 'login_form',
						'class' => 'w-100'
					)
				);
			?>
			<input type="hidden" name="redirect" value="/shop"/>                
			<input type="hidden" name="ajax" value="1"/>                
			<div class="form-group">
      	<input type="email" id="login-email" class="form-control" name="data[User][email]" placeholder="Email" required />
      </div>
      <div class="form-group position-relative">
      	<input type="password" class="form-control" id="login-password" name="data[User][password]" placeholder="Contraseña" required />
				<i class="form-pass-icon fa fa-eye-slash is-clickable" data-target="#login-password"></i>
			</div>
      <!--label class="form-group p-1">

      	<input type="checkbox" name="rememberme" />
      	<span class="label-text text-muted"><span class="text-sm text-link">Recordarme en este dispositivo</span></span>
      </label-->
      <div class="d-flex flex-column justify-content-center align-items-center gap-05 pb-4 w-100">
      	<input type="submit" class="btn btn-chatelet dark w-100" value="Iniciar sesión" />
      	<hr> 
        <a class="btn btn-chatelet light w-100" href="<?=$this->Html->url(
						array(
							'controller' => 'shop',
							'action' => 'registro'
						)
					)?>">Crear mi cuenta</a>
        <a class="btn btn-chatelet light w-100" href="<?=$this->Html->url(
						array(
							'controller' => 'shop',
							'action' => 'recuperar_acceso'
						)
					)?>">Olvidé la contraseña</a>
      </div>
      <?php echo $this->Form->end(); ?>
		</div>
	</div>
</section>


<script type="text/javascript">
	$(function(){
		$('input[type="submit"]').prop('disabled', false)
		var timeout = 0
    $('#login_form').submit(function(e) {
    	e.preventDefault();
    	if($('#password').length){
	    	if($('#password').val().trim() != $('#password2').val().trim()) {
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
        $.post(url, data)
          .success(function(res) {
            if (!res.success) {
              $.growl.error({
                  title: 'Error al iniciar sesión',
                  message: res.errors
              });

              $('input[type="submit"]').prop('disabled',false)
              return false;
            } else {
              $.growl.notice({
                  title: 'Inicio de sesión exitoso',
                  message: 'Bienvenida de nuevo'
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
                  title: 'Error al inciar sesión',
                  message: 'Por favor verifica los datos introducidos e intenta de nuevo'
              });
          });

      }, 500)
      return false;
    });
    // $("#registro_form").bootstrapValidator('validate');		
	})
</script>