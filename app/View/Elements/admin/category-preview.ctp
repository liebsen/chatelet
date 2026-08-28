
<div class="d-flex cat-preview preview-toggle d-none gap-1">
  <div class="shop-preview posnum-<?=$cat['Category']['posnum'] ?? 'auto' ?> alignnum-<?=$cat['Category']['alignnum'] ?? '0' ?>" style="background-image: url(<?= $settings['upload_url'].$cat['Category']['img_url']?>); background-repeat: no-repeat; background-size: cover;">
  	<span class="texts-block <?=$cat['Category']['show_text'] == '1' ? '' : 'd-none'?>" style="color: <?=@$cat['Category']['text_style']->color ?? 'white'?>">
  		<span class="name-catalog text-uppercase <?=$cat['Category']['show_name'] == '1' ? '' : 'd-none'?>"><?=$cat['Category']['name']?></span>
  		<span class="p-catalog" style="font-size: <?=$cat['Category']['text_style']->font_size ?? '12'?>px; font-weight: <?=$cat['Category']['text_style']->font_weight ?? '300'?>; font-family: <?=$cat['Category']['text_style']->font_family ?? 'inherit'?>; text-shadow: <?=$cat['Category']['text_style']->shadow_width ?? '0'?>px <?=$cat['Category']['text_style']->shadow_width ?? '0'?>px <?=$cat['Category']['text_style']->shadow_blur ?? '1'?>px <?=$cat['Category']['text_style']->shadow_color ?? 'transparent'?>, -<?=$cat['Category']['text_style']->shadow_width ?? '0'?>px -<?=$cat['Category']['text_style']->shadow_width ?? '0'?>px <?=$cat['Category']['text_style']->shadow_blur ?? '1'?>px <?=$cat['Category']['text_style']->shadow_color ?? 'transparent'?>;"><?=$cat['Category']['text']?></span>
  	</span>
  </div>

  <div class="cat-preview-form d-flex flex-column">
    <div class="d-flex flex-column w-100">
      <label class="control-label" for="show_text"><?php echo __('Mostrar Texto'); ?></label>
      <div class="form-group">
        <input type="checkbox" name="data[show_text]" value="1" id="show_text" class="toggle-checkbox toggle-block" data-block=".texts-block" data-class="d-none"<?=$cat['Category']['show_text'] == '1' ? ' checked' : '' ?>>
        <label for="show_text" class="toggle-label"></label>
      </div>
    </div>

    <div class="d-flex texts-block flex-column gap-05 w-100">
      <ul class="nav nav-tabs" role="tablist">
        <li class="active text-center">
          <a href="#content" aria-controls="toolbox" role="tab" data-toggle="tab" title="Información">
            <i class="hi hi-info-sign"></i>
          </a>
        </li>
        <li class="text-center">
          <a href="#props" aria-controls="toolbox" role="tab" data-toggle="tab" title="Columna">
          	<i class="fa fa-columns"></i>
          </a>
        </li>
        <li class="text-center">
          <a href="#texts" aria-controls="toolbox" role="tab" data-toggle="tab" title="Texto">
          	<i class="gi gi-font"></i>
          </a>
        </li>
        <li class="text-center">
          <a href="#effects" aria-controls="toolbox" role="tab" data-toggle="tab" title="Efectos">
          	<i class="gi gi-magic"></i>
          </a>
        </li>
      </ul>
      <div class="tab-content" id="toolbox">
        <div class="tab-pane active" id="content" role="tabpanel">
          <div class="control-group">
            <label class="control-label" for="show_name"><?php echo __('Mostrar Título'); ?></label>
            <div class="form-group">
              <input type="checkbox" name="data[show_name]" value="1" id="show_name" class="toggle-checkbox toggle-block" data-block=".name-catalog" data-class="d-none"<?= $cat['Category']['show_name'] == '1' ? ' checked' : '' ?>>
              <label for="show_name" class="toggle-label"></label>
            </div>
          </div>		              
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Descripción'); ?></label>
            <div class="controls">
              <textarea name="data[text]" class="form-control w-100" rows="8"><?= @$cat['Category']['text'] ?></textarea>
            </div>
            <small class="text-muted">Descripción de categoría</small>
          </div>
        </div>
	      <div class="tab-pane" id="texts" role="tabpanel">
	        <div class="control-group">
	          <label class="control-label" for="font_size">Tamaño texto descripción (<i class="preview-font_size"><?=$cat['Category']['text_style']->font_size??'9'?></i> px)</label>
	          <div class="controls">
	      			<input type="range" id="font_size" class="form-control" name="data[text_style][font_size]" data-change="1" step="1" min="9" max="50" value="<?=$cat['Category']['text_style']->font_size??'9'?>">
	          </div>
	          <small class="text-muted">Selecciona tamaño de descripción de categoría</small>
	        </div>
	        <div class="control-group">
	          <label class="control-label" for="font_weight">Peso de texto descripción (<i class="preview-font_weight"><?=$cat['Category']['text_style']->font_weight??'300'?></i>)</label>
	          <div class="controls">
	          	<input type="range" class="form-control" id="font_weight" name="data[text_style][font_weight]" data-change="1" step="100" min="300" max="1000" value="<?=$cat['Category']['text_style']->font_weight?>">
	          </div>
	          <small class="text-muted">Selecciona un peso para el texto</small>
	        </div>

	        <div class="control-group">
	          <label class="control-label" for="font_family"><?php echo __('Tipografía del texto'); ?></label>
	          <div class="controls">
	            <select class="form-control" id="font_family" name="data[text_style][font_family]" data-change="1">
	            	<option value="">Selecciona una fuente</option>
	            <?php foreach($families as $font):?>
	            	<option value="<?=$font?>"<?= @$cat['Category']['text_style']->font_family == $font ? ' selected' : '' ?>><?=$font?></option>	
	            <?php endforeach?>
	            </select>
	          </div>
	          <small class="text-muted">Seleccioná una fuente para mostrar tu texto</small>
	        </div>
					<div class="control-group">
					  <label class="control-label" for="font_color"><?php echo __('Color Texto'); ?></label>
					  <div class="controls">
					  	<input type="color" id="font_color" name="data[text_style][color]" data-change="1" value="<?= @$cat['Category']['text_style']->color ?>">
					  </div>
	          <small class="text-muted">Seleccioná color de texto para esta categoría. <span class="text-info is-clickable" onclick="$('#font_color').val('')">Resetear</span></small>
					</div>
				</div>
	      <div class="tab-pane" id="props" role="tabpanel">
	        <h4 class="sub-header"><?=__('Propiedades de columna')?></h4>
	        <p><?=__('Selecciona como deseas ver tu categoría en el Catálogo de Shop')?></p>  
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Ancho'); ?></label>
	          <div class="controls">
	            <select class="form-control" name="data[colsize]">
	              <option value="6"<?= empty($cat['Category']['colsize']) ? ' selected' : '' ?>>Auto</option>
	              <!--option value="2"<?= @$cat['Category']['colsize'] == '2' ? ' selected' : '' ?>>16.66%</option-->
	              <option value="20"<?= @$cat['Category']['colsize'] == '20' ? ' selected' : '' ?>>20%</option>
	              <option value="3"<?= @$cat['Category']['colsize'] == '3' ? ' selected' : '' ?>>25%</option>
	              <option value="4"<?= @$cat['Category']['colsize'] == '4' ? ' selected' : '' ?>>33%</option>
	              <option value="40"<?= @$cat['Category']['colsize'] == '40' ? ' selected' : '' ?>>40%</option>
	              <option value="6"<?= @$cat['Category']['colsize'] == '6' ? ' selected' : '' ?>>50%</option>
	              <option value="60"<?= @$cat['Category']['colsize'] == '60' ? ' selected' : '' ?>>60%</option>
	              <option value="8"<?= @$cat['Category']['colsize'] == '8' ? ' selected' : '' ?>>66%</option>
	              <option value="9"<?= @$cat['Category']['colsize'] == '9' ? ' selected' : '' ?>>75%</option>
	              <option value="80"<?= @$cat['Category']['colsize'] == '80' ? ' selected' : '' ?>>80%</option>
	              <option value="12"<?= @$cat['Category']['colsize'] == '12' ? ' selected' : '' ?>>100%</option>
	            </select>              
	          </div>
	          <small class="text-muted">Seleccioná el ancho de columna para esta categoría (solo para dispositivos de escritorio y smart-tv).</small>
	        </div>

	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Imagen'); ?></label>
	          <div class="controls">
	            <select class="form-control" name="data[posnum]">
	              <option value="1"<?= empty($cat['Category']['posnum']) ? ' selected' : '' ?>>Auto</option>
	              <option value="2"<?= @$cat['Category']['posnum'] == '2' ? ' selected' : '' ?>>Arriba</option>
	              <option value="3"<?= @$cat['Category']['posnum'] == '3' ? ' selected' : '' ?>>Abajo</option>
	            </select>              
	          </div>
	          <small class="text-muted">Seleccioná la posición para las imágenes de los productos. Selecciona <b>Arriba</b> para ver rostros, <a>Abajo</a> para ver los zapatos</small>
	        </div>

	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Texto'); ?></label>
	          <div class="controls">
	            <select class="form-control" name="data[alignnum]">
	              <option value="0"<?= empty($cat['Category']['alignnum']) ? ' selected' : '' ?>>Centro</option>
	              <option value="1"<?= @$cat['Category']['alignnum'] == '1' ? ' selected' : '' ?>>Izquierda</option>
	              <option value="2"<?= @$cat['Category']['alignnum'] == '2' ? ' selected' : '' ?>>Derecha</option>
	              <option value="3"<?= @$cat['Category']['alignnum'] == '3' ? ' selected' : '' ?>>Arriba</option>
	              <option value="4"<?= @$cat['Category']['alignnum'] == '4' ? ' selected' : '' ?>>Abajo</option>
	              <option value="5"<?= @$cat['Category']['alignnum'] == '5' ? ' selected' : '' ?>>Arriba/Izquierda</option>
	              <option value="6"<?= @$cat['Category']['alignnum'] == '6' ? ' selected' : '' ?>>Arriba/Derecha</option>
	              <option value="7"<?= @$cat['Category']['alignnum'] == '7' ? ' selected' : '' ?>>Abajo/Izquierda</option>
	              <option value="8"<?= @$cat['Category']['alignnum'] == '8' ? ' selected' : '' ?>>Abajo/Derecha</option>
	            </select>              
	          </div>
	          <small class="text-muted">Seleccioná la posición para el texto de la columna del Catálogo de Shop.</small>
	        </div>
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Ordenar'); ?></label>
	          <div class="controls">
	            <input  class="form-control w-100" type="number" name="data[ordernum]" value="<?= !empty($cat) ? $cat['Category']['ordernum'] : '100' ?>">
	          </div>
	          <small class="text-muted">Seleccioná el orden de prioridad para esta categoría</small>
	        </div>
	        <div class="control-group">
	          <label class="control-label" for="ribbon_color"><?php echo __('Color Burbuja'); ?></label>
	          <div class="controls">
	            <input type="color" id="ribbon_color" name="data[ribbon_color]" value="<?=@$cat['Category']['ribbon_color']??'#333' ?>">
	          </div>
	          <small class="text-muted">Seleccioná color de burbuja para los productos de esta categoría. <span class="text-info is-clickable" onclick="$('#ribbon_color').val('')">Resetear</span></small>
	        </div>
	      </div>
	      <div class="tab-pane" id="effects" role="tabpanel">
	        <div class="control-group">
	          <label class="control-label" for="shadow_width">Tamaño sombra (<i class="preview-shadow_width"><?=$cat['Category']['text_style']->shadow_width??'0'?></i> px)</label>
	          <div class="controls">
	      			<input type="range" id="shadow_width" class="form-control" name="data[text_style][shadow_width]" data-change="1" step="1" min="0" max="10" value="<?=$cat['Category']['text_style']->shadow_width??'0'?>">
	          </div>
	          <small class="text-muted">Selecciona tamaño de la sombra</small>
	        </div>
	        <div class="control-group">
	          <label class="control-label" for="shadow_blur">Tamaño sombra (<i class="preview-shadow_blur"><?=$cat['Category']['text_style']->shadow_blur??'0'?></i> px)</label>
	          <div class="controls">
	      			<input type="range" id="shadow_blur" class="form-control" name="data[text_style][shadow_blur]" data-change="1" step="1" min="0" max="30" value="<?=$cat['Category']['text_style']->shadow_blur??'0'?>">
	          </div>
	          <small class="text-muted">Selecciona cantidad de blur para la sombra</small>
	        </div>
					<div class="control-group">
					  <label class="control-label" for="shadow_color"><?php echo __('Color sombra'); ?></label>
					  <div class="controls">
					  	<input type="color" id="shadow_color" name="data[text_style][shadow_color]" data-change="1" value="<?= @$cat['Category']['text_style']->shadow_color ?>">
					  </div>
	          <small class="text-muted">Seleccioná color de sombra para el texto. <span class="text-info is-clickable" onclick="$('#shadow_color').val('')">Resetear</span></small>
					</div>
	      </div>
	    </div>
    </div>
  </div>
</div>