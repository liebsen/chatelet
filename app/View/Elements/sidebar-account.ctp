<nav class="sidebar sidebar-account d-flex flex-column justify-content-center align-items-start gap-05">
  <button type="button" class="corner-pin btn-close-sidebar">
    <i class="ico-times" role="img" aria-label="Cerrar"></i>
  </button>
  <div class="sidebar-top d-flex flex-column justify-content-center align-items-center gap-05 content">
  <?php if ($loggedIn) : ?>
    <h5 class="text-uppercase text-bolder text-muted">Hola, <?php echo $user['name'] ?? 'Invitada' ?></h5>
  <?php else : ?>
    <h5 class="text-uppercase text-bolder text-muted">Sin sesión activa</h5>
  <?php endif ?>
    <!--div class="content pt-4">    
    <?php if ($loggedIn) : ?>    
      <p>Tu sesión está activa y accediste como <?php echo $user['email'] ?></p>
    <?php else : ?>
      <p>No tenés una sesión activa. ¿Qué deseas hacer?</p>
    <?php endif ?>
    </div-->
  </div>
  <div class="sidebar-bottom">
    <div class="d-flex flex-column justify-content-center align-items-center gap-05 w-100">
    <?php if ($loggedIn) : ?>
      <?php if(empty($user['name']) == false) : ?>
      <a href="/shop/cuenta" class="btn btn-chatelet dark w-100">Mi cuenta</a>
      <?php endif ?>
      <a href="/shop/mis_compras" class="btn btn-chatelet w-100">Mis compras</a>
      <a href="/users/logout" class="btn btn-chatelet light btn-logout w-100">Cerrar sesión</a>
    <?php else : ?>
      <a href="/shop/login" class="btn btn-chatelet dark w-100">Iniciar sesión</a>
      <a href="/shop/registro" class="btn btn-chatelet w-100">Crear cuenta</a>
    <?php endif ?>
    </div>
  </div>
</nav>
