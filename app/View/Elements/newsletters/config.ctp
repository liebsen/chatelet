<?php // echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php echo $this->Html->script('application-form.js?v=' . $version['ver'], array('inline' => false)); ?>
<?php echo $this->Html->script('newsletter-config.js?v=' . $version['ver'], array('inline' => false)); ?>
		<form action="" method="post" class="form-inline" enctype="multipart/form-data">
		  <input type="hidden" name="x_coord" id="x_coord">
		  <input type="hidden" name="y_coord" id="y_coord">			
			<div class="row">
	      <div class="col-md-6">
	        <h4 class="sub-header">Datos básicos</h4>
					<p>Habilita el procesamiento de Newsletter.</p>
	        <div class="control-group">
						<label class="control-label" for="columns-text"><?php echo __('Habilitar'); ?></label>
						<div class="form-group">
							<input type="checkbox" name="data[newsletter_enabled]" value="1" id="toggle" class="toggle-checkbox"<?=@$settings['newsletter_enabled'] == '1' ? ' checked' : '' ?>>
							<label for="toggle" class="toggle-label"></label>
						</div>
	          <small class="text-muted">Indica si se debe procesar los envíos.</small>
	        </div>
	        <div class="show-panel <?= !$settings['newsletter_enabled'] ? 'show-inactive' : '' ?>">
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Nombre remitente'); ?></label>
		          <div class="controls">
		            <input type="text" name="data[newsletter_name]" class="form-control" placeholder="Chatelet" value="<?= @$settings['newsletter_name'] ?>"/>
		          </div>
		          <small class="text-muted">Ingresá el mailbox del remitente.</small>
		        </div>	        
						<div class="control-group">
							<label class="control-label" for="columns-text"><?php echo __('Seleccione una imagen de logo (256x256)'); ?></label>
							<?php if(!empty($settings['newsletter_logo'])): ?>
								<div class="card">
									<div class="card-body">
										<img src="<?= $settings['upload_url']?>/<?= $settings['newsletter_logo']?>" width="256">
									</div>
								</div>
							<?php endif ?>
							<div class="controls">
								<input type="file" class="form-control" name="data[newsletter_logo]" value="" accept="image/png">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="columns-text"><?php echo __('Seleccione una imagen de badge (92x92)'); ?></label>
							<?php if(!empty($settings['newsletter_badge'])): ?>
								<div class="card">
									<div class="card-body">
										<img src="<?= $settings['upload_url']?>/<?= $settings['newsletter_badge']?>" width="92">
									</div>
								</div>
							<?php endif ?>
							<div class="controls">
								<input type="file" class="form-control" name="data[newsletter_badge]" value="" accept="image/png">
							</div>
						</div>
					</div>
	      </div>
	      <div class="col-md-6">
	      	<div class="show-panel <?= !$settings['newsletter_enabled'] ? 'show-inactive' : '' ?>">
		      	<h4 class="sub-header">Configuración de Newsletter</h4>
		      	<p>Configura qué datos se utilizarán para procesar los envíos</p>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Nombre de usuario'); ?></label>
		          <div class="controls">
		            <input type="text" name="data[newsletter_username]" class="form-control" placeholder="storenews@gmail.com" value="<?= @$settings['newsletter_username'] ?>"/>
		          </div>
		          <small class="text-muted">Ingresá el mailbox de la cuenta que enviará los emails.</small>
		        </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Contraseña'); ?></label>
		          <div class="controls position-relative">
		            <input type="password" name="data[newsletter_password]" id="newsletter_password" class="form-control" placeholder="**********" value="<?= @$settings['newsletter_password'] ?>"/>
		            <i class="form-pass-icon fa fa-eye-slash is-clickable" data-target="#newsletter_password"></i>
		          </div>
		          <small class="text-muted">Ingresá la contraseña de aplicación (Google my account: app password).</small>
		        </div>
		        <!--div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Email remitente'); ?></label>
		          <div class="controls">
		            <input type="text" name="data[newsletter_from]" class="form-control" placeholder="news@domain.com" value="<?= @$settings['newsletter_from'] ?>"/>
		          </div>
		          <small class="text-muted">Ingresá el mailbox del remitente.</small>
		        </div-->

		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Agregar texto a todos los Newsletters'); ?></label>
		          <div class="controls">
		            <textarea name="data[newsletter_text]" class="form-control w-100" rows="4" placeholder="En qué te puedo ayudar?"><?= @$settings['newsletter_text'] ?></textarea>
		          </div>
		          <small class="text-muted">Indica el texto que se enviará con cada Newsletter</small>
		        </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Máximo de envíos'); ?></label>
		          <div class="controls">
		            <input type="number" max="100" min="0" size="4" name="data[newsletter_perminute]" class="form-control" placeholder="3" value="<?= @$settings['newsletter_perminute'] ?? 20 ?>"/>
		          </div>
		          <small class="text-muted">Cantidad de envíos por minuto.</small>
		        </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Mostrar logo del encabezado'); ?></label>
							<div class="form-group">
								<input type="checkbox" name="data[newsletter_show_header]" value="1" id="toggle_header" class="toggle-checkbox"<?=@$settings['newsletter_show_header'] == '1' ? ' checked' : '' ?>>
								<label for="toggle_header" class="toggle-label"></label>
							</div>
		        </div>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Mostrar redes sociales'); ?></label>
							<div class="form-group">
								<input type="checkbox" name="data[newsletter_show_social]" value="1" id="toggle_social" class="toggle-checkbox"<?=@$settings['newsletter_show_social'] == '1' ? ' checked' : '' ?>>
								<label for="toggle_social" class="toggle-label"></label>
							</div>
		        </div>
					</div>
				</div>
			</div>
	    <br />               
	    <div class="form-actions">
	      <a href="/admin/cupones" class="btn btn-info"><i class="fa fa-chevron-left mr-1"></i> Atrás</a>
	      <button type="submit" class="btn btn-success track-coords" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
	    </div>
	  </form>
