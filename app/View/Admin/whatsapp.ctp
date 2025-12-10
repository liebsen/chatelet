<?php echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php echo $this->Html->script('admin-whatsapp.js?v=' . Configure::read('APP_VERSION'), array('inline' => false)); ?>

<div class="block">
	<div class="block-content">
		<form action="" method="post" class="form-inline" enctype="multipart/form-data">
			<div class="row">
	      <div class="col-md-6">
	        <h4 class="sub-header">Vía de contacto</h4>
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Habilitar Whatsapp como vía de contacto'); ?></label>
	          <div class="controls text-center switch-scale">
	            <?php
	              $enabled = $data['whatsapp_enabled'] == 1 ? 'checked' : '';
	              $disabled = $data['whatsapp_enabled'] == 0 ? 'checked' : '';
	            ?>
	            <span>
	            	<input type="radio" class="form-control" id="enabled_1" name="data[whatsapp_enabled]" value="1" <?php echo $enabled; ?> /> 
	            	<label for="enabled_1">Sí</label>
	          	</span>
	          	<span>
	            	<input type="radio" class="form-control" id="enabled_0" name="data[whatsapp_enabled]" value="0" <?php echo $disabled; ?> />
	            	<label for="enabled_0">No</label>
	          	</span>
	          </div>
	          <span class="text-muted">Indica si debe mostrarse un mensaje solicitar al cliente a contacto vía chat de WhatsApp.</span>
	        </div>

	      </div>
	      <div class="col-md-6">
	      	<div class="show-panel <?= !$data['whatsapp_enabled'] ? 'show-inactive' : '' ?>">
		      	<h4 class="sub-header">Datos de asistente por Whatsapp</h4>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Texto para chatear en whatsapp.'); ?></label>
		          <div class="controls">
		            <textarea name="data[whatsapp_text]" class="form-control w-100"><?= @$data['whatsapp_text'] ?></textarea>
		          </div>
		        </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Autoesconder (segs)'); ?></label>
		          <div class="controls">
		            <input type="number" max="100" min="0" size="4" name="data[whatsapp_autohide]" class="form-control" value="<?= @$data['whatsapp_autohide'] ?>"/>
		          </div>
		          <span class="text-muted">Esconder Whatsapp luego de x segundos. Ingresá 0 para mostrar siempre.</span>
		        </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Nro. de teléfono Whatsapp'); ?></label>
		          <div class="controls">
		            <input type="number" min="0" size="16" name="data[whatsapp_phone]" class="form-control" value="<?= @$data['whatsapp_phone'] ?>"/>
		          </div>
		          <span class="text-muted">Ingresá el número de teléfono del whatsapp que recibirá los chats.</span>
		        </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Mostrar animación'); ?></label>
		          <div class="controls text-center switch-scale">
		            <?php
		              $enabled = $data['whatsapp_animated'] == 1 ? 'checked' : '';
		              $disabled = $data['whatsapp_animated'] == 0 ? 'checked' : '';
		            ?>
		            <span>
			            <input type="radio" class="form-control" id="enabled_1" name="data[whatsapp_animated]" value="1" <?php echo $enabled; ?> />
			            <label for="enabled_1">Sí</label>
			          </span>
			          <span>
			            <input type="radio" class="form-control" id="enabled_0" name="data[whatsapp_animated]" value="0" <?php echo $disabled; ?> />
			            <label for="enabled_0">No</label>
			           </span>
		          </div>
		        </div>

		      	<!--div class="row">
							<div class="col-xs-4">
								<div class="control-group">
									<label class="control-label" for="columns-text"><?php echo __('Seleccione una imagen'); ?></label>
									<div class="controls">
										<input type="file" name="data[whats]" value="" accept="image/*">
									</div>
								</div>
								<br />
								<div class="control-group">						
									<div class="controls">
										<button class="btn btn-primary" type="submit">Agregar Imagen</button>
									</div>
								</div>
							</div>
							<div class="col-xs-8">
								<ul class="list-unstyled">
									<?php foreach ($items as $key => $item): ?>
									<li>
										<br />
										<img src="<?php echo $settings['upload_url'] . $item['Promo']['image'] ?>" width="200">
										<button class="btn btn-danger" onclick="window.location.href='<?php echo $this->Html->url(array('action'=>'remove_whatsapp',$item['Promo']['id'])) ?>'">x</button>
										<br />
									</li>
									<?php endforeach ?>
								</ul>
							</div>
						</div-->
					</div>
				</div>
			</div>
	    <br />               
	    <div class="form-actions">
	      <a href="/admin/cupones" class="btn btn-info"><i class="icon-repeat"></i> Atrás</a>
	      <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="icon-ok"></i> Guardar</button>
	    </div>
	  </form>
	</div>
</div>