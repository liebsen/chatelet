
<div class="modal fade" id="particular-login" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title" id="modal-title">
					<?php  echo 'Iniciar Sesion'; ?>
				</h3>
			</div>
			<div class="modal-body">
				 <?php 
                    echo $this->Form->create(null, array('url' => array('controller' => 'users', 'action' => 'login'))); 
                  ?>
                    <p class="title">Iniciar Sesion</p>
                    <input type="email" id="login-email" name="data[User][email]" placeholder="Email" />
                    <input type="password" id="login-password" name="data[User][password]" placeholder="Password" />
                    <input type="submit" id="login" value="Ingresar" />
                    <a href="#" id="forgot-password">Olvide mi contraseña</a>
                  <?php echo $this->Form->end(); ?>
                  <p class="register-container">
                    <a href="#" id="register" data-toggle="modal" data-dismiss="modal"  data-target="#particular-modal">Registrarse</a>
                  </p>
			</div>
		</div>
	</div>
</div>
				
			
		
	