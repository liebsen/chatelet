
<div class="modal fade" id="particular-password" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title" id="modal-title">
					<?php  echo 'Recuperar Contraseña'; ?>
				</h3>
			</div>
			<div class="modal-body">
				 <?php 
                    echo $this->Form->create(null, array('url' => array('controller' => 'users', 'action' => 'forgot_password'))); 
                  ?>
                    <p class="title">Ingrese su correo</p>
                    <input type="email" id="login-email"  name="data[User][email]" placeholder="Email" />
                    <input type="submit" id="login" value="Enviar" />
                    <span id="forgot-password" >
                    Recibira un correo electronico con su nueva contraseña
                    </span>

                  <?php echo $this->Form->end(); ?>
          
                  
			</div>
		</div>
	</div>
</div>
	