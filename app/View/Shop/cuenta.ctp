<?php 
$this->set('short_header', 'Cuenta');
$this->set('short_header_text', '← Volver a la tienda');
$this->set('short_header_link', '/shop');
$this->set('short_header_classname', 'btn_continue_shopping');
echo $this->Session->flash();
?>
<section id="detalle" class="is-flex-center min-h-101">
  <div class="wrapper container d-flex flex-column justify-content-center align-items-center gap-1 animated fadeIn delay">
  	<div class="d-flex justify-content-center align-items-center gap-1">
  		<img src="/images/isologo.png" width="30"/> 
			<h2 class="text-uppercase">
				<?php if ($loggedIn) : ?>
					Hola, <?php echo $user['name']; ?>
				<?php else : ?>
					No estás conectada ahora
				<?php endif ?>
			</h2>
		</div>
	<?php if ($loggedIn) : ?>
		<p>Iniciaste sesión como <?php echo $user['email']; ?></p>		
	<?php else : ?>	
		<p>No has iniciado una sesión. ¿Qué deseas hacer?</p>	
	<?php endif ?>
		<div class="max-22 w-100">
			<div class="is-flex-center flex-column gap-05 mb-4 w-100">
			<?php if ($loggedIn) : ?>
				<a href="/shop/mis_compras" class="btn btn-chatelet dark w-100">Mis compras</a>
				<a href="/shop/registro" class="btn btn-chatelet w-100">Actualizar mi cuenta</a>
				<a href="/users/logout" class="btn btn-chatelet btn-logout light w-100">Cerrar sesión</a>
			<?php else : ?>
				<a href="/shop/login" class="btn btn-chatelet dark w-100">Iniciar sesión</a>
				<a href="/shop/registro" class="btn btn-chatelet w-100">Crear mi cuenta</a>
			<?php endif ?>
				<a href="/shop" class="btn btn-chatelet light btn-continue-shopping w-100">Seguir comprando</a>
			</div>
		</div>
	</div>
</section>
