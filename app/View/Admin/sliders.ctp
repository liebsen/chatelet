<?php echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php echo $this->Html->script('custom-tabs.js?v=' . Configure::read('APP_VERSION'), array('inline' => false)); ?>
<?php echo $this->Html->script('admin_sliders.js?v=' . Configure::read('APP_VERSION'), array('inline'=>false)) ?>
<?php // $this->Html->script('ckeditor/ckeditor.js', array('inline' => false));?>

<div class="block">
	<div class="block-content">
		<form action="" id="display_form" method="post" class="form-inline" enctype="multipart/form-data">
			<input type="hidden" name="data[id]" value="1" />
	    <div class="custom-tabs block-themed">
	      <ul class="nav nav-tabs" id="myTab" role="tablist">
	      <?php foreach($tags as $key => $tag): ?>
	        <li class="<?php echo $key == 0 ? 'active ' : '' ?>text-center">
	          <a href="#<?php echo $tag ?>">
	            <?php echo $tag ?>
	          </a>
	        </li>
	       <?php endforeach ?>
	      </ul>
	      <div class="tab-content">
	      	<?php foreach($tags as $key => $tag): ?>
	        <div class="tab-pane pane-<?php echo $tag ?><?php echo $key == 0 ? ' active' : '' ?>">
		        <!--h4 class="sub-header">Pantalla inicial <span class="counter_newsletter hide"></span></h4-->
		        <p><?php echo $slider['tag'] ?></p>
						<div class="control-group w-100 bg-dark" style="min-height: 233px;">
							<div class="controls w-100">
	      				<?php foreach($sliders[$tag] as $key => $item): ?>
									<span class="image-item">	
										<div class="media-container">
											<?php if(strstr($item['img_url'], '.mp4') != false): ?>
								        <video src="<?php echo $settings['upload_url'] ?><?php echo $item['img_url'] ?>"  id="video<?=$key?>" class="carousel-video" <?= (strpos( $_SERVER['HTTP_USER_AGENT'], 'Safari') !== false) ? ' controls="true" ' : '' ?>>
								        </video>
											<?php else: ?>
												<img src="<?php echo $settings['upload_url'] ?><?php echo $item['img_url'] ?>"/> 
											<?php endif ?>
										</div>
										<a href="#" class="delete-image" data-input="[name='data[splash]']" data-file="<?php echo $item['img_url'] ?>"><i class="fa fa-close"></i></a>
										<i class="fa fa-2x fa-<?php echo $item['device'] ?> min-w-4 is-clickable edit-orientation" data-file="<?php echo $item['img_url'] ?>" data-origin="splash" data-orientation="<?php echo $item['device'] ?>"></i>
									</span>
								<?php endforeach ?>
							</div>
					  </div>
					  <progress class="progress_newsletter hide w-100" value="50" max="100">0%</progress>
						<div class="control-group">
							<div class="controls">
								<input type="file" class="form-control" id="HomeImgPopupNewsletter" data-input="[name='data[splash]']" data-progress=".progress_newsletter" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
								Imagen. Tamaño recomendado 1920x1080 o 720x1600
								<input type="hidden" name="data[splash]" value="<?php echo $slider['Home']['splash'] ?>" />
							</div>
						</div>
	        </div>
	      <?php endforeach ?>
	      </div>
	    </div>
			<div class="form-actions">
				<input type="hidden" name="id" value="1">
				<button type="reset" class="btn btn-danger" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="icon-repeat"></i> Restaurar</button>
				<button type="submit" class="btn btn-success animated fast" title="Pulsa aquí para actualizar este formulario"><i class="icon-ok"></i> Guardar</button>
			</div>
		</form>
	</div>
</div>
