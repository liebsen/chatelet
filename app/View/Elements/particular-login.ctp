
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
					<?php  echo 'Iniciar Sesión'; ?>
				</h3>
			</div>
			<div class="modal-body">
				 <?php echo $this->Form->create(false, array('url' => array('controller' => 'users', 'action' => 'login'))); ?>                  
                    <p class="title mb-1">Ingresá tu email y contraseña para continuar.</p>
                    <input type="email" id="login-email"  name="data[User][email]" placeholder="Email" />
                    <input type="password" id="login-password" name="data[User][password]" placeholder="Password" />
                    <input type="submit" id="login" form="" value="Ingresar" />
                   
                    <a href="#" id="forgot-password"     class="open-Modal" 
                      data-toggle="modal" data-dismiss="modal"  data-target="#particular-password">Olvide mi contraseña</a>

                  <?php echo $this->Form->end(); ?>
 
                  <p class="register-container">
                    <a href="#" id="register" class="open-Modal" 
                      data-toggle="modal" data-dismiss="modal"  data-target="#particular-modal">Registrarse</a>
                  </p>
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
		
	