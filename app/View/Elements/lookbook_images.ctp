<?php echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php echo $this->Html->script('lookbook_images',array('inline'=>false)) ?>

<div class="row">
	<div class="col-xs-12">
		<div class="control-group">
			<label class="control-label" for="columns-text">Imagen: <span class="counter">0</span>%</label>
			<div class="controls">
				<input type="file" id="upload" data-input="[name='img_url']" data-count=".counter" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
				<input type="hidden" name="img_url" value="<?php echo (!empty( $lookbook['LookBooks']['img_url'] )) ? $lookbook['LookBooks']['img_url'] : null ; ?>" />
			</div>
		</div>
		<br />
		<div class="control-group">
			<label class="control-label" for="columns-text"></label>
			<div class="controls">
				<script id="image_thumb" type="text/x-handlebars-template" data-url="<?php echo $this->webroot . 'files/uploads/' ?>">
					<span style="margin-top:10px;margin-bottom:10px;">	
						<img src="{{image}}" width="100"/> 
						<a href="#" class="delete_image" data-input="[name='img_url']" data-file="{{file}}">X</a>
					</span>
				</script>
				<span id="images">
				</span>
			</div>
		</div>
	</div>
</div>