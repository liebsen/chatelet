<?php 
$this->set('short_header', 'Cuenta');
echo $this->Session->flash();
?>
<section id="detalle" class="is-flex-center min-h-101">
  <div class="wrapper container d-flex flex-column justify-content-center align-items-center gap-1">
		<h2>
			<?php  echo 'Recuperar Contraseña'; ?>
		</h2>
		<p>
			Recupera fácilmente el acceso a tu cuenta ingresando el correo con el que creaste tu cuenta en Chatelet.<br> Te enviaremos instrucciones a ese correo.
		</p>
		<?php echo $this->Form->create('ForgotPass', array(
			'class' => 'w-auto',
			'url' => array(
				'controller' => 'users', 
				'action' => 'forgot_password'
			)
		)); ?>
    <p class="title mb-1">Ingresá tu correo</p>
    <input type="email" id="login-email" class="form-control"  name="data[User][email]" placeholder="Email" />
    <input type="submit" id="login" value="Enviar" />
    <span id="forgot-password" class="text-muted text-sm d-block mt-1">
    Recibirás un correo electrónico con tu nueva contraseña
    </span>
    <!--div class="modal-buttons">                
			<a href="#" id="register" data-toggle="modal" data-dismiss="modal" data-target="#particular-modal">Crear nueva cuenta</a>
      <a href="#" data-toggle="modal" data-dismiss="modal" data-target="#particular-login">Iniciar sesión</a>
    </div-->
  	<?php echo $this->Form->end(); ?>       
	</div>
</section>
	
