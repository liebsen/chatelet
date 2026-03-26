<?php if(!empty($navs)): ?>
<div class="block">
  <div class="block-content">  
    <div class="block-tabs">
      <ul class="nav nav-tabs">
  <?php foreach ($navs as $key => $nav): ?>        
        <li class="<?= $this->request->here === $nav['url'] || !empty($nav['enabled']) ? 'active' : '' ?>">
          <a href="<?php echo $nav['url']; ?>">
            <i class="<?=$nav['icon']?>"></i> <span class="desktop"><?php echo $key ?></span>
          </a>
        </li>
  <?php endforeach ?>
      </ul>
    </div>
<?php endif ?>