	<h4 class="sub-header">Descripción de la tienda</h4>
	<p>Asigna el título y descripción de la tuenda</p>
	<div class="control-group">
	  <label class="control-label" for="columns-text"><?php echo __('Nombre de la tienda'); ?></label>
	  <div class="controls">
	    <input type="text" maxlength="100" name="data[site_title]" class="form-control" value="<?php echo @$settings['site_title'] ?>" placeholder="Nombre de la tienda"/>
	  </div>
	  <small class="text-muted">To optimize these elements for SEO and visibility:
Meta Title Length: Keep titles between 50-60 characters (or up to 70 characters/600 pixels on desktop) to prevent truncation in search results. </small>
	</div>
	<div class="control-group">
	  <label class="control-label" for="columns-text"><?php echo __('Descripción de la tienda'); ?></label>
	  <div class="controls">
	    <textarea maxlength="200" name="data[site_description]" placeholder="Descripción de la tienda" class="form-control"><?=@$settings['site_description'] ?></textarea>
	  </div>
	  <small class="text-muted">Best Practices: Include primary keywords naturally, ensure each page has a unique title and description, and use compelling language or calls to action (e.g., "Learn more," "Shop now") to improve click-through rates. </small>
	</div>
	<hr>
	<p>
		<span class="text-muted">
		<a href="https://search.brave.com/search?q=website+meta+title+and+description&conversation=096ee5fe1ae8e60ad9238bc6e17711f129e3" target="_blank">
			<i class="fa fa-question-circle"></i>
			<span class="ml-1">Más sobre información de la tienda</span>
		</a>
	</p>