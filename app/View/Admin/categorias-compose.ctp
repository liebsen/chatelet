<?php
echo $this->element('admin-menu');
echo $this->Html->css('draggable-compose.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->css('shop-compose.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->script('draggable-compose.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->script('shop-compose.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
?>

<div class="block-section">
	<section id="listShop">
    <?php echo $this->element('shop_list_compose') ?>
  </section>
</div>

<div class="form-actions">
	<input type="hidden" name="id" value="1">
	<button type="reset" class="btn btn-danger" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="fa fa-close mr-1"></i> Restaurar</button>
	<button type="submit" class="btn btn-success btn-update" title="Pulsa aquí para actualizar este formulario" disabled><i class="fa fa-check mr-1"></i> Guardar</button>
</div>  
