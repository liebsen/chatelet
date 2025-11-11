<?php
echo $this->Session->flash();
$this->set('short_header', 'Iniciar sesión');
$this->set('short_header_text', '← Volver a la tienda');
$this->set('short_header_link', '/shop');
echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
echo $this->Html->script('formValidation.min', array('inline' => false));
echo $this->Html->script('vendor/validation/jquery.validate.min', array('inline' => false));
echo $this->Html->script('bootstrapValidator', array('inline' => false)); 
echo $this->Html->script('particular-validation', array('inline' => false));
?>
<section id="detalle" class="is-flex-center min-h-100">
  <div class="wrapper container d-flex flex-column justify-content-center align-items-center gap-1 animated fadeIn delay">
		<h2 class="text-uppercase">
			<?php echo 'Inicia sesión para continuar'; ?>
		</h2>			
		<p>
			Inicia sesión en Chatelet con tus credenciales. Ingresá tu email y contraseña para continuar.<br> Si no tienes una cuenta presiona <b>Crear mi cuenta</b>.
		</p>
		<div class="max-22 w-100">
			<div class="is-flex justify-content-center align-items-center gap-1 mb-4">
				<!--img src="/images/v8WrVxzTlKt7ZEEgkSt2shf41.jpg" width="100" /-->
			</div>					
			<?php echo $this->Form->create(false, array(
				'url' => array(
					'controller' => 'users', 
					'action' => 'login'
				)
			)); ?>
			<input type="hidden" name="redirect" value="/"/>                
      <input type="email" id="login-email" class="form-control" name="data[User][email]" placeholder="Email" />
      <input type="password" class="form-control" id="login-password" name="data[User][password]" placeholder="Contraseña" />
      <!--label class="form-group p-1">
      	<input type="checkbox" name="rememberme" />
      	<span class="label-text text-muted"><span class="text-sm text-link">Recordarme en este dispositivo</span></span>
      </label-->
      <input type="submit" id="login" form="" value="Iniciar sesión" /> 
      <div class="modal-buttons">                
        <a href="/shop/registro">Crear mi cuenta</a>
        <a href="/shop/recuperar_acceso">Olvidé la contraseña</a>
      </div>
      <?php echo $this->Form->end(); ?>
		</div>
	</div>
</section>
	
<script type="text/javascript">

/*
$("#login-email").keyup(function () {
        var myemail = $(this).val();
        $(".modal-body #email").val( myemail );
    });

$("#login-password").keyup(function () {
        var mypass = $(this).val();
        $(".modal-body #password").val( mypass );
 });
*/
</script>			
		
	