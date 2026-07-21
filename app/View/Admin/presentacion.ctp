<?php echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php echo $this->Html->script('custom-tabs.js?v=' . $version['ver'], array('inline' => false)); ?>
<?php echo $this->Html->script('admin-index.js?v=' . $version['ver'], array('inline'=>false)) ?>
<?php // $this->Html->script('ckeditor/ckeditor.js', array('inline' => false));?>

<div class="block">
	<div class="block-content">
		<form action="" id="display_form" method="post" class="form-inline" enctype="multipart/form-data">
			<input type="hidden" name="data[id]" value="1" />
	    <div class="custom-tabs block-tabs">
	      <ul class="nav nav-tabs" id="myTab" role="tablist">
	        <li class="active text-center">
	          <a href="#splash">
	            <i class="gi gi-picture"></i> <span class="ml-2">Primera pantalla</span>
	          </a>
	        </li>
	        <li class="text-center">
	          <a href="#slider">
	            <i class="gi gi-sampler"></i> <span class="ml-2">Carrusel</span>
	          </a>
	        </li>
	        <li class="text-center">
	          <a href="#config">
	            <i class="gi gi-cogwheel"></i> <span class="ml-2">Configuración</span>
	          </a>
	        </li>
	      </ul>
	      <div class="tab-content">
	        <div class="tab-pane pane-splash active">
		        <!--h4 class="sub-header">Pantalla inicial <span class="counter_newsletter hide"></span></h4-->
		        <p>Una pantalla forzada al inicio. Splash es la primera imagen que se verá en la pantalla mientras esté cargando la home.</p>
						<div class="control-group w-100 bg-theme is-rounded-md" style="min-height: 260px;">
							<div class="controls w-100">
								<script id="image_thumb_newsletter" type="text/x-handlebars-template" data-url="<?php echo $settings['upload_url'] ?>">
									<span class="image-item image-{{orientation}}">	
										<div class="media-container">
											<img src="{{image_newsletter}}"/> 
										</div>
										<a href="#" class="delete_image_newsletter" data-input="[name='data[img_popup_newsletter]']" data-file="{{file_newsletter}}"><i class="fa fa-close"></i></a>
										<i class="fa fa-2x fa-{{orientation}} min-w-4 is-clickable edit-orientation" data-file="{{file_newsletter}}" data-origin="img_popup_newsletter" data-orientation="{{orientation}}"></i>
									</span>
								</script>
								<span id="images_newsletter" class="animation-fadeIn animation-both w-100"></span>
							</div>
					  </div>
					  <progress class="progress_newsletter hide w-100" value="50" max="100">0%</progress>
						<div class="control-group">
							<div class="controls">
								<input type="file" class="form-control" id="HomeImgPopupNewsletter" data-input="[name='data[img_popup_newsletter]']" data-progress=".progress_newsletter" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
								Imagen. Tamaño recomendado 1920x1080 o 720x1600
								<input type="hidden" name="data[img_popup_newsletter]" value="<?php echo $p['Home']['img_popup_newsletter'] ?>" />
							</div>
						</div>
	        </div>
	        <div class="tab-pane pane-slider">
		        <!--h4 class="sub-header">Slider </h4-->
		        <p>Es el carrusel principal de la home que se ve al cerrar el splash. </p>
						<div class="control-group w-100 bg-theme is-rounded-md" style="min-height: 260px;">
							<div class="controls w-100">
								<script id="image_thumb" type="text/x-handlebars-template" data-url="<?php echo $settings['upload_url'] ?>">
									<li class="image-item image-{{orientation}}">
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
								<ul id="images" class="animation-fadeIn w-100"></ul>
							</div>
						</div>
					  <span class="counter hide"></span>
							<progress class="progress_slider hide w-100" value="50" max="100">0%</progress>
							<div class="control-group">
							<div class="controls">
								<input type="file" class="form-control" id="upload" data-input="[name='data[img_url]']" data-progress=".progress_slider" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>Imagen y video. Tamaño recomendado 1920x1080 o 720x1600
								<input type="hidden" name="data[img_url]" value="<?php echo $p['Home']['img_url'] ?>" />
							</div>
						</div>		        
		      </div>

	        <div class="tab-pane pane-config">
		        <!--h4 class="sub-header">Configuración adicional de Carrousel Principal</h4-->
		        <p>Configuración adicional de Carrousel Principal</p>
		        <div class="control-group">
		          <label class="control-label" for="columns-text"><?php echo __('Duración'); ?></label>
		          <div class="controls">
		            <input type="number" max="100" min="0" name="data[slideshow_timeout]" class="form-control" placeholder="20" value="<?= @$settings['slideshow_timeout'] ?? 20 ?>"/>
		          </div>
		          <small class="text-muted">Es el tiempo de duración en segundos de cada fotograma</small>
		        </div>
		      </div>
	      </div>
	    </div>
			<div class="form-actions">
				<input type="hidden" name="id" value="1">
				<button type="reset" class="btn btn-danger" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="fa fa-close"></i> <span class="ml-1">Restaurar</span></button>
				<button type="submit" class="btn btn-success fast" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check"></i> <span class="ml-1">Guardar</span></button>
			</div>
		</form>
	</div>
</div>
