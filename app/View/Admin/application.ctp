<?php 
	echo $this->Html->script('custom-tabs.js?v=' . $version['ver'], array('inline' => false));	
	echo $this->Html->script('application-form.js?v=' . $version['ver'], array('inline' => false));	
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
	      <div class="tab-content<?=$viewComponent == 'index' ? ' bg-transparent' : ''?>">
					<div class="tab-pane pane-<?= $pane ?> active">
<?php echo $this->element('application/' . $viewComponent) ?>
					</div>
	     	</div>
		  </div>		  
		</div>
    <div class="form-actions">
      <a href="javascript:history.go(-1)" class="btn btn-info"><i class="fa fa-chevron-left"></i> <span class="ml-1">Atrás</span></a>
      <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check"></i> <span class="ml-1">Guardar</span></button>
    </div>
	</div>
<?php echo $this->Form->end(); ?>
