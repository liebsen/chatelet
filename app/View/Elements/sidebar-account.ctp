<nav class="sidebar sidebar-account">
  <button type="button" class="btn-close btn-close-sidebar">
    <i class="fa fa-times"></i>
  </button>
<?php if ($loggedIn) : ?>
  <h6 class="text-bolder text-uppercase">Hola, <?php echo $user['name'] ?></h6>
<?php else : ?>
  <h6 class="text-bolder text-uppercase">Sin sesión activa</h6>
<?php endif ?>
  <div class="content pt-4">    
  <?php if ($loggedIn) : ?>    
    <p>Tu sesión está activa y accediste como <?php echo $user['email'] ?></p>
  <?php else : ?>
    <p>No tenés una sesión activa. ¿Qué deseas hacer?</p>
  <?php endif ?>
    <div class="max-22 w-100">
      <div class="is-flex-center flex-column gap-05 mb-4 w-100">
      <?php if ($loggedIn) : ?>
        <a href="/shop/mis_compras" class="btn btn-chatelet w-100">Mis compras</a>
        <a href="/users/logout" class="btn btn-chatelet w-100">Cerrar sesión</a>
      <?php else : ?>
        <a href="/shop/login" class="btn btn-chatelet w-100">Iniciar sesión</a>
        <a href="/shop/registro" class="btn btn-chatelet w-100">Crear cuenta</a>
      <?php endif ?>
      </div>
    </div>
  </div>
</nav>
