<?php if(!empty($navs)): ?>
<div class="block">
  <div class="block-content">  
    <div class="block-tabs">
      <ul class="nav nav-tabs">
  <?php foreach ($navs as $key => $nav): ?>        
        <li class="<?= strpos($this->request->here, $nav['url']) === 0 || !empty($nav['enabled']) ? 'active' : '' ?>">
          <a href="<?php echo $nav['url']; ?>" title="<?php echo $key ?>">
            <i class="<?=$nav['icon']?>"></i> <span><?php echo $key ?></span>
          </a>
        </li>
  <?php endforeach ?>
      </ul>
    </div>
<?php endif ?>