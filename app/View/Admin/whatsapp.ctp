<?php echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php #echo $this->Html->script('admin-whatsapp.js?v=' . $version['ver'], array('inline' => false)); ?>
<?php echo $this->Html->script('application-form.js?v=' . $version['ver'], array('inline' => false)); ?>
<?php echo $this->element('admin/menu'); ?>
<div class="block-section">
<div class="block-tabs">
	<div class="tab-content">
		<form action="" method="post" class="form-inline" enctype="multipart/form-data">
			<div class="row">
	      <div class="col-md-6">
	        <h4 class="sub-header">Contacto WhatsApp</h4>
					<p>Habilita el contacto directo por WhatsApp en la tienda.</p>
	        <div class="control-group">
						<label class="control-label" for="columns-text"><?php echo __('Habilitar'); ?></label>
						<div class="form-group">
							<input type="checkbox" name="data[whatsapp_enable]" value="1" id="toggle" class="toggle-checkbox toggle-block" data-block=".show-panel" <?=@$settings['whatsapp_enable'] == '1' ? ' checked' : '' ?>>
							<label for="toggle" class="toggle-label"></label>
						</div>
	          <small class="text-muted">Indica si debe mostrarse un mensaje solicitar al cliente a contacto vía chat de WhatsApp.</small>
	        </div>
	      </div>
	      <div class="col-md-6">
	      	<div class="show-panel <?=@$settings['whatsapp_enable'] != '1' ? 'd-disable' : '' ?>">
		      	<h4 class="sub-header">Configuración de Whatsapp</h4>
		      	<p>Configura el mensaje que se mostrará a la clienta</p>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Texto'); ?></label>
		          <div class="controls">
		            <textarea name="data[whatsapp_text]" class="form-control w-100" placeholder="En qué te puedo ayudar?"><?= @$settings['whatsapp_text'] ?></textarea>
		          </div>
		          <small class="text-muted">Indica el texto que invitará a chatear a la clienta</small>
		        </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Autoesconder (segs)'); ?></label>
		          <div class="controls">
		            <input type="number" max="100" min="0" size="4" name="data[whatsapp_autohide]" class="form-control" placeholder="3" value="<?= @$settings['whatsapp_autohide'] ?>"/>
		          </div>
		          <small class="text-muted">Esconder Whatsapp luego de x segundos. Ingresá 0 para mostrar siempre.</small>
		        </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Nro. de teléfono'); ?></label>
		          <div class="controls">
		            <input type="number" min="0" size="16" name="data[whatsapp_phone]" class="form-control" placeholder="+54 1147012233" value="<?= @$settings['whatsapp_phone'] ?>"/>
		          </div>
		          <small class="text-muted">Ingresá el número de teléfono del whatsapp que recibirá los chats.</small>
		        </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Mostrar animación'); ?></label>
							<div class="form-group">
								<input type="checkbox" name="data[whatsapp_animated]" value="1" id="toggle2" class="toggle-checkbox"<?=@$settings['whatsapp_animated'] == '1' ? ' checked' : '' ?>>
								<label for="toggle2" class="toggle-label"></label>
							</div>
		        </div>
					</div>
				</div>
			</div>
	    <br />               
	    <div class="form-actions">
	      <a href="/admin/cupones" class="btn btn-info"><i class="fa fa-chevron-left"></i> <span class="ml-1">Atrás</span></a>
	      <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check"></i> <span class="ml-1">Guardar</span></button>
	    </div>
	  </form>
	</div>
</div>
</div>