			        <h4 class="sub-header">Fuente de la tienda</h4>
			        <p>Asigna el nombre de la fuente que desees (los archivos correspondientes se solicitarán a Google Fonts)</p>
			        <div class="control-group">
			          <label class="control-label" for="columns-text"><?php echo __('Google Font name'); ?></label>
			          <div class="controls">
			            <input type="text" maxlength="100" name="data[google_font_name]" class="form-control" value="<?php echo @$settings['google_font_name'] ?>" placeholder="nombre de la fuente, ej: DM Sans"/>
			          </div>
			        </div>
			        <div class="control-group">
			          <label class="control-label" for="columns-text"><?php echo __('Google Font size'); ?></label>
			          <div class="controls">
			            <input type="text" maxlength="100" name="data[google_font_size]" class="form-control" value="<?php echo @$settings['google_font_size'] ?>" placeholder="Tamaño de la fuente ej:300,400,500,600,700,800"/>
			          </div>
			        </div>