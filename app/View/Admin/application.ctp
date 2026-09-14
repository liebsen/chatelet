<?php 
	$this->Html->script('custom-tabs.js?v=' . $version['ver'], array('block' => 'script'));	
	$this->Html->script('form_app.js?v=' . $version['ver'], array('block' => 'script'));	
	echo $this->Form->create(null, array(
  'class' => 'w-100',
  'id' => 'form_app',
));
?>
	<div class="block">
		<div class="block-content">
	    <div class="block-tabs">
<?php if($viewComponent != 'index'):?>
<?php echo $this->element('admin/menu'); ?>
<?php endif ?>
	      <div class="tab-content p-0 <?=$viewComponent == 'index' ? ' bg-ocean' : ''?>">
					<div class="tab-pane pane-<?= $pane ?> active">
<?php echo $this->element('application/' . $viewComponent) ?>
					</div>
	     	</div>
		  </div>		  
		</div>
	</div>
<?php echo $this->Form->end(); ?>
