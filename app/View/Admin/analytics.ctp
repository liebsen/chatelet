<?php 
	echo $this->Html->script('custom-tabs.js?v=' . $version['ver'], array('inline' => false));	
?>
	<div class="block">
		<div class="block-content">
	    <div class="block-tabs">
<?php if($viewComponent != 'index'):?>
<?php echo $this->element('admin/menu'); ?>
<?php endif ?>
	      <div class="tab-content<?=$viewComponent == 'index'?' bg-light':''?>">
					<div class="tab-pane pane-<?= $pane ?> active">
<?php echo $this->element('analytics/' . $viewComponent) ?>
					</div>
	     	</div>
		  </div>
		</div>
	</div>
