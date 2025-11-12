  <nav class="navbar navbar-chatelet short animated">
    <div class="container-fluid pt-1">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <a class="navbar-brand"
         href="<?php echo router::url(array('controller' => 'Home', 'action' => 'index')) ?>" >
            Châtelet</a>
      </div>
      <div class="is-flex-center gap-1 navbar-right text-center p-4">
        <?php if ($short_header_link) :?>
          <a href="<?php echo $short_header_link ?>" class="<?php echo $short_header_classname ?? '' ?>" style="position: relative; top: -1px">
            <span class="text-sm"><?php echo $short_header_text ?? 'Seguir comprando' ?></span>
          </a>
        <?php endif ?>
        <i class="text-muted"><?= $short_header ?></i>
      </div>
    </div>
  </nav>

