  <h4 class="sub-header">Reportes de la tienda</h4>
  <p>Proporciona el código público del sitio para todos los servicios.</p>
  <div class="control-group">
    <label class="control-label" for="columns-text"><?php echo __('Google Analytics code'); ?></label>
    <div class="controls">
      <input type="text" maxlength="100" name="data[google_analytics_code]" class="form-control" value="<?php echo @$settings['google_analytics_code'] ?>" placeholder="Código de Google Analytics"/>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="columns-text"><?php echo __('Facebook Pixel ID'); ?></label>
    <div class="controls">
      <input type="text" maxlength="100" name="data[facebook_pixel_id]" class="form-control" value="<?php echo @$settings['facebook_pixel_id'] ?>" placeholder="ID de FB pixel"/>
    </div>
  </div>	 
	<hr>
	<p>
		<a href="https://tagmanager.google.com" target="_blank">
			<i class="fa fa-question-circle"></i>
			<span class="ml-1">Más sobre Google Analytics</span>
		</a>
	</p>