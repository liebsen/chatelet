<?php
	echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
	echo $this->Html->script('newsletters-emails-edit.js?v=' . $version['ver'], array('inline' => false));
?>

<?php echo $this->Form->create(null,
  array(
    'id' => 'newsletter_edit',
    'class' => 'w-100',
  )
); ?>
  <input type="hidden" name="x_coord" id="x_coord">
  <input type="hidden" name="y_coord" id="y_coord">
  <input type="hidden" name="redirect" value="/admin/newsletters"/>
  <input type="hidden" name="data[id]" value="<?= $newsletter['Newsletter']['id'] ?? 0 ?>"/>
	<div class="row">
    <div class="col-md-6">
      <h4 class="sub-header"><?=$newsletter['Newsletter']['title'] ?? 'Crea un nueva plantilla'?></h4>
      <p><?=$newsletter['Newsletter']['title'] ? 'Modifica' : 'Crea'?> tu plantilla. Puedes asociarle productos si lo deseas.</p>
      <div class="form-group flex-between gap-05">
        <div class="controls flex-1">
          <label class="control-label" for="toggle">Activo</label>
          <input type="checkbox" name="data[enabled]" value="1" id="toggle" class="toggle-checkbox"<?=@$newsletter['Newsletter']['enabled'] == '1' ? ' checked' : '' ?>>
          <label for="toggle" class="toggle-label"></label>
        </div>      
<?php if(!empty($newsletter_products)): ?>
        <a href="javascript:void(0)" onclick="$('.table-products').toggle()"><span class="badge badge-<?=  count($newsletter_products) ? 'success' : 'danger' ?> is-rounded is-large"><?php echo count($newsletter_products) ?></span></a>
<?php endif ?>
      </div>
      <div class="table-products bg-success d-none">
        <h6>Productos</h6>
        <table class="table table-forum">
    <?php foreach($newsletter_products as $product): ?>
            <tr><td><?php echo $product['Product']['name']?> (<?php echo $product['Product']['article']?>)</td></tr>
    <?php endforeach ?>
        </table>
      </div>
    </div>
    <div class="col-md-6">
      <h4 class="sub-header">Datos internos</h4>
      <p>Datos con los que identificarás esta plantilla.</p>
      <div class="control-group">
        <label class="control-label" for="name">Código</label>
        <div class="controls">
          <input type="text" id="name" name="data[name]" class="form-control" placeholder="Código de la plantilla" value="<?=$newsletter['Newsletter']['name']?>" required />
        </div>
        <small class="text-muted">Es el código que verán solo los gestores para gestionar el envío</small>
      </div>      
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="control-group">
        <label class="control-label" for="title">Título</label>
        <div class="controls">
          <input type="text" id="title" name="data[title]" class="form-control" placeholder="Título de la plantilla" value="<?=$newsletter['Newsletter']['title']?>" required />
        </div>
        <small class="text-muted">Es el título que verán las clientas en su dispositivo</small>
      </div>
      <div class="control-group d-block">
        <textarea class="form-control w-100" name="data[body]" id="newsletter" rows="8"><?=htmlentities($newsletter['Newsletter']['body'])?></textarea>
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
      <h4 class="sub-header">Configuración adicional</h4>
      <p>Establece la configuración adicional de esta Plantilla</p>
      <div class="control-group">
        <label class="control-label" for="toggle-follow"><?php echo __('Mostrar redes'); ?></label>
        <input type="checkbox" name="data[show_follow]" value="1" id="toggle-follow" class="toggle-checkbox"<?=@$newsletter['Newsletter']['show_follow'] == '1' ? ' checked' : '' ?>>
        <label for="toggle-follow" class="toggle-label"></label>
        <small class="text-muted">Indica si debe mostrarse, en caso que hubieran el enlace a las redes sociales al pie del email</small>
      </div>
    </div>
    <div class="col-md-6">
    	<h4 class="sub-header">Agrega productos</h4>
<?php if(empty($newsletter['Newsletter']['id'])): ?>
      <p>Podrás agregar productos una vez que guardes la nueva plantilla.</p>
<?php else: ?>
    	<p>Puedes aregar productos a la plantilla, se mostrarán en un catálogo de lista con sus respectivos enlaces y precios.</p>
			<div class="control-group">
				<label class="control-label" for="toggle-price"><?php echo __('Mostrar precio'); ?></label>
				<input type="checkbox" name="data[show_prices]" value="1" id="toggle-price" class="toggle-checkbox"<?=@$newsletter['Newsletter']['show_prices'] == '1' ? ' checked' : '' ?>>
				<label for="toggle-price" class="toggle-label"></label>
	      <small class="text-muted">Indica si debe mostrarse el precio en el catálogo.</small>
			</div>
      <div class="control-group w-100">
        <label class="control-label" for="product-filter">Productos</label>
        <div class="controls">
          <input type="text" id="product-filter" class="form-control" placeholder="Buscar"/>
        </div>
        <div class="controls tags-container product-container">
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
<?php endif ?>
    </div>
  </div>
  <div class="form-actions">
    <a href="/admin/newsletters" class="btn btn-info"><i class="fa fa-chevron-left mr-1"></i> Atrás</a>
    <button type="submit" class="btn btn-success track-coords" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
  </div>

<?php echo $this->Form->end(); ?>