<?php 
$this->set('short_header', 'Cuenta');
$this->set('short_header_text', '← Volver a mi cuenta');
$this->set('short_header_link', '/shop/cuenta');
echo $this->Session->flash();
?>
<section id="detalle" class="is-flex-center min-h-101">
  <div class="wrapper container d-flex flex-column justify-content-center align-items-center gap-1">
		<h2 class="text-uppercase">
			<?php echo 'Recuperar Contraseña'; ?>
		</h2>
		<p>
			Recupera fácilmente el acceso a tu cuenta ingresando el correo con el que creaste tu cuenta en Châtelet.<br> Te enviaremos instrucciones a ese correo.
		</p>
		<?php echo $this->Form->create('ForgotPass', array(
			'id' => 'password_form',
			'class' => 'w-100 max-22',
			'url' => array(
				'controller' => 'users', 
				'action' => 'forgot_password'
			)
		)); ?>
    <p class="title mb-1">Ingresá tu correo</p>
    <input type="hidden" name="ajax" value="1" />
    <input type="email" id="login-email" class="form-control" name="data[User][email]" placeholder="Email" />
    <div class="d-flex flex-column justify-content-center align-items-center gap-05 pb-4">
	    <input type="submit" id="login" value="Enviar" />
	    <span id="forgot-password" class="text-muted text-sm d-block mt-1">
  		  Recibirás un correo electrónico con tu nueva contraseña
    	</span>
    </div>
    <!--div class="modal-buttons">                
			<a href="#" id="register" data-toggle="modal" data-dismiss="modal" data-target="#particular-modal">Crear mi cuenta</a>
      <a href="#" data-toggle="modal" data-dismiss="modal" data-target="#particular-login">Iniciar sesión</a>
    </div-->
  	<?php echo $this->Form->end(); ?>       
	</div>
</section>

<script type="text/javascript">
	$(document).ready(function() {
	    $('#password_form').on('submit', function(event) {
	        event.preventDefault();
	        const formData = $(this).serialize();
	        const btnSubmit = $(this).find('[type="submit"]');
	        const redirect = $(this).find('[name="redirect"]').val();
	        btnSubmit.prop('disabled', true)
	        $.ajax({
	            url: $(this).attr('action'),
	            type: 'POST',
	            data: formData,
	            success: function(res) {
	            	if(res.success) {
	            		onSuccessAlert('Datos de acceso actualizados', res.message)
	                /* $('#responseContainer').html(res.message);
	                setTimeout(() => {
	                	location.href = redirect || location.href
	                }, 3000)*/
	            	} else {
	            		onWarningAlert('Error al registrar usuario', res.errors)
	            		$('#responseContainer').html(res.errors);
	            	}
	            	btnSubmit.prop('disabled', false)
	            },
	            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
                btnSubmit.prop('disabled', false)
                // Handle errors
	            }
	        });
	    });
	});
</script>
	
