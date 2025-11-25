<?php 
echo $this->Session->flash();

$this->set('short_header', 'Checkout');
$this->set('short_header_text', '← Volver al carrito'); 
$this->set('short_header_link', '/carrito');

echo $this->Html->css('checkout.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->script('cart.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));	
// echo $this->Html->script('envio.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
?>
<!--section id="main" class="is-flex-center has-checkout-steps min-h-101"-->
<section id="main" class="has-checkout-steps container animated fadeIn delay min-h-101">
	<?php echo $this->element('checkout-steps') ?>
  <div class="wrapper d-flex flex-column justify-content-center align-items-center gap-1">
		<!--div class="header">
			<h1>Registro</h1>			
		</div-->
		<div class="animated fadeIn delay">
			<div class="is-flex flex-column-sm justify-content-center align-items-start gap-1">
			<?php if ($loggedIn) : ?>
				<div class="card p-4 p-md-5 max-25">
					<div class="card-body">
						<div class="d-flex flex-column justify-content-start align-items-center gap-05">
							<h2 class="text-bolder">Hola, <?php echo $user['name'] ?? 'Invitada'; ?>!</h2>
							<p>Confirma tu identidad para continuar con tu compra de <?php echo \price_format($cart_totals['grand_total']) ?>.</p>
							<a href="/checkout/envio" class="btn btn-chatelet dark w-100">Continuar como <?php echo $user['name'] ?? 'Invitada'; ?> <?php echo $user['surname']; ?> </a>
							<span class="text-sm text-muted"><b>Al finalizar el proceso</b> revisa tu cuenta en <b><?php echo $user['email']; ?></b></span>
						</div>
						<!--script>
							setTimeout(function(){
								location.href = '/checkout/envio'
							}, 3000)
						</script-->
					</div>
				</div>
			<?php else : ?>
				<div class="card max-25">
					<div class="card-body p-md-5 is-bordered">
						<h4 class="text-uppercase text-center">Ya soy clienta</h4>
						<p>Ingresa con tu cuenta Châtelet, si no recordás la clave presiona Olvidé contraseña.</p>
						<?php echo $this->Form->create(false, array(
							'id' => 'login_form',
							'url' => array(
								'controller' => 'users', 
								'action' => 'login'
							)
						)); ?> 
						<input type="hidden" name="redirect" value="/checkout/envio" />
						<input type="hidden" name="ajax" value="1" />
			      <input type="email" id="login-email" class="form-control" name="data[User][email]" placeholder="Email" required />
			      <input type="password" class="form-control" id="login-password" name="data[User][password]" placeholder="Contraseña" required />
			      <hr>
						<div class="d-flex flex-column justify-content-center align-items-center gap-05 pb-4">			      
			      	<input type="submit" class="btn btn-chatelet dark w-100" value="Iniciar sesión" />
			        <a class="btn btn-chatelet w-100" href="/shop/recuperar_acceso">Olvidé la contraseña</a>
			      </div>
			      <?php echo $this->Form->end(); ?>
					</div>
				</div>
				<div class="card max-25 bg-light-desktop">
					<div class="card-body p-md-5">
						<h4 class="text-uppercase text-center">Soy nueva</h4>
						<p>Ingresá tu email para continuar con tu compra, lo usaremos para notificarte de la compra.</p>
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
			      <input type="email" id="login-email" class="form-control" name="data[User][email]" placeholder="Email" required />
			      <!--input type="password" class="form-control" id="login-password" name="data[User][password]" placeholder="Contraseña" /-->
			      <hr>
			      <div class="d-flex flex-column justify-content-center align-items-center gap-05 pb-4">
			      	<input type="submit" class="btn btn-chatelet dark w-100" value="Continuar como invitada" />
			      	<input type="submit" class="btn btn-chatelet w-100" value="Registrar mi cuenta" />
			      <?php echo $this->Form->end(); ?>
					</div>
				</div>
			<?php endif ?>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	$(document).ready(function() {
			localStorage.setItem('continue_shopping_url', window.location.pathname)
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
	            		onSuccessAlert('Sesión iniciada', res.message)
	                // $('#responseContainer').html(res.message);
	                setTimeout(() => {
	                	const red = redirect || location.href
	                	console.log('redirect', red)
	                	location.href = red
	                }, 5000)
	            	} else {
	            		onWarningAlert('Error al registrar usuario', res.errors)
	            		// $('#responseContainer').html(res.errors);
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
