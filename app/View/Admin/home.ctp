<?php 
echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false));
echo $this->Html->script('custom-tabs.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->script('sliders-compose.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->css('sliders-compose.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->script('admin-sliders.js?v=' . Configure::read('APP_VERSION'), array('inline'=>false));
// $this->Html->script('ckeditor/ckeditor.js', array('inline' => false));
?>

<div class="block">
	<div class="block-content">
		<form action="" id="display_form" method="post" class="form-inline" enctype="multipart/form-data">
			<input type="hidden" name="data[id]" value="1" />
	    <div class="custom-tabs block-themed">
	      <ul class="nav nav-tabs" id="myTab" role="tablist">
	      <?php foreach($tags as $key => $tag): ?>
	        <li class="<?php echo $key == 0 ? 'active ' : '' ?>text-center">
	          <a href="#<?php echo $tag['name'] ?>">
	            <?php echo $tag['description'] ?>
	          </a>
	        </li>
	       <?php endforeach ?>
	      </ul>
	      <div class="tab-content">
	      	<?php foreach($tags as $key => $tag): ?>
	        <div class="tab-pane pane-<?php echo $tag['name'] ?><?php echo $key == 0 ? ' active' : '' ?>">
		        <!--h4 class="sub-header">Pantalla inicial <span class="counter_newsletter hide"></span></h4-->
		        <!--p><?php echo $slider['tag'] ?></p-->
						<div class="w-100 bg-grey draggable-table">
							<div class="w-100 category-item-container">
	      				<?php foreach($sliders[$tag['name']] as $key => $item): ?>
									<span class="category-item device-<?php echo $item['device'] ?>">	
										<div class="category-content video-container">
											<?php if(strstr($item['img_url'], '.mp4') != false): ?>
								        <video src="<?php echo $settings['upload_url'] ?><?php echo $item['img_url'] ?>">
								        </video>
											<?php else: ?>
												<div class="category-image ci-<?= !empty($item['alignnum']) ? $item['alignnum'] : '0' ?> p-3 w-100" style="background-image: url('<?php echo $settings['upload_url'] ?><?php echo $item['img_url'] ?>');"></div>
											<?php endif ?>
										</div>
		                <span class="category-toolbox">
											<a href="#" class="btn bg-transparent p-3">
												<i class="fa fa-2x fa-<?php echo $item['device'] ?> min-w-4 is-clickable edit-orientation" data-file="<?php echo $item['img_url'] ?>" data-origin="splash" data-orientation="<?php echo $item['device'] ?>"></i>
											</a>
		                  <span class="btn bg-transparent btn-toggle-form p-3">
		                    <i class="fa fa-edit fa-lg text-success"></i>
		                  </span>
											<a href="#" class="btn bg-transparent delete-image p-3" data-input="[name='data[splash]']" data-file="<?php echo $item['img_url'] ?>">
												<i class="fa fa-close"></i>
											</a>
		                </span>
		                <span class="category-form">
		                  <div class="category-form-content">
		                    <span class="form-group d-flex flex-start gap-05" title="Posición del texto">
		                      <!--label class="text-chatelet">Posición del texto</label-->
		                      <i class="fa fa-text-height"></i>
		                      <select class="form-control update-alignnum" name="data[alignnum]">
		                        <option value="0"<?= empty($item['alignnum']) ? ' selected' : '' ?>>Centro</option>
		                        <option value="1"<?= @$item['alignnum'] == '1' ? ' selected' : '' ?>>Izquierda</option>
		                        <option value="2"<?= @$item['alignnum'] == '2' ? ' selected' : '' ?>>Derecha</option>
		                        <option value="3"<?= @$item['alignnum'] == '3' ? ' selected' : '' ?>>Arriba</option>
		                        <option value="4"<?= @$item['alignnum'] == '4' ? ' selected' : '' ?>>Abajo</option>
		                        <option value="5"<?= @$item['alignnum'] == '5' ? ' selected' : '' ?>>Arriba/Izquierda</option>
		                        <option value="6"<?= @$item['alignnum'] == '6' ? ' selected' : '' ?>>Arriba/Derecha</option>
		                        <option value="7"<?= @$item['alignnum'] == '7' ? ' selected' : '' ?>>Abajo/Izquierda</option>
		                        <option value="8"<?= @$item['alignnum'] == '8' ? ' selected' : '' ?>>Abajo/Derecha</option>
		                      </select>
		                    </span>
		                    <span class="form-group d-flex flex-start gap-05" title="Posición de imagen">
		                      <!--label class="text-chatelet">Ancho de columna</label-->
		                      <i class="fa fa-image"></i>
		                      <select class="form-control update-posnum" name="data[posnum]">
		                        <option value="0"<?= empty($item['posnum']) ? ' selected' : '' ?>>Centro</option>
		                        <option value="1"<?= @$item['posnum'] == '1' ? ' selected' : '' ?>>Izquierda</option>
		                        <option value="2"<?= @$item['posnum'] == '2' ? ' selected' : '' ?>>Derecha</option>
		                        <option value="3"<?= @$item['posnum'] == '3' ? ' selected' : '' ?>>Arriba</option>
		                        <option value="4"<?= @$item['posnum'] == '4' ? ' selected' : '' ?>>Abajo</option>
		                        <option value="5"<?= @$item['posnum'] == '5' ? ' selected' : '' ?>>Arriba/Izquierda</option>
		                        <option value="6"<?= @$item['posnum'] == '6' ? ' selected' : '' ?>>Arriba/Derecha</option>
		                        <option value="7"<?= @$item['posnum'] == '7' ? ' selected' : '' ?>>Abajo/Izquierda</option>
		                        <option value="8"<?= @$item['posnum'] == '8' ? ' selected' : '' ?>>Abajo/Derecha</option>
		                      </select>
		                    </span>
		                  </div>
		                </span>										
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
				<button type="reset" class="btn btn-danger" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="fa fa-close mr-1"></i> Restaurar</button>
				<button type="submit" class="btn btn-success animated fast" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
			</div>
		</form>
	</div>
</div>



