<?php
	echo $this->Session->flash();
?>
<section id="detalle">
  <div class="wrapper d-flex flex-column justify-content-center align-items-center gap-1">
		<div class="header">
			<h3 class="modal-title" id="modal-title">
				<?php if($loggedIn): ?>
					Hola, <?php echo $user['name']; ?>	
				<?php else: ?>
					Inicia sesión o crea una cuenta
				<?php endif ?>
			</h3>			
		</div>
		<div class="max-22">
			<div class="is-flex justify-content-center align-items-center gap-1 mb-4">
			<?php if($loggedIn): ?>
				<p>Iniciaste sesión como <?php echo $user['email']; ?></p>
				<a href="/shop/mis_compras" class="btn btn-chatelet">Mis compras</a>
				<a href="/users/logout" class="btn btn-chatelet">Cerrar sesión</a>
			<?php else: ?>
				<p>Inicia sesión o crea una cuenta. ¿Qué deseas hacer?</p>
			<?php endif ?>
			</div>
		</div>
	</div>
</section>
