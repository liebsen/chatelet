<?php 
	echo $this->Html->script('admin-delete', array('inline' => false));
	echo $this->Html->script('custom-tabs.js?v=' . $version['ver'], array('inline' => false));
	echo $this->element('admin/menu');
?>
	<div class="block">
		<div class="block-content">
			<form action="" id="form_app" method="post" class="form-inline" enctype="multipart/form-data">
		    <div class="custom-tabs block-tabs">
		      <div class="tab-content">
						<div class="tab-pane pane-<?= $pane ?> active">
<?php echo $this->element('newsletters/' . $viewComponent) ?>
						</div>
		     	</div>
			  </div>
			</form>
		</div>
	</div>
