<?php
$this->Html->css('draggable-compose.css?v=' . $version['ver'], array('block' => 'css'));
$this->Html->script('draggable-compose.js?v=' . $version['ver'], array('block' => 'script'));
$this->Html->script('shop-compose.js?v=' . $version['ver'], array('block' => 'script'));
echo $this->element('admin/menu');
?>

<div class="block-section">
	<section id="listShop">
    <?php echo $this->element('shop/composer') ?>
  </section>
</div>

<div class="form-actions">
	<input type="hidden" name="id" value="1">
	<button type="reset" onclick="location.href=location.href" class="btn btn-danger" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="fa fa-close mr-1"></i> Restaurar</button>
	<button type="submit" class="btn btn-success btn-update" title="Pulsa aquí para actualizar este formulario" disabled><i class="fa fa-check mr-1"></i> Guardar</button>
</div>  
