  <nav class="navbar navbar-chatelet short animated">
    <div class="container-fluid pt-1">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <a class="navbar-brand"
         href="<?php echo router::url(array('controller' => 'Home', 'action' => 'index')) ?>" >
            Châtelet</a>
      </div>
      <div class="navbar-right text-center p-4">
        <?php if ($short_header_link) :?>
          <a href="<?php echo $short_header_link ?>"><?php echo $short_header_text ?? 'Carrito' ?></a>
        <?php endif ?>
        <i><?= $short_header ?></i>
      </div>
    </div>
  </nav>

