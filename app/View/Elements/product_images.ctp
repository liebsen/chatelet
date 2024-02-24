<?php echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php echo $this->Html->script('product_images',array('inline'=>false)) ?>
<?php echo $this->Html->css('product_images',array('inline'=>false)) ?>
<div class="row">
	<div class="col-xs-12">
		<h4>Imagenes Extra</h4>
		<div class="control-group">
			<label class="control-label" for="columns-text">Archivo: <span class="counter">0</span>%</label>
			<div class="controls">
				<input class="form-control" type="file" id="upload" data-input="[name='gallery']" data-count=".counter" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
				<input type="hidden" name="gallery" value="<?php echo (!empty( $prod['Product']['gallery'] )) ? $prod['Product']['gallery'] : null ; ?>" />
			</div>
		</div>
		<br />
		<div class="control-group">
			<label class="control-label" for="columns-text"></label>
			<div class="controls">
				<script id="image_thumb" type="text/x-handlebars-template" data-url="<?php echo Configure::read('uploadUrl') ?>">
					<li style="margin-top:10px;margin-bottom:10px;">	
						<img src="{{image}}" width="100"/> 
						<a href="#" class="delete_image" data-input="[name='gallery']" data-file="{{file}}">X</a>
					</li>
				</script>
				<ul id="images">
				</ul>
			</div>
		</div>
	</div>
</div>