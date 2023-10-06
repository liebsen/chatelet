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
	      </div>
	      <div class="col-md-6">
	      	<h4 class="sub-header">Imagen</h4>
					<div class="control-group">
						<label class="control-label" for="columns-text"><?php echo __('Seleccione una imagen'); ?></label>
						<div class="controls">
							<input type="file" name="data[opengraph][image]" value="" accept="image/*">
						</div>
					</div>
					<br />
					<div class="control-group">						
						<div class="controls">
							<button class="btn btn-primary" type="submit">Agregar Imagen</button>
						</div>
					</div>
				<?php if($data['opengraph_image']): ?>
					<img src="<?= $data['opengraph_image'] ?>" width="200">
					<button class="btn btn-danger" onclick="window.location.href='<?php echo $this->Html->url(array('action'=>'remove_opengraph_image')) ?>'">x</button>
				<?php endif; ?>
				</div>
			</div>
	    <br />               
	    <div class="form-actions">
	      <a href="/admin/cupones" class="btn btn-info"><i class="icon-repeat"></i> Atrás</a>
	      <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Guardar</button>
	    </div>
	  </form>
	</div>
</div>