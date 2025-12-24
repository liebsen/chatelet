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
	.text-catalog {
	  text-shadow: 0 0 2px #111,0 0 10px #666;
	  font-size: 1.75rem;
	  font-weight: 300;
	  letter-spacing: -0.03rem;
	  color: white;
	  line-height: 1;
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
		display: flex;
		height: 200px;
    transition: all .3s ease-in-out;
	}
	.ci-0 {
		justify-content: center;
		align-items: center;
	}
	.ci-1 {
		justify-content: start;
		align-items: center;
	}
	.ci-2 {
		justify-content: end;
		align-items: center;
	}
	.ci-3 {
		justify-content: center;
		align-items: start;
	}
	.ci-4 {
		justify-content: center;
		align-items: end;
	}
	.ci-5 {
		justify-content: start;
		align-items: start;
	}
	.ci-6 {
		justify-content: end;
		align-items: start;
	}
	.ci-7 {
		justify-content: start;
		align-items: end;
	}
	.ci-8 {
		justify-content: end;
		align-items: end;
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
    background-size: cover;
    background-repeat: no-repeat;
    background-position: top center;
    transition: all 0.5s ease-in;
    outline: 4px solid #bbb;
    border: none;
	}
</style>