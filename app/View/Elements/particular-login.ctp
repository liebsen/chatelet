
<?php
  echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
  echo $this->Html->script('formValidation.min', array('inline' => false));
  echo $this->Html->script('vendor/validation/jquery.validate.min', array('inline' => false));
  echo $this->Html->script('bootstrapValidator', array('inline' => false)); 
  echo $this->Html->script('particular-validation', array('inline' => false));
?>
<div class="modal fade" id="particular-login" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title" id="modal-title">
					<?php  echo 'Inicia sesión para continuar'; ?>
				</h3>			
			</div>
			<div class="modal-body">
				<div class="is-flex justify-content-center align-items-center gap-1 mb-4">
					<p>
						Inicia sesión en Chatelet con tus credenciales. Ingresá tu email y contraseña para continuar. Si no tienes una cuenta presiona Crear cuenta.
					</p>
					<!--img src="/images/v8WrVxzTlKt7ZEEgkSt2shf41.jpg" width="100" /-->
				</div>					
				<?php echo $this->Form->create(false, array('url' => array('controller' => 'users', 'action' => 'login'))); ?>                  
        <input type="email" id="login-email" class="form-control" name="data[User][email]" placeholder="Email" />
        <input type="password" class="form-control" id="login-password" name="data[User][password]" placeholder="Contraseña" />
        <input type="submit" id="login" form="" value="Iniciar sesión" /> 
        <!--div class="modal-buttons">                
          <a href="#" id="register" data-toggle="modal" data-dismiss="modal" data-target="#particular-modal">Crear nueva cuenta</a>
          <a href="#" id="forgot-password" data-toggle="modal" data-dismiss="modal"  data-target="#particular-password">Olvidé mi contraseña</a>
        </div-->
        <?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
	
<script type="text/javascript">

$("#login-email").keyup(function () {
        var myemail = $(this).val();
        $(".modal-body #email").val( myemail );
    });

$("#login-password").keyup(function () {
        var mypass = $(this).val();
        $(".modal-body #password").val( mypass );
 });

</script>			
		
	