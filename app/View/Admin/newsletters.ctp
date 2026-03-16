<?php 
	echo $this->Html->script('admin-delete', array('inline' => false));
	echo $this->Html->script('custom-tabs.js?v=' . $version['ver'], array('inline' => false));
	echo $this->element('admin-menu');
?>
	<div class="block">
		<div class="block-content">
			<form action="" id="form_app" method="post" class="form-inline" enctype="multipart/form-data">
		    <div class="custom-tabs block-tabs">
		      <div class="tab-content">
						<div class="tab-pane pane-<?= $component ?> active">
		<?php echo $this->element('newsletters-' . $component) ?>
						</div>
		     	</div>
			    <!--br />
			    <div class="form-actions">
			      <a href="/admin/cupones" class="btn btn-info"><i class="fa fa-chevron-left mr-1"></i> Atrás</a>
			      <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
			    </div-->
			  </div>
			</form>
		</div>
	</div>
