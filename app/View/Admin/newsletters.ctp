<?php 
	echo $this->Html->script('admin-delete', array('inline' => false));
	echo $this->Html->script('custom-tabs.js?v=' . $version['ver'], array('inline' => false));
	echo $this->element('admin/menu');
?>
	<div class="block">
		<div class="block-content">
	    <div class="custom-tabs block-tabs">
	      <div class="tab-content">
					<div class="tab-pane pane-<?= $pane ?> active">
<?php echo $this->element('newsletters/' . $viewComponent) ?>
					</div>
	     	</div>
		  </div>
		</div>
	</div>
