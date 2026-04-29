<?php if(!empty($navs)): ?>
<div class="block">
  <div class="block-content">  
    <div class="block-tabs">
      <ul class="nav nav-tabs">
  <?php foreach ($navs as $key => $nav): ?>        
        <li class="<?= strpos($this->request->here, $nav['url']) === 0 || !empty($nav['enabled']) ? 'active' : '' ?>">
          <a href="<?php echo $nav['url']; ?>" title="<?php echo $key ?>">
            <i class="<?=$nav['icon']?>"></i> <span class="ml-1"><?php echo $key ?></span>
<?php if(!empty($nav['text'])):?>
<i class="fa fa-question-circle is-clickable" data-text="<?=$nav['text']?>"></i>
<?php endif ?>
          </a>
        </li>
  <?php endforeach ?>
      </ul>
    </div>
<?php endif ?>