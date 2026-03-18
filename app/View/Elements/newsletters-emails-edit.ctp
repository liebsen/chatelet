<?php
	echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
	echo $this->Html->script('newsletters-emails-edit.js?v=' . $version['ver'], array('inline' => false));
?>

<?php echo $this->Form->create(null, array(
  'url' => array(
      'controller' => 'admin',
      'action' => 'newsletters'
  ),
  'class' => 'w-100',
  'id' => 'newsletter_edit',
)); ?>
  <input type="hidden" name="redirect" value="/admin/newsletters"/>
  <input type="hidden" name="id" value="<?= $newsletter['Newsletter']['id'] ?? 0 ?>"/>
	<div class="row">
    <div class="col-md-12">
      <h4 class="sub-header"><?=$newsletter['Newsletter']['title'] ?? 'Crea un nueva plantilla'?></h4>
      <p><?=$newsletter['Newsletter']['title'] ? 'Modifica' : 'Crea'?> tu plantilla. Puedes asociarle productos si lo deseas.</p>
      <div class="control-group">
        <label class="control-label" for="title">Título</label>
        <div class="controls">
          <input type="text" id="title" name="data[title]" class="form-control" placeholder="Título de la plantilla" value="<?=$newsletter['Newsletter']['title']?>" required />
        </div>
        <small class="text-muted">Es el título que verán las clientas en su dispositivo</small>
      </div>
      <div class="control-group d-block">
        <textarea class="form-control w-100" name="body" id="newsletter" rows="8"><?=$newsletter['Newsletter']['body']?></textarea>
        <h6 class="text-theme">Tabla de variables disponibles</h6>
        <table class="table table-striped">
<?php foreach($templateVars as $id => $name): ?>
        <tr class="is-clickable btn-append-editor" data-text="{{<?= $id ?>}}">
          <th>
            <small class="text-lowercase">
              <i class="fa fa-key text-warning"></i> <?= $id ?>
            </small>
          </th>
          <td>
            <small>
              <i class="gi gi-chat text-muted"></i> <?= $name ?>
            </small>
          </td>
        </tr>
<?php endforeach ?>
        </table>
      </div>      
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
    	<h4 class="sub-header">Datos principales</h4>
    	<p>Datos con los que identificarás esta plantilla.</p>
      <div class="control-group">
        <label class="control-label" for="name">Código</label>
        <div class="controls">
          <input type="text" id="name" name="data[name]" class="form-control" placeholder="Código de la plantilla" value="<?=$newsletter['Newsletter']['name']?>" required />
        </div>
        <small class="text-muted">Es el código que verán solo los gestores para gestionar el envío</small>
      </div>
    </div>
    <div class="col-md-6">
    	<h4 class="sub-header">Agrega productos</h4>
    	<p>Puedes aregar productos a la plantilla, se mostrarán en un catálogo de lista con sus respectivos enlaces y precios.</p>
			<div class="control-group">
				<label class="control-label" for="toggle"><?php echo __('Mostrar precio'); ?></label>
				<input type="checkbox" name="data[show_prices]" value="1" id="toggle" class="toggle-checkbox">
				<label for="toggle" class="toggle-label"></label>
	      <small class="text-muted">Indica si debe mostrarse el precio en el catálogo.</small>
			</div>
      <div class="control-group w-100">
        <label class="control-label" for="products-filter">Productos</label>
        <div class="controls">
          <input type="text" id="products-filter" class="form-control" placeholder="Buscar"/>
        </div>
        <div class="controls tags-container products-container">
<?php foreach($newsletter_products as $product): ?>
    <span 
    	class="label product-item is-clickable is-enabled" 
    	data-rel_id="<?php echo $newsletter['Newsletter']['id'] ?>" 
      data-id="<?=$product['Product']['id']?>"
      data-type="product"
      data-source="newsletter"
      data-model="NewsletterProduct"><?php echo $product['Product']['name']?>
    </span>
<?php endforeach ?>
        </div>
      </div>		
    </div>
  </div>
  <div class="form-actions">
    <a href="/admin/newsletters" class="btn btn-info"><i class="fa fa-chevron-left mr-1"></i> Atrás</a>
    <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
  </div>

<?php echo $this->Form->end(); ?>