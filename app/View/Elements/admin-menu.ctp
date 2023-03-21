<div class="row-fluid">
  <div class="span12">
      <ul class="nav nav-tabs">
        <?php foreach ($navs as $key => $nav): ?>        
            <li class="<?= $_SERVER['REQUEST_URI'] === $nav['active'] ? 'active' : '' ?>"><a href="<?php echo $nav['url']; ?>"> <?php echo $key ?></a></li>
        <?php endforeach ?>
      </ul>
  </div>
</div>