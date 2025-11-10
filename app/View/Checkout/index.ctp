<?php 
echo $this->Session->flash();
$this->set('short_header', 'Checkout');
$this->set('short_header_text', 'Volver al carrito'); 
$this->set('short_header_link', '/carrito');
echo $this->Html->script('carrito-lib.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));	
echo $this->Html->script('envio.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
?>
<section id="detalle" class="is-flex-center min-h-101">
	<?php echo $this->element('checkout-steps') ?>
  <div class="wrapper d-flex flex-column justify-content-center align-items-center gap-1">
		<!--div class="header">
			<h1>Registro</h1>			
		</div-->
		<div class="container p-3 animated fadeIn delay">
			<div class="is-flex flex-column-sm justify-content-center align-items-center gap-1">
			<?php if ($loggedIn) : ?>
				<div class="card">
					<div class="card-body">
						<h2>Hola <?php echo $user['name']; ?></h2>
						<p>Confirma tu identidad para continuar</p>
						<a href="/checkout/envio" class="btn btn-chatelet dark w-100">Continuar como como <?php echo $user['name']; ?> <?php echo $user['surname']; ?> </a>
						<!--script>
							setTimeout(function(){
								location.href = '/checkout/envio'
							}, 3000)
						</script-->
					</div>
				</div>
			<?php else : ?>
				<div class="card min-25 min-h-24">
					<div class="card-body p-5">
						<h2>Inicia sesión</h2>
						<p>Si ya estás registrada inicia sesión con tu cuenta, si no recordás la clave presiona Olvidé contraseña.</p>
						<?php echo $this->Form->create(false, array(
							'id' => 'login_form',
							'url' => array(
								'controller' => 'users', 
								'action' => 'login'
							)
						)); ?> 
						<input type="hidden" name="redirect" value="/checkout/envio" />
						<input type="hidden" name="ajax" value="1" />
			      <input type="email" id="login-email" class="form-control" name="data[User][email]" placeholder="Email" />
			      <input type="password" class="form-control" id="login-password" name="data[User][password]" placeholder="Contraseña" />
			      <input type="submit" class="btn btn-chatelet dark w-100" value="Iniciar sesión" /> 
			      <div class="modal-buttons">                
			        <!--a href="/shop/registro">Crear nueva cuenta</a-->
			        <a href="/shop/recuperar_acceso">Olvidé mi contraseña</a>
			      </div>
			      <?php echo $this->Form->end(); ?>
					</div>
				</div>
				<div class="card min-25 min-h-24">
					<div class="card-body p-5">
						<h2>Comprar como invitada</h2>
						<p>También podés continuar como invitada, solo necesitamos tu email para notificarte de la compra.</p>
						<?php echo $this->Form->create(false, array(
							'id' => 'register_form',
							'url' => array(
								'controller' => 'users', 
								'action' => 'register'
							)
						)); ?>
						<input type="hidden" name="ajax" value="1" />
						<input type="hidden" name="invite" value="1" />
						<input type="hidden" name="redirect" value="/checkout/envio" />    
			      <input type="email" id="login-email" class="form-control" name="data[User][email]" placeholder="Email" />
			      <!--input type="password" class="form-control" id="login-password" name="data[User][password]" placeholder="Contraseña" /-->
			      <input type="submit" class="btn btn-chatelet dark w-100" value="Continuar como invitada" />
			      <?php echo $this->Form->end(); ?>
					</div>
				</div>
			<?php endif ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function() {
	    $('#login_form, #register_form').on('submit', function(event) {
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
	            		onSuccessAlert('Success', res.message)
	                $('#responseContainer').html(res.message);
	                setTimeout(() => {
	                	location.href = redirect || location.href
	                }, 3000)
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
