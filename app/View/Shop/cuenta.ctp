<?php 
$this->set('short_header', 'Cuenta');
$this->set('short_header_text', '<i class="gi gi-shop mr-1"></i> Volver a la tienda');
$this->set('short_header_link', '/shop');
$this->set('short_header_classname', 'btn_continue_shopping');
echo $this->Session->flash();
?>
<section id="detalle" class="is-flex-center min-h-101">
  <div class="wrapper container-flex d-flex flex-column justify-content-center align-items-center max-30">
		<h3>
			<?php if ($loggedIn) : ?>
				Hola, <?php echo $user['name'] ?? 'invitada'; ?>
			<?php else : ?>
				No estás conectada ahora
			<?php endif ?>
		</h3>
		<h1>
			<i class="fa fa-flash text-<?=$loggedIn ? 'light' : 'warning'?>"></i>
		</h1>
	<?php if ($loggedIn) : ?>
		<p class="text-center">Iniciaste sesión como <?php echo $user['email']; ?>. La última modificación en tu cuenta fue realizada <?=\readable_time_ago($user['modified'])?></p>		
	<?php else : ?>	
		<p>No has iniciado una sesión. ¿Qué deseas hacer?</p>	
	<?php endif ?>
		<div class="max-22 w-100">
			<div class="is-flex-center flex-column gap-05 mb-4 w-100">
			<?php if ($isAdmin):?>
				<a href="/admin" class="btn btn-info dark w-100"><span>Administrador</span></a>
			<?php endif ?>
			<?php if ($loggedIn): ?>
				<a href="/shop/mis_compras" class="btn btn-chatelet dark w-100">Mis compras</a>
				<a href="/shop/registro" class="btn btn-chatelet w-100">Actualizar mi cuenta</a>
				<a href="/users/logout" class="btn btn-chatelet btn-logout light w-100">Cerrar sesión</a>
			<?php else:?>
				<a href="/shop/login" class="btn btn-chatelet dark w-100">Iniciar sesión</a>
				<a href="/shop/registro" class="btn btn-chatelet w-100">Crear mi cuenta</a>
			<?php endif ?>
				<a href="/shop" class="btn btn-chatelet light btn-continue-shopping w-100">Seguir comprando</a>
			</div>
		</div>
	</div>
</section>
<footer>
	<?php echo $this->element('signature') ?>
</footer>

