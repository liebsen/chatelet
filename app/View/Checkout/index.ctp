<?php 
$this->set('short_header', 'Checkout');
echo $this->Session->flash();
echo $this->Html->script('carrito-lib.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));	
echo $this->Html->script('envio.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));	
?>

<section id="detalle" class="is-flex-center min-h-100">
  <div class="wrapper d-flex flex-column justify-content-center align-items-center gap-1">
		<div class="header">
			<h3 class="modal-title" id="modal-title">
				<?php  echo 'Inicia sesión para continuar'; ?>
			</h3>			
		</div>
		<div class="max-22 p-3">
			<div class="is-flex justify-content-center align-items-center gap-1 mb-4">
			<?php if ($loggedIn) : ?>
				<div class="card p-3">
					<div class="card-body">
						<h2>Hola <?php echo $user['name']; ?></h2>
						<p>Te estamos redirigiendo al siguiente paso..</p>
					</div>
				</div>
			<?php else : ?>
				<div class="card">
					<div class="card-body">
						<?php echo $this->Form->create(false, array('url' => array('controller' => 'users', 'action' => 'login'))); ?>                  
			      <input type="email" id="login-email" class="form-control" name="data[User][email]" placeholder="Email" />
			      <input type="password" class="form-control" id="login-password" name="data[User][password]" placeholder="Contraseña" />
			      <input type="submit" id="login" form="" value="Iniciar sesión" /> 
			      <div class="modal-buttons">                
			        <a href="/shop/registro">Crear nueva cuenta</a>
			        <a href="#" id="forgot-password" data-toggle="modal" data-dismiss="modal"  data-target="#particular-password">Olvidé mi contraseña</a>
			      </div>
			      <?php echo $this->Form->end(); ?>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<h1>Comprar como invitado</h1>
						<p>Opcionalmente puedes continuar como invitado</p>
						<?php echo $this->Form->create(false, array('url' => array('controller' => 'users', 'action' => 'login'))); ?>                  
			      <input type="email" id="login-email" class="form-control" name="data[User][email]" placeholder="Email" />
			      <!--input type="password" class="form-control" id="login-password" name="data[User][password]" placeholder="Contraseña" /-->
			      <input type="submit" id="login" form="" value="Continuar como invitado" /> 
			      <?php echo $this->Form->end(); ?>
					</div>
				</div>
			<?php endif ?>
			</div>
		</div>
	</div>
</div>
