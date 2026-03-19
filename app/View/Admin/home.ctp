<?php 
echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false));
// echo $this->Html->script('custom-tabs.js?v=' . $version['ver'], array('inline' => false));
echo $this->Html->script('home-compose.js?v=' . $version['ver'], array('inline' => false));
echo $this->Html->css('home-compose.css?v=' . $version['ver'], array('inline' => false));
// echo $this->Html->script('admin-home.js?v=' . $version['ver'], array('inline'=>false));
// $this->Html->script('ckeditor/ckeditor.js', array('inline' => false));
echo $this->element('admin/menu');
?>

<div class="block-tabs">
	<div class="tab-content">
		<form action="" id="display_form" method="post" class="form-inline" enctype="multipart/form-data">
			<input type="hidden" name="data[id]" value="1" />
			<div id="slider_block" class="category-item-container slider-template draggable-table film-strip w-100"></div>
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
				<button type="submit" class="btn btn-successfast" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
			</div>
		</form>
	</div>
</div>


<script type="text/javascript">
	const slides = <?php echo json_encode($slides, JSON_PRETTY_PRINT) ?>;
</script>

<script id="slider_template" type="text/x-handlebars-template" data-url="<?php echo $settings['upload_url'] ?>">
	<span class="category-item device-{{device}}">	
		<div class="category-content video-container">
			<div class="d-flex flex-column flex-center text-content position-absolute p-2 w-100">
				<h3 class="text-center{{title_animation}}">{{title}}</h3>
				<p class="text-center{{text_animation}}">{{text}}</p>
			</div>
		{{#if video}}
			<video src="{{img_url}}" controls="true"></video>
		{{else}}
			<div class="category-image posnum-{{posnum}} p-3 w-100" style="background-image: url('{{img_url}}')"></div>
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
    <div class="category-form-content d-flex flex-column flex-start gap-05 w-100">
    {{#if video}}{{else}}
      <span class="form-group d-flex flex-start gap-05 w-100" title="Posición del texto">
        <i class="fa fa-text-height"></i>
        <select class="form-control update-alignnum" name="data[alignnum]">
          <option value="0"{{#if_eq alignnum 0}}selected{{/if_eq}}>Centro</option>
          <option value="1"{{#if_eq alignnum 1}}selected{{/if_eq}}>Izquierda</option>
          <option value="2"{{#if_eq alignnum 2}}selected{{/if_eq}}>Derecha</option>
          <option value="3"{{#if_eq alignnum 3}}selected{{/if_eq}}>Arriba</option>
          <option value="4"{{#if_eq alignnum 4}}selected{{/if_eq}}>Abajo</option>
          <option value="5"{{#if_eq alignnum 5}}selected{{/if_eq}}>Arriba/Izquierda</option>
          <option value="6"{{#if_eq alignnum 6}}selected{{/if_eq}}>Arriba/Derecha</option>
          <option value="7"{{#if_eq alignnum 7}}selected{{/if_eq}}>Abajo/Izquierda</option>
          <option value="8"{{#if_eq alignnum 8}}selected{{/if_eq}}>Abajo/Derecha</option>
        </select>
      </span>
      <span class="form-group d-flex flex-start gap-05 w-100" title="Posición de imagen">
        <i class="fa fa-image"></i>
        <select class="form-control update-posnum" name="data[posnum]">
          <option value="0"{{#if_eq posnum 0}}selected{{/if_eq}}>Centro</option>
          <option value="1"{{#if_eq posnum 1}}selected{{/if_eq}}>Izquierda</option>
          <option value="2"{{#if_eq posnum 2}}selected{{/if_eq}}>Derecha</option>
          <option value="3"{{#if_eq posnum 3}}selected{{/if_eq}}>Arriba</option>
          <option value="4"{{#if_eq posnum 4}}selected{{/if_eq}}>Abajo</option>
          <option value="5"{{#if_eq posnum 5}}selected{{/if_eq}}>Arriba/Izquierda</option>
          <option value="6"{{#if_eq posnum 6}}selected{{/if_eq}}>Arriba/Derecha</option>
          <option value="7"{{#if_eq posnum 7}}selected{{/if_eq}}>Abajo/Izquierda</option>
          <option value="8"{{#if_eq posnum 8}}selected{{/if_eq}}>Abajo/Derecha</option>
        </select>
      </span>
    {{/if}}
      <span class="form-group d-flex flex-start gap-05 w-100" title="Posición del texto">
        <!--i class="fa fa-text-height"></i-->
        <input type="text" class="form-control w-100" name="data[title]" value="{{title}}" maxlength="20">
      </span>
      <span class="form-group d-flex flex-start gap-05 w-100" title="Posición del texto">
        <!--i class="fa fa-text-height"></i-->
        <textarea class="form-control" name="data[text]" maxlength="500" rows="5">{{text}}</textarea>
      </span>
    </div>
  </span>
</script>
