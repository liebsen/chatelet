	<h4 class="sub-header">Colores de la tienda</h4>
	<p>Asigna los colores que desees (los archivos correspondientes se generarán en la tienda)
	</p>
	<div class="control-group">
	  <label class="control-label" for="site_theme_color"><?php echo __('Theme color'); ?></label>
    <div class="controls">
      <input type="color" id="site_theme_color" name="data[site_theme_color]" value="<?= @$settings['site_theme_color'] ?>">
    </div>
	</div>
	<div class="control-group">
	  <label class="control-label" for="site_theme_color"><?php echo __('Theme variant'); ?></label>
    <div class="controls">
      <input type="color" id="site_theme_variant" name="data[site_theme_variant]" value="<?= @$settings['site_theme_variant'] ?>">
    </div>
	</div>
	<div class="control-group">
	  <label class="control-label" for="site_text_color"><?php echo __('Texto color'); ?></label>
	  <div class="controls">
	  	<input type="color" id="site_text_color" name="data[site_text_color]" value="<?= @$settings['site_text_color'] ?>">
	  </div>
	</div>
	<hr>
	<p>
		<a href="#themesandcolors" target="_blank">
			<i class="fa fa-question-circle"></i>
			<span class="ml-1">Más sobre Temas y Colores</span>
		</a>
	</p>