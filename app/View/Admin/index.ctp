<?php echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php echo $this->Html->script('admin_index',array('inline'=>false)) ?>
<?php // $this->Html->script('ckeditor/ckeditor.js', array('inline' => false));?>

<div class="block">
	<div class="block-content">
		<form action="" method="post" class="form-inline" enctype="multipart/form-data">
			<input type="hidden" name="data[id]" value="1" />
			<div class="row">
				<div class="col-md-12">
					<div class="control-group">
						<label class="control-label" for="columns-text">Pantalla inicial <span class="counter_newsletter">0</span>%</label>
						<div class="controls">
							<input type="file" class="form-control" id="HomeImgPopupNewsletter" data-input="[name='data[img_popup_newsletter]']" data-count=".counter_newsletter" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
							Imagen. Tamaño recomendado 1920x1080 o 720x1600
							<input type="hidden" name="data[img_popup_newsletter]" value="<?php echo $p['Home']['img_popup_newsletter'] ?>" />
						</div>
					</div>	
					 <div class="control-group w-100">
						<div class="controls w-100">
							<script id="image_thumb_newsletter" type="text/x-handlebars-template" data-url="<?php echo $settings['upload_url'] ?>">
								<span class="image-item">	
									<div class="media-container">
										<img src="{{image_newsletter}}"/> 
									</div>
									<a href="#" class="delete_image_newsletter" data-input="[name='data[img_popup_newsletter]']" data-file="{{file_newsletter}}"><i class="fa fa-close"></i></a>
									<i class="fa fa-2x fa-{{orientation}} min-w-4 is-clickable edit-orientation" data-file="{{file_newsletter}}" data-origin="img_popup_newsletter" data-orientation="{{orientation}}"></i>
								</span>
							</script>
							<span id="images_newsletter" class="w-100"></span>
						</div>
				  </div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="control-group">
						<label class="control-label" for="columns-text">Slider <span class="counter">0</span>%</label>
						<div class="controls">
							<input type="file" class="form-control" id="upload" data-input="[name='data[img_url]']" data-count=".counter" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>Imagen y video. Tamaño recomendado 1920x1080 o 720x1600
							<input type="hidden" name="data[img_url]" value="<?php echo $p['Home']['img_url'] ?>" />
						</div>
					</div>
					<br />
					<div class="control-group">
						<div class="controls">
							<script id="image_thumb" type="text/x-handlebars-template" data-url="<?php echo $settings['upload_url'] ?>">
								<li class="image-item">
									<div class="media-container">
										{{#if video}}
										<video src="{{image}}"/> 
										{{else}}
										<img src="{{image}}"/> 
										{{/if}}
									</div>
									<a href="#" class="delete_image" data-input="[name='data[img_url]']" data-file="{{file}}"><i class="fa fa-close"></i></a>
									<i class="fa fa-2x fa-{{orientation}} min-w-4 is-clickable edit-orientation" data-file="{{file}}" data-origin="img_url" data-orientation="{{orientation}}"></i>
								</li>
							</script>
							<ul id="images">
							</ul>
						</div>
					</div>
				</div>             
			</div>	
			</br>
			</br>
			<div class="form-actions">
				<input type="hidden" name="id" value="1">
				<button type="reset" class="btn btn-danger" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="icon-repeat"></i> Restaurar</button>
				<button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="icon-ok"></i> Guardar</button>
			</div>
		</form>
	</div>
</div>
