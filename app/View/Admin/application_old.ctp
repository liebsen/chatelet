<?php echo $this->Html->script('ckeditor/ckeditor', array('inline' => false)) ?>
<?php echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php echo $this->Html->script('custom-tabs.js?v=' . $version['ver'], array('inline' => false)); ?>
<?php echo $this->Html->script('jquery.growl.js?v=' . $version['ver'], array('inline' => false)); ?>
<?php echo $this->Html->script('application-form.js?v=' . $version['ver'], array('inline' => false)); ?>
<?php echo $this->Html->script('application-notifications.js?v=' . $version['ver'], array('inline' => false)); ?>
<?php echo $this->Html->css('jquery.growl.css?v=' . $version['ver']) ?>

	<div class="block">
		<div class="block-content">
			<!--form action="" id="form_app" method="post" class="form-inline" enctype="multipart/form-data"-->
			<form action="" id="form_app" method="post" class="form-inline">
		    <div class="custom-tabs block-tabs">
		      <ul class="nav nav-tabs" id="myTab" role="tablist">
<?php foreach($tabs as $id => $tab): ?>
				<li class="text-center<?= $tab['default'] ? ' active' : '' ?>">
				  <a href="#<?= $id ?>"><i class="gi gi-<?= $tab['icon'] ?>"></i> <?= $tab['title'] ?></a>
				</li>
<?php endforeach ?>
		      </ul>
		      <div class="tab-content">
<?php foreach($tabs as $id => $tab): ?>
				<div class="tab-pane pane-<?= $id ?><?= $tab['default'] ? ' active' : '' ?>">
<?php echo $this->element('application/' . $id) ?>
				</div>
<?php endforeach ?>
		     	</div>
			    <br />      
			    <div class="form-actions">
			      <a href="javascript:history.go(-1)" class="btn btn-info"><i class="fa fa-chevron-left"></i> <span class="ml-1">Atrás</span></a>
			      <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check"></i> <span class="ml-1">Guardar</span></button>
			    </div>
			  </div>
			</form>
		</div>
	</div>
