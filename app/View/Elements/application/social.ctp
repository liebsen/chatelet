	<div class="row">
		<div class="col-md-6">
	    <h4 class="sub-header">Presencia en redes sociales</h4>
	    <p>Incluye la URL entera correspondiente a cada red social</p>
	  <?php foreach(\get_socials() as $item): ?>
	    <div class="control-group">
	      <label class="control-label d-flex justify-content-start align-items-center gap-05" for="<?php echo $item ?>_on">
	      	<i class="fa fa-lg fa-<?php echo $item ?>"></i>
	      	<?php echo __(ucfirst($item)); ?>
	      </label>
	      <div class="d-flex flex-center gap-05 w-100">
					<div class="controls flex-1 mt-1">
						<input type="checkbox" id="toggle_<?php echo $item ?>" name="data[<?php echo $item ?>_on]" value="1" id="toggle" class="toggle-checkbox"<?= $settings[$item.'_on'] == '1' ? ' checked' : '' ?>>
						<label for="toggle_<?php echo $item ?>" class="toggle-label"></label>
					</div>
	        <div class="controls">
	          <input type="text" maxlength="100" name="data[<?php echo $item ?>_url]" class="form-control" value="<?php echo @$settings[$item.'_url'] ?>" placeholder="Ingresá la URL de tu perfil de <?php echo __($item); ?>"/>
	        </div>
				</div>
	    </div>
	  	<br>
	  <?php endforeach ?>
		</div>
		<div class="col-md-6">
	    <h4 class="sub-header">Compartir contenido</h4>
	    <p>Estos datos se visualizarán al momento de compartir la aplicación con el estandar opengraph de huella de sitios web y aplicaciones. Este estandar es utilizado por la mayoría de los sistemas de mensajería instantánea.</p>
	    <div class="control-group">
	      <label class="control-label" for="columns-text"><?php echo __('Presentación de card Opengraph'); ?></label>
	      <div class="controls text-center switch-scale">
	        <span>
	          <input type="radio" class="form-control" id="enabled_1" name="data[opengraph_type]" value="website" <?php echo @$settings['opengraph_type'] == 'website' ? 'checked' : ''; ?> /> 
	        <label for="enabled_1">Website</label>
	        </span>
	        <span>
	          <input type="radio" class="form-control" id="enabled_0" name="data[opengraph_type]" value="article" <?php echo @$settings['opengraph_type'] == 'article' ? 'checked' : ''; ?> />
	          <label for="enabled_0">Artículo</label>
	        </span>
	      </div>
	      <small class="text-muted">Inidca como debería mostrarse la presentación del *card* cuando decides compartir un enlace del sitio.</small>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="columns-text"><?php echo __('Título'); ?></label>
	      <div class="controls">
	        <input type="text" maxlength="100" name="data[opengraph_title]" class="form-control" value="<?php echo @$settings['opengraph_title'] ?>" placeholder="Ingresá el título que desees para tu aplicación"/>
	      </div>
	    </div>
	    <div class="control-group">
	      <label class="control-label" for="columns-text"><?php echo __('Descripción'); ?></label>
	      <div class="controls">
	        <textarea name="data[opengraph_text]" class="form-control w-100" placeholder="Ingresá el texto que desees para tu aplicación"><?php echo @$settings['opengraph_text'] ?></textarea>
	      </div>
	    </div>
			<hr>	      			
	    <h4 class="sub-header">Imagen principal</h4>
	    <p>Resolución recomendada 500x500px</p>

			<div class="control-group">
				<label class="control-label" for="columns-text"><?php echo __('Seleccione una imagen'); ?></label>
				<div class="controls">
					<input type="file" class="form-control" name="data[opengraph_image]" value="" accept="image/*">
				</div>
			</div>

	    <div class="control-group">
	      <label class="control-label" for="columns-text"><?php echo __('Width'); ?></label>
	      <div class="controls">
	        <input type="number" maxlength="100" name="data[opengraph_width]" class="form-control" value="<?php echo @$settings['opengraph_width'] ?>" placeholder="Ancho de la imagen"/>
	      </div>
	    </div>
			<div class="control-group">
	      <label class="control-label" for="columns-text"><?php echo __('Height'); ?></label>
	      <div class="controls">
	        <input type="number" maxlength="100" name="data[opengraph_height]" class="form-control" value="<?php echo @$settings['opengraph_height'] ?>" placeholder="Alto de la imagen"/>
	      </div>
	    </div>
			<br />
			<!--div class="control-group">						
				<div class="controls">
					<button class="btn btn-primary" type="submit">Agregar Imagen</button>
				</div>
			</div-->
		<?php if($settings['opengraph_image']): ?>
			<img src="<?php echo $settings['opengraph_image'] ?>" id="opengraph_image" width="200">
			<button class="btn btn-danger" onclick="window.location.href='<?php echo $this->Html->url(array('action'=>'remove_opengraph_image')) ?>'">x</button>
		<?php endif; ?> 			        
	  </div>
	</div>