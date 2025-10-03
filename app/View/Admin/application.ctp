<?php echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php echo $this->Html->script('whatsapp',array('inline' => false)) ?>

<div class="block block-themed">
	<div class="block-title">
		<h4><?php echo __('Configuración principal') ?></h4>
	</div>

	<div class="block-content">
		<form action="" method="post" class="form-inline" enctype="multipart/form-data">
			<div class="row">
	      <div class="col-md-6">
	        <h4 class="sub-header">Datos Opengraph</h4>
	        <p>Estos datos se visualizarán al momento de compartir la aplicación con el estandar opengraph de huella de sitios web y aplicaciones. Este estandar es utilizado por la mayoría de los sistemas de mensajería instantánea.</p>
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Tipo'); ?></label>
	          <div class="controls text-center switch-scale">
	            <?php
	              $enabled = @$data['opengraph_type'] == 'website' ? 'checked' : '';
	              $disabled = @$data['opengraph_type'] == 'article' ? 'checked' : '';
	            ?>
	            <label for="enabled_1">Website</label>
	            <input type="radio" class="form-control" id="enabled_1" name="data[opengraph_type]" value="website" <?php echo $enabled; ?> /> &nbsp;
	            <label for="enabled_0">Artículo</label>
	            <input type="radio" class="form-control" id="enabled_0" name="data[opengraph_type]" value="article" <?php echo $disabled; ?> />
	          </div>
	          <span class="text-muted">Indica si debe mostrarse como artículo o como sitio web.</span>
	        </div>
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Título'); ?></label>
	          <div class="controls">
	            <input type="text" maxlength="100" name="data[opengraph_title]" class="form-control" value="<?= @$data['opengraph_title'] ?>"/>
	          </div>
	          <span class="text-muted">Ingresá el título que desees para tu aplicación.</span>
	        </div>
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Descripción'); ?></label>
	          <div class="controls">
	            <textarea name="data[opengraph_text]" class="form-control w-100"><?= @$data['opengraph_text'] ?></textarea>
	            <span class="text-muted">Ingresá el texto que desees para tu aplicación.</span>
	          </div>
	        </div>

					<br />
					<br />
	        <h4 class="sub-header">Reportes de la tienda</h4>
	        <p>Proporciona el código público del sitio para todos los servicios.</p>
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Google Analytics code'); ?></label>
	          <div class="controls">
	            <input type="text" maxlength="100" name="data[google_analytics_code]" class="form-control" value="<?= @$data['google_analytics_code'] ?>"/>
	          </div>
	          <span class="text-muted">Ingresa el código de Google Analytics</span>
	        </div>
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Facebook Pixel ID'); ?></label>
	          <div class="controls">
	            <input type="text" maxlength="100" name="data[facebook_pixel_id]" class="form-control" value="<?= @$data['facebook_pixel_id'] ?>"/>
	          </div>
	          <span class="text-muted">Ingresa la identificación del pixel.</span>
	        </div>	 	        
	      </div>
	      <div class="col-md-6">
	      	<h4 class="sub-header">Imagen</h4>
					<div class="control-group">
						<label class="control-label" for="columns-text"><?php echo __('Seleccione una imagen'); ?></label>
						<div class="controls">
							<input type="file" name="data[opengraph][image]" value="" accept="image/*">
						</div>
					</div>
      		<div class="col">
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Width'); ?></label>
		          <div class="controls">
		            <input type="number" maxlength="100" name="data[opengraph_width]" class="form-control" value="<?= @$data['opengraph_width'] ?>"/>
		          </div>
		          <span class="text-muted">Ancho de la imagen</span>
		        </div>
        		<div class="col">
		          <label class="control-label" for="columns-text"><?php echo __('Height'); ?></label>
		          <div class="controls">
		            <input type="number" maxlength="100" name="data[opengraph_height]" class="form-control" value="<?= @$data['opengraph_height'] ?>"/>
		          </div>
		          <span class="text-muted">Alto de la imagen.</span>
		        </div>
		      </div>
					<br />
					<!--div class="control-group">						
						<div class="controls">
							<button class="btn btn-primary" type="submit">Agregar Imagen</button>
						</div>
					</div-->
				<?php if($data['opengraph_image']): ?>
					<img src="<?= $data['opengraph_image'] ?>" width="200">
					<button class="btn btn-danger" onclick="window.location.href='<?php echo $this->Html->url(array('action'=>'remove_opengraph_image')) ?>'">x</button>
				<?php endif; ?>


					<br />
					<br />
	        <h4 class="sub-header">Fuente de la tienda</h4>
	        <p>Asigna el nombre de la fuente que desees (los archivos correspondientes se solicitarán a Google Fonts)</p>
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Google Font name'); ?></label>
	          <div class="controls">
	            <input type="text" maxlength="100" name="data[google_font_name]" class="form-control" value="<?= @$data['google_font_name'] ?>"/>
	          </div>
	          <span class="text-muted">Ingresa el nombre de la fuente, ej:
	          	<span class="text-muted">DM Sans</span>
	          </span>
	        </div>
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Google Font size'); ?></label>
	          <div class="controls">
	            <input type="text" maxlength="100" name="data[google_font_size]" class="form-control" value="<?= @$data['google_font_size'] ?>"/>
	          </div>
	          <span class="text-muted">Ingresa el tamaño de la fuente, ej: 
          		<span class="text-muted">300,400,500,600,700,800</span>
	          </span>
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