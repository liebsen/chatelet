<?php 
echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false));
// echo $this->Html->script('custom-tabs.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->script('home-compose.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->css('home-compose.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
// echo $this->Html->script('admin-home.js?v=' . Configure::read('APP_VERSION'), array('inline'=>false));
// $this->Html->script('ckeditor/ckeditor.js', array('inline' => false));
echo $this->element('admin-menu');
?>

<script type="text/javascript">
	const slides = <?php echo json_encode($slides, JSON_PRETTY_PRINT) ?>;
</script>

<div class="block">
	<div class="block-content">
		<form action="" id="display_form" method="post" class="form-inline" enctype="multipart/form-data">
			<input type="hidden" name="data[id]" value="1" />
			<div id="slider_block" class="category-item-container slider-template draggable-table film-strip w-100"></div>
			<script id="slider_template" type="text/x-handlebars-template" data-url="<?php echo $settings['upload_url'] ?>">
				<span class="category-item device-{{device}}">	
					<div class="category-content video-container">
						<div class="d-flex flex-column flex-center text-content position-absolute p-2 w-100">
							<h3 class="text-center animated {{title_animation}}">{{title}}</h3>
							<p class="text-center animated {{text_animation}}">{{text}}</p>
						</div>
					{{#if video}}
						<video src="{{img_url}}" controls="true"></video>
					{{else}}
						<div class="category-image ci-{{alignnum}} p-3 w-100" style="background-image: url('{{img_url}}')"></div> 
					{{/if}}
				</span>
        <span class="category-toolbox">
					<a href="#" class="btn bg-transparent p-3">
						<i class="fa fa-2x fa-{{device}} min-w-4 is-clickable edit-orientation" data-file="{{img_url}}" data-origin="splash" data-orientation="{{device}}"></i>
					</a>
          <span class="btn bg-transparent btn-toggle-form p-3">
            <i class="fa fa-edit fa-lg text-success"></i>
          </span>
					<a href="#" class="btn bg-transparent delete-image p-3" data-input="[name='data[splash]']" data-file="{{img_url}}">
						<i class="fa fa-close"></i>
					</a>
        </span>
        <span class="category-form">
          <div class="category-form-content d-flex flex-column flex-start gap-05">
            <span class="form-group d-flex flex-start gap-05" title="Posición del texto">
              <i class="fa fa-text-height"></i>
              <input type="text" class="form-control" name="data[title]" maxlength="20">
            </span>
            <span class="form-group d-flex flex-start gap-05" title="Posición del texto">
              <i class="fa fa-text-height"></i>
              <input type="text" class="form-control" name="data[description]" maxlength="20">
            </span>
            <span class="form-group d-flex flex-start gap-05" title="Posición del texto">
              <i class="fa fa-text-height"></i>
              <select class="form-control update-alignnum" name="data[alignnum]">
                <option value="0">Centro</option>
                <option value="1">Izquierda</option>
                <option value="2">Derecha</option>
                <option value="3">Arriba</option>
                <option value="4">Abajo</option>
                <option value="5">Arriba/Izquierda</option>
                <option value="6">Arriba/Derecha</option>
                <option value="7">Abajo/Izquierda</option>
                <option value="8">Abajo/Derecha</option>
              </select>
            </span>
            <span class="form-group d-flex flex-start gap-05" title="Posición de imagen">
              <i class="fa fa-image"></i>
              <select class="form-control update-posnum" name="data[posnum]">
                <option value="0">Centro</option>
                <option value="1">Izquierda</option>
                <option value="2">Derecha</option>
                <option value="3">Arriba</option>
                <option value="4">Abajo</option>
                <option value="5">Arriba/Izquierda</option>
                <option value="6">Arriba/Derecha</option>
                <option value="7">Abajo/Izquierda</option>
                <option value="8">Abajo/Derecha</option>
              </select>
            </span>
          </div>
        </span>
			</script>
		  <progress class="progress_newsletter hide w-100" value="50" max="100">0%</progress>
			<div class="control-group">
				<div class="controls">
					<input type="file" class="form-control" id="HomeImgPopupNewsletter" data-input="[name='data[splash]']" data-progress=".progress_newsletter" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
					Imagen. Tamaño recomendado 1920x1080 o 720x1600
					<input type="hidden" name="data[splash]" value="<?php echo $slider['Home']['splash'] ?>" />
				</div>
			</div>
			<div class="form-actions">
				<input type="hidden" name="id" value="1">
				<button type="reset" class="btn btn-danger" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="fa fa-close mr-1"></i> Restaurar</button>
				<button type="submit" class="btn btn-success animated fast" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
			</div>
		</form>
	</div>
</div>



