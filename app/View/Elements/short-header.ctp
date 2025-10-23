  <nav class="navbar navbar-chatelet">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <a class="navbar-brand"
         href="<?php echo router::url(array('controller' => 'Home', 'action' => 'index')) ?>" >
            Châtelet</a>
      </div>
      <div class="navbar-right text-center p-3">
        <strong><?= $short_header ?></strong>
      </div>
    </div>
  </nav>

