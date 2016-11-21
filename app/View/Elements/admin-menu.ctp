<div class="row-fluid">
  <div class="span12">
      <ul class="nav nav-tabs">
        <?php foreach ($navs as $key => $nav): 
          $active = ($nav['active'] == $template['active_sub'])? 'active' : '';
        ?>        
            <li class="<?php echo $active ?>"><a href="<?php echo $nav['url']; ?>"><i class="<?php echo $nav['icon'] ?>"></i> <?php echo $key ?></a></li>
        <?php endforeach ?>
      </ul>
  </div>
</div>