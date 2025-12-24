<?php
echo $this->element('admin-menu');
echo $this->Html->css('draggable-compose.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
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

<style type="text/css">
	.p-0 {
		padding: 0;
	}
	.border-success {
		outline: 4px solid lightgreen!important;
	}
	.border-danger {
		z-index: 2!important;
		outline: 4px solid red!important;
	}
	.category-item {
		height: 200px;
	}
	.category-image {
		height: 200px;
    transition: all .3s ease-in-out;
	}
	.category-toolbox {
		position: absolute;
		top: 0.5rem;
		right: 1rem;
	}
	.category-item-image {
		position: relative;
		z-index: 1;
		display: block;
		filter: brightness(1.25);
    background-size: cover;
    background-repeat: no-repeat;
    background-position: top center;
    transition: all 0.5s ease-in;
    outline: 4px solid #bbb;
    border: none;
	}
</style>