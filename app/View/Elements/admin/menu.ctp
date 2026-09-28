<?php if(!empty($navs)): ?>
<div class="block">
  <div class="block-content">  
    <div class="block-tabs">
      <ul class="list-group list-group-hero animation-fadeIn animation-both delay">
  			<!--a href="/admin/<?=$this->request->params['action']?>">
			  	<li class="list-group-item text-center">
            <i class="fa fa-home rounded-icon"></i> <span class="ml-2 text-capitalize"><?=$this->request->params['action']?></span>
        	</li>
        </a-->
  <?php foreach ($navs as $key => $nav): ?>
  			<a href="<?php echo $nav['url']; ?>" title="<?php echo $key ?>">
			  	<li class="list-group-item text-center <?= strpos($this->request->here, $nav['url']) === 0 || !empty($nav['enabled']) ? 'active' : '' ?>">
            <i class="<?=$nav['icon']?> rounded-icon"></i> <span class="ml-2"><?=$key?></span>
        	</li>
        </a>
  <?php endforeach ?>
      </ul>
    </div>
<?php endif ?>