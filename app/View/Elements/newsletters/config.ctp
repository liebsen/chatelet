<?php #echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php echo $this->Html->script('application-form.js?v=' . $version['ver'], array('inline' => false)); ?>
<?php #echo $this->Html->script('newsletter-config.js?v=' . $version['ver'], array('inline' => false)); ?>
	<form action="" method="post" id="form_app" class="form-inline">
	  <input type="hidden" name="x_coord" id="x_coord">
	  <input type="hidden" name="y_coord" id="y_coord">			
		<div class="row">
      <div class="col-md-6">
        <h4 class="sub-header">Datos básicos</h4>
				<p>Establece características generales de Newsletter.</p>
        <div class="control-group">
					<label class="control-label" for="columns-text"><?php echo __('Activar tarea programada'); ?></label>
					<div class="form-group">
						<input type="checkbox" name="data[newsletter_enabled]" value="1" id="toggle" class="toggle-checkbox toggle-block" data-block=".show-panel"<?=@$settings['newsletter_enabled'] == '1' ? ' checked' : '' ?>>
						<label for="toggle" class="toggle-label"></label>
					</div>
          <small class="text-muted">Indica si se debe procesar las campañas. Cuando se activen se correrá la tarea una vez por minuto.</small>
        </div>
        <div class="show-panel <?= !$settings['newsletter_enabled'] ? 'd-disable' : '' ?>">
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Nombre remitente'); ?></label>
	          <div class="controls">
	            <input type="text" name="data[newsletter_name]" class="form-control" placeholder="Chatelet" value="<?= @$settings['newsletter_name'] ?>"/>
	          </div>
	        </div>
	        <div class="form-box bg-info-outline">
		      	<h4 class="sub-header">Notificaciones push</h4>
		      	<p>Establece ícono y badge para notificaciones push.</p>	        	
						<div class="control-group">
							<label class="control-label" for="columns-text"><?php echo __('Seleccione una imagen de logo (PNG, 256x256px recomendado)'); ?></label>
							<?php if(!empty($settings['newsletter_icon'])): ?>
								<div class="card">
									<div class="card-body">
										<img id="newsletter_icon" src="<?= $settings['upload_url']?>/<?= $settings['newsletter_icon']?>">
									</div>
								</div>
							<?php endif ?>
							<div class="controls">
								<input type="file" class="form-control" name="data[newsletter_icon]" value="" accept="image/png">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="columns-text"><?php echo __('Seleccione una imagen de badge (PNG transparente, 96x96px recomendado)'); ?></label>
							<?php if(!empty($settings['newsletter_badge'])): ?>
								<div class="card">
									<div class="card-body">
										<img id="newsletter_badge" src="<?= $settings['upload_url']?>/<?= $settings['newsletter_badge']?>">
									</div>
								</div>
							<?php endif ?>
							<div class="controls">
								<input type="file" class="form-control" name="data[newsletter_badge]" value="" accept="image/png">
							</div>
						</div>
					</div>
					<div class="form-box bg-success-outline">
		      	<h4 class="sub-header">Configuración extra</h4>
		      	<p>Establece las características generales de todos las campañas.</p>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Logo del encabezado'); ?></label>
							<div class="form-group">
								<input type="checkbox" name="data[newsletter_show_header]" value="1" id="toggle_header" class="toggle-checkbox"<?=@$settings['newsletter_show_header'] == '1' ? ' checked' : '' ?>>
								<label for="toggle_header" class="toggle-label"></label>
							</div>
		        </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Redes sociales'); ?></label>
							<div class="form-group">
								<input type="checkbox" name="data[newsletter_show_social]" value="1" id="toggle_social" class="toggle-checkbox"<?=@$settings['newsletter_show_social'] == '1' ? ' checked' : '' ?>>
								<label for="toggle_social" class="toggle-label"></label>
							</div>
		        </div>
		        <div class="control-group">
			        <div class="control-group">
								<label class="control-label" for="toggle-text"><?php echo __('Activar aviso general'); ?></label>
								<div class="form-group">
									<input type="checkbox" name="data[newsletter_text_enable]" value="1" id="toggle-text" class="toggle-checkbox toggle-block" data-block=".newslettertext"<?=@$settings['newsletter_text_enable'] == '1' ? ' checked' : '' ?>>
									<label for="toggle-text" class="toggle-label"></label>
								</div>
			        </div>
		          <div class="controls newslettertext<?=@$settings['newsletter_text_enable'] == '1' ? '' : ' d-disable'?>">
		          	<label class="control-label" for="toggle-text"><?php echo __('Aviso general'); ?></label>
		            <textarea name="data[newsletter_text]" class="form-control w-100" rows="4" placeholder="En qué te puedo ayudar?"><?= @$settings['newsletter_text'] ?></textarea>
		          </div>
		          <small class="text-muted">Indica el texto que se enviará al pie con cada Newsletter. Puede ser un aviso legal o cualquier cosa que se te ocurra. Asegurate de activarlo para que se envíe correctamente.</small>
		        </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Campañas por hora'); ?></label>
		          <div class="controls">
		            <input type="number" max="100" min="0" name="data[newsletter_perminute]" class="form-control" placeholder="20" value="<?= @$settings['newsletter_perminute'] ?? 20 ?>"/>
		          </div>
		          <small class="text-muted">Cantidad máxima de campañas por minuto.</small>
		        </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Campañas por día'); ?></label>
		          <div class="controls">
		            <input type="number" max="5000" min="0" name="data[newsletter_perday]" class="form-control" placeholder="500" value="<?= @$settings['newsletter_perday'] ?? 500 ?>"/>
		          </div>
		          <small class="text-muted">Cantidad máxima de campañas por día.</small>
		        </div>
		      </div>
				</div>
      </div>
      <div class="col-md-6">
      	<div class="show-panel <?= !$settings['newsletter_enabled'] ? 'd-disable' : '' ?>">
	      	<div class="form-box bg-info-outline">
		      	<h4 class="sub-header">Datos del transport</h4>
		      	<p>Configura como se enviarán los emails desde Tarea programada Campañas.</p>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Username'); ?></label>
		          <div class="controls">
		            <input type="text" name="data[newsletter_username]" class="form-control" placeholder="storenews@gmail.com" value="<?= @$settings['newsletter_username'] ?>"/>
		          </div>
		        </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Password'); ?></label>
		          <div class="controls position-relative">
		            <input type="password" name="data[newsletter_password]" id="newsletter_password" class="form-control" placeholder="**********" value="<?= @$settings['newsletter_password'] ?>"/>
		            <i class="form-pass-icon fa fa-eye-slash is-clickable" data-target="#newsletter_password"></i>
		          </div>
		        </div>			      	
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Transport'); ?></label>
	      	    <div class="controls">
                <select class="form-control" name="data[newsletter_transport]">
                	<option value="">Seleccione un transport</option>
                  <option value="Smtp"<?=$settings['newsletter_transport'] == 'Smtp' ? ' selected' : ''?>>SMTP</option>
                  <option value="Mail"<?=$settings['newsletter_transport'] == 'Mail' ? ' selected' : ''?>>Mail</option>
                  <option value="Debug"<?=$settings['newsletter_transport'] == 'Debug' ? ' selected' : ''?>>Debug</option>
                </select>
              </div>
            </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Host'); ?></label>
		          <div class="controls position-relative">
		            <input type="text" name="data[newsletter_host]" class="form-control" placeholder="smtp.google.com" value="<?= @$settings['newsletter_host'] ?>"/>
		          </div>
		        </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Port'); ?></label>
		          <div class="controls position-relative">
		            <input type="number" name="data[newsletter_port]" class="form-control" placeholder="587" value="<?= @$settings['newsletter_port'] ?>"/>
		          </div>
		        </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Timeout'); ?></label>
		          <div class="controls position-relative">
		            <input type="number" name="data[newsletter_timeout]" class="form-control" placeholder="30" value="<?= @$settings['newsletter_timeout'] ?>"/>
		          </div>
		        </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Charset'); ?></label>
	      	    <div class="controls">
                <select class="form-control" name="data[newsletter_charset]">
                	<option value="">Seleccione un charset</option>
                  <option value="utf-8"<?=$settings['newsletter_charset'] == 'utf-8' ? ' selected' : ''?>>utf-8</option>
                  <option value="iso-8859-1"<?=$settings['newsletter_charset'] == 'iso-8859-1' ? ' selected' : ''?>>iso-8859-1</option>
                  <option value="us-ascii"<?=$settings['newsletter_charset'] == 'us-ascii' ? ' selected' : ''?>>us-ascii</option>
                </select>
              </div>
            </div>
		        <div class="control-group">
							<label class="control-label" for="columns-text"><?php echo __('Tls'); ?></label>
							<div class="form-group">
								<input type="checkbox" name="data[newsletter_tls]" value="1" id="toggle-tls" class="toggle-checkbox"<?=@$settings['newsletter_tls'] == '1' ? ' checked' : '' ?>>
								<label for="toggle-tls" class="toggle-label"></label>
							</div>
		        </div>

		      </div>
				</div>
			</div>
		</div>
    <br />               
    <div class="form-actions">
      <a href="/admin/cupones" class="btn btn-info"><i class="fa fa-chevron-left"></i> <span class="ml-1">Atrás</span></a>
      <button type="submit" class="btn btn-success track-coords" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check"></i> <span class="ml-1">Guardar</span></button>
    </div>
  </form>
