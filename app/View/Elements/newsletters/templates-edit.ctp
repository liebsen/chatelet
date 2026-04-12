<?php
	echo $this->Html->script('ckeditor/ckeditor.js?v=' . $version['ver'], array('inline' => false));
  echo $this->Html->script('relations.js?v=' . $version['ver'], array('inline' => false));
	echo $this->Html->script('templates-edit.js?v=' . $version['ver'], array('inline' => false));
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
        <h4 class="sub-header"><i class="gi gi-cogwheel is-clickable" onclick="$('#product-filter').focus()"></i> Productos</h4>
        <table class="table table-forum">
    <?php foreach($newsletter_products as $product): ?>
            <tr><td><?php echo $product['Product']['name']?> (<?php echo $product['Product']['article']?>)</td></tr>
    <?php endforeach ?>
        </table>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-box bg-info-outline">
        <h4 class="sub-header">Método de envío</h4>
        <p>Selecciona el canal por donde notificar a las cuentas</p>
        <div class="form-group flex-start gap-05">
          <div class="controls flex-1">
            <label class="control-label" for="toggle-email">Email</label>
            <input type="checkbox" name="data[send_email]" value="1" id="toggle-email" class="toggle-checkbox"<?=@$newsletter['Newsletter']['send_email'] == '1' ? ' checked' : '' ?>>
            <label for="toggle-email" class="toggle-label"></label>
          </div>
          <div class="controls flex-1">
            <label class="control-label" for="toggle-push">Push</label>
            <input type="checkbox" name="data[send_push]" value="1" id="toggle-push" class="toggle-checkbox"<?=@$newsletter['Newsletter']['send_push'] == '1' ? ' checked' : '' ?>>
            <label for="toggle-push" class="toggle-label"></label>
          </div>
        </div>
      </div>      
    </div>
  </div>
  <div class="row">
    <!--div class="col-md-6">
      <div class="control-group">
        <label class="control-label" for="name">Código</label>
        <div class="controls">
          <input type="text" id="name" name="data[name]" class="form-control" placeholder="Código de la plantilla" value="<?=$newsletter['Newsletter']['name']?>" required />
        </div>
        <small class="text-muted">Es el código que verán solo los gestores</small>
      </div>
    </div-->
    <div class="col-md-12">
      <div class="control-group">
        <label class="control-label" for="title">Título</label>
        <div class="controls">
          <input type="text" id="title" name="data[title]" class="form-control" placeholder="Título de la plantilla" value="<?=$newsletter['Newsletter']['title']?>" required />
        </div>
        <small class="text-muted">Es el título que verán las clientas en su dispositivo</small>
      </div>
    </div>
    <div class="col-md-12">
      <div class="control-group">
        <label class="control-label" for="toggle-follow"><?php echo __('Mensaje PUSH'); ?></label>
        <textarea class="form-control w-100" name="data[message]" rows="4"><?=$newsletter['Newsletter']['message']?></textarea>
        <small class="text-muted">Es el texto que verán las clientas en su notificación push</small>
      </div>
    </div>
    <div class="col-md-12">
      <div class="control-group d-block">
        <label class="control-label" for="toggle-follow"><?php echo __('Cuerpo del email'); ?></label>
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
<?php if($settings['newsletter_show_header'] == '1' || $settings['newsletter_show_social'] == '1'):?>
      <h4 class="sub-header">Configuración adicional</h4>
      <p>Establece la configuración adicional de esta Plantilla</p>
<?php if($settings['newsletter_show_header'] == '1'):?>
      <div class="control-group">
        <label class="control-label" for="toggle-follow"><?php echo __('Mostrar logo de encabezado'); ?></label>
        <input type="checkbox" name="data[show_header]" value="1" id="toggle-header" class="toggle-checkbox"<?=@$newsletter['Newsletter']['show_header'] == '1' ? ' checked' : '' ?>>
        <label for="toggle-header" class="toggle-label"></label>
        <small class="text-muted">Indica si debe mostrarse el logo de encabezado en el email</small>
      </div>
<?php endif ?>
<?php if($settings['newsletter_show_social'] == '1'):?>
      <div class="control-group">
        <label class="control-label" for="toggle-follow"><?php echo __('Mostrar redes'); ?></label>
        <input type="checkbox" name="data[show_social]" value="1" id="toggle-follow" class="toggle-checkbox"<?=@$newsletter['Newsletter']['show_social'] == '1' ? ' checked' : '' ?>>
        <label for="toggle-follow" class="toggle-label"></label>
        <small class="text-muted">Indica si debe mostrarse, en caso que hubieran el enlace a las redes sociales al pie del email</small>
      </div>
<?php endif ?>
<?php endif ?>
    </div>
    <div class="col-md-6">
      <div class="form-box bg-success-outline">
      	<h4 class="sub-header">Catálogo</h4>
  <?php if(empty($newsletter['Newsletter']['id'])): ?>
        <p>Podrás agregar productos una vez que guardes la nueva plantilla.</p>
  <?php else: ?>
      	<p>Puedes aregar productos a la plantilla, se mostrarán en un catálogo de lista con sus respectivos enlaces y precios.</p>
  			<div class="control-group">
  				<label class="control-label" for="toggle-price"><?php echo __('Mostrar precio'); ?></label>
  				<input type="checkbox" name="data[show_price]" value="1" id="toggle-price" class="toggle-checkbox"<?=@$newsletter['Newsletter']['show_price'] == '1' ? ' checked' : '' ?>>
  				<label for="toggle-price" class="toggle-label"></label>
  	      <small class="text-muted">Indica si debe mostrarse el precio en el catálogo.</small>
  			</div>
        <div class="control-group">
          <label class="control-label" for="toggle-price"><?php echo __('Mostrar descripción'); ?></label>
          <input type="checkbox" name="data[show_text]" value="1" id="toggle-text" class="toggle-checkbox"<?=@$newsletter['Newsletter']['show_text'] == '1' ? ' checked' : '' ?>>
          <label for="toggle-text" class="toggle-label"></label>
          <small class="text-muted">Indica si debe mostrarse el precio en el catálogo.</small>
        </div>
        <div class="controls d-flex flex-column gap-05">
          <input type="text" class="form-control relation-search" data-type="product" placeholder="Buscar"/>
        </div>
        <div class="secondary-box">
          <!--label class="control-label" for="product-filter">Productos seleccionados (<?=count($newsletter_products)?>)-->
          <a class="relations-action-add text-success d-none" data-type="product" href="javascript:void(0)">Agregar <span class="relations-count"><?=count($newsletter_products)?></span></a>
          <?php if(count($newsletter_products)): ?>
          <a class="relations-action-remove text-danger" data-type="product" href="javascript:void(0)">Eliminar todo</a>
        <?php endif ?><!--/label-->
        </div>
        <div class="controls tags-container product-container">
  <?php foreach($newsletter_products as $product): ?>
      <span 
      	class="label relation-item is-clickable is-enabled" 
      	data-parent-id="<?php echo $newsletter['Newsletter']['id'] ?>" 
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
  </div>
  <div class="form-actions">
    <a href="javascript:history.go(-1)" class="btn btn-info"><i class="fa fa-chevron-left mr-1"></i> Atrás</a>
    <a href="#" class="btn btn-warning btn-templates-preview"><i class="fa fa-eye mr-1"></i> Previsualizar</a>
    <button type="submit" class="btn btn-success track-coords" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
  </div>

<?php echo $this->Form->end(); ?>

  <div class="templates-preview d-none">
    <div class="p-4 bg-white">
      <h3><?=$newsletter['Newsletter']['title']?></h3>
      <p><?=$newsletter['Newsletter']['body']?></p>
    </div>
  </div>
