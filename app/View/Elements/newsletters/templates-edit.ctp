<?php
	echo $this->Html->script('ckeditor/ckeditor.js?v=' . $version['ver'], array('inline' => false));
  echo $this->Html->script('application-form.js?v=' . $version['ver'], array('inline' => false));
  echo $this->Html->script('relations.js?v=' . $version['ver'], array('inline' => false));
	echo $this->Html->script('templates-edit.js?v=' . $version['ver'], array('inline' => false));
?>

<?php echo $this->Form->create(null,
  array(
    'id' => 'form_app',
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
      <div class="form-group flex-end flex-between gap-05">
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
      <div class="form-box bg-info-outline">
        <h4 class="sub-header">Datos del mensaje</h4>
        <p>Compone un mensaje para los mensajes push</p>
        <div class="control-group">
          <label class="control-label" for="title">Título</label>
          <div class="controls">
            <input type="text" id="title" name="data[title]" class="form-control" placeholder="Título de la plantilla" value="<?=$newsletter['Newsletter']['title']?>" required />
          </div>
          <small class="text-muted">Es el título que verán las clientas en su dispositivo</small>
        </div>
        <div class="control-group">
          <label class="control-label" for="toggle-follow"><?php echo __('Texto Push'); ?></label>
          <textarea class="form-control w-100" name="data[message]" rows="4"><?=$newsletter['Newsletter']['message']?></textarea>
          <small class="text-muted">Es el texto que verán las clientas en su notificación push</small>
        </div>
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
      <div class="form-box bg-success-outline">
        <h4 class="sub-header">Catálogo</h4>
  <?php if(empty($newsletter['Newsletter']['id'])): ?>
        <p>Podrás agregar productos una vez que guardes la nueva plantilla.</p>
  <?php else: ?>
        <p>Puedes aregar productos a la plantilla, se mostrarán en un catálogo de lista con sus respectivos enlaces y precios.</p>
        <div class="control-group">
          <label class="control-label" for="toggle-price"><?php echo __('Precio'); ?></label>
          <input type="checkbox" name="data[show_price]" value="1" id="toggle-price" class="toggle-checkbox"<?=@$newsletter['Newsletter']['show_price'] == '1' ? ' checked' : '' ?>>
          <label for="toggle-price" class="toggle-label"></label>
          <small class="text-muted">Indica si debe mostrarse el precio en el catálogo.</small>
        </div>
        <div class="control-group">
          <label class="control-label" for="toggle-price"><?php echo __('Descripción'); ?></label>
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
  <?php endif ?>
      </div>

  <?php if($settings['newsletter_show_header'] == '1' || $settings['newsletter_show_social'] == '1'):?>
      <div class="form-box bg-info-outline">
        <h4 class="sub-header">Configuración extra</h4>
        <p>Establece la configuración adicional de esta Plantilla</p>
        <div class="control-group">
          <label class="control-label" for="toggle-cta"><?php echo __('Llamada a la Acción'); ?></label>
          <input type="checkbox" name="data[show_cta]" value="1" id="toggle-cta" class="toggle-checkbox toggle-block" data-block=".show-cta"<?=@$newsletter['Newsletter']['show_cta'] == '1' ? ' checked' : '' ?>>
          <label for="toggle-cta" class="toggle-label"></label>
          <small class="text-muted">Indica si debe mostrarse el logo de encabezado en el email</small>
        </div>

        <div class="show-cta<?=@$newsletter['Newsletter']['show_cta'] == '1' ? ' ' : ' d-disable' ?>">
          <div class="control-group">
            <label class="control-label" for="cta_text">Texto del botón</label>
            <div class="controls">
              <input type="text" id="cta_text" name="data[cta_text]" class="form-control" placeholder="Título de la plantilla" value="<?=$newsletter['Newsletter']['cta_text']?>" />
            </div>
            <small class="text-muted">Texto que será legible en el botón</small>
          </div>
          <div class="control-group">
            <label class="control-label" for="cta_url">URL de Call to Action</label>
            <div class="controls">
              <input type="text" id="cta_url" name="data[cta_url]" class="form-control" placeholder="Título de la plantilla" value="<?=$newsletter['Newsletter']['cta_url']?>" />
            </div>
            <small class="text-muted">Dirección URL a la que se redirigirá cuando se llame a la acción</small>
          </div>
        </div>
  <?php if($settings['newsletter_show_header'] == '1'):?>
        <div class="control-group">
          <label class="control-label" for="toggle-follow"><?php echo __('Logo de encabezado'); ?></label>
          <input type="checkbox" name="data[show_header]" value="1" id="toggle-header" class="toggle-checkbox"<?=@$newsletter['Newsletter']['show_header'] == '1' ? ' checked' : '' ?>>
          <label for="toggle-header" class="toggle-label"></label>
          <small class="text-muted">Indica si debe mostrarse el logo de encabezado en el email</small>
        </div>
  <?php endif ?>
  <?php if($settings['newsletter_show_social'] == '1'):?>
        <div class="control-group">
          <label class="control-label" for="toggle-follow"><?php echo __('Redes sociales'); ?></label>
          <input type="checkbox" name="data[show_social]" value="1" id="toggle-follow" class="toggle-checkbox"<?=@$newsletter['Newsletter']['show_social'] == '1' ? ' checked' : '' ?>>
          <label for="toggle-follow" class="toggle-label"></label>
          <small class="text-muted">Indica si debe mostrarse, en caso que hubieran el enlace a las redes sociales al pie del email</small>
        </div>
  <?php endif ?>
  <?php endif ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="control-group flex-column d-block">
        <label class="control-label" for="toggle-follow"><?php echo __('Cuerpo del email'); ?></label>
        <textarea class="form-control w-100" name="data[body]" id="newsletter"><?=htmlentities($newsletter['Newsletter']['body'])?></textarea>
        <h6 class="text-theme">Elementos de plantilla</h6>
        <table class="table table-striped">
  <?php foreach($templateVars as $id => $name): ?>
        <tr class="is-clickable append-editor" data-text="{{<?= $id ?>}}">
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
  <div class="form-actions">
    <a href="<?=$this->Html->url(
      array(
        'controller' => 'admin',
        'action' => 'newsletters',
        'templates'
      )
    )?>" class="btn btn-info">
      <i class="fa fa-chevron-left"></i> 
      <span class="ml-1">Atrás</span>
    </a>
    <span class="btn btn-info btn-templates-editor">
      <i class="gi gi-font"></i> 
      <span class="ml-1">Editor</span>
    </span>
<?php if(!empty($newsletter['Newsletter']['id'])):?>
    <a href="<?=$this->Html->url(
        array(
          'controller' => 'newsletter', 
          'action' => 'template',
          $newsletter['Newsletter']['id']
        )
      )?>"
      class="btn btn-warning" target="_blank">
      <i class="fa fa-eye"></i> 
      <span class="ml-1">Previsualizar</span>
    </a>
<?php endif ?>
    <button type="submit" class="btn btn-success track-coords" title="Pulsa aquí para actualizar este formulario">
      <i class="fa fa-check"></i> 
      <span class="ml-1">Guardar</span>
    </button>
  </div>

<?php echo $this->Form->end(); ?>
