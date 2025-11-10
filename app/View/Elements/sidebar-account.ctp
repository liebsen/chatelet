<nav class="sidebar sidebar-account">
  <button type="button" class="corner-pin btn-close-sidebar">
    <i class="ico-times" role="img" aria-label="Cerrar"></i>
  </button>
  <div class="sidebar-top">
  <?php if ($loggedIn) : ?>
    <h5 class="text-bolder text-uppercase">Hola, <?php echo $user['name'] ?></h5>
  <?php else : ?>
    <h5 class="text-bolder text-uppercase">Sin sesión activa</h5>
  <?php endif ?>
    <div class="content pt-4">    
    <?php if ($loggedIn) : ?>    
      <p>Tu sesión está activa y accediste como <?php echo $user['email'] ?></p>
    <?php else : ?>
      <p>No tenés una sesión activa. ¿Qué deseas hacer?</p>
    <?php endif ?>
    </div>
  </div>
  <div class="sidebar-bottom">
    <div class="d-flex flex-column justify-content-center align-items-center gap-05 w-100">
    <?php if ($loggedIn) : ?>
      <a href="/shop/cuenta" class="btn btn-chatelet w-100">Mi cuenta</a>
      <a href="/shop/mis_compras" class="btn btn-chatelet w-100">Mis compras</a>
      <a href="/users/logout" class="btn w-100">Cerrar sesión</a>
    <?php else : ?>
      <a href="/shop/login" class="btn btn-chatelet w-100">Iniciar sesión</a>
      <a href="/shop/registro" class="btn btn-chatelet w-100">Crear cuenta</a>
    <?php endif ?>
    </div>
  </div>
</nav>
